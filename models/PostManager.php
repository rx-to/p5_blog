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
        $db->query("SET lc_time_names = 'fr_FR'");
        $query  = "SELECT    p.*, DATE_FORMAT(p.`creation_date`, '%e %M %Y à %Hh%i') `creation_date_fr`, u.`first_name`, u.`last_name`, COUNT(c.`id`) `number_of_comments`
                   FROM      `post`    p
                   JOIN      `user`    u ON p.`creation_author_id` = u.`id`
                   LEFT JOIN `comment` c ON c.`post_id` = p.`id`
                   GROUP BY  p.`id`
                   LIMIT     :limit, 5";

        $limit = isset($_GET['page']) ? ($_GET['page'] - 1) * 5 : 0;

        $stmt  = $db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['user_slug'] = Util::slugify("{$row['first_name']}-{$row['last_name']}-{$row['creation_author_id']}");
            $data[]           = $row;
        }

        $query = "SELECT COUNT(*) FROM `post`";
        $stmt  = $db->query($query);
        $countPosts = $stmt->fetch(PDO::FETCH_COLUMN);
        $data['number_of_pages'] = intval($countPosts / 5) + ($countPosts % 5 > 0 ? 1 : 0);

        return count($data) > 0 ? $data : false;
    }

    /**
     * Returns a post.
     * @param int $id
     * @return array
     */
    public function get($id)
    {

        $db     = $this->getDB();

        $db->query("SET lc_time_names = 'fr_FR'");
        $query  = "SELECT p.*, DATE_FORMAT(p.`creation_date`, '%e %M %Y à %Hh%imin%ss') `creation_date_fr`, u.`first_name`, u.`last_name`
                   FROM   `post` p
                   JOIN   `user` u ON p.`creation_author_id` = u.`id`
                   WHERE  p.`id` = :id";

        $stmt   = $db->prepare($query);
        $stmt->execute([':id' => $id]);

        if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['slug'] = Util::slugify($data['title'] . '-' . $data['id']);

            // Previous article slug
            $query = "SELECT `id`, `title` FROM `post` WHERE `id` < :id LIMIT 1";
            $stmt  = $db->prepare($query);
            $stmt->execute([':id' => $id]);
            if ($previous = $stmt->fetch(PDO::FETCH_ASSOC))
                $data['previous'] = Util::slugify("{$previous['title']}-{$previous['id']}");

            // Next article slug
            $query = "SELECT `id`, `title` FROM `post` WHERE `id` > :id LIMIT 1";
            $stmt  = $db->prepare($query);
            $stmt->execute([':id' => $id]);
            if ($next = $stmt->fetch(PDO::FETCH_ASSOC))
                $data['next'] = Util::slugify("{$next['title']}-{$next['id']}");
        }

        return $data ? $data : false;
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
