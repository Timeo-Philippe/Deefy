<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\render\Renderer;

class AudioListRenderer implements Renderer
{
    protected AudioList $audioList;

    public function __construct(AudioList $audioList)
    {
        $this->audioList = $audioList;
    }

    public function render(int $selector = Renderer::COMPACT): string
    {
        $name = ($this->audioList->nom);
        $html = '<section class="audio-list">'
            . '<h1>' . $name . '</h1>';

        foreach ($this->audioList->trackList as $track) {
            $html .= (new AudioTrackRenderer($track))->render(Renderer::COMPACT);
        }

        $html .= '<footer class="audio-list-summary">'
            . '<p>Nombre de pistes : ' . $this->audioList->nbPiste . '</p>'
            . '<p>Durée totale : ' . $this->audioList->dureeT . ' s</p>'
            . '</footer>'
            . '</section>';

        return $html;
    }
}
