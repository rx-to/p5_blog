<?php

class PostManager extends Model
{
    /**
     * Returns all posts.
     * @return array
     */
    public function getAll()
    {
        $db     = $this->getDB();
        $query  = "SELECT p.*, DATE_FORMAT(p.`creation_date`, '%e %M %Y') `creation_date_fr`, u.`first_name`, u.`last_name`
                   FROM `post` p
                   JOIN `user` u ON p.`creation_author_id` = u.`id`";
        $stmt   = $db->query($query);

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return count($data) > 0 ? $data : false;
    }

    /**
     * Deletes all posts.
     */
    public function deleteAll()
    {
        $this->deleteFrom('post');
    }

    /**
     * Deletes a post.
     * @param string $column
     * @param mixed  $value
     */
    public function delete($column, $value)
    {
        $this->deleteFrom($column, $value);
    }
}
