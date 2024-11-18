<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

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

    public function createUser () : ResponseInterface | string
    {
        $data = $this->request->getPost(["username", "password"]);

        $validatedData = $this->validateUserRegisterInput($data);

        if (sizeof($validatedData) == 0) {
            return view("auth-views/register");
        }

        $password = $this->hashPassword($validatedData["password"]);

        $model = model(UserModel::class);
        try {
            $model->save([
                "id" => $validatedData["username"],
                "password" => $password
            ]);
            return redirect()->to(base_url("/login"));
        } catch (\ReflectionException $exception) {
            echo "error";
            return redirect()->to(base_url("/register"), 500, "refresh");
        }
    }

    public function checkUser (): RedirectResponse | string
    {
        $requestBody = $this->request->getPost(["username", "password"]);

        $validatedData = $this->validateUserLoginInput($requestBody);

        if (sizeof($validatedData) == 0) {
            return view("auth-views/login");
        }

        $userModel = model(UserModel::class);
        $user = $userModel->find($validatedData["username"]);

        if (!$user) { return redirect()->to("/login", 404, "refresh"); }

        if ($this->verifyPassword($validatedData["password"], $user["password"])) {
            $session = session();
            $session->start();
            $session->set([
                "username" => $user["id"],
                "profile" => $user["profile_pic"]
            ]);

            return redirect()->to(base_url("/"));
        }

        return redirect()->to(base_url("/login"), 401, "refresh");
    }

    public function logoutUser (): RedirectResponse
    {
        $session = session();
        $session->destroy();
        $session->close();

        return redirect()->to(base_url("/login"));
    }



    // PRIVATE METHODS
    private function verifyPassword (string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
    private function validateUserRegisterInput (array $data): array
    {
        $rules = [
            "username" => "required|is_unique[users.id]|max_length[100]",
            "password" => "required|min_length[8]"
        ];

        if (!$this->validateData($data, $rules)) {
            return [];
        }

        return $this->validator->getValidated();
    }

    private function validateUserLoginInput (array $data): array
    {
        $rules = [
            "username" => "required|max_length[100]",
            "password" => "required|min_length[8]"
        ];

        if (!$this->validateData($data, $rules)) {
            return [];
        }

        return $this->validator->getValidated();
    }

    private function hashPassword (string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

}