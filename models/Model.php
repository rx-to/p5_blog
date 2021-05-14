<?php

class Model
{
    private const DB_HOST     = 'localhost';
    private const DB_USER     = 'root';
    private const DB_PASSWORD = '';
    private const DB_NAME     = 'p5_blog';
    private $_pdo;

    /**
     * Returns database connection.
     * @return PDO
     */
    private function getDB()
    {
        if (!$this->_pdo)
            $this->_pdo = new PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8mb4', self::DB_USER, self::DB_PASSWORD);
        
        return $this->_pdo;
    }

    /**
     * Returns all data from table.
     * @param string $table
     * @param string $column
     * @param string $value
     */
    public function selectFrom($table, $column = null, $value = null)
    {
        $db     = $this->getDB();
        $query  = "SELECT * FROM `$table`" . ($column && $value ? " WHERE `$column` = :value" : "");
        $bind   = [':value' => $value];
        $stmt   = $db->prepare($query);
        $stmt->execute($bind);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return count($data) > 0 ? $data : false;
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
