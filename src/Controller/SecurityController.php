<?php

// src/Controller/LoginController.php
namespace App\Controller;

use App\Service\LoginService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\DTO\LoginDTO;

class SecurityController extends AbstractController
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $loginDTO = new LoginDTO();
        $loginDTO->setEmail($data['email']);
        $loginDTO->setPassword($data['password']);

        $token = $this->loginService->authenticate($loginDTO);

        if ($token) {
            return new JsonResponse(['token' => $token]);
        }

        return new JsonResponse(['message' => 'Identifiants invalides'], 401);
    }

    // ... Autres actions du contrôleur, y compris la déconnexion
}
