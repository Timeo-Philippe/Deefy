<?php

namespace iutnc\deefy\repository;

use PDO;
use PDOException;
use Exception;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks;
use iutnc\deefy\audio\tracks\AudioTrack;

class DeefyRepository
{
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private PDO $db;

    private function __construct()
    {
        if (empty(self::$config)) {
            throw new Exception("Configuration non définie. Utilisez TouiterRepository::setConfig().");
        }

        $driver = self::$config['driver'] ?? 'mysql';
        $host = self::$config['host'] ?? 'localhost';
        $dbname = self::$config['database'] ?? '';
        $charset = self::$config['charset'] ?? 'utf8mb4';
        $user = self::$config['username'] ?? '';
        $pass = self::$config['password'] ?? '';

        $dsn = "$driver:host=$host;dbname=$dbname;charset=$charset";

        try {
            $this->db = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Charge la configuration depuis un fichier INI
     */
    public static function setConfig(string $file): void
    {
        if (!file_exists($file)) {
            throw new Exception("Fichier de configuration introuvable : $file");
        }

        $config = parse_ini_file($file);
        if ($config === false) {
            throw new Exception("Erreur lors de la lecture du fichier INI : $file");
        }

        self::$config = $config;
    }

    /**
     * Retourne l’instance unique du Repository (singleton)
     */
    public static function getInstance(): DeefyRepository
    {
        if (self::$instance === null) {
            self::$instance = new DeefyRepository();
        }

        return self::$instance;
    }

    /**
     * Retourne la connexion PDO
     */
    public function getPDO(): PDO
    {
        return $this->db;
    }

    /**
     * Fonctionnalité 1 : affiche la liste des playlists enregistrées en base de données
     */
    public function afficher_liste_playlist(): array
    {
        $query = "SELECT p.* 
                  FROM playlist p ";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->execute();

        $playlist = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $playlist[] = [
                'id' => $row['id'],
                'playlist' => new Playlist($row['nom'])
            ];
        }

        return $playlist;
    }

    /**
     * Fonctionnalité 2 :  chaque élément de la liste est cliquable et permet d’afficher une 
     * playlist qui devient la playlist courante stockée en session
     */
    public function afficher_playlist(int $id): ?Playlist
    {
        $query = "SELECT p.id, p.nom, t.id as id_track, t.titre, t.filename, t.duree
                  FROM playlist p
                  LEFT JOIN playlist2track p2t on p.id = p2t.id_pl
                  LEFT JOIN track t on p2t.id_track = t.id
                  WHERE p.id = ?
                  ORDER BY p2t.no_piste_dans_liste";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $pl = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($pl === null) {
                $pl = new Playlist($row['nom']);
            }

            if ($row['id_track'] !== null) {
                $track = new AudioTrack($row['titre'], $row['filename'], (int)$row['duree']);
                $pl->ajoutPiste($track);
            }
        }

        return $pl;
    }

    /**
     * Fonctionnalité 3 : Ajouter une piste : ajoute une nouvelle piste à la playlist courante ; 
     * un formulaire est affiché pour saisir les données de la piste. 
     * Cette fonctionnalité est accessible dans l’affichage d’une playlist.
     */
    public function ajoutPiste(string $nom, string $filename, int $duree): int
    {
        $query = "INSERT INTO track (titre, filename, duree) values (?, ?, ?)";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->bindParam(2, $filename, PDO::PARAM_STR);
        $stmt->bindParam(3, $duree, PDO::PARAM_INT);
        $stmt->execute();
        return (int) $this->getPDO()->lastInsertId();
    }

    public function ajoutPisteAPlaylist(int $idP, int $idT): void
    {
        $query = "SELECT MAX(no_piste_dans_liste)
                  FROM playlist2track
                  WHERE id_pl = ? ";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $idP, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row['MAX(no_piste_dans_liste)'] === null) {
            $max = 1;
        } else {
            $max = (int)$row['MAX(no_piste_dans_liste)'] + 1;
        }

        $query = "INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) values (?, ?, ?)";
        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $idP, PDO::PARAM_INT);
        $stmt->bindParam(2, $idT, PDO::PARAM_INT);
        $stmt->bindParam(3, $max, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Fonctionnalité 4 : créer une playlist vide : un formulaire permettant de saisir le nom 
     * d’une nouvelle playlist est affiché. A la validation, la playlist est créée et stockée 
     * en BD ; elle devient la playlist courante.
     */
    public function ajoutPlaylist(string $nom): int
    {
        $query = "INSERT INTO playlist (nom) values (?)";

        $stmt = $this->getPDO()->prepare($query);
        $stmt->bindParam(1, $nom, PDO::PARAM_STR);
        $stmt->execute();
        return (int) $this->getPDO()->lastInsertId();
    }
}
