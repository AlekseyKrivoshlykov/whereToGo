<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
     * @ORM\Column(type="string", length=255)
     */
    private $main_photo;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="place")
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryPlace::class, inversedBy="place")
     */
    private $category_place;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="place", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $how_to_get;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $content_source;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->placeCategories = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getMainPhoto(): ?string
    {
        return $this->main_photo;
    }

    public function setMainPhoto(string $main_photo): self
    {
        $this->main_photo = $main_photo;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

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
            $image->setPlace($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPlace() === $this) {
                $image->setPlace(null);
            }
        }

        return $this;
    }

    public function getCategoryPlace(): ?CategoryPlace
    {
        return $this->category_place;
    }

    public function setCategoryPlace(?CategoryPlace $category_place): self
    {
        $this->category_place = $category_place;

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
            $comment->setPlace($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPlace() === $this) {
                $comment->setPlace(null);
            }
        }

        return $this;
    }

    public function getHowToGet(): ?string
    {
        return $this->how_to_get;
    }

    public function setHowToGet(?string $how_to_get): self
    {
        $this->how_to_get = $how_to_get;

        return $this;
    }

    public function getContentSource(): ?string
    {
        return $this->content_source;
    }

    public function setContentSource(?string $content_source): self
    {
        $this->content_source = $content_source;

        return $this;
    }

}
