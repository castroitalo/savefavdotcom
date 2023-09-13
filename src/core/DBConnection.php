<?php

declare(strict_types=1);

namespace src\core;

use PDO;
use PDOException;

/**
 * Class DBConnection
 * 
 * @package src\core
 */
final class DBConnection
{
    /**
     * Singleton database connection
     *
     * @var PDO|null
     */

    private static ?PDO $connection = null;
    /**
     * Database connection options
     *
     * @var array
     */
    private static array $connectionOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    /**
     * DBConnection constructor
     */
    final public function __construct()
    {
    }

    /**
     * DBConnection clone
     *
     * @return void
     */
    final public function __clone(): void
    {
    }

    /**
     * Get singleton database connection
     *
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (!self::$connection) {
            try {

                // Creates a singleton connection with database
                self::$connection = new PDO(
                    "mysql:host=" . $_ENV["DB_HOST"]
                    . ";dbname=" . $_ENV["DB_NAME"]
                    . ";post=" . $_ENV["DB_PORT"],
                    $_ENV["DB_USER"],
                    $_ENV["DB_PASSWORD"],
                    self::$connectionOptions
                );
            } catch (PDOException $ex) {
                die($ex->getMessage());
            }
        }

        return self::$connection;
    }
}
