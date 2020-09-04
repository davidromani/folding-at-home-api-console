<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected ?DateTimeInterface $created;

    /**
     * @ORM\Column(type="datetime")
     */
    protected ?DateTimeInterface $updated;

    /**
     * Methods.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function getCreatedString(): string
    {
        return $this->getCreated() ? $this->getCreated()->format('d/m/Y H:i') : '---';
    }

    /**
     * @return $this
     */
    public function setCreated(?DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }

    /**
     * @return $this
     */
    public function setUpdated(?DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return int|string
     */
    public function __toString()
    {
        return $this->id ? $this->getId() : '---';
    }

    /**
     * Get an integer value in a pretty format string.
     */
    public static function getPrettyFormatValueInString(?int $value): string
    {
        $result = '0';
        if ($value) {
            $value = floatval($value);
            $result = number_format($value, 0, ',', '.');
        }

        return $result;
    }
}
