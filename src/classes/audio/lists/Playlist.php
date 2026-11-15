<?php

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;
use InvalidArgumentException;

class Playlist extends AudioList
{
    public function ajoutPiste(AudioTrack $track): void
    {
        $this->nbPiste++;
        $this->dureeT += $track->duree;
        $this->trackList[] = $track;
    }

    public function supprimerPiste(int $index): void
    {
        if ($index < 0 || $index >= $this->nbPiste) {
            throw new InvalidArgumentException("Index out of bounds");
        }

        $trackToRemove = $this->trackList[$index];
        $this->dureeT -= $trackToRemove->duree;
        unset($this->trackList[$index]);
        $this->trackList = array_values($this->trackList);
        $this->nbPiste--;
    }

    public function ajoutPistes(array $tracks): void
    {
        foreach ($tracks as $track) {
            if (!in_array($track, $this->trackList)) {
                $this->ajoutPiste($track);
            }
        }
    }
}
