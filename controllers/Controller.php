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
    protected function getView($visibility, $slug)
    {
        $slugElements = explode('-', $slug);
        $directory    = "views/$visibility/";
        $viewFilename = 'view';
        $tplFilename  = 'tpl';

        foreach ($slugElements as $element) {
            $viewFilename .= ucfirst($element);
            $tplFilename  .= ucfirst($element);
        }

        $viewFilename .= ".php";
        $tplFilename  .= ".php";

        $viewFilepath  = $directory . $viewFilename;
        $tplFilepath   = $directory . $tplFilename;

        if (is_file($viewFilepath)) {
            $filepath = $viewFilepath;
        } elseif (is_file($tplFilepath)) {
            $filepath = $tplFilepath;
        } else {
            $filepath = $directory . 'view404.php';
        }

        return $filepath;
    }

    /**
     * Returns current page data.
     * @param  string $slug
     * @return array
     */
    protected function getPageData($visibility, $slug)
    {
        $model = new Model();

        $page = $model->selectPage($visibility, $slug);
        if (!$page) $page = $model->selectPage('public', '404');

        $data['page'] = [
            'meta_title'       => $page[0]['meta_title'],
            'meta_description' => $page[0]['meta_description'],
            'meta_keywords'    => $page[0]['meta_keywords'],
            'title'            => $page[0]['title'],
            'subtitle'         => $page[0]['subtitle'],
            'header'           => $page[0]['header']
        ];

        return $data;
    }

    /**
     * Generates HTML of view.
     * @param  string $visibility
     * @param  string $slug
     * @return string
     */
    public function displayView($visibility, $slug, $id = null)
    {
        $file = $this->getView($visibility, $slug);
        ob_start();
        require_once $file;
        $content = ob_get_clean();
        $data    = $this->getPageData($visibility, $slug, $id);
        require_once 'views/public/Template.php';
    }

    /**
     * Requires controller of a specific page.
     * @param string $slug
     * @return mixed
     */
    public function requireController($visibility, $slug)
    {
        $model = new Model();
        $data = $model->selectPage($visibility, $slug);
        $controller = null;
        $controllerName = $data[0]['controller'] ? $data[0]['controller'] : null;
        if ($controllerName) {
            require_once("controllers/$controllerName.php");
            $controller = new $controllerName();
        }
        return $controller;
    }
}
