<?php

namespace App\Model;

class FoldingTeamAccount
{
    private ?FoldingTeam $team;
    private int $id;
    private string $name;
    private int $score;
    private int $wus;
    private int $rank;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->team = new FoldingTeam();
        $this->id = 0;
    }

    /**
     * @return FoldingTeam|null
     */
    public function getTeam(): ?FoldingTeam
    {
        return $this->team;
    }

    /**
     * @param FoldingTeam|null $team
     *
     * @return $this
     */
    public function setTeam(?FoldingTeam $team): FoldingTeamAccount
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): FoldingTeamAccount
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): FoldingTeamAccount
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     *
     * @return $this
     */
    public function setScore(int $score): FoldingTeamAccount
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return int
     */
    public function getWus(): int
    {
        return $this->wus;
    }

    /**
     * @param int $wus
     *
     * @return $this
     */
    public function setWus(int $wus): FoldingTeamAccount
    {
        $this->wus = $wus;

        return $this;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     *
     * @return $this
     */
    public function setRank(int $rank): FoldingTeamAccount
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '>>  ID#'.$this->getId().' · '.$this->getName().' · SCORE:'.$this->getScore().' · WUs:'.$this->getWus().' · RANK: '.$this->getRank();
    }
}
