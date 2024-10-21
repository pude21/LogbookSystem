<?php

require_once "DbHelper.php";

/**
 * The `DbSeeder` class is a utility class designed to seed a database table with data.
 */
class DbSeeder
{
    private string $tableName;
    private DbHelper $db;

    /**
     * Initializes a new `DbSeeder` object, taking a table name as a parameter, and sets up a new instance of `DbHelper` to interact with the database.
     * @param mixed $tableName
     */
    public function __construct($tableName)
    {
        $this->db = new DbHelper();
        $this->tableName = $tableName;
    }

    /**
     * Inserts the data into the specified table.
     * @param array $data the data to seed into the table.
     * @param bool $isArray (*optional*, default: `false`): If `true`, the `$data` array is assumed to contain multiple records to seed.
     * @return string Success message if the seeding is successful, or an error message if not.
     */
    public function seed(array $data, bool $isArray = false)
    {
        $count = 0;
        if ($isArray === true) {
            foreach ($data as $datum) {
                $count += $this->db->addRecord($this->tableName, $datum);
            }
        } else {
            $count = $this->db->addRecord($this->tableName, $data);
        }

        return $count > 0 ? "'$this->tableName' table seeded \n"
            : "Error seeding '$this->tableName' table \n";
    }
}