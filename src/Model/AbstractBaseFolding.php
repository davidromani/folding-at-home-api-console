<?php

namespace App\Model;

abstract class AbstractBaseFolding extends AbstractBase
{
    protected int $id;
    protected string $name;
    protected int $score;
    protected int $wus;
    protected ?int $rank;

    /**
     * Methods.
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getIdString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getId());
    }

    /**
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function getScoreString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getScore());
    }

    /**
     * @return $this
     */
    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getWus(): int
    {
        return $this->wus;
    }

    public function getWusString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getWus());
    }

    /**
     * @return $this
     */
    public function setWus(int $wus): self
    {
        $this->wus = $wus;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function getRankString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getRank());
    }

    /**
     * @return $this
     */
    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
