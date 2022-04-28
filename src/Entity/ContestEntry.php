<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContestEntryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ContestEntryRepository::class)
 */
class ContestEntry
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=ContestOption::class, inversedBy="contestEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contestOption;

    /**
     * @ORM\ManyToOne(targetEntity=ContestQuestion::class, inversedBy="contestEntries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contestQuestion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getContestOption(): ?ContestOption
    {
        return $this->contestOption;
    }

    public function setContestOption(?ContestOption $contestOption): self
    {
        $this->contestOption = $contestOption;

        return $this;
    }

    public function getContestQuestion(): ?ContestQuestion
    {
        return $this->contestQuestion;
    }

    public function setContestQuestion(?ContestQuestion $contestQuestion): self
    {
        $this->contestQuestion = $contestQuestion;

        return $this;
    }
}
