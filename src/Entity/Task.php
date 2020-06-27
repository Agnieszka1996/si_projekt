<?php
/**
 * Task entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Task.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="tasks")
 *
 * @UniqueEntity(fields={"name"})
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
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     */
    private $name;

    /**
     * Term.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
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
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private $description;

    /**
     * Category.
     *
     * @ORM\ManyToOne(
     *     targetEntity=Category::class,
     *     inversedBy="tasks"
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Category")
     */
    private $category;

    /**
     * Tags.
     *
     * @var array
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Tag",
     *     inversedBy="tasks",
     *     orphanRemoval=true,
     *     fetch="EXTRA_LAZY",
     * )
     * @ORM\JoinTable(name="tasks_tags")
     *
     * @Assert\All({
     * @Assert\Type(type="App\Entity\Tag")
     * })
     */
    private $tags;

    /**
     * Author.
     *
     * @var \App\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\User")
     */
    private $author;

    /**
     * Comments.
     *
     * @var array
     *
     * @ORM\OneToMany(
     *     targetEntity=Comment::class,
     *     mappedBy="task",
     *     orphanRemoval=true
     * )
     *
     * @Assert\All({
     * @Assert\Type(type="App\Entity\Comment")
     * })
     */
    private $comments;

    /**
     * Alarm.
     *
     * @ORM\ManyToOne(targetEntity=Alarm::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Alarm")
     */
    private $alarm;

    /**
     * Priority.
     *
     * @ORM\ManyToOne(targetEntity=Priority::class)
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Priority")
     */
    private $priority;

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

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
    public function getTerm(): ?DateTimeInterface
    {
        return $this->term;
    }

    /**
     * Setter for Term.
     *
     * @param \DateTimeInterface $term Term
     */
    public function setTerm(DateTimeInterface $term): void
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
     * Getter for category.
     *
     * @return \App\Entity\Category|null Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category.
     *
     * @param \App\Entity\Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for tags.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag from collection.
     *
     * @param \App\Entity\Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

    /**
     * Getter for author.
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Setter for author.
     *
     * @return $this
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter for comments.
     *
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    /**
     * Add comment.
     *
     * @return $this
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTask($this);
        }

        return $this;
    }

    /**
     * Remove comment.
     *
     * @return $this
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTask() === $this) {
                $comment->setTask(null);
            }
        }

        return $this;
    }

    /**
     * Getter for alarm.
     *
     * @return Alarm|null
     */
    public function getAlarm(): ?Alarm
    {
        return $this->alarm;
    }

    /**
     * Setter for alarm.
     *
     * @return $this
     */
    public function setAlarm(?Alarm $alarm): void
    {
        $this->alarm = $alarm;
    }

    /**
     * Getter for priority.
     *
     * @return Priority|null
     */
    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    /**
     * Setter for priority.
     *
     * @return $this
     */
    public function setPriority(?Priority $priority): void
    {
        $this->priority = $priority;
    }
}
