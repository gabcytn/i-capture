<?php

namespace App\Controllers;

use App\Models\FollowerModel;
use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class AccountsController extends BaseController
{
    public function index(): string
    {
        return view("home");
    }

    public function profile($username): string
    {
        $postModel = model(PostModel::class);
        $userModel = model(UserModel::class);
        $followerModel = model(FollowerModel::class);

        if (sizeof($userModel->findByUsername($username)) == 0) {
            $errorMessage["message"] = "User Not Found!";
            return view("errors/html/error_404", $errorMessage);
        }

        $currentUserId = session()->get("id");
        $currentUserUsername = session()->get("username");

        $params["posts"] = $postModel->findAllByPostOwnerUsername($username);
        $params["username"] = $username;

        if ($currentUserUsername == $username)
        {
            $params["follower_count"] = $followerModel->getFollowerCount($currentUserId);
            $params["following_count"] = $followerModel->getFollowingCount($currentUserId);
            $params["post_count"] = $postModel->getPostCount($currentUserId);

            return view("user-views/your-profile", $params);
        }
        else
        {
            $detailsOfTheUser = $userModel->findByUsername($username);
            $idOfTheUser = $detailsOfTheUser[0]->id;
            $params["follower_count"] = $followerModel->getFollowerCount($idOfTheUser);
            $params["following_count"] = $followerModel->getFollowingCount($idOfTheUser);
            $params["post_count"] = $postModel->getPostCount($idOfTheUser);
            $params["profile_pic"] = $detailsOfTheUser[0]->profile_pic;

            return view("user-views/other-profile", $params);
        }
    }


    private function validateUserUpdateInput (array $data): array
    {
        $currentUsername = session()->get("username");
        if (!$this->validateData($data, [
            "username" => "required|max_length[255]|is_unique[users.username, username, {$currentUsername}]"
        ])) {
            return [];
        }

        return $this->validator->getValidated();
    }

    public function changeUsername(): RedirectResponse
    {
        $newUsername = $this->request->getPost("username");
        $validatedUsername = $this->validateUserUpdateInput(["username" => $newUsername]);

        if (sizeof($validatedUsername) == 0) { return redirect()->to(base_url("/" . session()->get("username")), 401, "refresh"); }

        $userModel = model(UserModel::class);
        $userModel->save([
            "id" => session()->get("id"),
            "username" => $validatedUsername["username"]
        ]);

        session()->set(["username" => $validatedUsername["username"]]);
        return redirect()->to(base_url("/" . session()->get("username")));
    }

    public function changePicture(): RedirectResponse
    {
        $image = $this->request->getFile("profile");

        if ($image && $image->isValid() && !$image->hasMoved() && $image->isFile()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . "images", $imageName);
            $userModel = model(UserModel::class);
            $userModel->save([
                "id" => session()->get("id"),
                "profile_pic" => "images/" . $imageName
            ]);
            session()->set(["profile" => "images/" . $imageName]);
        }
        return redirect()->to(base_url("/" . session("username")), 200, "refresh");
    }
}
