<?php

require_once "DbConnection.php";

/**
 * The **`DbHelper`** class is a utility for interacting with a **`MySQL`** database using the mysqli extension. It provides methods for basic CRUD operations and specific queries related to a visitor logging system.
 */
class DbHelper extends DbConnection
{
    public function __construct()
    {
        parent::__construct();

        try {
            $this->conn->select_db($this->database);

            if ($this->conn->error) {
                throw new Exception("Database selection failed: " . $this->conn->error);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . " \n";
            exit();
        }
    }

    /**
     * The **`fetchRecords`** function retrieves all records from a specified database table.
     * 
     * @param string $table The name of the table to fetch records from.
     * @return array The function returns an array of all records from a specified database table.
     */
    public function fetchRecords(string $table): array
    {
        $sql = "SELECT * FROM `$table`";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = (object) $row;
        }
        return $rows;
    }

    /**
     * The **`fetchRecord`** function retrieves a single record from a specified table based on the provided conditions.
     * 
     * @param string $table The name of the table to fetch the record from.
     * @param array $args An associative array of column names and their corresponding values, used to build the **`WHERE`** clause of the query.
     * @return array|bool|null The function returns an associative array of a single record from a specified table based on the provided conditions.
     */
    public function fetchRecord(string $table, array $args)
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = $this->condition($keys, 0, ' AND ');
        $sql = "SELECT * FROM `$table` WHERE $condition";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param($this->bindingParams($values), ...$values);
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }

    /**
     * The **`deleteRecord`** function deletes a record from a specified table based on the given conditions and returns the number of affected rows.
     * 
     * @param string $table The name of the table from which to delete the record.
     * @param array $args An associative array of column names and values used to build the **`WHERE`** clause for deletion.
     * @return int|string number of affected rows.
     */
    public function deleteRecord(string $table, array $args): int|string
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $condition = $this->condition($keys, 0, ' AND ');
        $sql = "DELETE FROM `$table` WHERE $condition";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param($this->bindingParams($values), ...$values);
        $this->stmt->execute();
        return $this->stmt->affected_rows;
    }

    /**
     * The **`addRecord`** function inserts a new record into a specified table using the provided data and returns the number of affected rows.
     * 
     * @param string $table The name of the table where the new record will be inserted.
     * @param array $args An associative array of column names and values to insert into the table.
     * @return int|string number of affected rows.
     */
    public function addRecord(string $table, array $args): int|string
    {
        $keys = array_keys($args);
        $values = array_values($args);
        $key = implode("`, `", $keys);
        $sql = "INSERT INTO `$table` (`$key`) VALUES (" . $this->blindItem($values) . ")";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param($this->bindingParams($values), ...$values);
        $this->stmt->execute();
        return $this->stmt->affected_rows;
    }

    /**
     * The **`updateRecord`** function updates an existing record in a specified table based on the provided data and returns the number of affected rows.
     * 
     * @param string $table The name of the table where the record will be updated.
     * @param array $args An associative array of column names and values. The first key-value pair is used as the **`WHERE`** condition, while the rest are used to update the record.
     * @return int|string number of affected rows.
     */
    public function updateRecord(string $table, array $args): int|string
    {
        $keys = array_keys($args);
        $values = $this->updateValues(array_values($args));
        $sets = $this->condition($keys, 1, ", ");
        $sql = "UPDATE `$table` SET $sets WHERE `$keys[0]` = ?";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->bind_param($this->bindingParams($values), ...$values);
        $this->stmt->execute();
        return $this->stmt->affected_rows;
    }

    public function foreignKeyNameFinder($table, $column)
    {
        $sql = "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = '$table' AND COLUMN_NAME = '$column'";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        $fk_name = $result->fetch_assoc();
        return $fk_name["CONSTRAINT_NAME"];
    }

    /**
     * get the current date
     * @return mixed
     */
    public function getCurrentDate()
    {
        $sql = "SELECT CURRENT_DATE AS `currentDate`";
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute();
        $result = $this->stmt->get_result();
        $date = $result->fetch_assoc();
        return $date['currentDate'];
    }

    /**
     * The **`condition`** function generates a conditional SQL-like string based on key-value pairs. It takes four parameters:
     *
     * @param array $key an array of keys (likely representing column names),
     * @param int $index the starting point from which to begin constructing the condition,
     * @param string $implode a string that is used to concatenate the conditions (such as AND or OR).
     * @return string
     */
    private function condition($key, $index, $implode): string
    {
        $condition = [];
        for ($i = $index; $i < count($key); $i++) {
            $condition[] = "`" . $key[$i] . "` = ?";
        }
        return implode($implode, $condition);
    }

    private function updateValues(array $values)
    {
        $firstValue = array_shift($values);
        array_push($values, $firstValue);

        return $values;
    }

    private function blindItem($values)
    {
        return implode(', ', array_fill(0, count($values), '?'));
    }

    private function bindingParams($values): string
    {
        return str_repeat('s', count($values));
    }

    /**
     * The **`getAllLogs`** function retrieves and returns all visitor logs from the database, including details such as visitor name, purpose, type, status, office, date, and time.
     * @return array
     */
    public function getAllLogs(): array
    {
        $sql = "SELECT 
                    `id`, 
                    CONCAT(`fname`, ' ', `lname`) AS `title`,
                    `division`,
                    `office`,
                    `purpose`, 
                    `type`, 
                    `status`,
                    DATE_FORMAT(`date`, '%Y-%m-%d') AS `start`, 
                    DATE_FORMAT(`date`, '%Y-%m-%d') AS `end`, 
                    DATE_FORMAT(`date`, '%I:%i %p') AS `time` 
                FROM `visitor_info`
                ";
        $query = $this->conn->query($sql);
        $rows = [];
        while ($row = $query->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * The **`allClients`** function retrieves the count of accepted employees and visitors for a given month.
     * 
     * @param string $month The month and year in the format **`'YYYY-MM'`** to filter the records.
     * @return array|bool|null
     */
    public function allClients(string $month): array|bool|null
    {
        $sql = "SELECT 
                    COUNT(CASE WHEN type = 'Employee' THEN 1 END) AS employee_count,
                    COUNT(CASE WHEN type = 'Visitor' THEN 1 END) AS visitor_count
                FROM 
                    visitor_info
                WHERE
                    DATE_FORMAT(date, '%Y-%m') = '$month' AND status = 'Accepted'
                ";
        $query = $this->conn->query($sql);
        return $query->fetch_assoc();
    }
}
