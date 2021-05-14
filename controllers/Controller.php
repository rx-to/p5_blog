<?php
require 'models/Model.php';
class Controller
{
    /**
     * Returns view file from slug.
     * @param  string $visibility
     * @param  string $slug
     * @return string
     */
    private function getView($visibility, $slug)
    {
        $slugElements = explode('-', $slug);
        $directory    = "views/$visibility/";
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
     * Returns current page data.
     * @param  string $slug
     * @return array
     */
    private function getPageData($visibility, $slug)
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

    /**
     * Generates HTML of view.
     * @param  string $visibility
     * @param  string $slug
     * @return string
     */
    public function displayView($visibility, $slug)
    {
        $file = $this->getView($visibility, $slug);
        ob_start();
        require_once $file;
        $content = ob_get_clean();
        $data    = $this->getPageData($visibility, $slug);
        require_once 'views/public/Template.php';
    }

    /**
     * Requires controller of a specific page.
     * @param string $slug
     */
    public function requireController($visibility, $slug)
    {
        $model = new Model();
        $data = $model->selectPage($visibility, $slug);
        if ($data[0]['controller']) require_once('controllers/' . $data[0]['controller']);
    }
}
