<?php

namespace Blog\Controllers;

require_once 'models/Model.php';
require_once 'controllers/ControllerUser.php';

use \Blog\Models\Model;
use \Exception;

class Controller
{
    private $_visibility;
    private $_slug;

    public function __construct($visibility, $slug)
    {
        $this->setSlug($slug);
        $this->setVisibility($visibility);
    }

    /**
     * Sets value of `$_visibility`.
     * @param string $visibility
     */
    private function setVisibility($visibility)
    {
        $this->_visibility = $visibility;
    }

    /**
     * Gets value of `$_visibility`.
     * @return string
     */
    protected function getVisibility()
    {
        return $this->_visibility;
    }

    /**
     * Sets value of `$_slug`.
     * @param string $slug
     */
    private function setSlug($slug)
    {
        $this->_slug = $slug;
    }

    /**
     * Gets value of `$_slug`.
     * @return string
     */
    protected function getSlug()
    {
        return $this->_slug;
    }

    /**
     * Returns view file from slug.
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
     * @param string $visibility
     * @param string $slug
     * @param int    $id
     * @return array
     */
    protected function getPageData($visibility, $slug, $id = null)
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
    public function requireController()
    {
        $model          = new Model();
        $visibility     = $this->getVisibility();
        $slug           = $this->getSlug();
        $data           = $model->selectPage($visibility, $slug);
        $controller     = null;
        $controllerName = isset($data[0]['controller']) && $data[0]['controller'] ? $data[0]['controller'] : null;
        if ($controllerName) {
            require_once("controllers/$controllerName.php");
            $controllerName = '\\Blog\Controllers\\' . $controllerName;
            $controller = new $controllerName($visibility, $slug);
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

        $file = $this->getView($visibility, $slug);
        $data = $this->getPageData($visibility, $slug, $id);
        if (!$data) throw new Exception('Pas de données pour cette URL', 404);

        ob_start();
        require_once $file;
        $content = ob_get_clean();

        require_once "views/$visibility/Template.php";
    }
}
