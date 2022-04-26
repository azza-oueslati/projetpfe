<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ApiResource
 */
class Post
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
    private $nom_post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPost(): ?string
    {
        return $this->nom_post;
    }

    public function setNomPost(string $nom_post): self
    {
        $this->nom_post = $nom_post;

        return $this;
    }
}
