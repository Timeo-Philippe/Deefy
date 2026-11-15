<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\render\Renderer;
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
        return '<div class="track-compact">'
            . '<h3>' . $this->track->titre . '</h3>'
            . $this->renderAudio()
            . '</div>';
    }

    public function renderLong(): string
    {
        return '<div class="track-long">'
            . '<h2>' . $this->track->titre . '</h2>'
            . '<p>Author: ' . $this->track->auteur . '</p>'
            . $this->renderAudio()
            . '</div>';
    }

    public function renderAudio(): string
    {
        return '<audio controls>'
            . '<source src="' . $this->track->nomFichierAudio . '" type="audio/mpeg">'
            . 'Your browser does not support the audio element.'
            . '</audio>';
    }
}
