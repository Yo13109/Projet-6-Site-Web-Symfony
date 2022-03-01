<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message="l'email que vous avez indiqué est déjà utilisé !"
 * )
 * @UniqueEntity(
 * fields={"userName"},
 * message="le pseudo que vous avez indiqué est déjà utilisé !"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)^[a-zA-Z\d]{8,}$/",
     *     message="Votre mot de passe doit contenir une Majuscule, une minuscule et 8 caratères minimum !"
     * )
     *  @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Votre mot de passe doit comporter au moins  {{ limit }} caratères",
     *      maxMessage = "Votre mot de passe ne peut pas dépasser  {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

   
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activated;

    /**
     * @ORM\OneToMany(targetEntity=Commentary::class, mappedBy="user")
     */
    private $commentary;

    /**
     * @ORM\OneToMany(targetEntity=Trick::class, mappedBy="users")
     */
    private $tricks;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Votre pseudo doit comporter au moins  {{ limit }} caratères",
     *      maxMessage = "Votre pseudo ne peut pas dépasser  {{ limit }} caractères"
     * )
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    public function __construct()
    {
        $this->commentary = new ArrayCollection();
        $this->tricks = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->userName;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADMIN';
        $roles[] = 'ROLE_SUPER_ADMIN';



        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getActivated(): ?bool
    {
        return $this->activated;
    }

    public function setActivated(bool $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * @return Collection|Commentary[]
     */
    public function getCommentary(): Collection
    {
        return $this->commentary;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentary->contains($commentary)) {
            $this->commentary[] = $commentary;
            $commentary->setUser($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentary->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getUser() === $this) {
                $commentary->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUsers($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getUsers() === $this) {
                $trick->setUsers(null);
            }
        }

        return $this;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }
   
}
