<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tags")
 *
 * @UniqueEntity(fields={"name"})
 */
class Tag
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
     * Tasks.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Task[] Tasks
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Task", mappedBy="tags")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $tasks;

    /**
     * Notes.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Note[] Notes
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Note", mappedBy="tags")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $notes;

    /**
     * Taskslists.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection|\App\Entity\Tasklist[] Tasklists
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Tasklist", mappedBy="tags")
     *
     * @Assert\Type(type="Doctrine\Common\Collections\ArrayCollection")
     */
    private $tasklists;

    /**
     * Tag constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->tasklists = new ArrayCollection();
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
     * Getter for tasks.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Task[] Tasks collection
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    /**
     * Add task to collection.
     *
     * @param \App\Entity\Task $task Task entity
     */
    public function addTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->addTag($this);
        }
    }

    /**
     * Remove task from collection.
     *
     * @param \App\Entity\Task $task Task entity
     */
    public function removeTask(Task $task): void
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            $task->removeTag($this);
        }
    }

    /**
     * Getter for notes.
     *
     * @return \Doctrine\Common\Collections\Collection|\App\Entity\Note[] Notes collection
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    /**
     * Add note to collection.
     *
     * @param \App\Entity\Note $note Note entity
     */
    public function addNote(Note $note): void
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->addTag($this);
        }
    }

    /**
     * Remove note from collection.
     *
     * @param \App\Entity\Note $note Note entity
     */
    public function removeNote(Note $note): void
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            $note->removeTag($this);
        }
    }

    /**
     * @return Collection|Tasklist[]
     */
    public function getTasklists(): Collection
    {
        return $this->tasklists;
    }

    public function addTasklist(Tasklist $tasklist): self
    {
        if (!$this->tasklists->contains($tasklist)) {
            $this->tasklists[] = $tasklist;
            $tasklist->addTag($this);
        }

        return $this;
    }

    public function removeTasklist(Tasklist $tasklist): self
    {
        if ($this->tasklists->contains($tasklist)) {
            $this->tasklists->removeElement($tasklist);
            $tasklist->removeTag($this);
        }

        return $this;
    }
}