<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = "posts";
    protected $primaryKey = "id";
    protected $allowedFields = ["post_owner", "likes", "photo_url", "photo_public_id"];
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

    public function decreaseLikes ($postId): void
    {
        $this->db->query("UPDATE posts SET likes = likes - 1 WHERE id = ?", [$postId]);
    }

    public function increaseLikes ($postId): void
    {
        $this->db->query("UPDATE posts SET likes = likes + 1 WHERE id = ?", [$postId]);
    }

    public function findAllWherePostOwnerNotEqualTo (string $username): array
    {
        $resultSet = $this->db->query("SELECT * FROM posts WHERE post_owner != ? ORDER BY RAND() LIMIT 10", [$username]);
        return $resultSet->getResult();
    }
}