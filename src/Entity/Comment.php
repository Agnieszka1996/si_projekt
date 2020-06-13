<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comment.
 *
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Content.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $content;

    /**
     * Date.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(
     *     type="datetime"
     * )
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $task;


    /**
     * Getter for Id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Content.
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }


    /**
     * Setter for Content.
     *
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter for Date.
     *
     * @return DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Setter for Date.
     *
     * @param DateTimeInterface $date
     * @return $this
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter for Task.
     *
     * @return Task|null
     */
    public function getTask(): ?Task
    {
        return $this->task;
    }

    /**
     * Setter for Task.
     *
     * @param Task|null $task
     * @return $this
     */
    public function setTask(?Task $task): void
    {
        $this->task = $task;
    }
}
