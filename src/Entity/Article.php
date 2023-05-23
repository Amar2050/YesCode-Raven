<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PrePersist;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[HasLifecycleCallbacks]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $intro = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[PrePersist]
    public function initSlug(){
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->getTitle() . time() . hash( "sha1" , $this->getIntro()));
        }
    }

    #[PrePersist]
    #[PreUpdate]
    public function updateDate(){
        if (empty($this->createdAt)) {
            $this->createdAt = new \DateTime();
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

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): self
    {
        $this->intro = $intro;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
}
