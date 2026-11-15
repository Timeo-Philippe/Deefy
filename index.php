<?php

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\AfficherPlaylistAction;
use iutnc\deefy\repository\DeefyRepository;

session_start();
DeefyRepository::setConfig('Config.db.ini');

$dispatcher = new Dispatcher();
$dispatcher->addRoute('default', DefaultAction::class);
$dispatcher->addRoute('afficher-Playlist', AfficherPlaylistAction::class);

// $dispatcher->addRoute('add-track', 'iutnc\deefy\action\AddPodcastTrackAction');
// $dispatcher->addRoute('add-playlist', 'iutnc\deefy\action\AddPlaylistAction');
// $dispatcher->addRoute('add-user', 'iutnc\deefy\action\AddUserAction');

try {
    $dispatcher->run();
} catch (Exception $e) {
    echo "Oups, erreur: " . $e->getMessage();
}
