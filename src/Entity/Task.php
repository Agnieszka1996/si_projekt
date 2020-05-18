<?php
/**
 * Task entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * Primary key.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     * )
     */
    private $name;

    /**
     * Term.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(
     *     type="datetime",
     *     nullable=true,
     * )
     */
    private $term;

    /**
     * Description.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     * )
     */
    private $description;

    /**
     * Comment.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true,
     * )
     */
    private $comment;

    /**
     * Category.
     *
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * Tasklist.
     *
     * @ORM\ManyToOne(targetEntity=Tasklist::class)
     */
    private $tasklist;

    /**
     * Getter for Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for Name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for Name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Getter for Term.
     *
     * @return \DateTimeInterface|null Term
     */
    public function getTerm(): ?\DateTimeInterface
    {
        return $this->term;
    }

    /**
     * Setter for Term.
     *
     * @param \DateTimeInterface $term Term
     */
    public function setTerm(?\DateTimeInterface $term): void
    {
        $this->term = $term;
    }

    /**
     * Getter for Description.
     *
     * @return string|null Description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for Description.
     *
     * @param string $description Description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter for Comment.
     *
     * @return string|null Comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Setter for Comment.
     *
     * @param string $comment Comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    public function getTasklist(): ?Tasklist
    {
        return $this->tasklist;
    }

    public function setTasklist(?Tasklist $tasklist): self
    {
        $this->tasklist = $tasklist;

        return $this;
    }
}
