<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="date")
     */
    private $created_date;

    /**
     * @ORM\ManyToMany(targetEntity=BandeDessinee::class, inversedBy="authors")
     */
    private $bd;

    /**
     * @ORM\ManyToMany(targetEntity=BandeDessinee::class, mappedBy="authors")
     */
    private $bandeDessinees;

    public function __construct()
    {
        $this->bd = new ArrayCollection();
        $this->bandeDessinees = new ArrayCollection();
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

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function __toString()
    {
        return $this->getLastname();
    }

    /**
     * @return Collection|BandeDessinee[]
     */
    public function getBandeDessinees(): Collection
    {
        return $this->bandeDessinees;
    }

    public function addBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if (!$this->bandeDessinees->contains($bandeDessinee)) {
            $this->bandeDessinees[] = $bandeDessinee;
            $bandeDessinee->addAuthor($this);
        }

        return $this;
    }

    public function removeBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if ($this->bandeDessinees->removeElement($bandeDessinee)) {
            $bandeDessinee->removeAuthor($this);
        }

        return $this;
    }
}
