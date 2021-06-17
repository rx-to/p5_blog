<?php
require_once 'models/PostManager.php';
class ControllerHome extends Controller
{
    /**
     * Returns postlist.
     * @param int $limit
     * @return array
     */
    protected function getPostList($limit = null)
    {
        $postManager = new PostManager();
        $page        = $postManager->selectPage('public', 'accueil');

        if ($postlist = $postManager->getAll($limit)) {
            foreach ($postlist as $key => $row) {
                if (is_int($key))
                    $postlist[$key]['slug'] = Util::slugify($row['title'] . '-' . $row['id']);
            }

            $data = [
                'postlist' => $postlist,
                'page'     => [
                    'meta_title'       => $page[0]['meta_title'],
                    // 'meta_description' => $page[0]['meta_description'],
                    // 'meta_keywords'    => $page[0]['meta_keywords'],
                    'title'            => $page[0]['title'],
                    'subtitle'         => $page[0]['subtitle'],
                    'header'           => $page[0]['header'],
                ]
            ];
        } else {
            $data = false;
        }

        return $data;
    }

    /**
     * Returns current page data.
     * @param  string $visibility
     * @param  string $slug
     * @param  int    $id
     * @return array
     */
    protected function getPageData($visibility, $slug, $id = null)
    {
        return $this->getPostList(3);
    }

    /**
     * Generates HTML of view.
     * @param  string $visibility
     * @param  string $slug
     * @return string
     */
    public function displayView($visibility, $slug, $id = null)
    {
        $file = $this->getView($visibility, $slug, $id);
        $data = $this->getPageData($visibility, $slug, $id);
        if (!$data) throw new Exception('Pas de données pour cette URL', 404);

        ob_start();
        require_once $file;
        $content = ob_get_clean();

        require_once 'views/public/Template.php';
    }
}
