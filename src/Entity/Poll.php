<?php

namespace App\Entity;

use App\Repository\PollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PollRepository::class)
 */
class Poll
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
     * @ORM\Column(type="boolean")
     */
    private $visibility;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=PollVote::class, mappedBy="poll", orphanRemoval=true)
     */
    private $pollVotes;

    /**
     * @ORM\OneToMany(targetEntity=PollOption::class, mappedBy="poll")
     */
    private $pollOptions;

    public function __toString(){
        return (string) $this->question;
    }

    public function __construct()
    {
        $this->pollVotes = new ArrayCollection();
        $this->pollOptions = new ArrayCollection();
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

    public function getVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): self
    {
        $this->visibility = $visibility;

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

    /**
     * @return Collection|PollVote[]
     */
    public function getPollVotes(): Collection
    {
        return $this->pollVotes;
    }

    public function addPollVote(PollVote $pollVote): self
    {
        if (!$this->pollVotes->contains($pollVote)) {
            $this->pollVotes[] = $pollVote;
            $pollVote->setPoll($this);
        }

        return $this;
    }

    public function removePollVote(PollVote $pollVote): self
    {
        if ($this->pollVotes->removeElement($pollVote)) {
            // set the owning side to null (unless already changed)
            if ($pollVote->getPoll() === $this) {
                $pollVote->setPoll(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PollOption[]
     */
    public function getPollOptions(): Collection
    {
        return $this->pollOptions;
    }

    public function addPollOption(PollOption $pollOption): self
    {
        if (!$this->pollOptions->contains($pollOption)) {
            $this->pollOptions[] = $pollOption;
            $pollOption->setPoll($this);
        }

        return $this;
    }

    public function removePollOption(PollOption $pollOption): self
    {
        if ($this->pollOptions->removeElement($pollOption)) {
            // set the owning side to null (unless already changed)
            if ($pollOption->getPoll() === $this) {
                $pollOption->setPoll(null);
            }
        }

        return $this;
    }

    public function isVoted($user) : bool
    {
        foreach ($this->pollVotes as $pollVote)
        {
            if ($pollVote->getUser() == $user)
            {
                return true;
            }
        }
        return false;
    }
}
