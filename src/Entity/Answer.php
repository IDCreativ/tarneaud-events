<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnswerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 * @ApiResource(
 *      normalizationContext={
 *          "groups"={
 *              "read:question"
 *          }
 *      },
 *      collectionOperations={"get"},
 *      itemOperations={"get"}
 * )
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read:question"})
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:question"})
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    public function __toString(){
        return (string) $this->answer;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
