<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $allowedFields = ["post_owner", "likes", "photo_url"];
    protected bool $updateOnlyChanged = true;

    public function findAllByPostOwnerUsername (string $username): array
    {
        $data = $this->db->query("SELECT * FROM posts WHERE post_owner = ?", [$username]);

        return $data->getResult();
    }

    public function getPostCount (string $username): int
    {
        $resultSet = $this->db->query("SELECT * FROM posts WHERE post_owner = ?", [$username]);
        return $resultSet->getNumRows();
    }

}