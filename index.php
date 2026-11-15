<?php

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\AfficherListePlaylistAction;
use iutnc\deefy\action\AfficherPlaylist;

session_start();
DeefyRepository::setConfig('Config.db.ini');

$dispatcher = new Dispatcher();
$dispatcher->addRoute('default', DefaultAction::class);
$dispatcher->addRoute('afficher_liste_Playlist', AfficherListePlaylistAction::class);
$dispatcher->addRoute('afficher_playlist', AfficherPlaylist::class);

// $dispatcher->addRoute('add-track', 'iutnc\deefy\action\AddPodcastTrackAction');
// $dispatcher->addRoute('add-playlist', 'iutnc\deefy\action\AddPlaylistAction');
// $dispatcher->addRoute('add-user', 'iutnc\deefy\action\AddUserAction');

try {
    $dispatcher->run();
} catch (Exception $e) {
    echo "Oups, erreur: " . $e->getMessage();
}
