<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;


class AddPlaylistAction extends Action
{
    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $html = '<form method="post" action="?action=add-playlist">
                        <input type="text" placeholder="nom de la playlist" name="name">
                        <button type="submit">valider</button>
                     </form>';

            return $html;
        } else {
            $_POST['name'] = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);

            $pl = new Playlist($_POST['name']);
            $_SESSION['playlist'] = serialize($pl);

            $r = new AudioListRenderer(unserialize($_SESSION['playlist']));
            $html = $r->render();
            $html .= '<a href="?action=add-track">Ajouter une piste</a>';

            return $html;
        }
    }
}
