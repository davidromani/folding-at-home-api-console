<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractBaseFoldingTeamRecord
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

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
     * @ORM\Column(type="datetime")
     * Gedmo\Timestampable(on="create")
     */
    protected ?DateTimeInterface $recorded;

    /**
     * Methods
     */

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
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
     * @param int|null $rank
     *
     * @return $this
     */
    public function setRank(?int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getRecorded(): ?DateTimeInterface
    {
        return $this->recorded;
    }

    /**
     * @param DateTimeInterface|null $recorded
     *
     * @return $this
     */
    public function setRecorded(?DateTimeInterface $recorded): self
    {
        $this->recorded = $recorded;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'ID#'.$this->getId().' · SCORE:'.$this->getScore().' · WUs:'.$this->getWus().' · RANK: '.$this->getRank();
    }
}
