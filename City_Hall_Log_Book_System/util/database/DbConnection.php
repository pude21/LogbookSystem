<?php

/**
 * This class provides a set of methods for establishing a connection to a database and performing basic database operations.
 */
class DbConnection
{
    protected string $hostname = "127.0.0.1";
    protected string $username = "root";
    protected string $password = "";
    protected string $database = "city_log_booksystem";
    protected mysqli $conn;
    protected mixed $stmt;

    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->hostname, $this->username, $this->password);

            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . " \n";
            exit();
        }
    }

    /**
     * This destructor closes the database connection when the object is destroyed.
     */
    public function __destruct()
    {
        $this->conn->close();
        if (isset($this->stmt) && $this->stmt !== null) {
            $this->stmt->close();
        }
    }

    /**
     * Checks if a database exists and creates it if it does not. It uses the mysqli extension to execute a `CREATE DATABASE` query.
     * @throws \Exception
     * @return void
     */
    protected function createDatabaseIfNotExists()
    {
        try {
            $sql = "CREATE DATABASE IF NOT EXISTS `$this->database`";
            if ($this->conn->query($sql) === false) {
                throw new Exception("Error creating database: " . $this->conn->error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}