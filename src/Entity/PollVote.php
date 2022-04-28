<?php

namespace App\Entity;

use App\Repository\PollVoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PollVoteRepository::class)
 */
class PollVote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pollVotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Poll::class, inversedBy="pollVotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poll;

    /**
     * @ORM\ManyToOne(targetEntity=PollOption::class, inversedBy="pollVotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pollOption;

    public function __toString(){
        return (string) $this->user." - ".$this->pollOption;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function setPoll(?Poll $poll): self
    {
        $this->poll = $poll;

        return $this;
    }

    public function getPollOption(): ?PollOption
    {
        return $this->pollOption;
    }

    public function setPollOption(?PollOption $pollOption): self
    {
        $this->pollOption = $pollOption;

        return $this;
    }
}
