<?php

namespace App\Entity;

use App\Repository\SubCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=SubCategoryRepository::class)
 *  @Vich\Uploadable()
 */
class SubCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("subcategory")
     * @Groups("pictogram")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("subcategory")
     * @Groups("pictogram")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("subcategory")
     * @Groups("pictogram")
     */
    private $filename;

    /**
     * @var File
     * @Assert\Image(
     *     mimeTypes="image/png"
     * )
     * @Vich\UploadableField(mapping="subcategory_image", fileNameProperty="filename")
     */
    private $subillustration;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subCategories")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("subcategory")
     * @Groups("pictogram")
     */
    private $category_id;

    /**
     * @ORM\ManyToOne(targetEntity=Therapist::class, inversedBy="subCategories")
     */
    private $therapist_id;

    /**
     * @ORM\OneToMany(targetEntity=Pictogram::class, mappedBy="subcategory_id")
     */
    private $pictograms_id;

    public function __construct()
    {
        $this->pictograms_id = new ArrayCollection();
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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

        /**
     * Get mimeTypes="image/png"
     *
     * @return  File
     */ 
    public function getSubIllustration()
    {
        return $this->subillustration;
    }

    /**
     * Set mimeTypes="image/png"
     *
     * @param  File  $subillustration  mimeTypes="image/png"
     *
     * @return  self
     */ 
    public function setSubIllustration(File $subillustration) : SubCategory
    {
        $this->subillustration = $subillustration;
        if ($this->subillustration instanceof UploadedFile) {
            $this->update_at = new \DateTime('now');
        }

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

    public function getCategoryId(): ?category
    {
        return $this->category_id;
    }

    public function setCategoryId(?category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getTherapistId(): ?therapist
    {
        return $this->therapist_id;
    }

    public function setTherapistId(?therapist $therapist_id): self
    {
        $this->therapist_id = $therapist_id;

        return $this;
    }

    /**
     * @return Collection|Pictogram[]
     */
    public function getPictogramsId(): Collection
    {
        return $this->pictograms_id;
    }

    public function addPictogramsId(Pictogram $pictogramsId): self
    {
        if (!$this->pictograms_id->contains($pictogramsId)) {
            $this->pictograms_id[] = $pictogramsId;
            $pictogramsId->setSubcategoryId($this);
        }

        return $this;
    }

    public function removePictogramsId(Pictogram $pictogramsId): self
    {
        if ($this->pictograms_id->removeElement($pictogramsId)) {
            // set the owning side to null (unless already changed)
            if ($pictogramsId->getSubcategoryId() === $this) {
                $pictogramsId->setSubcategoryId(null);
            }
        }

        return $this;
    }
}
