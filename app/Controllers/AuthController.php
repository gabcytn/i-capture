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

    public function checkUser (): RedirectResponse | string
    {
        $data = $this->request->getPost(["username", "password"]);

        $validatedData = $this->validateUserLoginInput($data);

        if (sizeof($validatedData) == 0) { return view ("auth-views/login"); }

        $model = model(UserModel::class);
        $data = $model->findByUsername($data["username"]);
        $user = $data[0];

        if ($this->verifyPassword($validatedData["password"], $user->password)) {
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
    private function validateUserRegisterInput (array $data): array
    {
        $rules = [
            "username" => "required|is_unique[users.username]|max_length[100]",
            "password" => "required|min_length[8]"
        ];

        if (!$this->validateData($data, $rules)) {
            return [];
        }

        return $this->validator->getValidated();
    }

    private function validateUserLoginInput (array $data): array
    {
        if (!$this->validateData($data, [
            "username" => "required|max_length[100]",
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