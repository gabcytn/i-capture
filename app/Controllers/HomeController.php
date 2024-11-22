<?php

namespace App\Controllers;

use App\Models\UserModel;

class HomeController extends BaseController
{
    public function index (): string
    {
        return view("home");
    }

    public function search (): string
    {
        $searchUsername = $this->request->getGet("username");

        if ($searchUsername == "") {
            $params["users"] = [];
            return view("user-views/search", $params);
        }

        $userModel = model(UserModel::class);

        $users = $userModel->search($searchUsername);
        $params["users"] = $users;


        return view("user-views/search", $params);
    }
}