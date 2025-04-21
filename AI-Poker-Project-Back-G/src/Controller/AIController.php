<?php

namespace App\Controller;

use App\Service\AiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AIController extends AbstractController
{
    private AiService $AiService;

    public function __construct(AiService $AiService)
    {
        $this->AiService = $AiService;
    }

    #[Route('/AI-Project/api/ai/chat', methods: ['GET'])]
    public function ask(Request $request): JsonResponse
    {
        $prompt = $request->query->get('prompt');
        if (!$prompt) {
            return new JsonResponse(['error' => 'Le paramètre prompt est requis'], 400);
        }

        $result = $this->AiService->generateResponse($prompt);

        if ($result['success']) {
            $response = ['response' => $result['message']];

             if (isset($result['reasoning'])) {
                $response['reasoning'] = $result['reasoning'];
            }

            return new JsonResponse(
                $response,
                200,
                [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Credentials' => 'true',
                    'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, private',
                    'Pragma' => 'no-cache',
                    'Expires' => '0'
                ]
            );
        }else {
            return new JsonResponse(
                [
                    'error' => $result['message'],
                    'details' => $result['data']
                ],
                400,
                [
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Credentials' => 'true'
                ]
            );
        }
    }
}
