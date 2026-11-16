<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class DefaultAction extends Action
{

    public function execute(): string
    {
        $page = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Deefy</title>
                <style>
                    p {
                        font-family: monospace, sans-serif;
                    }

                    h2 {
                        margin: 10px;
                        color: white;
                        font-family: monospace, sans-serif;
                    }

                    .playlist a {
                        color: white;
                        text-decoration: none;
                        font-family: monospace, sans-serif;
                        margin-right: 10px;
                    }

                    .playlist {
                        display: grid;
                        align-items: center;
                        justify-content: center;
                    }

                    .playlist p {
                        font-family: monospace, sans-serif;
                        border: 1px solid #6820dc;
                    }
                </style>
            </head>
            
            <body>
                <h2>Bienvenue sur Deefy</h2>
                <div class='playlist'>
                    <p><a href='?action=playlist_courante'>Afficher la playlist courante</a></p>
                </div>
        HTML;

        return $page;
    }
}
