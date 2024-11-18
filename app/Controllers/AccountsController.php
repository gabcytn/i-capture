<?php

namespace App\Controllers;

use App\Models\FollowerModel;
use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

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

    public function changePassword (): RedirectResponse | string | ResponseInterface
    {
        $requestBody = $this->request->getJSON(true);

        $validatedData = $this->validateUpdatePasswordInput($requestBody);

        if (!$validatedData[0]) {
            return $this->response->setJSON(["message" => $validatedData[1]]);
        }

        $userModel = model(UserModel::class);
        $userModel->save([
            "id" => session()->get("username"),
            "password" => password_hash($validatedData[1]["new-password"], PASSWORD_DEFAULT)
        ]);

        return $this->response->setJSON(["message" => "ok"]);
//        return redirect()->to(base_url("/" . session()->get("username")), 200, "refresh");
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

    private function validateUpdatePasswordInput (array $data): array | string
    {
        $userModel = model(UserModel::class);
        $oldHashedPassword = $userModel->find(session()->get("username"))["password"];

        if (!password_verify($data["old-password"], $oldHashedPassword)){
            return [false, "Old password is incorrect"];
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
            return [true, $this->validator->getValidated()];
        }

        return [false, $this->validator->getError("new-password")];
    }
}
