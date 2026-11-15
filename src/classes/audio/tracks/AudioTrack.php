<?php

namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException;

class AudioTrack {

    protected string $titre;
    private string $auteur = '';
    private string $date = '';
    private string $genre = '';
    private int $duree = 0;
    protected string $nomFichierAudio;

    public function __construct(string $titreP, string $cheminFichier) {
        $this->titre = $titreP;
        $this->nomFichierAudio = $cheminFichier;
    }

    public function __toString() {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
    }

    public function __get(string $name) : mixed {
        if (!array($name, ['titre', 'auteur', 'date', 'genre', 'duree', 'nomFichierAudio'], true)) {
            throw new InvalidPropertyNameException("$name : invalid property");
        }

        return $this->$name;
    }

    public function __set(string $name, mixed $value) : void {
        if (!in_array($name, ['titre', 'auteur', 'date', 'genre', 'duree', 'nomFichierAudio'], true)) {
            throw new InvalidPropertyNameException("$name : invalid property");
        }

        if ($name === 'duree' && $value < 0) {
            throw new InvalidPropertyValueException("$name cannot be negative");
        }

        $this->$name = $value;
    }

    public function setAuteur(string $auteur) {
        $this->auteur = $auteur;
    }
}