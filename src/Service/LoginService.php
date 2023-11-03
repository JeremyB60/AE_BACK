<?php

// src/Service/LoginService.php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use App\DTO\LoginDTO;

class LoginService
{
    private $passwordHasher;
    private $entityManager;
    private $jwtManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->jwtManager = $jwtManager;
    }

    public function authenticate(LoginDTO $loginDTO): ?string
    {
        $email = $loginDTO->getEmail();
        $password = $loginDTO->getPassword();

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user && $this->passwordHasher->isPasswordValid($user, $password)) {
            // Génération du token JWT
            return $this->jwtManager->create($user);
        }

        return null;
    }
}
