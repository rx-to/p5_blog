<?php
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
        require_once 'views/Template.php';
    }
}
