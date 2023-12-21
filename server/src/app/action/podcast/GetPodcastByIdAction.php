<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\podcast\iPodcastService;
use radio\net\domaine\service\podcast\PodcastNotFoundException;
use Slim\Exception\HttpNotFoundException;

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
        $podcastGenerator = new PodcastGenerator();
        return $podcastGenerator->generateActionResponse($request, $response, $this->servicePodcast->getPodcastById($id));
    }
}