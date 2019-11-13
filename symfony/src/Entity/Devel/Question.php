<?php

namespace App\Entity\Devel;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Devel\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $answer_count;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $best_answer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $time;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAnswerCount(): ?int
    {
        return $this->answer_count;
    }

    public function setAnswerCount(int $answer_count): self
    {
        $this->answer_count = $answer_count;

        return $this;
    }

    public function getBestAnswer(): ?string
    {
        return $this->best_answer;
    }

    public function setBestAnswer(?string $best_answer): self
    {
        $this->best_answer = $best_answer;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }
}
