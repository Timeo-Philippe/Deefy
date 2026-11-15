<?php

namespace iutnc\deefy\repository;

use PDO;
use PDOException;
use Exception;
use iutnc\deefy\audio\lists\Playlist;

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
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $playlist[] = new Playlist($row['nom']);
        }

        return $playlist;
    }
}
