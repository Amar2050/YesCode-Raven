<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[HasLifecycleCallbacks]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Un prenom aussi court ? Minimum {{ limit }} caracteres',
        maxMessage: "C'est trop long ! Max {{ limit }} caracteres",
    )]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Un nom de famille aussi court ? Minimum {{ limit }} caracteres',
        maxMessage: "C'est trop long ! Max {{ limit }} caracteres",
    )]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    private ?string $fullname = null;

    #[Assert\Email(
        message: "Email {{ value }} n'est pas valide  ",
    )]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $hash = null;


    #[Assert\EqualTo(propertyPath:"hash",
        message:"Le mot passe et la confirmation de mot passe sont differents")]
    private ?string $passwordConfirm = null;

    #[Assert\Url(
        message:"Ceci n'est pas une URL valide"
    )]
    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Votre présentation est trop courte . Minimum {{ limit }} caracteres',
        maxMessage: "Votre présentation est trop longue . Max {{ limit }} caracteres",
    )]
    #[ORM\Column(length: 255)]
    private ?string $presentation = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;


    #[PrePersist]
    public function initSlug(){
        if (empty($this->slug)) {
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->getFullname() . time() . hash( "md5" , $this->getFirstname()));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->firstname . " " . $this->lastname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getPasswordConfirm(): ?string
    {
        return $this->passwordConfirm;
    }

    public function setPasswordConfirm(string $passwordConfirm): self
    {
        $this->passwordConfirm = $passwordConfirm;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

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
