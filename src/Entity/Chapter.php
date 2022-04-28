<?php

namespace App\Entity;

use App\Repository\ChapterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterRepository::class)
 */
class Chapter
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="chapters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="chapter")
     */
    private $programmes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showTime;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
    }

    public function __toString(){
        return (string) $this->name;
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(?\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

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

    /**
     * @return Collection|Programme[]
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setChapter($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getChapter() === $this) {
                $programme->setChapter(null);
            }
        }

        return $this;
    }

    public function getShowTime(): ?bool
    {
        return $this->showTime;
    }

    public function setShowTime(bool $showTime): self
    {
        $this->showTime = $showTime;

        return $this;
    }
}
