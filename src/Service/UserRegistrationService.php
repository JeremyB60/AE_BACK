<?php

namespace App\Service;

use App\DTO\UserRegistrationDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UserRegistrationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function registerUser(UserRegistrationDTO $registrationDTO)
    {
        // Effectuez des opérations de validation des données
        // (par exemple,vérification de l'unicité de l'adresse email, longueur minimale du mot de passe, etc.)
        if (!$this->isEmailUnique($registrationDTO->getEmail())) {
            return 'Email déjà utilisé';
        }

        // Récupérez le mot de passe de l'objet $registrationDTO
        $password = $registrationDTO->getPassword();

        if (empty($password)) {
            return 'Le mot de passe ne peut être vide.';
        } else {
            // Le mot de passe n'est pas vide, hachez-le
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        }

        // Créez une nouvelle entité User
        $user = new User();
        $user->setLastName($registrationDTO->getLastName());
        $user->setFirstName($registrationDTO->getFirstName());
        $user->setEmail($registrationDTO->getEmail());
        $user->setPassword($hashedPassword);
        $user->setRoles($registrationDTO->getRoles());
        $user->setAccountStatus($registrationDTO->getAccountStatus());

        // Enregistrez l'utilisateur en base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return 'Inscription réussie';
    }

    private function isEmailUnique($email)
    {
        // Supprimer les espaces de l'adresse e-mail
        $cleanedEmail = str_replace(' ', '', $email);
        // Vous pouvez implémenter une logique pour vérifier si l'adresse email est unique dans la base de données
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $cleanedEmail]);

        return $existingUser === null;
    }
}
