<?php

namespace radio\net\app\action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\service\podcast\iPodcastService;
use radio\net\app\service\podcast\PodcastNotFoundException;

class GetPodcastByIdAction extends Action
{

    private iPodcastService $servicePodcast;

    public function __construct(iPodcastService $service_podcast)
    {
        $this->servicePodcast = $service_podcast;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $id = $args['id_podcast'] ?? 0;

        try {
            $podcast = $this->servicePodcast->getPodcastById($id);
            $data = [
              'type' => 'resource',
              'podcast' => $podcast
            ];
            $response->getBody()->write(json_encode($data));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PodcastNotFoundException) {
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }

    }
}