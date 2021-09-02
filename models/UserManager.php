<?php

namespace Blog\Models;

use \PDO;

class UserManager extends Model
{
    /**
     * Inserts user.
     * @param string $data
     * @return bool
     */
    public function insertUser($data)
    {
        $db     = $this->getDB();
        $query  = "INSERT INTO `user` (`type_id`, `last_name`, `first_name`, `email`, `password`, `birthdate`) 
                   VALUES (2, :last_name, :first_name, :email, :password, :birthdate)";
        $stmt   = $db->prepare($query);

        $params = [
            ':last_name'  => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':email'      => $data['email'],
            ':password'   => password_hash($data['password'], PASSWORD_DEFAULT),
            ':birthdate'  => $data['birthdate']
        ];

        return $stmt->execute($params);
    }

    /**
     * Returns user.
     * @param string $column
     * @param mixed  $value
     * @return mixed
     */
    public function selectUser($column, $value)
    {
        $db    = $this->getDB();
        $query = "SELECT * FROM `user` WHERE `$column` = :value";
        $stmt  = $db->prepare($query);
        $stmt->execute([':value' => $value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
