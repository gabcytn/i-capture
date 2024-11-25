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

    public function findAllNotLikedBy(string $username, array $array = []): array
    {
        $postIdPlaceholder = $this->createStringArrayFromIntArray($array);
        $sql =
            "SELECT posts.id AS post_id, posts.post_owner, posts.likes, posts.photo_url, users.profile_pic
            FROM posts 
            INNER JOIN users 
            ON posts.post_owner = users.id
            LEFT JOIN likes
            ON likes.post_id = posts.id AND likes.liker_id = ?
            WHERE likes.post_id IS NULL
            AND posts.post_owner != ?
            AND posts.id NOT IN ($postIdPlaceholder)
            ORDER BY RAND()
            LIMIT 10";

        $resultSet = $this->db->query($sql, [$username, $username]);
        return $resultSet->getResult();
    }

    private function createStringArrayFromIntArray (array $nums): string
    {
        if (sizeof($nums) == 0) return "0";

        $str = "";
        for ($i = 0; $i < sizeof($nums); $i++) {
            if ($i == sizeof($nums) - 1) {
                $str .= $nums[$i];
                return $str;
            }

            $str .= $nums[$i] . ", ";
        }

        return "0";
    }
}
