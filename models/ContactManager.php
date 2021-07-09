<?php

class ContactManager extends Model
{
    /**
     * Inserts message.
     * @param string $data
     * @return bool
     */
    public function insertContact($data)
    {
        $db     = $this->getDB();
        $query  = "INSERT INTO `contact` (`last_name`, `first_name`, `email`, `subject`, `message`) 
                   VALUES (:last_name, :first_name, :email, :subject, :message)";
        $stmt   = $db->prepare($query);

        $params = [
            ':last_name'  => $data['last_name'],
            ':first_name' => $data['first_name'],
            ':email'      => $data['email'],
            ':subject'    => $data['subject'],
            ':message'    => $data['message']
        ];
        return $stmt->execute($params);
    }
}
