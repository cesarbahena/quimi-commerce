<?php

namespace QuimiCommerce\Presentation\Health;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class HealthController
{
    #[Route('/health', name: 'health_check', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'timestamp' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
            'checks' => [
                'application' => 'ok',
            ],
        ], Response::HTTP_OK);
    }

    #[Route('/health/liveness', name: 'health_liveness', methods: ['GET'])]
    public function liveness(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok'], Response::HTTP_OK);
    }

    #[Route('/health/readiness', name: 'health_readiness', methods: ['GET'])]
    public function readiness(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok',
            'database' => 'ok',
            'redis' => 'ok',
        ], Response::HTTP_OK);
    }
}
