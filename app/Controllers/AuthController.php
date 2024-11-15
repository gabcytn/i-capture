<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    public function login (): string
    {
        return view("auth-views/login");
    }

    public function register(): string
    {
        return view("auth-views/register");
    }
}