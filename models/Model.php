<?php

class Model
{
    private const DB_HOST     = 'localhost';
    private const DB_USER     = 'u571467911_blog';
    private const DB_PASSWORD = '9f?eWrxUJ*';
    private const DB_NAME     = 'u571467911_blog';
    private $_pdo;

    /**
     * Returns database connection.
     * @return PDO
     */
    public function getDB()
    {
        if (!$this->_pdo)
            $this->_pdo = new PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8mb4', self::DB_USER, self::DB_PASSWORD);
        
        return $this->_pdo;
    }

    /**
     * Returns all data from table.
     * @param string $table
     * @param string $column
     * @param mixed
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

    /**
     * Returns page data.
     * @param string $visibility
     * @param string $slug
     * @return mixed
     */
    public function selectPage($visibility, $slug) {
        $db     = $this->getDB();
        $query  = "SELECT * FROM `page` WHERE `visibility` = :visibility AND `slug` = :slug";
        $bind   = [':visibility' => $visibility, ':slug' => $slug];
        $stmt   = $db->prepare($query);
        $stmt->execute($bind);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return count($data) > 0 ? $data : false;
    }
}
