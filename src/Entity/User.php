<?php

namespace App\Entity;

use ReflectionClass;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Undocumented variable
     *
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilPicture;

    /**
     * Undocumented variable
     *
     * @var File|null
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="profilPicture")
     * @Assert\Image(
     * mimeTypes="image/jpeg",
     * minWidth = 250,
     * maxWidth = 250,
     * minHeight = 250,
     * maxHeight = 250,
     * mimeTypesMessage = "Merci d'uploader une image au format jpeg",
     * maxWidthMessage = "La largeur maximal autorisé est de {{ max_width }}px",
     * minWidthMessage = "La largeur minimal autorisé est de {{ min_width }}px",
     * maxHeightMessage = "La hauteur maximal autorisé est de {{ max_height }}px",
     * minHeightMessage ="La hauteur minimal autorisé est de {{ min_height }}px"
     * )
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *  @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "Votre pseudo ne doit pas faire moins de {{ limit }} caractères",
     *      maxMessage = "Votre pseudo ne doit pas faire plus de {{ limit }} caractères"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->posts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->roles = ["ROLE_USER"];
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername() : string
    {
        return (string)$this->username;
    }

    public function setUsername(string $username) : self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles() : array
    {
        $roles = $this->roles;
        if (empty($roles)) {
            // guarantee every user at least has ROLE_USER
            $roles[] = "ROLE_USER";
        }


        return $roles;
    }

    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword() : string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts() : Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post) : self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post) : self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments() : Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment) : self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment) : self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() : ? \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(? \DateTimeInterface $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return null|string
     */
    public function getProfilPicture() : ? string
    {
        return $this->profilPicture;
    }

    /**
     * Undocumented function
     *
     * @param null|string $profilPicture
     * @return User
     */
    public function setProfilPicture(? string $profilPicture) : User
    {
        $this->profilPicture = $profilPicture;
        return $this;
    }


    /**
     * Undocumented function
     *
     * @return null|File
     */
    public function getImageFile() : ? File
    {
        return $this->imageFile;
    }

    /**
     * Undocumented function
     *
     * @param null|File $imagefile
     * @return User
     */
    public function setImageFile(? File $imageFile) : User
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateModifiedDatetime()
    {
        // update the modified time
        $this->setUpdatedAt(new \DateTime());
    }

    public function __sleep()
    {
        $ref = new \ReflectionClass(__class__);
        $props = $ref->getProperties(\ReflectionProperty::IS_PRIVATE);

        $serialize_fields = array();

        foreach ($props as $prop) {
            $serialize_fields[] = $prop->name;
        }

        return $serialize_fields;
    }

}
