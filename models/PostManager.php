<?php

class PostManager extends Model {
    /**
     * Returns all posts.
     * @return array
     */
    public function getAll() {
        return $this->selectFrom('post');
    }

    /**
     * Deletes all posts.
     */
    public function deleteAll() {
        $this->deleteFrom('post');
    }

    /**
     * Deletes a post.
     * @param string $column
     * @param mixed  $value
     */
    public function delete($column, $value) {
        $this->deleteFrom($column, $value);
    }
}