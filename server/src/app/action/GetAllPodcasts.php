<?php

namespace radio\net\app\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;

class GetAllPodcasts extends Action
{
    private iPodcastService $servicePodcast;
    public function __construct(iPodcastService $service_podcast)
    {
        $this->servicePodcast = $service_podcast;
    }
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        try {
            $podcast = $this->servicePodcast->GetAllPodcast();
            $data = [
                'type' => 'resource',
                'podcast' => $podcast
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PodcastNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }    }
}