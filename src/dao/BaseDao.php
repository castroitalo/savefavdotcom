<?php

declare(strict_types=1);

namespace src\dao;

use PDO;
use PDOException;
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
        PDO $connection
    ) {
        $this->connection = $connection;
    }

    /**
     * Create a new register in database
     *
     * @param array $data
     * @return string|false
     */
    public function createData(array $data): string|false
    {
        // Check if fields parameter is empty
        if (empty($data)) {
            throw new BaseDaoException("Cannot use CREATE statement with empty data.");
        }

        // Starts db transaction
        $this->connection->beginTransaction();

        try {
            // INSERT INTO table (fields) VALUES (values);
            $fields = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO {$this->databaseTableName}
                        ($fields) VALUES ($values)";
            $stmt = $this->connection->prepare($sql);

            // Commit new register if it was executed, rollback if it's not
            if ($stmt->execute($data)) {
                $this->connection->commit();
            } else {
                $this->connection->rollBack();
            }

            return $this->connection->lastInsertId();
        } catch (PDOException $ex) {
            // Rollback transaction if anything goes wrong 
            $this->connection->rollBack();
            die($ex->getMessage());
        }
    }

    /**
     * Read all register from a query in database
     *
     * @param string|null $where
     * @param string|null $params
     * @param string $columns
     * @return array
     */
    public function readAllData(
        ?string $where = null,
        ?string $params = null,
        string $columns = "*"
    ): array {
        // Check if WHERE has parameters
        if ($where && !$params) {
            throw new BaseDaoException("Cannot use WHERE statement without parameters.");
        }

        // Check if parameter has a WHERE
        if (!$where && $params) {
            throw new BaseDaoException("Cannot use parameters without a WHERE statement.");
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

    /**
     * Read a single register from database
     *
     * @param string $where
     * @param string $params
     * @param string $columns
     * @return object|false
     */
    public function readDataBy(
        string $where,
        string $params,
        string $columns = "*"
    ): object|false {
        // Check if WHERE statement is empty
        if (empty($where)) {
            throw new BaseDaoException("WHERE statement cannot be empty.");
        }

        // Check WHERE statement parameters is empty
        if (empty($params)) {
            throw new BaseDaoException("WHERE statement parameters cannot be empty.");
        }

        try {
            $sql = "SELECT {$columns}
                        FROM {$this->databaseTableName}
                        {$where}";
            $stmt = $this->connection->prepare($sql);

            parse_str($params, $paramsArray);

            foreach ($paramsArray as $key => $value) {
                $valueType = is_string($value)
                    ? PDO::PARAM_STR
                    : PDO::PARAM_INT;

                $stmt->bindValue(":{$key}", $value, $valueType);
            }

            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }
}
