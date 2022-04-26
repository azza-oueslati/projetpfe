<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
use Monolog\Formatter\FormatterInterface;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre_formation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $centre_formation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreFormation(): ?string
    {
        return $this->titre_formation;
    }

    public function setTitreFormation(string $titre_formation): self
    {
        $this->titre_formation = $titre_formation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCentreFormation(): ?string
    {
        return $this->centre_formation;
    }

    public function setCentreFormation(string $centre_formation): self
    {
        $this->centre_formation = $centre_formation;

        return $this;
    }
}
