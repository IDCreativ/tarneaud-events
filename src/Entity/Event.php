<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={
 *          "groups"={
 *              "read:event"
 *          }
 *      },
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:event"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:event"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"read:event"})
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:event"})
     */
    private $dateStart;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:event"})
     */
    private $dateEnd;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:event"})
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read:event"})
     */
    private $public;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:event"})
     */
    private $status = -1;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"read:event"})
     */
    private $type = 0;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="event", orphanRemoval=true)
     */
    private $programmes;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="event")
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $videos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eventPassword;

    /**
     * @ORM\OneToMany(targetEntity=Chapter::class, mappedBy="event")
     */
    private $chapters;

    /**
     * @ORM\OneToMany(targetEntity=Periode::class, mappedBy="event", orphanRemoval=true)
     */
    private $periodes;

    /**
     * @ORM\OneToMany(targetEntity=EventDate::class, mappedBy="event", orphanRemoval=true)
     */
    private $eventDates;

    /**
     * @ORM\OneToMany(targetEntity=Contest::class, mappedBy="event", orphanRemoval=true)
     */
    private $contests;

    public function __construct()
    {
        $this->programmes = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->chapters = new ArrayCollection();
        $this->periodes = new ArrayCollection();
        $this->eventDates = new ArrayCollection();
        $this->contests = new ArrayCollection();
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

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getEmbedCode(): ?string
    {
        return $this->embedCode;
    }

    public function setEmbedCode(?string $embedCode): self
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getEventPassword(): ?string
    {
        return $this->eventPassword;
    }

    public function setEventPassword(?string $eventPassword): self
    {
        $this->eventPassword = $eventPassword;

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
            $programme->setEvent($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getEvent() === $this) {
                $programme->setEvent(null);
            }
        }

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

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setEvent($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getEvent() === $this) {
                $video->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Chapter[]
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): self
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters[] = $chapter;
            $chapter->setEvent($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): self
    {
        if ($this->chapters->removeElement($chapter)) {
            // set the owning side to null (unless already changed)
            if ($chapter->getEvent() === $this) {
                $chapter->setEvent(null);
            }
        }

        return $this;
    }

    public function hasReplays() : bool
    {
        $v_array = array();
        foreach ($this->videos as $video) {
            if ($video->getType() == 2) {
                $v_array[] = $video;
            }
        }
        if (count($v_array) > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function dateHasProgrammes($date) : bool
    {
        foreach ($this->getProgrammes() as $programme) {
            if ($programme->getDateStart()->format('d') == $date) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function hasProgrammeWithNoDates() : bool
    {
        foreach ($this->getProgrammes() as $programme) {
            if ($programme->getDateStart()) {
                return true;
            }
            else {
                return false;
            }
        }
    }

    public function isLongerThanOneDay()
    {
        if ($this->getDateEnd()->format('d') - $this->getDateStart()->format('d') > 0) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @return Collection|Periode[]
     */
    public function getPeriodes(): Collection
    {
        return $this->periodes;
    }

    public function addPeriode(Periode $periode): self
    {
        if (!$this->periodes->contains($periode)) {
            $this->periodes[] = $periode;
            $periode->setEvent($this);
        }

        return $this;
    }

    public function removePeriode(Periode $periode): self
    {
        if ($this->periodes->removeElement($periode)) {
            // set the owning side to null (unless already changed)
            if ($periode->getEvent() === $this) {
                $periode->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventDate[]
     */
    public function getEventDates(): Collection
    {
        return $this->eventDates;
    }

    public function addEventDate(EventDate $eventDate): self
    {
        if (!$this->eventDates->contains($eventDate)) {
            $this->eventDates[] = $eventDate;
            $eventDate->setEvent($this);
        }

        return $this;
    }

    public function removeEventDate(EventDate $eventDate): self
    {
        if ($this->eventDates->removeElement($eventDate)) {
            // set the owning side to null (unless already changed)
            if ($eventDate->getEvent() === $this) {
                $eventDate->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Contest>
     */
    public function getContests(): Collection
    {
        return $this->contests;
    }

    public function addContest(Contest $contest): self
    {
        if (!$this->contests->contains($contest)) {
            $this->contests[] = $contest;
            $contest->setEvent($this);
        }

        return $this;
    }

    public function removeContest(Contest $contest): self
    {
        if ($this->contests->removeElement($contest)) {
            // set the owning side to null (unless already changed)
            if ($contest->getEvent() === $this) {
                $contest->setEvent(null);
            }
        }

        return $this;
    }
}
