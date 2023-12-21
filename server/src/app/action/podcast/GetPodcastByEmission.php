<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;

class GetPodcastByEmission extends Action
{
    private iPodcastService $podcastService;
    public function __construct (iPodcastService $iPodcastService) {
        $this->podcastService = $iPodcastService;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id_emission'];
        try {
            $emissions = $this->podcastService->GetPodcastByEmission($id);
            $data = [
                'type' => 'resource',
                'podcasts' => $emissions
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PodcastNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}