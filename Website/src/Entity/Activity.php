<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 * fields={"title"},
 * message="ce titre est deja utilise"
 * )
 */
class Activity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4, max=255, minMessage="Le titre doit faire 4 caractere minimum")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4, max=255, minMessage="Le titre doit faire 4 caractere minimum")
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4, max=255, minMessage="Le titre doit faire 4 caractere minimum")
     */
    private $category;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="Le titre doit faire 20 caractere minimum")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * 
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Url
     */
    private $coverImage;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=100, minMessage="Le titre doit faire 100 caractere minimum")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="activity", cascade={"remove"})
     * @Assert\Valid()
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="activity")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="activity", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Incl", mappedBy="activity")
     */
    private $incls;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Requ", mappedBy="activity")
     */
    private $requs;



    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->incls = new ArrayCollection();
        $this->requs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->incls;
    }

    /**
     * tableau dess dates deja reserve sur une activitee
     *
     * @return array
     */
    public function getNotAvailableDays()
    {
        $notAvailableDays = [];

        foreach ($this->bookings as $booking) {
            // Calculer les jours entre arrive et depart
            $resultat = range(
                $booking->getStartDate()->getTimestamp(),
                $booking->getEndDate()->getTimestamp(),
                24 * 60 * 60
            );

            $days = array_map(function ($dayTimestamp) {
                return new \DateTime(date('Y-m-d', $dayTimestamp));
            }, $resultat);

            $notAvailableDays = array_merge($notAvailableDays, $days);
        }

        return $notAvailableDays;
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


    /**
     * recuperer commentaire si il y a
     *
     * @param User $author
     * @return Comment | null
     */
    public function getCommentFromAuthor(User $author)
    {
        foreach ($this->comments as $comment) {
            if ($comment->getAuthor() === $author) {
                return $comment;
            }
        }

        return null;
    }


    /**
     * moyenne global des notes pour une activite
     *
     * @return float
     */
    public function getAvgRatings()
    {
        // calculer moyenne notes
        $sum = array_reduce($this->comments->toArray(), function ($total, $comment) {
            return $total + $comment->getRating();
        }, 0);

        if (count($this->comments) > 0) return $sum / count($this->comments);

        return 0;
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
            $image->setActivity($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getActivity() === $this) {
                $image->setActivity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setActivity($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getActivity() === $this) {
                $booking->setActivity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setActivity($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getActivity() === $this) {
                $comment->setActivity(null);
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
            $incl->addActivity($this);
        }

        return $this;
    }

    public function removeIncl(Incl $incl): self
    {
        if ($this->incls->contains($incl)) {
            $this->incls->removeElement($incl);
            $incl->removeActivity($this);
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
            $requs->addActivity($this);
        }

        return $this;
    }

    public function removeRequs(Requ $requs): self
    {
        if ($this->requs->contains($requs)) {
            $this->requs->removeElement($requs);
            $requs->removeActivity($this);
        }

        return $this;
    }
}
