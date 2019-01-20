<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimeRepository")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="anime", orphanRemoval=true, cascade={"persist"})
     */
    private $episodes;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAnneeDeProduction(): ?int
    {
        return $this->anneeDeProduction;
    }

    public function setAnneeDeProduction(?int $anneeDeProduction): self
    {
        $this->anneeDeProduction = $anneeDeProduction;

        return $this;
    }

    public function getStudio(): ?string
    {
        return $this->studio;
    }

    public function setStudio(?string $studio): self
    {
        $this->studio = $studio;

        return $this;
    }

    public function getClassification(): ?int
    {
        return $this->classification;
    }

    public function setClassification(int $classification): self
    {
        $this->classification = $classification;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setAnime($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
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
}
