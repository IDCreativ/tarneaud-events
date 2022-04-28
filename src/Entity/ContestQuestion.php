<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContestQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ContestQuestionRepository::class)
 */
class ContestQuestion
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
    private $question;

    /**
     * @ORM\OneToMany(targetEntity=ContestOption::class, mappedBy="contestQuestion")
     */
    private $contestOptions;

    /**
     * @ORM\ManyToOne(targetEntity=Contest::class, inversedBy="contestQuestions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contest;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=ContestEntry::class, mappedBy="contestQuestion", orphanRemoval=true)
     */
    private $contestEntries;

    public function __toString()
    {
        return $this->question;
    }

    public function __construct()
    {
        $this->contestOptions = new ArrayCollection();
        $this->contestEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    /**
     * @return Collection<int, ContestOption>
     */
    public function getContestOptions(): Collection
    {
        return $this->contestOptions;
    }

    public function addContestOption(ContestOption $contestOption): self
    {
        if (!$this->contestOptions->contains($contestOption)) {
            $this->contestOptions[] = $contestOption;
            $contestOption->setContestQuestion($this);
        }

        return $this;
    }

    public function removeContestOption(ContestOption $contestOption): self
    {
        if ($this->contestOptions->removeElement($contestOption)) {
            // set the owning side to null (unless already changed)
            if ($contestOption->getContestQuestion() === $this) {
                $contestOption->setContestQuestion(null);
            }
        }

        return $this;
    }

    public function getContest(): ?Contest
    {
        return $this->contest;
    }

    public function setContest(?Contest $contest): self
    {
        $this->contest = $contest;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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
            $contestEntry->setContestQuestion($this);
        }

        return $this;
    }

    public function removeContestEntry(ContestEntry $contestEntry): self
    {
        if ($this->contestEntries->removeElement($contestEntry)) {
            // set the owning side to null (unless already changed)
            if ($contestEntry->getContestQuestion() === $this) {
                $contestEntry->setContestQuestion(null);
            }
        }

        return $this;
    }
}
