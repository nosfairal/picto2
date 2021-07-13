<?php

namespace App\Entity;

use App\Repository\SentenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SentenceRepository::class)
 * @ORM\HasLifecycleCallbacks()php
 */
class Sentence
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
    private $text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("sentence:read")
     */
    private $audio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="sentences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\PrePersist
     */
    public function setCreated()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * @ORM\ManyToMany(targetEntity=Pictogram::class, inversedBy="sentences")
     */
    private $pictos;

    public function __construct()
    {
        $this->pictos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(?string $audio): self
    {
        $this->audio = $audio;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|Pictogram[]
     */
    public function getPictos(): Collection
    {
        return $this->pictos;
    }

    public function addPicto(Pictogram $picto): self
    {
        if (!$this->pictos->contains($picto)) {
            $this->pictos[] = $picto;
        }

        return $this;
    }

    public function removePicto(Pictogram $picto): self
    {
        $this->pictos->removeElement($picto);

        return $this;
    }
/**
     * Get the value of patient
     */ 
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Set the value of patient
     *
     * @return  self
     */ 
    public function setPatient($patient)
    {
        $this->patient = $patient;

        return $this;
    }
}
