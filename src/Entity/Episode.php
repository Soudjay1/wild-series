<?php

namespace App\Entity;

use App\Repository\EpisodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpisodeRepository::class)]
class Episode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $episodeTitle = null;

    #[ORM\Column(nullable: true)]
    private ?int $episodeNumber = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $episodeSynopsis = null;

    #[ORM\ManyToOne(inversedBy: 'episodes')]
    private ?SeasonNumber $season = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEpisodeTitle(): ?string
    {
        return $this->episodeTitle;
    }

    public function setEpisodeTitle(?string $episodeTitle): self
    {
        $this->episodeTitle = $episodeTitle;

        return $this;
    }

    public function getEpisodeNumber(): ?int
    {
        return $this->episodeNumber;
    }

    public function setEpisodeNumber(?int $episodeNumber): self
    {
        $this->episodeNumber = $episodeNumber;

        return $this;
    }

    public function getEpisodeSynopsis(): ?string
    {
        return $this->episodeSynopsis;
    }

    public function setEpisodeSynopsis(?string $episodeSynopsis): self
    {
        $this->episodeSynopsis = $episodeSynopsis;

        return $this;
    }

    public function getSeason(): ?seasonNumber
    {
        return $this->season;
    }

    public function setSeason(?seasonNumber $season): self
    {
        $this->season = $season;

        return $this;
    }
}
