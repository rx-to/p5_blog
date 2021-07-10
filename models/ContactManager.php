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

    /**
     * Returns contactlist.
     * @return bool
     */
    public function selectContacts()
    {
        $db    = $this->getDB();

        $query = "SELECT    *, DATE_FORMAT(`date`, '%d/%m/%Y à %Hh%i') `date_fr`
                  FROM     `contact`
                  ORDER BY `date` DESC";
        $stmt  = $db->query($query);
        $contacts = [];
        while ($comment = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = $comment;
        }

        return $contacts;
    }
}
