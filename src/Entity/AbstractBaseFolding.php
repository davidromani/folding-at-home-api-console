<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class AbstractBaseFolding extends AbstractBase
{
    /**
     * @var int
     */
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
     * Methods
     */

    /**
     * @return int
     */
    public function getFoldingId(): int
    {
        return $this->foldingId;
    }

    /**
     * @param int $foldingId
     *
     * @return $this
     */
    public function setFoldingId(int $foldingId): self
    {
        $this->foldingId = $foldingId;

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
     * @return int|null
     */
    public function getScore(): ?int
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
     * @param int|null $score
     *
     * @return $this
     */
    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getWus(): ?int
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
     * @param int|null $wus
     *
     * @return $this
     */
    public function setWus(?int $wus): self
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
