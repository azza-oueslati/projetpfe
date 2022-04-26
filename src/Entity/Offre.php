<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OffreRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 * @ApiResource
 */
class Offre
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
    public $titre_offre;



    /**
     * @ORM\Column(type="string", length=255)
     */
    public $region_offre;


    /**
     * @ORM\Column(type="string", length=255)
     */
    public $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $exigences;

    /**
     * @ORM\Column(type="date")
     */
    public $date_expiration;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreOffre(): ?string
    {
        return $this->titre_offre;
    }

    public function setTitreOffre(string $titre_offre): self
    {
        $this->titre_offre = $titre_offre;

        return $this;
    }


    public function getRegionOffre(): ?string
    {
        return $this->region_offre;
    }

    public function setRegionOffre(string $region_offre): self
    {
        $this->region_offre = $region_offre;

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

    public function getExigences(): ?string
    {
        return $this->exigences;
    }

    public function setExigences(string $exigences): self
    {
        $this->exigences = $exigences;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->date_expiration;
    }

    public function setDateExpiration(\DateTimeInterface $date_expiration): self
    {
        $this->date_expiration = $date_expiration;

        return $this;
    }
}
