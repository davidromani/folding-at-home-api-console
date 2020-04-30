<?php

namespace App\Model;

abstract class AbstractBaseFolding extends AbstractBase
{
    protected int $foldingId;
    protected string $name;
    protected int $score;
    protected int $wus;
    protected ?int $rank;

    /**
     * @return int
     */
    public function getFoldingId(): int
    {
        return $this->foldingId;
    }

    /**
     * @return string
     */
    public function getFoldingIdString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getFoldingId());
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id): self
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
    public function setName(string $name): self
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
     * @return string
     */
    public function getScoreString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getScore());
    }

    /**
     * @param int $score
     *
     * @return $this
     */
    public function setScore(int $score): self
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
     * @return string
     */
    public function getWusString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getWus());
    }

    /**
     * @param int $wus
     *
     * @return $this
     */
    public function setWus(int $wus): self
    {
        $this->wus = $wus;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getRank(): ?int
    {
        return $this->rank;
    }

    /**
     * @return string
     */
    public function getRankString(): string
    {
        return AbstractBase::getPrettyFormatValueInString($this->getRank());
    }

    /**
     * @param int|null $rank
     *
     * @return $this
     */
    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
