<?php

declare(strict_types=1);

namespace src\dao;

use PDO;
use PDOException;
use src\core\DBConnection;
use src\exceptions\BaseDaoException;

/**
 * Class BaseDao
 * 
 * @package src\dao
 */
class BaseDao
{
    /**
     * Database connection
     *
     * @var PDO
     */
    protected PDO $connection;

    /**
     * BaseDao constructor
     *
     * @param string $databaseTableName
     */
    public function __construct(
        private string $databaseTableName,
    ) {
        $this->connection = DBConnection::getConnection();
    }

    public function readAll(
        ?string $where = null,
        ?string $params = null,
        string $columns = "*"
    ) {
        // Check if the WHERE statement has parameters
        if (($where && !$params) || (!$where && $params)) {
            throw new BaseDaoException("Cannot call WHERE without passing it's parameters. And vice-versa.");
        }

        try {
            $sql = "SELECT {$columns}
                        FROM {$this->databaseTableName}
                        {$where}";
            $stmt = $this->connection->prepare($sql);

            // Bind params to WHERE statement
            if ($params) {
                parse_str($params, $paramsArray);

                foreach ($paramsArray as $key => $value) {
                    $valueType = is_string($value) 
                        ? PDO::PARAM_STR 
                        : PDO::PARAM_INT;
                    
                    $stmt->bindValue(":{$key}", $value, $valueType);
                }
            }

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
}
