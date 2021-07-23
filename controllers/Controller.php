<?php

require_once 'models/Model.php';
require_once 'controllers/ControllerUser.php';

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

    /**
     * Generates HTML of view.
     * @param  string $visibility
     * @param  string $slug
     * @return string
     */
    public function displayView($visibility, $slug, $id = null)
    {
        if (isset($_SESSION['user_id'])) {
            $controllerUser = new ControllerUser();
            $curUser        = $controllerUser->getUser('id', $_SESSION['user_id']);
        }
        
        $file           = $this->getView($visibility, $slug, $id);
        $data           = $this->getPageData($visibility, $slug, $id);
        if (!$data) throw new Exception('Pas de données pour cette URL', 404);

        ob_start();
        require_once $file;
        $content = ob_get_clean();

        require_once "views/$visibility/Template.php";
    }
}
