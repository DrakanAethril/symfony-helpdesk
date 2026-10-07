<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
#[UniqueEntity('numeroInventaire', message: 'Ce numéro est déjà attribué.')]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Regex('/^[A-Z]{2,3}-\d{4}$/', message: 'Le numéro d\'inventaire suit le format PC-0042.')]
    #[Groups(['ticket:detail'])]
    private ?string $numeroInventaire = null;

    #[ORM\Column(length: 30)]
    #[Groups(['ticket:detail'])]
    private ?string $type = null;

    #[ORM\Column(length: 20)]
    #[Groups(['ticket:detail'])]
    private ?string $site = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\ManyToMany(targetEntity: Ticket::class, mappedBy: 'materiels')]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroInventaire(): ?string
    {
        return $this->numeroInventaire;
    }

    public function setNumeroInventaire(?string $numeroInventaire): static
    {
        $this->numeroInventaire = $numeroInventaire;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(string $site): static
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->addMateriel($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            $ticket->removeMateriel($this);
        }

        return $this;
    }
}
