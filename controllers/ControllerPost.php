<?php

require_once 'models/PostManager.php';

class ControllerPost extends Controller
{
    function __construct()
    {
        if (!empty($_POST)) {
            switch ($_POST['action']) {
                    // Public
                case 'postComment':
                    $json['alert'] = !$_POST['comment_id'] ? $this->postComment($_POST) : $this->editComment($_POST);
                    break;

                case 'deleteComment':
                    $json['alert']    = $this->deleteComment($_POST['comment_id']);
                    $json['comments'] = $this->generateCommentList($_POST['post_id']);
                    break;

                case 'reportComment';
                    $json['alert'] = $this->reportComment($_POST['comment_id'], $_POST['report']);
                    break;

                    // Admin
                case 'createPost':
                    $json['alert'] = $this->createPost($_POST);
                    break;

                case 'editPost':
                    $json['alert'] = $this->editPost($_POST);
                    break;

                case 'deletePost':
                    $json['alert']    = $this->deletePost($_POST['post_id']);
                    $json['postlist'] = $this->generatePostList(20);
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
        $pageNo      = $_GET['page_no'] ?? 1;

        if ($postlist && $pageNo > 0 && $pageNo <= $postlist['number_of_pages']) {
            foreach ($postlist as $key => $row) {
                if (is_int($key))
                    $postlist[$key]['slug'] = Util::slugify($row['title'] . '-' . $row['id']);
            }
        }

        $data = $postlist ? $postlist : false;
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
        $post        = $postManager->get($id);
        $data        = $post ? $post : false;
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
        $postManager = new PostManager();
        $page        = $postManager->selectPage($visibility, $slug);
        $pageNo      = $_GET['page_no'] ?? 1;
        $limit       = $visibility == 'public' ? 5 : 20;

        if ($id) {
            $data['post'] = $this->getPost($id);
            $data['page'] = [
                'meta_title'       => str_replace('{% title %}', $data['post']['title'], $page[0]['meta_title']),
                'meta_description' => $page[0]['meta_description'],
                'meta_keywords'    => $page[0]['meta_keywords'],
                'title'            => $data['post']['title'],
                'subtitle'         => $data['post']['introduction'],
                'header'           => $page[0]['header']
            ];
        } else {
            $data['postlist'] = $this->getPostList($limit);
            $data['page'] = [
                'meta_title'       => str_replace('{% page_no %}', $pageNo, $page[0]['meta_title']),
                'meta_description' => str_replace('{% page_no %}', $pageNo, $page[0]['meta_description']),
                'meta_keywords'    => $page[0]['meta_keywords'],
                'title'            => $page[0]['title'],
                'subtitle'         => $page[0]['subtitle'],
                'header'           => $page[0]['header'],
                'page_no'          => $pageNo
            ];
        }
        return $data;
    }

    /**
     * Posts comment.
     * @param  array $data
     * @return string
     */
    private function postComment($data)
    {
        $controllerUser = new ControllerUser();
        $curUser        = $controllerUser->getUser('id', $_SESSION['user_id']);
        $errors         = [];
        if (strlen(strip_tags($data['comment'])) <= 3000) {
            $postManager = new PostManager();
            if (!$postManager->insertComment($data, $curUser['id'])) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
            return Util::generateAlert($errors, "Votre commentaire a été envoyé. Il s'affichera après avoir été approuvé par un administrateur.");
        }
    }

    /**
     * Edits comment.
     * @param  array $data
     * @return string
     */
    private function editComment($data)
    {
        //TODO: Sécuriser édition commentaires
        $errors = [];
        if (strlen(strip_tags($data['comment'])) <= 3000) {
            $postManager = new PostManager();
            if (!$postManager->updateComment($data)) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
            return Util::generateAlert($errors, "Votre commentaire a bien été mis à jour. Vos modifications s'afficheront après avoir été approuvées par un administrateur.");
        }
    }

    /**
     * Deletes comment.
     * @param  int    $id
     * @return string
     */
    private function deleteComment($id)
    {
        $errors         = [];
        $controllerUser = new ControllerUser();
        $curUser        = $controllerUser->getUser('id', $_SESSION['user_id']);
        $postManager    = new PostManager();
        $comment        = $this->getComment($id);
        if (!$postManager->deleteComment($id) || !$controllerUser->isAdmin($curUser['id']) && $curUser['id'] != $comment['author_id']) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
        return Util::generateAlert($errors, "Le commentaire a bien été supprimé.");
    }

    /**
     * Deletes post.
     * @param  int    $id
     * @return string
     */
    private function deletePost($id)
    {
        $errors         = [];
        $postManager    = new PostManager();
        if (!$postManager->deletePost($id)) $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter le webmaster si le problème persiste.';
        return Util::generateAlert($errors, "L'article a bien été supprimé.");
    }

    /**
     * Reports comment.
     * @param  int    $id
     * @return string
     */
    private function reportComment($id, $report)
    {
        $errors = [];
        $postManager = new PostManager();
        if (strlen($report) < 5) $report = 1;
        if (!$postManager->reportComment($id, $report))
            $errors[] = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';
        return Util::generateAlert($errors, "Votre signalement a bien été pris en compte. Nous l'étudierons dans les plus brefs délais afin de déterminer s'il enfreint nos conditions générales d'utilisation.");
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
     * Returns post comment.
     * @param  int   $id Comment ID.
     * @return array 
     */
    private function getComment($id)
    {
        $postManager = new PostManager();
        return $postManager->selectComment($id);
    }

    /**
     * Generates comment list.
     * @param  int   $id Post ID.
     * @return string      
     */
    public function generateCommentList($id)
    {
        $controllerUser = new ControllerUser();
        if (isset($_SESSION['user_id'])) {
            $curUser = $controllerUser->getUser('id', $_SESSION['user_id']);
        }
        $comments = $this->getComments($id);
        $html = '<h2>Commentaires (' . count($comments) . ')</h2>';

        if (!isset($curUser['id'])) {
            $html .= '<div class="alert alert-warning">';
            $html .= '<p class="mb-0">Vous devez être connecté(e) afin de commenter cet article.</p>';
            $html .= '</div>';
        }

        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                $html .= '<div id="comment-' . $comment['id'] . '" class="comment" data-id="' . $comment['id'] . '">';
                $html .=     '<div class="actions">';
                $html .=         '<i class="fas fa-ellipsis-v comment__nav-trigger"></i>';
                $html .=         '<div class="actions__wrapper">';
                $html .=             '<nav class="actions__list">';
                $html .=                 '<ul>';
                if (isset($curUser['id']) && ($controllerUser->isAdmin($curUser['id']) || $curUser['id'] == $comment['author_id'])) {
                    if ($curUser['id'] == $comment['author_id']) {
                        $html .=                 '<li><a href="#edit-comment">Modifier</a></li>';
                    }
                    $html .=                     '<li><a href="#delete-comment" data-toggle="modal" data-target="#staticBackdrop">Supprimer</a></li>';
                } else {
                    $html .=                     '<li><a href="#report-comment" data-toggle="modal" data-target="#staticBackdrop">Signaler</a></li>';
                }
                $html .=                 '</ul>';
                $html .=             '</nav>';
                $html .=         '</div>';
                $html .=     '</div>';
                $html .=     '<a href="/utilisateur/' . $comment['user_slug'] . '/">';
                $html .=         '<img src="/upload/avatar/' . $comment['author_avatar'] . '" alt="Avatar de prenom nom" class="comment__author-avatar">';
                $html .=     '</a>';
                $html .=     '<header>';
                $html .=         '<h3 class="comment__author-name"><a href="/utilisateur/' . $comment['user_slug'] . '/">' . $comment['author_first_name'] . ' ' . $comment['author_last_name'] . '</a></h3>';
                $html .=         '<div class="comment__date">' . $comment['creation_date_fr'] . '</div>';
                $html .=     '</header>';
                $html .=     '<div id="comment__content-' . $comment['id'] . '" class="comment__content">' . nl2br($comment['content']) . '</div>';
                $html .=     $comment['update_date_fr'] ? '<div class="comment__date mt-3 text-right"><em>(Modifié le ' . $comment['update_date_fr'] . ')</em></div>' : '';
                $html .= '</div>';
            }
        } else {
            if (isset($curUser['id'])) {
                $html .= '<p>Soyez la première personne à commenter cet article ! 😜</p>';
            }
        }
        return $html;
    }

    /**
     * Generates post list.
     * @param int     $limit
     * @return string      
     */
    public function generatePostList($limit = null)
    {
        $postlist = $this->getPostList($limit);
        $html     = '';
        foreach ($postlist as $key => $post) {
            if (is_numeric($key)) {
                $html .= '<tr class="tr-shadow post" data-id="' . $post['id'] . '">';
                $html .=    '<td>' . $post['title'] . '</td>';
                $html .=    '<td>' . "{$post['author_first_name']} {$post['author_last_name']}" . '</td>';
                $html .=    '<td><span class="block-email">' . $post['creation_date_fr'] . '</span></td>';
                $html .=    '<td><span class="block-email">' . $post['update_date_fr'] . '</span></td>';
                $html .=    '<td>';
                $html .=        '<div class="table-data-feature">';
                $html .=            '<a href="/admin/editer-un-article/' . $post['id'] . '/" class="item" title="Éditer"><i class="zmdi zmdi-edit"></i></a>';
                $html .=            '<a href="#delete-post" class="item" data-toggle="modal" data-target="#staticBackdrop" title="Supprimer"><i class="zmdi zmdi-delete"></i></a>';
                $html .=        '</div>';
                $html .=    '</td>';
                $html .= '</tr>';
                $html .= '<tr class="spacer"></tr>';
            }
        }

        return $html;
    }

    /**
     * Creates or update a post.
     * @param array  $data
     * @param string $action
     * @return bool
     */
    private function processPost($data, $action)
    {
        $controllerUser = new ControllerUser();
        $postManager    = new PostManager();
        $curUser        = $controllerUser->getUser('id', $_SESSION['user_id']);
        $errors         = [];
        $defaultError   = 'Une erreur est survenue, veuillez réessayer ou contacter un administrateur si le problème persiste.';

        if (isset($data['uploadImage'])) {
            $data['image']  = ($data['id'] == 0 ? $postManager->getLastPostID() : $data['id']) . '-' . Util::slugify($data['title']);
            $uploadImage   = Util::uploadImage($_FILES['uploadImage'], 'post', $data['image']);
            if ($uploadImage !== true) {
                if (is_array($uploadImage)) {
                    foreach ($uploadImage as $error) {
                        $errors[] = $error;
                    }
                }
            }
        }

        if (!Util::checkStrLen($data['title'], 3, 255))        $errors[] = 'Veuillez saisir un titre entre 3 et 255 caractères.';
        if (!Util::checkStrLen($data['title'], 3, 1000))       $errors[] = 'Veuillez saisir un titre entre 3 et 1 000 caractères.';
        if (!Util::checkStrLen($data['title'], 3, 20000))      $errors[] = 'Veuillez saisir un contenu entre 3 et 20 000 caractères.';

        if (count($errors) == 0) {
            $alert = Util::generateAlert($errors, "L'article a bien été créé.");
            if ($action == 'create') {
                if (!$postManager->insertPost($data, $curUser['id'])) $errors[] = $defaultError;
            } else {
                $alert = Util::generateAlert($errors, "Les modifications ont bien été prises en compte.");
                if (!$postManager->updatePost($data, $curUser['id'])) $errors[] = $defaultError;
            }
        }
        return $alert . Util::redirect('/admin/liste-des-articles/', 3000);
    }

    /**
     * Creates a post.
     * @param array $data
     * @return bool
     */
    private function createPost($data)
    {
        return $this->processPost($data, 'create');
    }

    /**
     * Edits a post.
     * @param array $data
     * @return bool
     */
    private function editPost($data)
    {
        return $this->processPost($data, 'edit');
    }
}
