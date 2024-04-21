<?php

namespace Db;

class DatabaseManager
{
    private string $host;

    private string $dbName;

    private string $user;

    private string $password;

    private \PDO $pdo;

    private static ?DatabaseManager $instance = null;

    private function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->dbName = getenv('DB_NAME');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');

        $this->connect();
    }

    public function __clone() {}

    public function __wakeup() {}

    public static function getInstance(): DatabaseManager
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        try {
            $this->pdo = new \PDO("mysql:host=$this->host;dbname=$this->dbName", $this->user, $this->password, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\PDOException $e) {
            // handle connection error
            die("DB connection failed: " . $e->getMessage());
        }
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}