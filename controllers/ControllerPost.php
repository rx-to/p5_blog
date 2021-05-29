<?php
require_once 'models/PostManager.php';
class ControllerPost extends Controller
{

    /**
     * Returns postlist.
     * @return array
     */
    protected function getPostList()
    {
        $postManager = new PostManager();
        $page        = $postManager->selectPage('public', 'articles');
        $postlist    = $postManager->getAll();
        $pageNo      = $_GET['page_no'];

        if ($postlist && $pageNo > 0 && $pageNo <= $postlist['number_of_pages']) {
            foreach ($postlist as $key => $row) {
                if (is_int($key))
                    $postlist[$key]['slug'] = Util::slugify($row['title'] . '-' . $row['id']);
            }

            $data = [
                'postlist' => $postlist,
                'page'     => [
                    'meta_title'       => str_replace('{% page_no %}', $pageNo, $page[0]['meta_title']),
                    // 'meta_description' => $page[0]['meta_description'],
                    // 'meta_keywords'    => $page[0]['meta_keywords'],
                    'title'            => $page[0]['title'],
                    'subtitle'         => $page[0]['subtitle'],
                    'header'           => $page[0]['header'],
                    'page_no'          => $pageNo
                ]
            ];
        } else {
            $data = false;
        }

        return $data;
    }

    /**
     * Returns a post.
     * @param int $id
     * @return array
     */
    private function getPost($id)
    {
        $postManager = new PostManager();

        $page = $postManager->selectPage('public', 'article');
        $post = $postManager->get($id);

        if ($post) {
            $data = [
                'post' => $post,
                'page' => [
                    'meta_title'       => str_replace('{% title %}', $post['title'], $page[0]['meta_title']),
                    'meta_description' => $page[0]['meta_description'],
                    'meta_keywords'    => $page[0]['meta_keywords'],
                    'title'            => $post['title'],
                    'subtitle'         => $post['introduction'],
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
        $data  = $id ? $this->getPost($id) : $this->getPostList();
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
