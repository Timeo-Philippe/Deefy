<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\interface\Renderer;
use InvalidArgumentException;

class AudioTrackRenderer implements Renderer
{
    protected AudioTrack $track;

    public function __construct(AudioTrack $track)
    {
        $this->track = $track;
    }

    public function render(int $selector = self::COMPACT): string
    {
        switch ($selector) {
            case self::COMPACT:
                return $this->renderCompact();
            case self::LONG:
                return $this->renderLong();
            default:
                throw new InvalidArgumentException("Invalid render mode");
        }
    }

    public function renderCompact(): string
    {
        $titre = htmlspecialchars($this->track->titre, ENT_QUOTES, 'UTF-8');
        return '<div class="track-compact">'
            . '<h3>' . $titre . '</h3>'
            . $this->renderAudio()
            . '</div>';
    }

    public function renderLong(): string
    {
        $titre = htmlspecialchars($this->track->titre, ENT_QUOTES, 'UTF-8');
        $auteur = htmlspecialchars($this->track->auteur, ENT_QUOTES, 'UTF-8');
        return '<div class="track-long">'
            . '<h2>' . $titre . '</h2>'
            . '<p>Author: ' . $auteur . '</p>'
            . $this->renderAudio()
            . '</div>';
    }

    public function renderAudio(): string
    {
        $nomFichierAudio = htmlspecialchars($this->track->nomFichierAudio, ENT_QUOTES, 'UTF-8');
        return '<audio controls>'
            . '<source src="' . $nomFichierAudio . '" type="audio/mpeg">'
            . 'Your browser does not support the audio element.'
            . '</audio>';
    }
}
