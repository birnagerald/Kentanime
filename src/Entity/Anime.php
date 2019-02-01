<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimeRepository")
 * @Vich\Uploadable
 * @ORM\HasLifecycleCallbacks
 */
class Anime
{

    const CLASSIFICATION = [
        0 => 'Tout Public',
        1 => '+12',
        2 => '+16',
        3 => '+18'
    ];

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
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * Undocumented variable
     *
     * @var File|null
     * @Vich\UploadableField(mapping="anime_image", fileNameProperty="filename")
     * @Assert\Image(
     * mimeTypes="image/jpeg"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anneeDeProduction;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $studio;

    /**
     * @ORM\Column(type="integer")
     */
    private $classification;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="anime", orphanRemoval=true, cascade={"persist"})
     */
    private $episodes;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->episodes = new ArrayCollection();
    }

    public function getId() : ? int
    {
        return $this->id;
    }

    public function getTitle() : ? string
    {
        return $this->title;
    }

    public function setTitle(string $title) : self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription() : ? string
    {
        return $this->description;
    }

    public function setDescription(? string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    public function getAnneeDeProduction() : ? int
    {
        return $this->anneeDeProduction;
    }

    public function setAnneeDeProduction(? int $anneeDeProduction) : self
    {
        $this->anneeDeProduction = $anneeDeProduction;

        return $this;
    }

    public function getStudio() : ? string
    {
        return $this->studio;
    }

    public function setStudio(? string $studio) : self
    {
        $this->studio = $studio;

        return $this;
    }

    public function getClassification() : ? int
    {
        return $this->classification;
    }

    public function setClassification(int $classification) : self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getNote() : ? float
    {
        return $this->note;
    }

    public function setNote(? float $note) : self
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt() : ? \DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at) : self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes() : Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode) : self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setAnime($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode) : self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getAnime() === $this) {
                $episode->setAnime(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt() : ? \DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(? \DateTimeInterface $updated_at) : self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return null|string
     */
    public function getFilename() : ? string
    {
        return $this->filename;
    }

    /**
     * Undocumented function
     *
     * @param null|string $filename
     * @return Post
     */
    public function setFilename(? string $filename) : Anime
    {
        $this->filename = $filename;
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
     * @return Post
     */
    public function setImageFile(? File $imageFile) : Anime
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
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
}
