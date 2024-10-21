<?php

require_once "DbConnection.php";
require_once "DbHelper.php";
require_once "util/Misc.php";

/**
 * This class provides a set of methods for creating, modifying, and dropping tables in a database. It extends the `DbConnection` class and uses the `DbHelper` class to perform database operations.
 */
class DbMigration extends DbConnection
{
    private string $tableName;
    private array $columns = [];
    private array $modifiedColumns = [];
    private DbHelper $db;

    /**
     * Initializes a new instance of the object, establishing a connection to the database and setting the table name.
     * @param mixed $tableName The name of the table to be operated on.
     */
    public function __construct($tableName)
    {
        parent::__construct();

        try {
            $this->createDatabaseIfNotExists();

            $this->conn->select_db($this->database);

            if ($this->conn->error) {
                throw new Exception("Database selection failed: " . $this->conn->error);
            }
        } catch (Exception $e) {
            echo $e->getMessage() . " \n";
            exit();
        }

        $this->db = new DbHelper();

        $this->tableName = $tableName;
    }

    /**
     * Adds a new column to a table with the specified name, type, and optional parameters
     * @param mixed $name The name of the column to be added.
     * @param mixed $type The data type of the column.
     * @param mixed $nullable (*optional*, default: `false`):  Whether the column can be null.
     * @param mixed $default (*optional*, default: `null`): The default value of the column.
     * @param mixed $auto_increment (*optional*, default: `false`): Whether the column is an auto-incrementing column.
     * @param mixed $position (*optional*, default: `''`): The position of the column in the table (e.g `first`, `before:column_name`, `after:column_name`).
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function addColumn($name, $type, $nullable = false, $default = null, $auto_increment = false, $position = '')
    {
        $column = "`$name` $type";

        $column .= $nullable ? " NULL" : " NOT NULL";

        $column .= $auto_increment ? " AUTO_INCREMENT" : "";

        if ($default !== null) {
            if (is_string($default) && $default !== 'CURRENT_TIMESTAMP') {
                $default = "'$default'";
            }
            $column .= " DEFAULT $default";
        }

        if (!empty(trim($position))) {
            $column .= " " . Misc::uppercaseBeforeColon($position);
        }

        $this->columns[] = $column;
        return $this;
    }

    /**
     * Adds two timestamp columns to the table: `created_at` and `updated_at`.
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function addTimestamps()
    {
        $createdAtColumn = "`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $updatedAtColumn = "`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";

        $this->columns[] = $createdAtColumn;
        $this->columns[] = $updatedAtColumn;

        return $this;
    }

    /**
     * Renames an existing column in a table with the specified new name, type, and optional nullability.
     * @param mixed $name The current name of the column to be renamed.
     * @param mixed $rename The new name of the column.
     * @param mixed $type The data type of the column.
     * @param mixed $nullable (*optional*, default: `false`): Whether the column can be null.
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function renameColumn($name, $rename, $type, $nullable = false)
    {
        $column = "CHANGE `$name` $rename $type";

        $column .= $nullable ? " NULL" : " NOT NULL";

        $this->modifiedColumns[] = $column;
        return $this;
    }

    /**
     * Modifies an existing column in a table with the specified new type, nullability, default value, auto-incrementing status, and position.
     * @param mixed $name The name of the column to be added.
     * @param mixed $type The data type of the column.
     * @param mixed $nullable (*optional*, default: `false`):  Whether the column can be null.
     * @param mixed $default (*optional*, default: `null`): The default value of the column.
     * @param mixed $auto_increment (*optional*, default: `false`): Whether the column is an auto-incrementing column.
     * @param mixed $position (*optional*, default: `''`): The position of the column in the table (e.g `first`, `before:column_name`, `after:column_name`).
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function modifyColumn($name, $type, $nullable = false, $default = null, $auto_increment = false, $position = '')
    {
        $column = "MODIFY `$name` $type";

        $column .= $nullable ? " NULL" : " NOT NULL";

        $column .= $auto_increment ? " AUTO_INCREMENT" : "";

        if ($default !== null) {
            if (is_string($default) && $default !== 'CURRENT_TIMESTAMP') {
                $default = "'$default'";
            }
            $column .= " DEFAULT $default";
        }

        if (!empty(trim($position))) {
            $column .= " " . Misc::uppercaseBeforeColon($position);
        }

        $this->modifiedColumns[] = $column;
        return $this;
    }

    /**
     * This method drops an existing column from a table with the specified name.
     * @param mixed $name The name of the column to be dropped.
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function dropColumn($name)
    {
        $column = "DROP COLUMN `$name`";
        $this->modifiedColumns[] = $column;
        return $this;
    }

    /**
     * Adds a primary key constraint to a column in a table with the specified name.
     * @param mixed $columnName The name of the column to be set as the primary key.
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function addPrimaryKey($columnName)
    {
        $column = "PRIMARY KEY (`$columnName`)";
        $this->columns[] = $column;
        return $this;
    }

    /**
     * Adds a foreign key constraint to a column in a table, referencing a column in another table.
     * @param mixed $columnName The name of the column to be set as the foreign key.
     * @param mixed $referencedTable The name of the referenced table.
     * @param mixed $referencedColumn The name of the referenced column in the referenced table.
     * @param mixed $onDelete (*optional*, default: `'CASCADE'`): The action to take when the referenced row is deleted.
     * @param mixed $onUpdate (*optional*, default: `'CASCADE'`): The action to take when the referenced row is updated.
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function addForeignKey($columnName, $referencedTable, $referencedColumn, $onDelete = 'CASCADE', $onUpdate = 'CASCADE')
    {
        $column = "FOREIGN KEY (`$columnName`) REFERENCES `$referencedTable`(`$referencedColumn`) ON DELETE $onDelete ON UPDATE $onUpdate";
        $this->columns[] = $column;
        return $this;
    }

    /**
     * Modifies the current object instance to drop the primary key of the table. 
     * @return static The current object `$this`, allowing for method chaining.
     */
    public function dropPrimaryKey()
    {
        $column = "DROP PRIMARY KEY";
        $this->modifiedColumns[] = $column;
        return $this;
    }

