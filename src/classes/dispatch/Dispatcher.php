<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\exception\DispatcherException;

class Dispatcher
{
    protected ?string $action = null;
    protected $actions = [];

    public function __construct()
    {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void
    {
        if (isset($this->actions[$this->action])) {
            $action_class = $this->actions[$this->action];
            $action = new $action_class();
            $result = $action->execute();
            $this->renderPage($result);
        } else {
            throw new DispatcherException("Action '{$this->action}' not found");
        }
    }

    public function addRoute(string $action, string $class): self
    {
        $this->actions[$action] = $class;
        return $this;
    }

    private function renderPage(string $html): void
    {
        $page = <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Deefy</title>
            </head>
            <style>
                body {
                  margin: 0;
                  padding: 0;
                  background-color: #000d26; 
                }

                h1,h2,h3, p {
                  margin: 10px;
                  color : white;
                  font-family: monospace, sans-serif;
                }

                .navbar {
                  list-style-type: none;
                  margin: 0;
                  padding: 0;
                  overflow: hidden;
                  background-color: #430261;
                }

                .navbar li {
                  float: left;
                  margin-right: 20px;
                  
                }

                .navbar li h2 {
                  color: white;
                  font-family: monospace, sans-serif;
                }
  
                .navbar li a {
                  display: block;
                  color: white;
                  text-align: center;
                  padding: 14px 16px;
                  text-decoration: none;
                  font-family: monospace, sans-serif;
                }

                .navbar h1{
                color: white;
                text-align: center;
                }
            </style>
            <body>
                <ul class='navbar'>
                    <h1>Deefy</h1>
                    <li><a href='?action=default'><h3>Accueil</h3></a></li>
                    <li><a href="?action=afficher_liste_Playlist"><h3>Afficher les playlist</h3></a></li>
                    <li><a href="?action=add-playlist"><h3>Ajouter une playlist</h3></a></li>
                </ul>
        HTML;

        $page = $page . $html;
        $page = $page . '</body>
                        </html>';
        echo $page;
    }
}
