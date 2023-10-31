<?php

namespace App\Controller;

use App\DTO\UserRegistrationDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\UserRegistrationService;

class UserController extends AbstractController
{
    private $serializer;
    private $validator;
    private $registrationService;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator,
    UserRegistrationService $registrationService)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->registrationService = $registrationService;
    }

    /**
     * @Route("/register", name="user_register", methods={"POST"})
     */
    public function register(Request $request)
    {
        // Désérialisez les données JSON en un objet UserRegistrationDTO
        $userRegistrationDTO = $this->deserializeUserRegistrationDTO($request);

        // Validez le DTO
        $errors = $this->validator->validate($userRegistrationDTO);

        if (count($errors) > 0) {
            // Il y a des erreurs de validation, retournez une réponse JSON d'erreur
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        // Utilisez le service pour gérer l'inscription
        $result = $this->registrationService->registerUser($userRegistrationDTO);

        if ($result === 'Inscription réussie') {
            // Retournez une réponse JSON en cas de succès
            return new JsonResponse(['message' => 'Inscription réussie']);
        } else {
            // Retournez une réponse JSON en cas d'erreur
            return new JsonResponse(['error' => $result], 400);
        }
    }

    private function deserializeUserRegistrationDTO(Request $request)
    {
        $content = $request->getContent();
        return $this->serializer->deserialize($content, UserRegistrationDTO::class, 'json');
    }
}
