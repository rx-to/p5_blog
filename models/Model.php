<?php

class Model
{
    /**
     * Returns database connection.
     * @return PDO
     */
    private function getDB()
    {
        define('DB_HOST', 'localhost');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'p5_blog');
        return new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASSWORD);
    }

    /**
     * Returns all data from table.
     * @param string $table
     * @param string $column
     * @param string $value
     */
    public function selectFrom($table, $column = null, $value = null)
    {
        $db    = $this->getDB();
        $query = "SELECT * FROM `$table`" . ($column && $value ? " WHERE `$column` = :value" : "");
        $bind  = [':value' => $value];
        $stmt  = $db->prepare($query);
        $stmt->execute($bind);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Delete one or several rows from table.
     * @param string $table
     * @param string $column
     * @param string $value
     * @return bool
     */
    public function deleteFrom($table, $column = null, $value = null)
    {
        $db     = $this->getDB();
        $query  = "DELETE FROM `$table` WHERE `$column` = :value";
        $bind   = [':value' => $value];
        $stmt   = $db->prepare($query);
        return $stmt->execute($bind);
    }
}
