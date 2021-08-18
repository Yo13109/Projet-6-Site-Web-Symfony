<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagesRepository::class)
 */
class Images
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
    private $Filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Main;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->Filename;
    }

    public function setFilename(string $Filename): self
    {
        $this->Filename = $Filename;

        return $this;
    }

    public function getMain(): ?string
    {
        return $this->Main;
    }

    public function setMain(string $Main): self
    {
        $this->Main = $Main;

        return $this;
    }
}
