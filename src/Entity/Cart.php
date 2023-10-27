<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: LineCart::class)]
    private Collection $cartLineCart;

    #[ORM\OneToOne(inversedBy: 'cartUser', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $cartUser = null;

    public function __construct()
    {
        $this->cartLineCart = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
    /**
     * @return Collection<int, LineCart>
     */
    public function getCartLineCart(): Collection
    {
        return $this->cartLineCart;
    }

    public function addCartLineCart(LineCart $cartLineCart): static
    {
        if (!$this->cartLineCart->contains($cartLineCart)) {
            $this->cartLineCart->add($cartLineCart);
            $cartLineCart->setCart($this);
        }

        return $this;
    }

    public function removeCartLineCart(LineCart $cartLineCart): static
    {
        if ($this->cartLineCart->removeElement($cartLineCart)) {
            // set the owning side to null (unless already changed)
            if ($cartLineCart->getCart() === $this) {
                $cartLineCart->setCart(null);
            }
        }

        return $this;
    }

    public function getCartUser(): ?User
    {
        return $this->cartUser;
    }

    public function setCartUser(User $cartUser): static
    {
        $this->cartUser = $cartUser;

        return $this;
    }
}