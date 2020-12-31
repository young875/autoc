<?php


namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
    const TITRE =[
        'Civilité' => null,
        'MME.' => 'MME.',
        'M.' => 'M.'
    ];


    /**
     * @var string|null
     * @Assert\NotNull()
     * @Assert\Length(min=3, max=5)
     */
    private $civility;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $country;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $city;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $zip;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=3, max=255)
     */
    private $object;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/[0-9]/"
     * )
     */
    private $phone;


    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;

    /**
     * @return string|null
     */
    public function getCivility(): ?string
    {
        return $this->civility;
    }

    /**
     * @param string|null $civility
     * @return Contact
     */
    public function setCivility(?string $civility): Contact
    {
        $this->civility = $civility;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return Contact
     */
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string|null $lastname
     * @return Contact
     */
    public function setLastname(?string $lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     * @return Contact
     */
    public function setCountry(?string $country): Contact
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return Contact
     */
    public function setCity(?string $city): Contact
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }

    /**
     * @param string|null $zip
     * @return Contact
     */
    public function setZip(?string $zip): Contact
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getObject(): ?string
    {
        return $this->object;
    }

    /**
     * @param string|null $object
     * @return Contact
     */
    public function setObject(?string $object): Contact
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     * @return Contact
     */
    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }




}