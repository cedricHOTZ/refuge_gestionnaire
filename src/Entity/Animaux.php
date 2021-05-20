<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnimauxRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * @ORM\Entity(repositoryClass=AnimauxRepository::class)
 * @Vich\Uploadable
 * 
 */
class Animaux
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $race;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="animal")
     */
    private $categorie;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;


     /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;
    
    /** 
     * @var string $slug   
     * @Gedmo\Slug(fields={"nom"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class, inversedBy="animauxes", cascade={"persist"})
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="animal", orphanRemoval=true)
     */
    private $commentaires;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }



    
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
            $this->created_at = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    // public function setCreatedAt(\DateTimeInterface $created_at):self
    // {
    //     $this->created_at = $created_at;
    //     return $this;
    // }

 


    /**
     * Get the value of updatedAt
     *
     * @return  \DateTime
     */ 
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param  \DateTime  $updatedAt
     *
     * @return  self
     */ 
    // public function setUpdatedAt(\DateTime $updatedAt)
    // {
    //     $this->updatedAt = $updatedAt;

    //     return $this;
    // }

    /**
     * Get the value of slug
     */ 
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * @return Collection|Tags[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }
public function __toString(){
    return $this->getNom().$this->getSlug();
   
        
}

/**
 * @return Collection|Commentaires[]
 */
public function getCommentaires(): Collection
{
    return $this->commentaires;
}

public function addCommentaire(Commentaires $commentaire): self
{
    if (!$this->commentaires->contains($commentaire)) {
        $this->commentaires[] = $commentaire;
        $commentaire->setAnimal($this);
    }

    return $this;
}

public function removeCommentaire(Commentaires $commentaire): self
{
    if ($this->commentaires->removeElement($commentaire)) {
        // set the owning side to null (unless already changed)
        if ($commentaire->getAnimal() === $this) {
            $commentaire->setAnimal(null);
        }
    }

    return $this;
}


      
}
