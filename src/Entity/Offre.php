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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $societe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postes_vacants;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $niveau_etude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_emploi_desire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;




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

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getPostesVacants(): ?string
    {
        return $this->postes_vacants;
    }

    public function setPostesVacants(string $postes_vacants): self
    {
        $this->postes_vacants = $postes_vacants;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveau_etude;
    }

    public function setNiveauEtude(string $niveau_etude): self
    {
        $this->niveau_etude = $niveau_etude;

        return $this;
    }

    public function getTypeEmploiDesire(): ?string
    {
        return $this->type_emploi_desire;
    }

    public function setTypeEmploiDesire(string $type_emploi_desire): self
    {
        $this->type_emploi_desire = $type_emploi_desire;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
