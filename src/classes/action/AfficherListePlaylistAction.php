<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\repository\DeefyRepository;

class AfficherListePlaylistAction extends Action
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

                 .playlist a {
                    color: white;
                    text-decoration: none;
                    font-family: monospace, sans-serif;
                    margin-right: 10px;
                 }
            </style>
            <h1>Liste des playlists du moment : </h1>
            <div class="playlist">
        HTML;

        foreach ($playlist as $p) {
            $pl = $p['playlist'];
            $id = $p['id'];
            $nom = $pl->nom;

            $html .= <<<HTML
                <a href="index.php?action=afficher_playlist&id=$id">
                    <p> "Playlist : $nom" </p>
                </a>
            HTML;
        }

        $html .= "</div>";
        return $html;
    }
}
