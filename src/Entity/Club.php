<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 */
class Club
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $REF;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $creation_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getREF(): ?string
    {
        return $this->REF;
    }

    public function setREF(?string $REF): self
    {
        $this->REF = $REF;

        return $this;
    }

    public function getCreationDate(): ?string
    {
        return $this->creation_date;
    }

    public function setCreationDate(?string $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }
}
