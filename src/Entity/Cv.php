<?php

namespace App\Entity;

use App\Repository\CvRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=CvRepository::class)
 * @ApiResource
 */
class Cv
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
    private $doc_cv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocCv(): ?string
    {
        return $this->doc_cv;
    }

    public function setDocCv(string $doc_cv): self
    {
        $this->doc_cv = $doc_cv;

        return $this;
    }
}
