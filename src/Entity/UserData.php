<?php

namespace App\Entity;

use App\Repository\UserDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class UserData.
 *
 * @ORM\Entity(repositoryClass=UserDataRepository::class)
 * @ORM\Table(name="users_data")
 */
class UserData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nick.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     *     nullable=true
     *     )
     */
    private $nick;

    /**
     * Firstname.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     *     nullable=true
     *     )
     */
    private $firstname;

    /**
     * Surname.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=45,
     *     nullable=true
     *     )
     */
    private $surname;

    /**
     * Bio.
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     *     )
     */
    private $bio;

    /**
     * User.
     *
     * @ORM\OneToOne(
     *     targetEntity=User::class,
     *     inversedBy="userData",
     *     cascade={"persist", "remove"}
     *     )
     *
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Getter for the Id.
     *
     * @return int|null Result
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for the Nick.
     *
     * @return string|null Nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * Setter for the Nick.
     *
     * @param string $nick Nick
     */
    public function setNick(?string $nick): void
    {
        $this->nick = $nick;
    }

    /**
     * Getter for the Firstname.
     *
     * @return string|null Firstname
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Setter for the Firstname.
     *
     * @param string $firstname Firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Getter for the Surname.
     *
     * @return string|null Surname
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * Setter for the Surname.
     *
     * @param string $surname Surname
     */
    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * Getter for the Bio.
     *
     * @return string|null Bio
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * Setter for the Bio.
     *
     * @param string $bio Bio
     */
    public function setBio(?string $bio): void
    {
        $this->bio = $bio;
    }

    /**
     * Getter for the user.
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Setter for the User.
     *
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
