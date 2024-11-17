<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view("home");
    }

    public function profile(): string
    {
        return view("user-views/your-profile.php");
    }
}
