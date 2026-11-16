<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\interface\Renderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AjoutTrackAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = '<form method="post" action="?action=add-track" enctype="multipart/form-data">
                        <input type="file" name="userfile" required>
                        <input type="number" name="minutes" placeholder="Minutes" min="0" required>
                        <input type="number" name="secondes" placeholder="Secondes" min="0" max="59" required>
                        <button type="submit">Ajouter une piste</button>
                     </form>';
            return $html;
        } else {
            $repo = DeefyRepository::getInstance();
            if (substr($_FILES['userfile']['name'], -4) === '.mp3' && $_FILES['userfile']['type'] === 'audio/mpeg') {
                $nomFichier = uniqid() . '.mp3';
                move_uploaded_file($_FILES['userfile']['tmp_name'], 'audio/' . $nomFichier);
                $titre = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);
                $duree = (int) $_POST['minutes'] * 60 + (int) $_POST['secondes'];
                $idTrack = $repo->ajoutPiste($titre, 'audio/' . $nomFichier, $duree);
                $repo->ajoutPisteAPlaylist($_SESSION['id_playlist'], $idTrack);
            } else {
                return 'Le fichier doit être au format mp3';
            }

            $pl = $repo->afficher_playlist($_SESSION['id_playlist']);
            if ($pl === null) {
                return "Cette playlist est introuvable";
            }

            $html = (new AudioListRenderer($pl))->render(Renderer::COMPACT);
            $html .= '<a href="?action=add-track">Ajouter encore une piste</a>';

            return $html;
        }
    }
}
