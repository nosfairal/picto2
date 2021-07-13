<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @Vich\Uploadable()
*/
 
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("pictogram")
     * @Groups("category")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pictogram")
     * @Groups("category")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("pictogram")
     * @Groups("category")
     */
    private $filename;


    /**
     * @var File
     * @Assert\Image(
     *     mimeTypes="image/png"
     * )
     * @Vich\UploadableField(mapping="category_image", fileNameProperty="filename")
     */
    private $illustration;

    /**
     * @ORM\OneToMany(targetEntity=Pictogram::class, mappedBy="category")
     */
    private $pictograms;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;

    /**
     * @ORM\ManyToMany(targetEntity=Question::class, mappedBy="category")
     * @ORM\JoinTable(name="question_category")
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Therapist", inversedBy="categories")
     * @ORM\JoinColumn(nullable=true)
     */
    private $therapist;

    public function __construct()
    {
        $this->pictograms = new ArrayCollection();
        $this->questions = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Pictogram[]
     */
    public function getPictograms(): Collection
    {
        return $this->pictograms;
    }

    public function addPictogram(Pictogram $pictogram): self
    {
        if (!$this->pictograms->contains($pictogram)) {
            $this->pictograms[] = $pictogram;
            $pictogram->setCategory($this);
        }

        return $this;
    }

    public function removePictogram(Pictogram $pictogram): self
    {
        if ($this->pictograms->removeElement($pictogram)) {
            // set the owning side to null (unless already changed)
            if ($pictogram->getCategory() === $this) {
                $pictogram->setCategory(null);
            }
        }

        return $this;
    }


    /**
     * Get mimeTypes="image/png"
     *
     * @return  File
     */ 
    public function getIllustration()
    {
        return $this->illustration;
    }

    /**
     * Set mimeTypes="image/png"
     *
     * @param  File  $illustration  mimeTypes="image/png"
     *
     * @return  self
     */ 
    public function setIllustration(File $illustration) : Category
    {
        $this->illustration = $illustration;
        if ($this->illustration instanceof UploadedFile) {
            $this->update_at = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get the value of filename
     */ 
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the value of filename
     *
     * @return  self
     */ 
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->addCategory($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            $question->removeCategory($this);
        }

        return $this;
    }

    /**
     * Get the value of therapist
     */ 
    public function getTherapist()
    {
        return $this->therapist;
    }

    /**
     * Set the value of therapist
     *
     * @return  self
     */ 
    public function setTherapist($therapist)
    {
        $this->therapist = $therapist;

        return $this;
    }
}
