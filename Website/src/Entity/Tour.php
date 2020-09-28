<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TourRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Tour
{
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
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="tour", orphanRemoval=true)
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Incl", mappedBy="tour")
     */
    private $incls;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Requ", mappedBy="tour")
     */
    private $requs;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->incls = new ArrayCollection();
        $this->requs = new ArrayCollection();
    }


    /**
     * initialisation du slug
     * 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function initializeSlug()
    {
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->title);
        }
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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setTour($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getTour() === $this) {
                $image->setTour(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Incl[]
     */
    public function getIncls(): Collection
    {
        return $this->incls;
    }

    public function addIncl(Incl $incl): self
    {
        if (!$this->incls->contains($incl)) {
            $this->incls[] = $incl;
            $incl->addTour($this);
        }

        return $this;
    }

    public function removeIncl(Incl $incl): self
    {
        if ($this->incls->contains($incl)) {
            $this->incls->removeElement($incl);
            $incl->removeTour($this);
        }

        return $this;
    }

    /**
     * @return Collection|Requ[]
     */
    public function getRequs(): Collection
    {
        return $this->requs;
    }

    public function addRequs(Requ $requs): self
    {
        if (!$this->requs->contains($requs)) {
            $this->requs[] = $requs;
            $requs->addTour($this);
        }

        return $this;
    }

    public function removeRequs(Requ $requs): self
    {
        if ($this->requs->contains($requs)) {
            $this->requs->removeElement($requs);
            $requs->removeTour($this);
        }

        return $this;
    }
}
