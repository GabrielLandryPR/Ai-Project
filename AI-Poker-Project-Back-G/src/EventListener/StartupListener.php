<?php
// src/EventListener/StartupListener.php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Psr\Log\LoggerInterface;

class StartupListener
{
    private $startTime;
    private $graceTime = 6; // secondes
    private $logger;
    private $kernelStartTime;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->kernelStartTime = time();

        // Utiliser le cache Symfony au lieu d'un fichier
        $cacheDir = __DIR__ . '/../../var/cache';
        $timeFile = $cacheDir . '/app_startup_time';

        if (!file_exists($timeFile)) {
            @file_put_contents($timeFile, $this->kernelStartTime);
        }

        $this->startTime = (int) @file_get_contents($timeFile);

        // Log pour debugging
        $this->logger->info('StartupListener initialized', [
            'startTime' => $this->startTime,
            'currentTime' => time(),
            'elapsedTime' => time() - $this->startTime
        ]);
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $currentTime = time();
        $elapsedTime = $currentTime - $this->startTime;
        $request = $event->getRequest();
        $path = $request->getPathInfo();

        $this->logger->debug('StartupListener checking request', [
            'path' => $path,
            'elapsedTime' => $elapsedTime,
            'shouldBlock' => $elapsedTime < $this->graceTime &&
                (strpos($path, '/AI-Project/api/') !== false || strpos($path, '/api/') !== false)
        ]);

        if ($elapsedTime < $this->graceTime) {
            if (strpos($path, '/AI-Project/api/') !== false || strpos($path, '/api/') !== false) {
                $response = new JsonResponse(
                    ['status' => 'warming_up', 'message' => 'Application is starting up, please retry in a few seconds'],
                    503,
                    [
                        'Retry-After' => $this->graceTime - $elapsedTime,
                        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                        'Pragma' => 'no-cache'
                    ]
                );
                $event->setResponse($response);
                $this->logger->info('Request blocked during startup period', ['path' => $path]);
            }
        }
    }
}