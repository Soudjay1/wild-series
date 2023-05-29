<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
class Program implements Countable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $synopsis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster = null;

    #[ORM\ManyToOne(inversedBy: 'programs')]
    private ?Category $category = null;



    #[ORM\OneToMany(mappedBy: 'program', targetEntity: SeasonNumber::class)]
    private Collection $seasonNumbers;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(nullable: true)]
    private ?int $yearProgram = null;

    public function __construct()
    {
        $this->seasonNumbers = new ArrayCollection();
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

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, SeasonNumber>
     */
    public function getSeasonNumbers(): Collection
    {
        return $this->seasonNumbers;
    }

    public function addSeasonNumber(SeasonNumber $seasonNumber): self
    {
        if (!$this->seasonNumbers->contains($seasonNumber)) {
            $this->seasonNumbers->add($seasonNumber);
            $seasonNumber->setProgram($this);
        }

        return $this;
    }

    public function removeSeasonNumber(SeasonNumber $seasonNumber): self
    {
        if ($this->seasonNumbers->removeElement($seasonNumber)) {
            // set the owning side to null (unless already changed)
            if ($seasonNumber->getProgram() === $this) {
                $seasonNumber->setProgram(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getYearProgram(): ?int
    {
        return $this->yearProgram;
    }

    public function setYearProgram(?int $yearProgram): self
    {
        $this->yearProgram = $yearProgram;

        return $this;
    }

    public function count(): int
    {
        // TODO: Implement count() method.
        return $this->seasonNumbers->count();
    }
}
