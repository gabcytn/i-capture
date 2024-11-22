<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = "users";
    protected $primaryKey = "id";
    protected $useAutoIncrement = false;
    protected $allowedFields = ["id", "password", "profile_pic"];

    public function search ($username): array
    {
        $result = $this->db->query("SELECT * FROM users WHERE LOWER(id) LIKE LOWER('$username%')");
        return $result->getResult();
    }
}