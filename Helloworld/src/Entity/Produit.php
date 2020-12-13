<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @UniqueEntity("designation", message="cet article existe déjà. vous pouvez changer la quantité si cela est nécessaire!")
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="ce champ ne peut être vide!")
     * @assert\Regex("/\D+/",message="la designation ne peut pas comporter des nombres")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "la designation ne peut comporter moin {{ limit }} caractères",
     *      maxMessage = "la designation ne peut comporter plus de {{ limit }} caractères")
     */
    private $designation;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="ce champ ne peut être vide!")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $color;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isShipped;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vendeur;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="Categorie")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getIsShipped(): ?bool
    {
        return $this->isShipped;
    }

    public function setIsShipped(bool $isShipped): self
    {
        $this->isShipped = $isShipped;

        return $this;
    }

    public function getVendeur(): ?string
    {
        return $this->vendeur;
    }

    public function setVendeur(string $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getCategorie(): ?Categories
    {
        return $this->categorie;
    }

    public function setCategorie(?Categories $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
