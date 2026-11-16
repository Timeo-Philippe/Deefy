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

            if (!isset($_SESSION['id_playlist'])) {
                return "Aucune playlist sélectionnée";
            }

            $repo = DeefyRepository::getInstance();

            if ($_FILES['userfile']['error'] !== 0) {
                return "erreur lors de l'envoie du fichier";
            }

            if (strtolower(substr($_FILES['userfile']['name'], -4)) === '.mp3' && $_FILES['userfile']['type'] === 'audio/mpeg') {
                $nomFichier = uniqid() . '.mp3';

                if ($_POST['minutes'] < 0 || $_POST['secondes'] < 0 || $_POST['secondes'] > 59) {
                    return "durée incorrecte";
                }

                if (move_uploaded_file($_FILES['userfile']['tmp_name'], 'audio/' . $nomFichier) === true) {
                    $titre = pathinfo($_FILES['userfile']['name'], PATHINFO_FILENAME);

                    $duree = (int) $_POST['minutes'] * 60 + (int) $_POST['secondes'];
                    $idTrack = $repo->ajoutPiste($titre, 'audio/' . $nomFichier, $duree);
                    $repo->ajoutPisteAPlaylist($_SESSION['id_playlist'], $idTrack);
                }
            } else {
                return 'Le fichier doit être au format mp3';
            }

            $pl = $repo->afficher_playlist($_SESSION['id_playlist']);
            if ($pl === null) {
                return "Cette playlist est introuvable";
            }

            $html = (new AudioListRenderer($pl))->render(Renderer::COMPACT);
            $html .= <<<HTML
                <style>
                    a{
                        color: white;
                        text-decoration: none;
                        font-family: monospace, sans-serif;
                    }
                </style>
                <a href="?action=add-track"><p>Ajouter une piste</p></a>
            HTML;

            return $html;
        }
    }
}
