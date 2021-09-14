<?php

namespace App\Entity;

use App\Repository\EditorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EditorRepository::class)
 */
class Editor
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\OneToMany(targetEntity=BandeDessinee::class, mappedBy="editor")
     */
    private $bandeDessinees;

    public function __construct()
    {
        $this->bandeDessinees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
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
            $bandeDessinee->setEditor($this);
        }

        return $this;
    }

    public function removeBandeDessinee(BandeDessinee $bandeDessinee): self
    {
        if ($this->bandeDessinees->removeElement($bandeDessinee)) {
            // set the owning side to null (unless already changed)
            if ($bandeDessinee->getEditor() === $this) {
                $bandeDessinee->setEditor(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->getName();
    }
}
