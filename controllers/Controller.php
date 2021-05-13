<?php
require 'models/Model.php';
class Controller
{
    /**
     * Returns view file from slug.
     * @param string $slug
     * @return string
     */
    private function getView($slug)
    {
        $slugElements = explode('-', $slug);
        $directory    = 'views/public/';
        $filename     = 'view';

        foreach ($slugElements as $element) {
            $filename .= ucfirst($element);
        }

        $filename .= ".php";
        $filepath  = $directory . $filename;

        if (!is_file($filepath)) $filepath = $directory . 'view404.php';

        return $filepath;
    }

    /**
     * Returns meta data of current page.
     * @param string $slug
     * @return array
     */
    private function getMeta($slug)
    {
        $model = new Model();
        $data  = $model->selectFrom('page', 'slug', $slug);

        if (!$data) $data = $model->selectFrom('page', 'slug', '404');

            $meta  = [
                'title'       => $data[0]['meta_title'],
                'description' => $data[0]['meta_description'],
                'keywords'    => $data[0]['meta_keywords']
            ];


        return $meta;
    }

    /**
     * Returns HTML of view.
     * @param string $slug
     * @return string
     */
    public function displayView($slug)
    {
        $file = $this->getView($slug);
        ob_start();
        require_once $file;
        $content = ob_get_clean();
        $meta    = $this->getMeta($slug);
        require_once 'views/Template.php';
    }
}
