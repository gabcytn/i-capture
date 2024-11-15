<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    protected $allowedFields = ["username", "password", "profile_pic", "bio"];
    protected bool $updateOnlyChanged = true;

    public function findByUsername(string $username): array
    {
        $db = db_connect();
        $data = $db->query("SELECT * FROM users WHERE username = ?", [$username]);
        return $data->getResult();
    }
}