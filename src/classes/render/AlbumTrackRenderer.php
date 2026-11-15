<?php

namespace iutnc\deefy\render;

use iutnc\deefy\audio\tracks\AlbumTrack;

class AlbumTrackRenderer extends AudioTrackRenderer {

    public AlbumTrack $albumTrack;

    public function __construct(AlbumTrack $track) {
        parent::__construct($track);
        $this->albumTrack = $track;
    }

    public function renderCompact(): string {
        return '<div class="track-compact">'
            . '<h3>' . $this->albumTrack->titre . '</h3>'
            . $this->renderAudio()
            . '</div>';
    }

    public function renderLong(): string {
        return '<div class="track-long">'
            . '<h2>' . $this->albumTrack->titre . '</h2>'
            . '<p>Author: ' . $this->albumTrack->auteur . '</p>'
            . '<p>Track Number: ' . $this->albumTrack->numero . '</p>'
            . $this->renderAudio()
            . '</div>';
    }
}