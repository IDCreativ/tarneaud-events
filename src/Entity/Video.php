<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
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
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\Column(type="integer")
     */
    private $platform;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $embedCode;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="videos")
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $type = 0;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtubeId;

    public function __toString(){
        return (string) $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getEmbedCode(): ?string
    {
        return $this->embedCode;
    }

    public function setEmbedCode(string $embedCode): self
    {
        $this->embedCode = $embedCode;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function isReplay() : bool
    {
        foreach ($this->videos as $video) {
            if ($video->getStatus == false) {
                return true;
            }
        }
    }

    public function getPlatform(): ?int
    {
        return $this->platform;
    }

    public function setPlatform(int $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getYoutubeId(): ?string
    {
        return $this->youtubeId;
    }

    public function setYoutubeId(?string $youtubeId): self
    {
        $this->youtubeId = $youtubeId;

        return $this;
    }
}
