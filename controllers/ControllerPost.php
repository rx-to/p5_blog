<?php

class ControllerPost {
    protected function postList() {
        $postManager = new PostManager();
        $postList    = $postManager->getAll();
    }
}