<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\render\AudioListRenderer;

class AddPodcastTrackAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = '<form method="post" action="?action=add-track" enctype="multipart/form-data">
                        <input type="text" name="name" placeholder="Nom de la piste">
                        <input type="file" name="userfile">
                        <button type="submit">Ajouter une piste</button>
                     </form>';
            return $html;
        } else {
            if (substr($_FILES['userfile']['name'], -4) === '.mp3' && $_FILES['userfile']['type'] === 'audio/mpeg') {
                $nomFichier = uniqid() . '.mp3';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'audio/' . $nomFichier);
                $pl = unserialize($_SESSION['playlist']);
                $track = new PodcastTrack($_POST['name'], 'audio/' . $nomFichier);
                $pl->ajoutPiste($track);
            } else {
                return 'Le fichier doit être au format mp3';
            }

            $_SESSION['playlist'] = serialize($pl);

            $r = new AudioListRenderer($pl);
            $html = $r->render();
            $html .= '<a href="?action=add-track">Ajouter encore une piste</a>';
            return $html;
        }
    }
}