    /**
     * Modifies the current object instance to drop a foreign key constraint from the table.
     * @param mixed $columnName
     * @return static The name of the column associated with the foreign key constraint to be dropped.
     */
    public function dropForeignKey($columnName)
    {
        $foreign_key_name = $this->db->foreignKeyNameFinder($this->tableName, $columnName);
        $column = "DROP FOREIGN KEY $foreign_key_name";
        $this->modifiedColumns[] = $column;
        return $this;
    }

    /**
     * Creates a new table with the specified name and columns. It first checks if the table already exists, and if not, it executes a `CREATE TABLE` query with the specified columns. If the query is successful, it returns a success message. If the query fails, it throws an exception with an error message.
     * @throws \Exception
     * @return mixed
     */
    public function create()
    {
        $columnsSQL = "";
        try {
            $columnsSQL = implode(", ", $this->columns);

            if (empty(trim($columnsSQL))) {
                throw new Exception('A table must have atleast one visible column.');
            }

            $checkTable = "SHOW TABLES LIKE '$this->tableName'";
            $checkTableQuery = $this->conn->query($checkTable);

            if ($checkTableQuery->num_rows > 0) {
                return;
            }

            $sql = "CREATE TABLE IF NOT EXISTS `$this->tableName` ($columnsSQL) ENGINE=InnoDB";

            $query = $this->conn->query($sql);

            if ($query === true) {
                return "Created '$this->tableName' table \n";
            } else {
                throw new Exception('Error Creating table: ' . $this->conn->error);
            }
        } catch (Exception $e) {
            return $e->getMessage() . " \n";
        }
    }

    /**
     * Modifies an existing table by adding new columns and/or modifying existing columns. It first checks if the table exists, and if so, it constructs an `ALTER TABLE` query to modify the table. If the query is successful, it returns a success message. If the query fails, it throws an exception with an error message.
     * @throws \Exception
     * @return string
     */
    public function modify()
    {
        $columnsSQL = "";
        try {

            $columnsSQL = implode(", ", $this->modifiedColumns);

            if (!empty($this->columns)) {
                $addColumns = array_map(function ($column) {
                    return "ADD $column";
                }, $this->columns);
                $columnsSQL .= (!empty(trim($columnsSQL)) ? ", " : "") . implode(", ", $addColumns);
            }

            if (empty(trim($columnsSQL))) {
                throw new Exception('Nothing to modify in the table.');
            }

            $checkTable = "SHOW TABLES LIKE '$this->tableName'";
            $checkTableQuery = $this->conn->query($checkTable);
            if ($checkTableQuery->num_rows <= 0) {
                throw new Exception("'$this->tableName' table does not exists");
            }

            $sql = "ALTER TABLE `$this->tableName` $columnsSQL";

            $query = $this->conn->query($sql);

            if ($query === true) {
                return "Modified '$this->tableName' table \n";
            } else {
                throw new Exception('Error Modifying table: ' . $this->conn->error);
            }

        } catch (Exception $e) {
            return $e->getMessage() . " \n";
        }
    }

    /**
     * Drops an existing table with the specified name. It executes a `DROP TABLE IF EXISTS` query to delete the table. If the query is successful, it returns a success message. If the query fails, it throws an exception with an error message.
     * @throws \Exception
     * @return string
     */
    public function dropTable()
    {
        try {
            $sql = "DROP TABLE IF EXISTS `$this->tableName`";

            $query = $this->conn->query($sql);

            if ($query === true) {
                return "Table '$this->tableName' deleted successfully \n";
            } else {
                throw new Exception('Error deleting table: ' . $this->conn->error);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}