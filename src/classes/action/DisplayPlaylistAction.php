<?php

namespace iutnc\deefy\action;

use iutnc\deefy\render\AudioListRenderer;


class displayPlaylistAction extends Action
{

    public function execute(): string
    {
        if (! isset($_SESSION['playlist'])) {
            $html = "<b>pas de playlist en session</b>";
        } else {
            $pl = unserialize($_SESSION['playlist']);
            $html = "<b>playlist en session</b>";
            $r = new AudioListRenderer($pl);
            $html = $r->render();
        }
        return $html;
    }
}
