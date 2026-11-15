<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\interface\Renderer;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\render\AudioListRenderer;

class AfficherPlaylist extends Action
{

    public function execute(): string 
    {
        $id = (int) $_GET['id'];

        $repo = DeefyRepository::getInstance();
        $pl = $repo->afficher_playlist($id);

        if ($pl === null){
            return "Cette playlist est introuvable";
        }

        $_SESSION['playlist'] = serialize($pl);

        $html = (new AudioListRenderer($pl))->render(Renderer::COMPACT);

        return $html;
    }
}
