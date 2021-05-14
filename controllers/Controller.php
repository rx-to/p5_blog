<?php
require 'models/Model.php';
class Controller
{
    /**
     * Returns view file from slug.
     * @param  string $part
     * @param  string $slug
     * @return string
     */
    private function getView($part, $slug)
    {
        $slugElements = explode('-', $slug);
        $directory    = "views/$part/";
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
     * @param  string $slug
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
     * Generates HTML of view.
     * @param  string $part
     * @param  string $slug
     * @return string
     */
    public function displayView($part, $slug)
    {
        $file = $this->getView($part, $slug);
        ob_start();
        require_once $file;
        $content = ob_get_clean();
        $meta    = $this->getMeta($slug);
        require_once 'views/Template.php';
    }

    /**
     * Requires controller of a specific page.
     * @param string $slug
     */
    public function requireController($slug)
    {
        $model = new Model();
        $data = $model->selectFrom('page', 'slug', $slug);
        if ($data[0]['controller']) require_once('controllers/' . $data[0]['controller']);
    }
}
