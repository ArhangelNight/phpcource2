<?php


namespace App\controllers;



use App\models\Post;
use App\models\User;
use Delight\Auth\Auth;
use JasonGrimes\Paginator;
use League\Plates\Engine;

class UserController
{
    public $post;
    public $auth;
    public $templates;
    public $user;

    public function __construct(Post $post, Auth $auth, User $user)
    {
        $this->auth = $auth;
        $this->post = $post;
        $this->user = $user;
        $this->templates =  new Engine('../app/views');
    }

    public function userPosts()
    {
        $userId = $this->auth->getUserId();
        $per_page = 3;
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $urlPattern = '?page=(:num)';
        $totalPosts = count($this->post->userPosts($userId));

        $userPosts = $this->post->userPostsPerPage($userId, $per_page, $page);
        $paginator = new Paginator($totalPosts, $per_page, $page, $urlPattern);

        echo $this->templates->render('user/user-posts', ['posts' => $userPosts, 'paginator' => $paginator]);
    }

    public function userProfile()
    {
        $userId = $this->auth->getUserId();
        $userProfile = $this->user->getUser($userId);
        echo $this->templates->render('user/profile', ['user' => $userProfile]);
    }

    public function updateUserProfile($id)
    {
        if ($this->auth->getUserId() == $id || $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            $this->user->updateUser($_POST, $id);
        }
    }

    public function editPassword($id)
    {
        if ($this->auth->getUserId() == $id || $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            echo $this->templates->render('user/editpass', ['user_id' => $id]);
        } else {
            header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;}
    }

    public function updatePassword($id)
    {
        if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
            try {
                $this->auth->admin()->changePasswordForUserById($id, $_POST['new_password']);
                flash()->success('Пароль успешно изменен');
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
            catch (\Delight\Auth\UnknownIdException $e) {
                flash()->error('Unknown ID');
                header('Location: /login');
                die;
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                flash()->error('Invalid password');
                header('Location: /login');
                die;
            }

        } else {
            try {
                $this->auth->changePassword($_POST['old_password'], $_POST['new_password']);

                flash()->success('Пароль успешно изменен');
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
            catch (\Delight\Auth\NotLoggedInException $e) {
                flash()->error('Not logged in');
                header('Location: /login');
                die;
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                flash()->error('Invalid password(s)');
                header('Location: /login');
                die;
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                flash()->error('Too many requests');
                header('Location: /login');
                die;
            }

        }
    }

    public function editAvatar($id)
    {
        $this->user->updateAvatar($_POST['oldAvatar'], $_FILES['avatar'], $id);
    }
}