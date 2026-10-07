<?php

namespace App\Entity;

use App\Enum\Priorite;
use App\Enum\Statut;
use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(enumType: Priorite::class)]
    private ?Priorite $priorite = null;

    #[ORM\Column(enumType: Statut::class)]
    private ?Statut $statut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $creeLe = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $resoluLe = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, Materiel>
     */
    #[ORM\ManyToMany(targetEntity: Materiel::class, inversedBy: 'tickets')]
    private Collection $materiels;

    public function __construct()
    {
        $this->materiels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPriorite(): ?Priorite
    {
        return $this->priorite;
    }

    public function setPriorite(Priorite $priorite): static
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(Statut $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCreeLe(): ?\DateTimeImmutable
    {
        return $this->creeLe;
    }

    public function setCreeLe(\DateTimeImmutable $creeLe): static
    {
        $this->creeLe = $creeLe;

        return $this;
    }

    public function getResoluLe(): ?\DateTimeImmutable
    {
        return $this->resoluLe;
    }

    public function setResoluLe(?\DateTimeImmutable $resoluLe): static
    {
        $this->resoluLe = $resoluLe;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Materiel>
     */
    public function getMateriels(): Collection
    {
        return $this->materiels;
    }

    public function addMateriel(Materiel $materiel): static
    {
        if (!$this->materiels->contains($materiel)) {
            $this->materiels->add($materiel);
        }

        return $this;
    }

    public function removeMateriel(Materiel $materiel): static
    {
        $this->materiels->removeElement($materiel);

        return $this;
    }
}
