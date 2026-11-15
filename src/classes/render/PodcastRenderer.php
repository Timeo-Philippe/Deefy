<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\PodcastTrack;

class PodcastRenderer extends AudioTrackRenderer {

    public function __construct(PodcastTrack $track) {
        parent::__construct($track);
    }

    public function renderCompact(): string {
        return '<div class="podcast-compact">'
            . '<h3>' . $this->track->titre . '</h3>'
            . $this->renderAudio()
            . '</div>';
    }

    public function renderLong(): string {
        return '<div class="podcast-long">'
            . '<h2>' . $this->track->titre . '</h2>'
            . '<p>Author: ' . $this->track->auteur . '</p>'
            . $this->renderAudio()
            . '</div>';
    }
}