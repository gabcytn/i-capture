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

        if (!$userModel->find($username)) {
            $errorMessage["message"] = "@" . $username . " Not Found!";
            return view("errors/html/error_404", $errorMessage);
        }

        $currentUserUsername = session()->get("username");

        $params["posts"] = $postModel->findAllByPostOwnerUsername($username);
        $params["username"] = $username;

        $userDetails = $userModel->find($username);

        $params["follower_count"] = $followerModel->getFollowerCount($username);
        $params["following_count"] = $followerModel->getFollowingCount($username);
        $params["post_count"] = $postModel->getPostCount($username);
        $params["profile_pic"] = $userDetails["profile_pic"];

        return $currentUserUsername == $username ? view("user-views/your-profile", $params) : view("user-views/other-profile", $params);
    }

    public function changePassword (): RedirectResponse | string
    {
        $requestBody = $this->request->getPost(["old-password", "new-password"]);

        $validatedData = $this->validateUpdatePasswordInput($requestBody);

        if (sizeof($validatedData) < 1) {
            return $this->profile(session()->get("username"));
        }

        $userModel = model(UserModel::class);
        $userModel->save([
            "id" => session()->get("username"),
            "password" => password_hash($validatedData["new-password"], PASSWORD_DEFAULT)
        ]);

        return redirect()->to(base_url("/" . session()->get("username")), 200, "refresh");
    }

    public function changePicture(): RedirectResponse
    {
        $image = $this->request->getFile("profile");

        if ($image && $image->isValid() && !$image->hasMoved() && $image->isFile()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . "images", $imageName);
            $userModel = model(UserModel::class);
            $userModel->save([
                "id" => session()->get("username"),
                "profile_pic" => "images/" . $imageName
            ]);
            session()->set(["profile" => "images/" . $imageName]);
        }
        return redirect()->to(base_url("/" . session("username")), 200, "refresh");
    }

    private function validateUpdatePasswordInput (array $data): array
    {
        $userModel = model(UserModel::class);
        $oldHashedPassword = $userModel->find(session()->get("username"))["password"];

        if (!password_verify($data["old-password"], $oldHashedPassword)){
            return [];
        }
        $rules = [
            "old-password" => [
                "rules" => "required|min_length[8]",
                "errors" => [
                    "required" => "Old password is missing"
                ],
            ],
            "new-password" => [
               "rules" => "required|min_length[8]",
                "errors" => [
                    "min_length" => "Minimum length of new password is 8 characters",
                    "required" => "New password is missing"
                ],
            ],
        ];

        if ($this->validateData($data, $rules)) {
            return $this->validator->getValidated();
        }

        return [];
    }
}
