<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack
{
    public function __construct(string $titre, string $cheminFichier, int $duree)
    {
        parent::__construct($titre, $cheminFichier, $duree);
    }
}
