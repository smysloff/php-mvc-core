<?php

declare(strict_types=1);

namespace smysloff\phpmvc\db;

use smysloff\phpmvc\Application;
use smysloff\phpmvc\Model;
use PDOStatement;

/**
 * Class DBModel
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
abstract class DBModel extends Model
{
    /**
     * @return string
     */
    abstract public function tableName(): string;

    /**
     * @return array
     */
    abstract public function attributes(): array;

    /**
     * @return string
     */
    abstract public static function primaryKey(): string;

    /**
     * @return bool
     */
    public function save(): bool
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $sql = "
            INSERT INTO $tableName
                (" . implode(', ', $attributes) . ")
            VALUES
                (" . implode(', ', $params) . ")
        ";
        $stmt = self::prepare($sql);
        foreach ($attributes as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }
        return $stmt->execute();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public static function findOne(array $where)
    {
        $tableName = (new static)->tableName();
        $attributes = array_keys($where);
        $params = array_map(fn($attr) => "$attr = :$attr", $attributes);
        $params = implode(' AND ', $params);
        $sql = "SELECT * FROM $tableName WHERE $params";
        $stmt = self::prepare($sql);
        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    /**
     * @param string $sql
     * @return PDOStatement|false
     */
    public static function prepare(string $sql): PDOStatement|false
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
