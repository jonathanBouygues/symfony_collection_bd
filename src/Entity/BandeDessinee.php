<?php

namespace App\Entity;

use App\Repository\BandeDessineeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=BandeDessineeRepository::class)
 */
class BandeDessinee
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
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="date")
     */
    private $created_date;

    /**
     * @ORM\OneToMany(targetEntity=Copy::class, mappedBy="bandeDessinee")
     */
    private $copies;

    /**
     * @ORM\ManyToOne(targetEntity=Editor::class, inversedBy="bandeDessinees")
     */
    private $editor;

    public function __construct()
    {
        $this->copies = new ArrayCollection();
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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    /**
     * @return Collection|Copy[]
     */
    public function getCopies(): Collection
    {
        return $this->copies;
    }

    public function addCopy(Copy $copy): self
    {
        if (!$this->copies->contains($copy)) {
            $this->copies[] = $copy;
            $copy->setBandeDessinee($this);
        }

        return $this;
    }

    public function removeCopy(Copy $copy): self
    {
        if ($this->copies->removeElement($copy)) {
            // set the owning side to null (unless already changed)
            if ($copy->getBandeDessinee() === $this) {
                $copy->setBandeDessinee(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }
}
