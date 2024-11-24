<?php

namespace App\Controllers;

use App\Models\UserModel;

class HomeController extends BaseController
{
    public function index (): string
    {
        $tab = $this->request->getGet("tab");
        $params = [];

        $params["tab"] = $tab;
        return view("home", $params);
    }

    public function search (): string
    {
        $searchUsername = $this->request->getGet("username");
        $params = [];

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
