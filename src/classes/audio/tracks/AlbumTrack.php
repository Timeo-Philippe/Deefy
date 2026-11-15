<?php

namespace iutnc\deefy\audio\tracks;

class AlbumTrack extends AudioTrack {

    private string $album;
    private int $numero;

    public function __construct(string $titre, string $cheminFichier, string $album, int $numPiste) {
        parent::__construct($titre, $cheminFichier);
        $this->album = $album;
        $this->numero = $numPiste;
    }

    public function __toString() {
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
    }

    public function __get(String $nameA) : mixed {
        if ($nameA === 'album' || $nameA === 'numero') {
            return $this->$nameA;
        }

        return parent::__get($nameA);
    }
}