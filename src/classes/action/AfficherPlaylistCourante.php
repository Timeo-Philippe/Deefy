<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\interface\Renderer;
use iutnc\deefy\render\AudioListRenderer;

class AfficherPlaylistCourante extends Action
{

    public function execute(): string
    {
        if (!isset($_SESSION['playlist'])) {
            return "Aucune playlist sélectionnée";
        }

        $playlist = $_SESSION['playlist'];

        $pl = unserialize($playlist);
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
