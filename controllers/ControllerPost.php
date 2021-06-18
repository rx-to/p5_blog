<?php
require_once 'models/PostManager.php';
class ControllerPost extends Controller
{
    function __construct()
    {
        if (!empty($_POST)) {
            switch ($_POST['action']) {
                case 'postComment':
                    $json['alert'] = $this->postComment($_POST);
                    break;

                case 'deleteComment':
                    $json['alert']    = $this->deleteComment($_POST['comment_id']);
                    $json['comments'] = $this->generateCommentList($_POST['post_id']);
                    break;

                case 'reportComment';
                    break;
            }
            echo json_encode($json);
        }
    }

    /**
     * Returns postlist.
     * @param  int   $limit
     * @return array
     */
    protected function getPostList($limit = null)
    {
        $postManager = new PostManager();
        $page        = $postManager->selectPage('public', 'articles');
        $postlist    = $postManager->getAll($limit);
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
     * @param  int   $id
     * @return array
     */
    public function getPost($id)
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
     * Post a comment.
     * @param  array $data
     * @return string
     */
    private function postComment($data)
    {
        $errors = [];
        if (strlen(strip_tags($data['comment'])) <= 3000) {
            $postManager = new PostManager();
            if (!$postManager->insertComment($data)) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
            return $this->generateAlert($errors, "Votre commentaire a été envoyé. Il s'affichera après avoir été approuvé par un administrateur.");
        }
    }

    /**
     * Returns current page data.
     * @param  int    $id
     * @return string
     */
    private function deleteComment($id)
    {
        // TODO: Checks if user is admin or is comment's author
        $errors = [];
        $postManager = new PostManager();
        if (!$postManager->deleteComment($id)) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
        return $this->generateAlert($errors, "Votre commentaire a été supprimé.");
    }

    /**
     * Returns post comments.
     * @param  int   $id Post ID.
     * @return array 
     */
    private function getComments($id)
    {
        $postManager = new PostManager();
        return $postManager->selectComments($id);
    }

    /**
     * Generates comment list.
     * @param  int   $id Post ID.
     * @return string      
     */
    public function generateCommentList($id)
    {
        $comments = $this->getComments($id);

        $html = '<h2>Commentaires (' . count($comments) . ')</h2>';
        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $html .= '<div id="comment-' . $comment['id'] . '" class="comment" data-id="' . $comment['id'] . '">';
                $html .=     '<div class="actions">';
                $html .=         '<i class="fas fa-ellipsis-v comment__nav-trigger"></i>';
                $html .=         '<div class="actions__wrapper">';
                // TODO: Manage user permissions. 
                $html .=             '<ul class="actions__list"0>';
                $html .=                 '<li><a href="#reply-to-comment"">Répondre</a></li>';
                $html .=                 '<li><a href="#edit-comment">Modifier</a></li>';
                $html .=                 '<li><a href="#delete-comment" data-toggle="modal" data-target="#staticBackdrop">Supprimer</a></li>';
                $html .=                 '<li><a href="#report-comment" data-toggle="modal" data-target="#staticBackdrop">Signaler</a></li>';
                $html .=             '</ul>';
                $html .=         '</div>';
                $html .=     '</div>';
                $html .=     '<a href="/utilisateur/' . $comment['user_slug'] . '/">';
                $html .=         '<img src="/upload/avatars/' . $comment['author_avatar'] . '" alt="Avatar de prenom nom" class="comment__author-avatar">';
                $html .=     '</a>';
                $html .=     '<header>';
                $html .=         '<h3 class="comment__author-name"><a href="/utilisateur/' . $comment['user_slug'] . '/">' . $comment['author_first_name'] . ' ' . $comment['author_last_name'] . '</a></h3>';
                $html .=         '<div class="comment__date">' . $comment['creation_date_fr'] . '</div>';
                $html .=     '</header>';
                $html .=     '<div id="comment__content-' . $comment['id'] . '" class="comment__content">' . nl2br($comment['content']) . '</div>';
                $html .= '</div>';
            }
        } else {
            $html .= '<p>Soyez la première personne à commenter cet article ! 😜</p>';
        }

        return $html;
    }
}
