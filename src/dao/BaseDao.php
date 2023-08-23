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
abstract class BaseDao
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
     * Validate BaseDao::createData parameter
     *
     * @array $data
     */
    public function validateCreateDataParameters(array $data): void
    {
        // Check if fields parameter is empty
        if (empty($data)) {
            throw new BaseDaoException("Cannot use CREATE statement with empty data.");
        }
    }

    /**
     * Create a new register in database
     *
     * @param array $data
     * @return string|false
     */
    public function createData(array $data): string|false
    {
        // Validate parameters
        $this->validateCreateDataParameters($data);

        $this->connection->beginTransaction();

        try {
            // Extract fields and values from $data to create SQL code
            $fields = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            // Format SQL code with extracted data
            $sql = "INSERT INTO {$this->databaseTableName}
                        ($fields) VALUES ($values)";
            $stmt = $this->connection->prepare($sql);

            if ($stmt->execute($data)) {
                $this->connection->commit();
            } else {
                $this->connection->rollBack();
            }

            return $this->connection->lastInsertId();
        } catch (PDOException $ex) {
            $this->connection->rollBack();
            die($ex->getMessage());
        }
    }

    /**
     * Validate BaseDao::readAll
     *
     * @param string|null $where
     * @param string|null $params
     * @return void
     */
    public function validateReadAllParameters(
        ?string $where = null,
        ?string $params = null,
    ): void {
        // Check if WHERE has parameters
        if ($where && !$params) {
            throw new BaseDaoException("Cannot use WHERE statement without parameters.");
        }

        // Check if parameter has a WHERE
        if (!$where && $params) {
            throw new BaseDaoException("Cannot use parameters without a WHERE statement.");
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
        // Validate parameters 
        $this->validateReadAllParameters($where, $params);

        try {
            // Format SQL code
            $sql = "SELECT {$columns}
                        FROM {$this->databaseTableName}
                        {$where}";
            $stmt = $this->connection->prepare($sql);

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
     * Validate BaseDao::readDataBy parameters
     *
     * @param string $where
     * @param string $params
     * @return void
     */
    public function validateReadDataByParameters(
        string $where,
        string $params,
    ): void {
        // Check if WHERE statement is empty
        if (empty($where)) {
            throw new BaseDaoException("WHERE statement cannot be empty.");
        }

        // Check WHERE statement parameters is empty
        if (empty($params)) {
            throw new BaseDaoException("WHERE statement parameters cannot be empty.");
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
        // Validate parameters
        $this->validateReadDataByParameters($where, $params);

        try {
            // Format SQL code
            $sql = "SELECT {$columns}
                        FROM {$this->databaseTableName}
                        {$where}";
            $stmt = $this->connection->prepare($sql);

            parse_str($params, $paramsArray);

            // Bind SQl code values
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

    /**
     * Validate BaseDao::updateData parameters
     *
     * @param array $values
     * @param string $where
     * @return void
     */
    private function validateUpdateDataParameters(array $values, string $where): void
    {
        // Check if values to update is empty
        if (empty($values)) {
            throw new BaseDaoException("Cannot UPDATE with empty values.");
        }

        // Check if update where is empty
        if (empty($where)) {
            throw new BaseDaoException("Cannot use UPDATE with empty WHERE");
        }
    }

    /**
     * Update data in database
     *
     * @param array $values
     * @param string $where
     * @return bool
     */
    public function updateData(array $values, string $where): bool
    {
        // Validate parameters
        $this->validateUpdateDataParameters($values, $where);

        $this->connection->beginTransaction();

        try {
            $assigments = "";
            $arrayKeys = array_keys($values);
            $end = end($arrayKeys);

            foreach ($values as $key => $value) {
                if ($key === $end) {
                    $assigments .= "{$key}=:{$key}";

                    break;
                }

                $assigments .= "{$key}=:{$key}, ";
            }

            $sql = "UPDATE {$this->databaseTableName}
                        SET {$assigments}
                        {$where}";
            $stmt = $this->connection->prepare($sql);

            if ($stmt->execute($values)) {
                $this->connection->commit();

                return true;
            } else {
                $this->connection->rollBack();

                return false;
            }
        } catch (PDOException $ex) {
            $this->connection->rollBack();
            die($ex->getMessage());
        }
    }

    /**
     * Validate BaseDao::where parameters
     *
     * @param string $where
     * @return void
     */
    public function validateDeleteDataParameters(string $where): void
    {
        // Check if where is empty
        if (empty($where)) {
            throw new BaseDaoException("Cannot call DELETE statement without a WHERE statement.");
        }
    }

    /**
     * Delete data from database
     *
     * @param array $data
     * @return bool
     */
    public function deleteData(string $where): bool
    {
        // Validate parameters
        $this->validateDeleteDataParameters($where);

        $this->connection->beginTransaction();

        try {
            // Format SQL code
            $sql = "DELETE FROM {$this->databaseTableName}
                        {$where}";
            $stmt = $this->connection->prepare($sql);

            if ($stmt->execute()) {
                $this->connection->commit();

                return true;
            } else {
                $this->connection->rollBack();

                return false;
            }
        } catch (PDOException $ex) {
            $this->connection->rollBack();
            die($ex->getMessage());
        }
    }
}
