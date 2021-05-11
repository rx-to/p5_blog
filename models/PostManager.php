<?php

class PostManager extends Model {
    /**
     * Returns all posts.
     * @return array
     */
    protected function getAll() {
        return $this->selectFrom('post');
    }

    /**
     * Deletes all posts.
     */
    protected function deleteAll() {
        $this->deleteFrom('post');
    }

    /**
     * Deletes a post.
     * @param string $column
     * @param mixed  $value
     */
    protected function delete($column, $value) {
        $this->deleteFrom($column, $value);
    }
}