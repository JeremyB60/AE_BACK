<?php

namespace App\DTO;

class UserRegistrationDTO
{
    private $lastname;
    private $firstname;
    private $email;
    private $password;
    private $roles;
    private $accountStatus;

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
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

    public function getAccountStatus(): array
    {
        $accountStatus = $this->accountStatus;
        $accountStatus[] = 'active';

        return array_unique($accountStatus);
    }
    public function setAccountStatus(array $accountStatus): static
    {
        $this->accountStatus = $accountStatus;

        return $this;
    }
}
