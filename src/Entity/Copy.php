<?php

namespace App\Entity;

use App\Repository\CopyRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CopyRepository::class)
 */
class Copy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $purchase_date;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="copies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=BandeDessinee::class, inversedBy="copies")
     */
    private $bandeDessinee;


    public function __construct()
    {
        // dump($this->security->getUser());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(\DateTimeInterface $purchase_date): self
    {
        $this->purchase_date = $purchase_date;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBandeDessinee(): ?BandeDessinee
    {
        return $this->bandeDessinee;
    }

    public function setBandeDessinee(?BandeDessinee $bandeDessinee): self
    {
        $this->bandeDessinee = $bandeDessinee;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
