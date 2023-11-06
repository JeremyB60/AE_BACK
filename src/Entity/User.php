<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, type: 'string')]
    private string $firstname;

    #[ORM\Column(length: 255, type: 'string')]
    private string $lastname;

    #[ORM\Column]
    private array $accountStatus = [];

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Cart $cartUser = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Order::class)]
    private Collection $orderUser;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Review::class)]
    private Collection $reviewUser;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: Address::class)]
    private Collection $userAddress;

    public function __construct()
    {
        $this->orderUser = new ArrayCollection();
        $this->reviewUser = new ArrayCollection();
        $this->userAddress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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

    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getaccountStatus(): array
    {
        $accountStatus = $this->accountStatus;
        $accountStatus[] = 'active';

        return array_unique($accountStatus);
    }

    public function setaccountStatus(array $accountStatus): static
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }

    public function getCartUser(): ?Cart
    {
        return $this->cartUser;
    }

    public function setCartUser(?Cart $cartUser): static
    {
        $this->cartUser = $cartUser;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrderUser(): Collection
    {
        return $this->orderUser;
    }

    public function addOrderUser(Order $orderUser): static
    {
        if (!$this->orderUser->contains($orderUser)) {
            $this->orderUser->add($orderUser);
            $orderUser->setUserId($this);
        }

        return $this;
    }

    public function removeOrderUser(Order $orderUser): static
    {
        if ($this->orderUser->removeElement($orderUser)) {
            // set the owning side to null (unless already changed)
            if ($orderUser->getUserId() === $this) {
                $orderUser->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviewUser(): Collection
    {
        return $this->reviewUser;
    }

    public function addReviewUser(Review $reviewUser): static
    {
        if (!$this->reviewUser->contains($reviewUser)) {
            $this->reviewUser->add($reviewUser);
            $reviewUser->setUserId($this);
        }

        return $this;
    }

    public function removeReviewUser(Review $reviewUser): static
    {
        if ($this->reviewUser->removeElement($reviewUser)) {
            // set the owning side to null (unless already changed)
            if ($reviewUser->getUserId() === $this) {
                $reviewUser->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getUserAddress(): Collection
    {
        return $this->userAddress;
    }

    public function addUserAddress(Address $userAddress): static
    {
        if (!$this->userAddress->contains($userAddress)) {
            $this->userAddress->add($userAddress);
            $userAddress->setUserId($this);
        }

        return $this;
    }

    public function removeUserAddress(Address $userAddress): static
    {
        if ($this->userAddress->removeElement($userAddress)) {
            // set the owning side to null (unless already changed)
            if ($userAddress->getUserId() === $this) {
                $userAddress->setUserId(null);
            }
        }

        return $this;
    }
}
