<?php

namespace App\Model;

class FoldingTeam
{
    private int $id;
    private string $name;
    private ?string $founder;
    private ?string $url;
    private ?string $logo;
    private int $score;
    private int $wus;
    private int $rank;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): FoldingTeam
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): FoldingTeam
    {
        $this->name = $name;

        return $this;
    }

    public function getFounder(): ?string
    {
        return $this->founder;
    }

    public function setFounder(?string $founder): FoldingTeam
    {
        $this->founder = $founder;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): FoldingTeam
    {
        $this->url = $url;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): FoldingTeam
    {
        $this->logo = $logo;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): FoldingTeam
    {
        $this->score = $score;

        return $this;
    }

    public function getWus(): int
    {
        return $this->wus;
    }

    public function setWus(int $wus): FoldingTeam
    {
        $this->wus = $wus;

        return $this;
    }

    public function getRank(): int
    {
        return $this->rank;
    }

    public function setRank(int $rank): FoldingTeam
    {
        $this->rank = $rank;

        return $this;
    }
}
