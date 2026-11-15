<?php

namespace iutnc\deefy\action;

use Override;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\Renderer;


class displayPlaylistAction extends Action {

    #[Override]
    public function execute(): string {
        if(! isset ($_SESSION['playlist'])){
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