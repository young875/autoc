<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarsRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("slug")
 */
class Cars
{



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Assert\Unique()
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @ORM\Column(type="integer")
     */
    private $chevaux;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version;

    /**
     * @ORM\Column(type="integer")
     */
    private $porte;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Cars
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $publie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Boites", inversedBy="Cars")
     */
    private $boites;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Carburations", inversedBy="Cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carburations;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Couleurs", inversedBy="Cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $couleurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etats", inversedBy="Cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etats;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marques", inversedBy="Cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marques;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="cars")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="car")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity=Wish::class, mappedBy="car")
     */
    private $wishes;




    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->wishes = new ArrayCollection();
    }



    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify($this->getMarques()->getMarque().' '.$this->model.' '.$this->version.' '.$this->annee.' '.$this->getCouleurs()->getCouleur());
        }
        return $this;
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function initializePublie(){
        if(empty($this->publie)){
            $this->publie = 0;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }


    public function getChevaux(): ?int
    {
        return $this->chevaux;
    }

    public function setChevaux(int $chevaux): self
    {
        $this->chevaux = $chevaux;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }


    public function getPorte(): ?int
    {
        return $this->porte;
    }

    public function setPorte(int $porte): self
    {
        $this->porte = $porte;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getKilometre(): ?int
    {
        return $this->kilometre;
    }

    public function setKilometre(int $kilometre): self
    {
        $this->kilometre = $kilometre;

        return $this;
    }

    public function getPublie(): ?bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): self
    {
        $this->publie = $publie;

        return $this;
    }

    public function getBoites(): ?Boites
    {
        return $this->boites;
    }

    public function setBoites(?Boites $boites): self
    {
        $this->boites = $boites;

        return $this;
    }

    public function getCarburations(): ?Carburations
    {
        return $this->carburations;
    }

    public function setCarburations(?Carburations $carburations): self
    {
        $this->carburations = $carburations;

        return $this;
    }

    public function getCouleurs(): ?Couleurs
    {
        return $this->couleurs;
    }

    public function setCouleurs(?Couleurs $couleurs): self
    {
        $this->couleurs = $couleurs;

        return $this;
    }

    public function getEtats(): ?Etats
    {
        return $this->etats;
    }

    public function setEtats(?Etats $etats): self
    {
        $this->etats = $etats;

        return $this;
    }

    public function getMarques(): ?Marques
    {
        return $this->marques;
    }

    public function setMarques(?Marques $marques): self
    {
        $this->marques = $marques;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCars($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getCars() === $this) {
                $image->setCars(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setCar($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getCar() === $this) {
                $booking->setCar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Wish[]
     */
    public function getWishes(): Collection
    {
        return $this->wishes;
    }

    public function addWish(Wish $wish): self
    {
        if (!$this->wishes->contains($wish)) {
            $this->wishes[] = $wish;
            $wish->setCar($this);
        }

        return $this;
    }

    public function removeWish(Wish $wish): self
    {
        if ($this->wishes->removeElement($wish)) {
            // set the owning side to null (unless already changed)
            if ($wish->getCar() === $this) {
                $wish->setCar(null);
            }
        }

        return $this;
    }






}
