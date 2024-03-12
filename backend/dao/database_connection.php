<?php
class DatabaseConnect
{
    private $connection = null;
    private static $instance;
    private static $host = "localhost";
    private static $port = "3306";
    private static $dbname = "shoesstore";
    private static $user = "root";
    private static $password = "";

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnect();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        try {
            if ($this->connection == null || $this->connection->connect_error) {
                $this->connection = new mysqli(self::$host, self::$user, self::$password, self::$dbname, self::$port);
            }
            return $this->connection;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return null;
    }

    public static function getPreparedStatement($sql, ...$args)
    {
        try {
            $preparedStatement = self::getInstance()->getConnection()->prepare($sql);
            $types = "";
            foreach ($args as $arg) {
                if (is_int($arg)) {
                    $types .= "i";
                } elseif (is_float($arg)) {
                    $types .= "d";
                } elseif (is_string($arg)) {
                    $types .= "s";
                } else {
                    $types .= "b";
                }
            }
            $preparedStatement->bind_param($types, ...$args);
            return $preparedStatement;
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage() . " with sql: " . $sql);
        }
    }

    public static function executeQuery($sql, ...$args)
    {
        $preparedStatement = self::getPreparedStatement($sql, ...$args);
        $preparedStatement->execute();
        return $preparedStatement->get_result();
    }

    public static function executeUpdate($sql, ...$args)
    {
        $preparedStatement = self::getPreparedStatement($sql, ...$args);
        $preparedStatement->execute();
        return $preparedStatement->affected_rows;
    }

    public static function closeConnection()
    {
        try {
            $instance = self::getInstance();
            if ($instance->connection != null && !$instance->connection->connect_error) {
                $instance->connection->close();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function checkConnection()
    {
        $this->getConnection();
        try {
            return $this->connection != null && !$this->connection->connect_error;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        return false;
    }

    public function beginTransaction()
    {
        try {
            $this->getConnection()->begin_transaction();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function endTransaction()
    {
        try {
            $this->getConnection()->commit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function rollbackTransaction()
    {
        try {
            $this->getConnection()->rollback();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
