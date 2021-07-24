<?php

declare(strict_types=1);

namespace smysloff\phpmvc\db;

use smysloff\phpmvc\Application;
use PDO;
use PDOStatement;

/**
 * Class Database
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
class Database
{
    /**
     * @var PDO
     */
    public PDO $pdo;

    /**
     * Database constructor
     */
    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . '/migrations');
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/migrations/' . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;
        }

        if (empty($newMigrations)) {
            $this->log('All migrations are applied already');
        } else {
            $this->saveMigrations($newMigrations);
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS migrations (
                id INTEGER PRIMARY KEY,
                migration TEXT NOT NULL,
                created_at TEXT DEFAULT (datetime('now', 'localtime'))
            );                  
        ");
    }

    /**
     * @return array
     */
    public function getAppliedMigrations(): array
    {
        $stmt = $this->pdo->prepare("SELECT migration FROM migrations");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * @param array $migrations
     */
    public function saveMigrations(array $migrations): void
    {
        $migrations = array_map(fn($m) => "('$m')", $migrations);
        $stmt = $this->pdo->prepare(
            'INSERT INTO migrations (migration) VALUES '
                    . implode(', ', $migrations)
        );
        $stmt->execute();
    }

    /**
     * @param string $sql
     * @return PDOStatement|false
     */
    public function prepare(string $sql): PDOStatement|false
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * @param string $message
     */
    protected function log(string $message): void
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
