<?php
require_once 'models/PostManager.php';
class ControllerPost extends Controller
{
    /**
     * Returns all posts.
     * @return array
     */
    private function postList()
    {
        $postManager = new PostManager();
        return $postManager->getAll();
    }

    /**
     * Returns a post.
     * @param int $id
     * @return array
     */
    private function getPost($id)
    {
        $postManager = new PostManager();
        return $postManager->get($id);
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
        $model = new Model();
        if ($id) {
            $data['post'] = $this->getPost($id);
        } else {
            $data['postlist']         = $this->postList();
            $data['postlist']['page'] = $_GET['page'];
            if(!isset($_GET['page'])) header('Location: /articles/1/');
        }

        if ($id && $data['post'] || $data['postlist']['page'] > 0 && $data['postlist']['number_of_pages'] >= $data['postlist']['page']) {
            $meta = $model->selectPage('public', 'articles');
            if (!$meta) $meta = $model->selectPage('public', '404');

            $data['meta']['title']       = $meta[0]['meta_title'];
            $data['meta']['description'] = $meta[0]['meta_description'];
            $data['meta']['keywords']    = $meta[0]['meta_keywords'];
            $data['page']['title']       = $meta[0]['title'];
            $data['page']['subtitle']    = $meta[0]['subtitle'];

            foreach ($data['postlist'] as $key => $row) {
                if (is_int($key))
                    $data['postlist'][$key]['slug'] = Util::slugify($row['title'] . '-' . $row['id']);
            }
        } else {
            $data = false;
        }

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
        $file = $this->getView($visibility, $slug, $id);
        $data = $this->getPageData($visibility, $slug, $id);
        if (!$data) throw new Exception('Pas de données pour cette URL', 404);

        ob_start();
        require_once $file;
        $content = ob_get_clean();

        require_once 'views/public/Template.php';
    }
}
