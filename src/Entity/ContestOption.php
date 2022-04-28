<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContestOptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ContestOptionRepository::class)
 */
class ContestOption
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $optionText;

    /**
     * @ORM\ManyToOne(targetEntity=ContestQuestion::class, inversedBy="contestOptions")
     */
    private $contestQuestion;

    /**
     * @ORM\OneToMany(targetEntity=ContestEntry::class, mappedBy="contestOption", orphanRemoval=true)
     */
    private $contestEntries;

    public function __toString()
    {
        return $this->optionText;
    }

    public function __construct()
    {
        $this->contestEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOptionText(): ?string
    {
        return $this->optionText;
    }

    public function setOptionText(string $optionText): self
    {
        $this->optionText = $optionText;

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

    /**
     * @return Collection<int, ContestEntry>
     */
    public function getContestEntries(): Collection
    {
        return $this->contestEntries;
    }

    public function addContestEntry(ContestEntry $contestEntry): self
    {
        if (!$this->contestEntries->contains($contestEntry)) {
            $this->contestEntries[] = $contestEntry;
            $contestEntry->setContestOption($this);
        }

        return $this;
    }

    public function removeContestEntry(ContestEntry $contestEntry): self
    {
        if ($this->contestEntries->removeElement($contestEntry)) {
            // set the owning side to null (unless already changed)
            if ($contestEntry->getContestOption() === $this) {
                $contestEntry->setContestOption(null);
            }
        }

        return $this;
    }
}
