<?php

class ControllerPost extends Controller
{
    /**
     * Returns all posts.
     * @return array
     */
    public function postList()
    {
        $postManager = new PostManager();
        return $postManager->getAll();
    }

    /**
     * Returns current page data.
     * @param  string $slug
     * @return array
     */
    protected function getPageData($visibility, $slug)
    {
        $model = new Model();
        $data  = $model->selectPage($visibility, $slug);

        if (!$data) $data = $model->selectPage('page', 'slug', '404');

        $meta  = [
            'meta_title'       => $data[0]['meta_title'],
            'meta_description' => $data[0]['meta_description'],
            'meta_keywords'    => $data[0]['meta_keywords'],
            'title'            => $data[0]['title'],
            'subtitle'         => $data[0]['subtitle']
        ];

        return $meta;
    }
}
