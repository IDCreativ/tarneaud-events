<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ContestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ContestRepository::class)
 */
class Contest
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=ContestQuestion::class, mappedBy="contest", orphanRemoval=true)
     */
    private $contestQuestions;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="contests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $questionStatus;

    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->contestQuestions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ContestQuestion>
     */
    public function getContestQuestions(): Collection
    {
        return $this->contestQuestions;
    }

    public function addContestQuestion(ContestQuestion $contestQuestion): self
    {
        if (!$this->contestQuestions->contains($contestQuestion)) {
            $this->contestQuestions[] = $contestQuestion;
            $contestQuestion->setContest($this);
        }

        return $this;
    }

    public function removeContestQuestion(ContestQuestion $contestQuestion): self
    {
        if ($this->contestQuestions->removeElement($contestQuestion)) {
            // set the owning side to null (unless already changed)
            if ($contestQuestion->getContest() === $this) {
                $contestQuestion->setContest(null);
            }
        }

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getQuestionStatus(): ?int
    {
        return $this->questionStatus;
    }

    public function setQuestionStatus(int $questionStatus): self
    {
        $this->questionStatus = $questionStatus;

        return $this;
    }
}
