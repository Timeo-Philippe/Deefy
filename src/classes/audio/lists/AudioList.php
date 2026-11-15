<?php

namespace iutnc\deefy\audio\lists;

abstract class AudioList
{
    protected string $nom;
    protected array $trackList = [];
    protected int $nbPiste;
    protected int $dureeT;

    public function __construct(string $nom, array $initialTrackList = [])
    {
        $this->nom = $nom;
        $this->trackList = $initialTrackList;
        $this->nbPiste = count($initialTrackList);
        $this->dureeT = 0;
        
        foreach ($initialTrackList as $track) {
            $this->dureeT += $track->duree;
        }
    }

    public function __get(string $nomParam): mixed
    {
        if (property_exists($this, $nomParam)) {
            return $this->$nomParam;
        }
        throw new \Exception("$nomParam : invalid property");
    }
}
