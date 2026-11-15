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
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Deefy</title>
            </head>
            <body>
                <h1>Deefy</h1>
                <ul>
                    <li><a href="?action=display">Afficher la playlist</a></li>
                    <li><a href="?action=add-user">Inscription</a></li>
                    <li><a href="?action=add-playlist">Ajouter une playlist</a></li>
                </ul>
        HTML;

        $page = $page . $html;
        $page = $page . '</body>
                        </html>';
        echo $page;
    }
}
