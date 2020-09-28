<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InclRepository")
 */
class Incl
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Tour", inversedBy="incls")
     */
    private $tour;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Activity", inversedBy="incls")
     */
    private $activity;

    public function __construct()
    {
        $this->tour = new ArrayCollection();
        $this->activity = new ArrayCollection();
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

    /**
     * @return Collection|Tour[]
     */
    public function getTour(): Collection
    {
        return $this->tour;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tour->contains($tour)) {
            $this->tour[] = $tour;
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tour->contains($tour)) {
            $this->tour->removeElement($tour);
        }

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivity(): Collection
    {
        return $this->activity;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activity->contains($activity)) {
            $this->activity[] = $activity;
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activity->contains($activity)) {
            $this->activity->removeElement($activity);
        }

        return $this;
    }
}
