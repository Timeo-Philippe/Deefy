<?php

namespace iutnc\deefy\audio\lists;

class Album extends AudioList
{
    protected string $artiste;
    protected string $dateSortie;

    public function __construct(string $nom, string $artiste, string $dateSortie, array $initialTrackList)
    {
        parent::__construct($nom, $initialTrackList);
        $this->artiste = $artiste;
        $this->dateSortie = $dateSortie;
    }

    public function setArtiste(string $artiste): void
    {
        $this->artiste = $artiste;
    }

    public function setDateSortie(string $dateSortie): void
    {
        $this->dateSortie = $dateSortie;
    }
}
