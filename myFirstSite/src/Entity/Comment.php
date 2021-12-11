<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    private const PUBLISHED = 1;
    private const DRAFT = 0;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $create_at;

     /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_published;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comment_user")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_name;

    public function __construct()
    {
        $this->create_at = new DateTimeImmutable();
        $this->update_at = new DateTimeImmutable();
    }

     /**
     * @param string $content
     * @param User $user
     * @param Place $place
     *
     * @return Comment
     */
    public static function createComment (string $content, User $user, Place $place, $is_published): Comment
    {
        $content = new self();
        $content->content = $content;
        $content->place = $place;
        $content->user = $user;
        $content->is_published = $is_published;
        
        return $content;
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }
    
    public function setCreateAtValue () 
    {
        $this->create_at = new DateTimeImmutable();
    }

    public function setCreateAt(\DateTimeImmutable $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->is_published;
    }

    public function setIsPublished()
    {
        $this->is_published = self::PUBLISHED;

    }

    public function setIsDraft ()
    {
        $this->is_published = self::DRAFT;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeImmutable $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }
}
