<?php
declare(strict_types=1);

use radio\net\app\action\auth\RefreshAction;
use radio\net\app\action\auth\SigninAction;
use radio\net\app\action\auth\SignupAction;
use radio\net\app\action\auth\ValidateAction;
use radio\net\app\action\creneau\GetAllCreneaux;
use radio\net\app\action\creneau\GetCreneauById;
use radio\net\app\action\emission\GetCreneauByEmission;
use radio\net\app\action\emission\GetEmissionById;
use radio\net\app\action\emission\GetEmissionsAction;
use radio\net\app\action\playlist\GetPlaylistByEmailUserAction;
use radio\net\app\action\playlist\GetPlaylistByIdAction;
use radio\net\app\action\playlist\PostPlaylist;
use radio\net\app\action\podcast\GetAllPodcasts;
use radio\net\app\action\podcast\GetPodcastByEmission;
use radio\net\app\action\podcast\GetPodcastByIdAction;
use radio\net\app\action\podcast\GetUSersByPodcast;
use radio\net\app\action\podcast\PostPodcast;
use radio\net\app\action\podcast\PutPodcast;
use radio\net\app\action\son\GetAllSons;
use radio\net\app\action\son\GetSonByIdAction;
use radio\net\app\action\son\GetSonsByPlaylistId;
use radio\net\app\action\user\GetUserAllInfo;
use radio\net\app\action\user\GetUserByMail;
use radio\net\domaine\middleware\Jwt;
use Slim\App;

return function (App $app) {

    $JwtVerification = new Jwt();

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });

    //podcast
    $app->group('/podcasts', function ($app) {
        $app->get("[/]", GetAllPodcasts::class)->setName('podcast.index'); // v
        $app->get("/{id_podcast}[/]", GetPodcastByIdAction::class)->setName('podcast.show'); // v
        $app->post("[/]", PostPodcast::class)->setName('podcast.create'); //
        $app->put('/{id}[/]', PutPodcast::class)->setName('podcast.update'); //
        $app->get('/{id}/users', GetUSersByPodcast::class)->setName('podcast.invites'); //
    });

    //emission
    $app->group('/emissions', function ($app) {
        $app->get("[/]", GetEmissionsAction::class)->setName('emission.index'); // v
        $app->get("/{id_emission}[/]", GetEmissionById::class)->setName('emission.show'); // v
        $app->get("/{id_emission}/podcasts", GetPodcastByEmission::class)->setName('podcasts.emission'); //v
        $app->get("/{id_emission}/creneau", GetCreneauByEmission::class)->setName('creneaux.emission');
    });

    //user
    $app->group('/users', function ($app) {
        //user infos
        $app->get("[/]", GetUserAllInfo::class)->setName('users.index');
        $app->get('/mail/{email}', GetUserByMail::class)->setName('user.show');
        $app->get("/{email_user}/playlists", GetPlaylistByEmailUserAction::class)->setName('playlists.user');

        //auth
        $app->post('/signin', SigninAction::class)->setName('signin');
        $app->post('/signup', SignupAction::class)->setName('signup');
        $app->post('/refresh', RefreshAction::class)->setName('refresh');
        $app->get('/validate', ValidateAction::class)->setName('validate_user');
    });

    //son
    $app->group('/sons', function ($app) {
        $app->get("[/]", GetAllSons::class)->setName('son.index');
        $app->get("/{id_son}[/]", GetSonByIdAction::class)->setName('son.show');
        $app->get("/playlist/{id_playlist}[/]", GetSonsByPlaylistId::class)->setName('sons.playlist');
    });

    //playlist
    $app->group('/playlists', function ($app) {
        $app->post("[/]", PostPlaylist::class)->setName("playlist.index");
        $app->get("/{id_playlist}[/]", GetPlaylistByIdAction::class)->setName('.playlist.show');
    });

    // creneau
    $app->group('/creneaux', function ($app) {
        $app->get("[/]", GetAllCreneaux::class)->setName('creneaux.index'); // v
        $app->get("/{id}[/]", GetCreneauById::class)->setName('creneaux.show'); // v
    });
};
