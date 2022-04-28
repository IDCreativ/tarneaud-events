<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\GeneralConfigurationRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=GeneralConfigurationRepository::class)
 * @Vich\Uploadable
 * @ApiResource(
 *      normalizationContext={
 *          "groups"={
 *              "read:config"
 *          }
 *      },
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 * )
 */
class GeneralConfiguration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:config"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $siteType = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tagline;

    /**
     * @ORM\OneToOne(targetEntity=Event::class, cascade={"persist", "remove"})
     * @Groups({"read:config"})
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @Vich\UploadableField(mapping="logo_images", fileNameProperty="logo")
     * @var File
     */
    private $logoFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkedin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $youtube;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $copyright;

    /**
     * @ORM\OneToMany(targetEntity=Module::class, cascade={"persist", "remove"}, mappedBy="generalConfiguration")
     */
    private $modules;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $googleAnalytics;

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    public function __toString(){
        return (string) $this->title . ' - ' . $this->tagline;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(?string $tagline): self
    {
        $this->tagline = $tagline;

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

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function setLogoFile(File $logo = null)
    {
        $this->logoFile = $logo;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($logo) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getLogoFile()
    {
        return $this->logoFile;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): self
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getCopyright(): ?string
    {
        return $this->copyright;
    }

    public function setCopyright(?string $copyright): self
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * @return Collection|Module[]
     */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules[] = $module;
            $module->setGeneralConfiguration($this);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        if ($this->modules->removeElement($module)) {
            // set the owning side to null (unless already changed)
            if ($module->getGeneralConfiguration() === $this) {
                $module->setGeneralConfiguration(null);
            }
        }

        return $this;
    }

    public function getSiteType(): ?int
    {
        return $this->siteType;
    }

    public function setSiteType(int $siteType): self
    {
        $this->siteType = $siteType;

        return $this;
    }

    public function getGoogleAnalytics(): ?string
    {
        return $this->googleAnalytics;
    }

    public function setGoogleAnalytics(?string $googleAnalytics): self
    {
        $this->googleAnalytics = $googleAnalytics;

        return $this;
    }
}
