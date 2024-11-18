<?php

namespace App\Models;

use CodeIgniter\Model;

class LikesModel extends Model
{
    protected $table = "likes";
    protected $allowedFields = ["post_id", "liker_id"];

    public function isLikedByThisUser (int $postId, string $user): bool
    {
        $resultSet = $this->db->query("SELECT * FROM likes WHERE post_id = ? AND liker_id = ?", [$postId, $user]);
        return $resultSet->getNumRows() == 1;
    }

    public function unlike (int $postId, string $user)
    {
        $this->db->query("DELETE FROM likes WHERE post_id = ? AND liker_id = ?", [$postId, $user]);

        $postModel = model(PostModel::class);
        $postModel->decreaseLikes($postId);
    }

    public function like (int $postId, string $user)
    {
        $this->save([
            "post_id" => $postId,
            "liker_id" => $user
        ]);

        $postModel = model(PostModel::class);
        $postModel->increaseLikes($postId);
    }

    public function deleteAllWherePostId ($postId) {
        $this->db->query("DELETE FROM likes WHERE post_id = ?", [$postId]);
    }

}