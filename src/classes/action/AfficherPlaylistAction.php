<?php

namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class AfficherPlaylistAction extends Action
{

    public function execute(): string
    {
        $repo = DeefyRepository::getInstance();
        $playlist = $repo->afficher_liste_playlist();

        $html = <<<HTML
            <style>
                h2 {
                    margin: 10px;
                    color : white;
                    font-family: monospace, sans-serif;
                }

                .playlist {
                    display: grid;
                    align-items: center;
                    justify-content: center;
                 }

                 .playlist p {
                    font-family: monospace, sans-serif;
                    border: 1px solid #6820dc;
                    font-family: monospace, sans-serif;
                 }
            </style>
            <h1>Liste des playlists du moment : </h1>
            <div class="playlist">
        HTML;
        ;
        foreach ($playlist as $p) {
            $nom = $p->nom;

            $html .= <<<HTML
                <p>Playlist : $nom</p>
            HTML;
        }

        $html .= "</div>";
        return $html;
    }
}
