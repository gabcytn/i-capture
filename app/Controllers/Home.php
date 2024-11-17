<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view("home");
    }

    public function profile($username): string
    {
        $postModel = model(PostModel::class);
        $userModel = model(UserModel::class);

        if (sizeof($userModel->findByUsername($username)) == 0) {
            $errorMessage["message"] = "User Not Found!";
            return view("errors/html/error_404", $errorMessage);
        }

        $params["posts"] = $postModel->findAllByPostOwnerUsername($username);
        $params["username"] = $username;

        $currentUserUsername = session()->get("username");
        return $username == $currentUserUsername ? view("user-views/your-profile.php", $params) : view("user-views/other-profile", $params);
    }

    public function posts ($postID)
    {
        $postModel = model(PostModel::class);
        $params["post"] = $postModel->find($postID);

        return view("posts-views/your-posts", $params);
    }

    public function editProfile ()
    {
        $data = $this->request->getPost();
        $image = $this->request->getFile("profile-pic");

        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(WRITEPATH . "uploads", $newName);
        }
    }
}
