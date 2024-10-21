<?php

require_once "DbConnection.php";

/**
 * The `DbDrop` class is a child class of `DbConnection` and is designed to drop a database.
 */
class DbDrop extends DbConnection
{
    /**
     * The constructor initializes a new mysqli connection using the `hostname`, `username`, and `password` properties inherited from the `DbConnection` class. If the connection fails, it dies with an error message.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The drop method is responsible for dropping the database.
     * @throws \Exception
     * @return string If the `DROP DATABASE` query fails, it throws an exception with an error message. If the query succeeds, it returns a success message.
     */
    public function drop()
    {
        try {
            $checkDB = "SHOW DATABASES LIKE '$this->database'";
            $checkDBQuery = $this->conn->query($checkDB);

            if ($checkDBQuery->num_rows <= 0) {
                throw new Exception("Database does not exists");
            }

            $dropDB = "DROP DATABASE $this->database";
            $dropDBQuery = $this->conn->query($dropDB);

            if ($dropDBQuery === true) {
                return "Database dropped successfully \n";
            } else {
                throw new Exception("Error Dropping Database: " . $this->conn->error);
            }
        } catch (Exception $e) {
            return $e->getMessage() . " \n";
        }
    }
}