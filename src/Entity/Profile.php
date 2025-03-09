<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Validation de la spécialité
    #[Assert\NotBlank(message: "La spécialité ne peut pas être vide.")]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: "La spécialité doit comporter au moins {{ limit }} caractères.",
        maxMessage: "La spécialité ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 50)]
    private ?string $specialite = null;

    // Validation de la description
    #[Assert\Length(
        max: 255,
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    // Validation de l'expérience
    #[Assert\Type(type: "integer", message: "L'expérience doit être un nombre entier.")]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: "L'expérience ne peut pas être négative."
    )]
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $experience = null;

    // Validation du tarif horaire
    #[Assert\Length(
        max: 50,
        maxMessage: "Le tarif horaire ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $tarifHoraire = null;

    // Validation de la localisation
    #[Assert\NotBlank(message: "La localisation ne peut pas être vide.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "La localisation ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 50)]
    private ?string $localisation = null;

    // Validation de la disponibilité
    #[Assert\NotBlank(message: "La disponibilité ne peut pas être vide.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "La disponibilité ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 50)]
    private ?string $disponibilite = null;

    // Validation de l'image
    #[Assert\Length(
        max: 250,
        maxMessage: "L'image ne peut pas dépasser {{ limit }} caractères."
    )]
    #[ORM\Column(length: 250, nullable: true)]
    private ?string $image = null;

    // Relation avec Artisan
    #[Assert\NotNull(message: "L'artisan ne peut pas être vide.")]
    #[ORM\ManyToOne(targetEntity: Artisan::class, inversedBy: 'profiles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artisan $artisan = null;
    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $rating = null;
  /**
     * @ORM\Column(type="integer")
     */
    private $likes = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $dislikes = 0;

    // Getters et setters...

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?int
    {
        return $this->dislikes;
    }

    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }
    // Getter and Setter for rating

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;
        return $this;
    }
    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): static
    {
        $this->specialite = $specialite;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(?int $experience): static
    {
        $this->experience = $experience;
        return $this;
    }

    public function getTarifHoraire(): ?string
    {
        return $this->tarifHoraire;
    }

    public function setTarifHoraire(?string $tarifHoraire): static
    {
        $this->tarifHoraire = $tarifHoraire;
        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;
        return $this;
    }

    public function getDisponibilite(): ?string
    {
        return $this->disponibilite;
    }

    public function setDisponibilite(string $disponibilite): static
    {
        $this->disponibilite = $disponibilite;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getArtisan(): ?Artisan
    {
        return $this->artisan;
    }

    public function setArtisan(?Artisan $artisan): static
    {
        $this->artisan = $artisan;
        return $this;
    }
}
