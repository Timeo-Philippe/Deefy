<?php

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;
use InvalidArgumentException;

class Playlist extends AudioList {

    /** la méthode pour ajouter une piste quelconque ; il faut
    * bien sûr mettre à jour le nombre de piste et la durée totale 
    */
    public function ajoutPiste(AudioTrack $track): void {
        $this->nbPiste++;
        $this->dureeT += $track->duree;
        $this->trackList[] = $track;
    }

    /**
     * la méthode pour supprimer une piste ; elle reçoit en paramètre l'indice de la piste à supprimer
     */
    public function supprimerPiste(int $index): void {
        if ($index < 0 || $index >= $this->nbPiste) {
            throw new InvalidArgumentException("Index out of bounds");
        }

        $trackToRemove = $this->trackList[$index];
        $this->dureeT -= $trackToRemove->duree;
        unset($this->trackList[$index]);
        $this->trackList = array_values($this->trackList); 
        $this->nbPiste--;
    }

    /**
     * la méthode permet d'ajouter une liste de pistes en une opération ; elle reçoit 
     * en paramètre un tableau de pistes à ajouter aux pistes déjà présentes.
     * Objectif : trouver une solution simple pour gérer les éventuels doublons 
     */
    public function ajoutPistes(array $tracks) : void {
        foreach ($tracks as $track) {
            if (!in_array($track, $this->trackList)) {
                $this->ajoutPiste($track);
            }
        }
    }
}