<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FicherRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=FicherRepository::class)
 * @ApiResource
 */
class Ficher
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
    private $nom_ficher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFicher(): ?string
    {
        return $this->nom_ficher;
    }

    public function setNomFicher(string $nom_ficher): self
    {
        $this->nom_ficher = $nom_ficher;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
