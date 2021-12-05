<?php

namespace App\Entity;

use App\Repository\CategoryPlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryPlaceRepository::class)
 */
class CategoryPlace
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
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="category_place")
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $en_title;

    public function __construct()
    {
        $this->place = new ArrayCollection();
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
     * @return Collection|Place[]
     */
    public function getPlace(): Collection
    {
        return $this->place;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->place->contains($place)) {
            $this->place[] = $place;
            $place->setCategoryPlace($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->place->removeElement($place)) {
            // set the owning side to null (unless already changed)
            if ($place->getCategoryPlace() === $this) {
                $place->setCategoryPlace(null);
            }
        }

        return $this;
    }

    public function getEnTitle(): ?string
    {
        return $this->en_title;
    }

    public function setEnTitle(?string $en_title): self
    {
        $this->en_title = $en_title;

        return $this;
    }
}
