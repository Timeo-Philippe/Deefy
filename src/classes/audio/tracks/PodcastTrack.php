<?php

namespace iutnc\deefy\audio\tracks;

class PodcastTrack extends AudioTrack
{
    public function __construct(string $titre, string $cheminFichier)
    {
        parent::__construct($titre, $cheminFichier);
    }
}
