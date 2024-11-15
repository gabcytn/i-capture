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
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        $validatedData = $this->validateUserRegisterInput();
        if (sizeof($validatedData) == 0) { return $this->response->setStatusCode(400)->setJSON(["message" => "Invalid fields"]); }

        $password = $this->hashPassword($validatedData["password"]);

        $model = model("UserModel");
        try {
            $model->save([
                "username" => $validatedData["username"],
                "password" => $password
            ]);
            return redirect()->to(base_url("/login"));
        } catch (\ReflectionException $exception) {
            return Services::response()->setStatusCode(400)->setJSON(["message" => $exception->getMessage()]);
        }
    }

    public function checkUser (): RedirectResponse
    {
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");

        $model = model(UserModel::class);
        $data = $model->findByUsername($username);
        $user = $data[0];

        if ($this->verifyPassword($password, $user->password)) {
            $session = session();
            $session->start();
            $session->set([
                "id" => $user->id,
                "username" => $user->username
            ]);

            return redirect()->to(base_url("/"));
        }

        return redirect()->to(base_url("/login"));
    }

    public function logoutUser (): RedirectResponse
    {
        $session = session();
        $session->destroy();
        $session->close();

        return redirect()->to(base_url("/login"));
    }
    private function verifyPassword (string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }
    private function validateUserRegisterInput (): array
    {
        if (!$this->validate([
            "username" => "required|is_unique[users.username]|max_length[100]",
            "password" => "required|min_length[8]"
        ])) {
            return [];
        }

        return $this->validator->getValidated();
    }

    private function hashPassword (string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

}