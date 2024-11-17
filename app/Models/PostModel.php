<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $allowedFields = ["post_owner", "likes", "photo_url"];
    protected bool $updateOnlyChanged = true;

    public function findAllByPostOwnerUsername ($username): array
    {
        $db = db_connect();
        $userModel = model(UserModel::class);
        $user = $userModel->findByUsername($username);

        $postOwner = $user[0]->id;
        $data = $db->query("SELECT * FROM posts WHERE post_owner = ?", [$postOwner]);

        return $data->getResult();
    }

    public function getPostCount (int $id): int
    {
        $resultSet = $this->db->query("SELECT * FROM posts WHERE post_owner = ?", [$id]);
        return $resultSet->getNumRows();
    }

}