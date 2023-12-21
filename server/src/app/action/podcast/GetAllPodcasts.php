<?php

namespace radio\net\app\action\podcast;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use radio\net\app\action\Action;
use radio\net\domaine\service\podcast\iPodcastService;
class GetAllPodcasts extends Action
{
    private iPodcastService $servicePodcast;

    public function __construct(iPodcastService $service_podcast)
    {
        $this->servicePodcast = $service_podcast;
    }

    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $podcast = new PodcastGenerator();
        return $podcast->generateActionResponse($request, $response, $this->servicePodcast->GetAllPodcast());
    }
}