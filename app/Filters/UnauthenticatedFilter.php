<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class UnauthenticatedFilter implements FilterInterface
{
    public function before (RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->has("id")) {
            return Services::response()->setStatusCode(401)->setJSON(["message" => "Unauthorized"]);
        }
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}