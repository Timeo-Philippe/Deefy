<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\interface\Renderer;
use iutnc\deefy\render\AudioListRenderer;

class AfficherPlaylistCourante extends Action
{

    public function execute(): string
    {
        $playlist = $_SESSION['playlist'];

        if (!isset($_SESSION['playlist'])) {
            return "Aucune playlist sélectionnée";
        }

        $pl = unserialize($playlist);
        $html = (new AudioListRenderer($pl))->render(Renderer::COMPACT);

        return $html;
    }
}
