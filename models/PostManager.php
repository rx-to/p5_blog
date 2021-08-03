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

        $query = "SELECT     pc.*, DATE_FORMAT(pc.`creation_date`, '%d/%m/%Y à %Hh%i') `creation_date_fr`, DATE_FORMAT(pc.`update_date`, '%d/%m/%Y à %Hh%i') `update_date_fr`, u.`avatar` `author_avatar`, u.`last_name` `author_last_name`, u.`first_name` `author_first_name`
                   FROM     `post_comment` pc 
                   JOIN     `user`         u      ON pc.`author_id` = u.`id`
                   WHERE    `post_id`              = :post_id
                   AND      `status`               = 1
                   ORDER BY `creation_date` DESC";
        $stmt  = $db->prepare($query);
        $stmt->execute([':post_id' => $id]);
        $comments = [];
        while ($comment = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment['user_slug'] = Util::slugify("{$comment['author_first_name']}-{$comment['author_last_name']}-{$comment['author_id']}");
            $comments[] = $comment;
        }

        return $comments;
    }

    /**
     * Returns comment.
     * @param  int  $id Comment ID.
     * @return bool
     */
    public function selectComment($id)
    {
        $db    = $this->getDB();

        $query = "SELECT pc.*, DATE_FORMAT(pc.`creation_date`, '%d/%m/%Y à %Hh%i') `creation_date_fr`, DATE_FORMAT(pc.`update_date`, '%d/%m/%Y à %Hh%i') `update_date_fr`, u.`avatar` `author_avatar`, u.`last_name` `author_last_name`, u.`first_name` `author_first_name`
                  FROM   `post_comment` pc 
                  JOIN   `user`         u  ON pc.`author_id` = u.`id`
                  WHERE  pc.`id`               = :id
                  AND    `status`           = 1";
        $stmt  = $db->prepare($query);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns all posts.
     * @param int $limit
     * @return array
     */
    public function getAll($limit = 5)
    {
        $db     = $this->getDB();

        $query  = "SELECT    p.*, DATE_FORMAT(p.`creation_date`, '%d/%m/%Y à %Hh%i') `creation_date_fr`, DATE_FORMAT(p.`update_date`, '%d/%m/%Y à %Hh%i') `update_date_fr`, u.`first_name` `author_first_name`, u.`last_name` `author_last_name`, COUNT(pc.`id`) `number_of_comments`
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

        $query  = "SELECT    p.*, DATE_FORMAT(p.`creation_date`, '%d/%m/%Y à %Hh%i') `creation_date_fr`, DATE_FORMAT(p.`update_date`, '%d/%m/%Y à %Hh%i') `update_date_fr`, u.`first_name` `author_first_name`, u.`last_name` `author_last_name`, COUNT(pc.`id`) `number_of_comments`
                   FROM      `post`         p
                   JOIN      `user`         u  ON p.`creation_author_id` = u.`id`
                   LEFT JOIN `post_comment` pc ON pc.`post_id`           = p.`id`
                   WHERE     p.`id` = :id
                   GROUP BY  p.`id`";

        $stmt   = $db->prepare($query);
        $stmt->execute([':id' => $id]);

        if ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post['slug'] = Util::slugify($post['title'] . '-' . $post['id']);

            // Comments
            $post['comments'] = $this->selectComments($id);

            // Previous article slug
            $query = "SELECT `id`, `title` FROM `post` WHERE `id` < :id ORDER BY `creation_date` DESC LIMIT 1";
            $stmt  = $db->prepare($query);
            $stmt->execute([':id' => $id]);
            if ($previous = $stmt->fetch(PDO::FETCH_ASSOC))
                $post['previous'] = Util::slugify("{$previous['title']}-{$previous['id']}");

            // Next article slug
            $query = "SELECT `id`, `title` FROM `post` WHERE `id` > :id ORDER BY `creation_date` ASC LIMIT 1";
            $stmt  = $db->prepare($query);
            $stmt->execute([':id' => $id]);
            if ($next = $stmt->fetch(PDO::FETCH_ASSOC))
                $post['next'] = Util::slugify("{$next['title']}-{$next['id']}");
        }

        return $post ? $post : false;
    }

    /**
     * Inserts comment.
     * @param string $data
     * @return bool
     */
    public function insertComment($data, $userID)
    {
        $db     = $this->getDB();
        $query  = "INSERT INTO `post_comment` (`author_id`, `post_id`, `content`, `status`) 
                   VALUES ($userID, :post_id, :content, 0)";
        $stmt   = $db->prepare($query);

        $params = [
            ':post_id' => $data['post_id'],
            ':content' => $data['comment'],
        ];

        return $stmt->execute($params);
    }

    /**
     * Updates comment.
     * @param string $data
     * @return bool
     */
    public function updateComment($data)
    {
        $db     = $this->getDB();
        $query  = "UPDATE `post_comment` SET `content` = :content, `update_date` = NOW(), `status` = 0 WHERE `id` = :comment_id";
        $params = [
            ':content'    => $data['comment'],
            ':comment_id' => $data['comment_id']
        ];

        $stmt = $db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Deletes comment.
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

    /**
     * Deletes post.
     * @param  int  $id
     * @return bool
     */
    public function deletePost($id)
    {
        $db    = $this->getDB();
        $query = "DELETE FROM `post` WHERE `id` = :id";
        $stmt  = $db->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Deletes post image.
     * @param  int  $postID
     * @return bool
     */
    public function deleteImage($postID)
    {
        $db    = $this->getDB();
        $query = "UPDATE `post` SET `image` = NULL WHERE `id` = :id";
        $stmt  = $db->prepare($query);
        return $stmt->execute([':id' => $postID]);
    }

    /**
     * Reports comment.
     * @param  int  $id
     * @return bool
     */
    public function reportComment($id, $report)
    {
        $db     = $this->getDB();

        $query  = "SELECT * FROM `comment_report` WHERE `comment_id` = :comment_id AND `user_id` = :user_id";
        $stmt   = $db->prepare($query);
        $params = [
            ':comment_id' => $id,
            ':user_id'    => 1
        ];
        $stmt->execute($params);

        if ($stmt->fetch(PDO::FETCH_ASSOC))
            $query  = "UPDATE `comment_report` SET `report` = :report WHERE `comment_id` = :comment_id AND `user_id` = :user_id";
        else
            $query  = "INSERT INTO `comment_report` (`comment_id`, `user_id`, `report`) VALUES (:comment_id, :user_id, :report)";

        $stmt   = $db->prepare($query);
        $params[':report'] = $report;
        return $stmt->execute($params);
    }

    /**
     * Inserts post.
     * @param string $data
     * @return bool
     */
    public function insertPost($data, $userID)
    {
        $db     = $this->getDB();
        $query  = "INSERT INTO `post` (`creation_author_id`, `title`, `introduction`, `image`, `content`, `status`) 
                   VALUES ($userID, :title, :introduction, :image, :content, :status)";
        $stmt   = $db->prepare($query);

        $params = [
            ':title'        => $data['title'],
            ':introduction' => $data['introduction'],
            ':image'        => $data['image'] ?? '',
            ':content'      => $data['content'],
            ':status'       => $data['status']
        ];

        return $stmt->execute($params);
    }

    /**
     * Updates post.
     * @param string $data
     * @return bool
     */
    public function updatePost($data, $userID)
    {
        $db     = $this->getDB();
        $query  = "UPDATE `post` 
                   SET    `update_author_id` = $userID, `title` = :title, `introduction` = :introduction, `image` = :image, `content` = :content, `status` = :status, `update_date` = NOW() 
                   WHERE  `id` = :id";
        $stmt   = $db->prepare($query);

        $params = [
            ':id'           => $data['id'],
            ':title'        => $data['title'],
            ':introduction' => $data['introduction'],
            ':image'        => $data['image'] ?? '',
            ':content'      => $data['content'],
            ':status'       => $data['status']
        ];

        return $stmt->execute($params);
    }

    /**
     * Returns last post ID.
     * @return int
     */
    public function getLastPostID()
    {
        $db    = $this->getDB();
        $stmt  = $db->query("SELECT MAX(`id`) FROM `post`");
        return $stmt->fetch(PDO::FETCH_COLUMN);
    }
}
