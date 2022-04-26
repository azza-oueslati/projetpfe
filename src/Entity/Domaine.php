<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DomaineRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=DomaineRepository::class)
 * @ApiResource
 */
class Domaine
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
    private $nom_domaine;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDomaine(): ?string
    {
        return $this->nom_domaine;
    }

    public function setNomDomaine(string $nom_domaine): self
    {
        $this->nom_domaine = $nom_domaine;

        return $this;
    }
}
