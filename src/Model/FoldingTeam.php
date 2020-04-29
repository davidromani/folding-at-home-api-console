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
    private ?array $accounts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = 0;
        $this->accounts = [];
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
    public function setId(int $id): FoldingTeam
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
    public function setName(string $name): FoldingTeam
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFounder(): ?string
    {
        return $this->founder;
    }

    /**
     * @param string|null $founder
     *
     * @return $this
     */
    public function setFounder(?string $founder): FoldingTeam
    {
        $this->founder = $founder;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     *
     * @return $this
     */
    public function setUrl(?string $url): FoldingTeam
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param string|null $logo
     *
     * @return $this
     */
    public function setLogo(?string $logo): FoldingTeam
    {
        $this->logo = $logo;

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
    public function setScore(int $score): FoldingTeam
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
    public function setWus(int $wus): FoldingTeam
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
    public function setRank(int $rank): FoldingTeam
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getAccounts(): ?array
    {
        return $this->accounts;
    }

    /**
     * @param array|null $accounts
     *
     * @return $this
     */
    public function setAccounts(?array $accounts): FoldingTeam
    {
        $this->accounts = $accounts;

        return $this;
    }

    /**
     * @param FoldingTeamAccount $foldingTeamAccount
     *
     * @return $this
     */
    public function addAccount(FoldingTeamAccount $foldingTeamAccount): FoldingTeam
    {
        $this->accounts[] = $foldingTeamAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'ID#'.$this->getId().' · '.$this->getName().' · SCORE:'.$this->getScore().' · WUs:'.$this->getWus().' · RANK: '.$this->getRank();
    }
}
