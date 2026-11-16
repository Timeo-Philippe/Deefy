<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\interface\Renderer;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AjoutPlaylistAction extends Action
{

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $html = '<form method="post" action="?action=add-playlist">
                        <input type="text" placeholder="nom de la playlist" name="name" maxlength="100" required>
                        <button type="submit">valider</button>
                     </form>';

            return $html;
        } else {
            $repo = DeefyRepository::getInstance();
            $_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);

            $idPl = $repo->ajoutPlaylist($_POST['name']);
            $pl = $repo->afficher_playlist($idPl);

            if ($pl === null) {
                return "Cette playlist est introuvable";
            }

            $_SESSION['playlist'] = serialize($pl);
            $_SESSION['id_playlist'] = $idPl;

            $html = (new AudioListRenderer($pl))->render(Renderer::COMPACT);
            $html .= <<<HTML
                <style>
                    a, p {
                        color: white;
                        text-decoration: none;
                        font-family: monospace, sans-serif;
                        margin-right: 10px;
                    }
                </style>
                <a href="?action=add-track"><p>Ajouter une piste</p></a>
            HTML;

            return $html;
        }
    }
}
