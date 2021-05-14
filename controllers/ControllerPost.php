<?php

class ControllerPost {
    /**
     * Returns all posts.
     * @return array
     */
    public function postList() {
        $postManager = new PostManager();
        return $postManager->getAll();
    }
}