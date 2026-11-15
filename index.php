<?php

use iutnc\deefy\dispatch\Dispatcher;

require_once __DIR__ . '/vendor/autoload.php';

$dispatcher = new Dispatcher();

$dispatcher->addRoute('add-track', 'iutnc\deefy\action\AddPodcastTrackAction');
$dispatcher->addRoute('add-playlist', 'iutnc\deefy\action\AddPlaylistAction');
$dispatcher->addRoute('default', 'iutnc\deefy\action\DefaultAction');
$dispatcher->addRoute('display', 'iutnc\deefy\action\DisplayPlaylistAction');
$dispatcher->addRoute('add-user', 'iutnc\deefy\action\AddUserAction');

session_start();
$dispatcher->run();