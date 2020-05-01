<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractBaseFolding extends AbstractBase
{
    protected int $foldingId;

    /**
     * @ORM\Column(type="string")
     */
    protected string $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $wus;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected ?int $rank;

    /**
     * Methods.
     */
    public function getFoldingId(): int
    {
        return $this->foldingId;
    }

    /**
     * @return $this
     */
    public function setFoldingId(int $foldingId): self
    {
        $this->foldingId = $foldingId;

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

    public function getScore(): ?int
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
    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getWus(): ?int
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
    public function setWus(?int $wus): self
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
