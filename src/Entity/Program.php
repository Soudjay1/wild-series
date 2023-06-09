<?php

namespace App\Entity;

use App\Repository\ProgramRepository;
use Countable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
     #[UniqueEntity('title',message: 'existe deja')]
class Program implements Countable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    protected ?string $title;
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Ne me laisse pas tout vide')]
    #[Assert\Regex(
        pattern: '/plus belle la vie/',
        message: 'On parle de vraies séries ici',
        match: false
    )]
    protected ?string $synopsis;


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

    #[ORM\ManyToMany(targetEntity: Actor::class, mappedBy: 'programs')]
    private Collection $actors;


    public function __construct()
    {
        $this->seasonNumbers = new ArrayCollection();
        $this->actors = new ArrayCollection();
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
    public function removeProgram(Program $program): self
    {
        if ($this->program->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getSeason() === $this) {
                $program->setSeason(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors->add($actor);
            $actor->addProgram($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actors->removeElement($actor)) {
            $actor->removeProgram($this);
        }

        return $this;
    }

}
