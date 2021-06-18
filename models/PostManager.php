<?php

class PostManager extends Model
{

    /**
     * Returns post comments.
     * @param  int  $id Post ID.
     * @return bool
     */
    public function selectComments($id)
    {
        $db    = $this->getDB();

        $query = "SELECT pc.*, DATE_FORMAT(pc.`creation_date`, '%e %M %Y à %Hh%i') `creation_date_fr`, u.`avatar` `author_avatar`, u.`last_name` `author_last_name`, u.`first_name` `author_first_name`
                   FROM `post_comment` pc 
                   JOIN `user`         u  ON pc.`author_id` = u.`id`
                   WHERE `post_id` = :post_id";
        $stmt  = $db->prepare($query);
        $stmt->execute([':post_id' => $id]);
        $comments = [];
        while ($comment = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment['user_slug']   = Util::slugify("{$comment['author_first_name']}-{$comment['author_last_name']}-{$comment['author_id']}");
            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     * Returns all posts.
     * @param int $limit
     * @return array
     */
    public function getAll($limit = 5)
    {
        $db     = $this->getDB();
        $db->query("SET lc_time_names = 'fr_FR'");
        $query  = "SELECT    p.*, DATE_FORMAT(p.`creation_date`, '%e %M %Y à %Hh%i') `creation_date_fr`, u.`first_name` `author_first_name`, u.`last_name` `author_last_name`, COUNT(pc.`id`) `number_of_comments`
                   FROM      `post`         p
                   JOIN      `user`         u  ON p.`creation_author_id` = u.`id`
                   LEFT JOIN `post_comment` pc ON pc.`post_id`           = p.`id`
                   GROUP BY  p.`id`
                   ORDER BY  p.`creation_date` DESC
                   LIMIT     :limit" . (!$limit ? ", 5" : '');

        $limit = $limit ? $limit : (isset($_GET['page_no']) ? ($_GET['page_no'] - 1) * 5 : 0);

        $stmt  = $db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $postlist = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['user_slug'] = Util::slugify("{$row['author_first_name']}-{$row['author_last_name']}-{$row['creation_author_id']}");
            $postlist[]       = $row;
        }

        $query = "SELECT COUNT(*) FROM `post`";
        $stmt  = $db->query($query);
        $countPosts = $stmt->fetch(PDO::FETCH_COLUMN);
        $postlist['number_of_pages'] = intval($countPosts / 5) + ($countPosts % 5 > 0 ? 1 : 0);

        return count($postlist) > 0 ? $postlist : false;
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
        $query  = "SELECT    p.*, DATE_FORMAT(p.`creation_date`, '%e %M %Y à %Hh%i') `creation_date_fr`, u.`first_name` `author_first_name`, u.`last_name` `author_last_name`, COUNT(pc.`id`) `number_of_comments`
                   FROM      `post`         p
                   JOIN      `user`         u  ON p.`creation_author_id` = u.`id`
                   LEFT JOIN `post_comment` pc ON pc.`post_id`           = p.`id`
                   WHERE     p.`id` = :id
                   GROUP BY  p.`id`";

        $stmt   = $db->prepare($query);
        $stmt->execute([':id' => $id]);

        if ($postlist = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $postlist['slug'] = Util::slugify($postlist['title'] . '-' . $postlist['id']);

            // Comments
            $postlist['comments'] = $this->selectComments($id);

            // Previous article slug
            $query = "SELECT `id`, `title` FROM `post` WHERE `id` < :id ORDER BY `creation_date` DESC LIMIT 1";
            $stmt  = $db->prepare($query);
            $stmt->execute([':id' => $id]);
            if ($previous = $stmt->fetch(PDO::FETCH_ASSOC))
                $postlist['previous'] = Util::slugify("{$previous['title']}-{$previous['id']}");

            // Next article slug
            $query = "SELECT `id`, `title` FROM `post` WHERE `id` > :id ORDER BY `creation_date` ASC LIMIT 1";
            $stmt  = $db->prepare($query);
            $stmt->execute([':id' => $id]);
            if ($next = $stmt->fetch(PDO::FETCH_ASSOC))
                $postlist['next'] = Util::slugify("{$next['title']}-{$next['id']}");
        }

        return $postlist ? $postlist : false;
    }

    /**
     * Inserts a comment.
     * @param string $data
     * @return bool
     */
    public function insertComment($data)
    {
        $db     = $this->getDB();
        $query  = "INSERT INTO `post_comment` (`author_id`, `reply_to_comment_id`, `post_id`, `content`, `status`) 
                   VALUES (1, :reply_to_comment_id, :post_id, :content, 1)";
        $stmt   = $db->prepare($query);

        $params = [
            ':reply_to_comment_id' => intval($data['reply_to_comment_id']) ? $data['reply_to_comment_id'] : null,
            ':post_id'             => $data['post_id'],
            ':content'             => $data['comment'],
        ];
        return $stmt->execute($params);
    }

    /**
     * Deletes a comment.
     * @param  int  $id
     * @return bool
     */
    public function deleteComment($id)
    {
        $db    = $this->getDB();
        $query = "DELETE FROM `post_comment` WHERE `id` = :id";
        $stmt  = $db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }
}
