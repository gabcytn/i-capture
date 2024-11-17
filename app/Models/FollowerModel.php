<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowerModel extends Model
{
    protected $table = "followers";
    protected $allowedFields = ["following_id", "follower_id"];
    protected bool $updateOnlyChanged = true;

    public function getFollowerCount (int $id): int
    {
        $resultSet = $this->db->query("SELECT * FROM followers WHERE following_id = ?", [$id]);
        return $resultSet->getNumRows();
    }

    public function getFollowingCount (int $id): int
    {
        $resultSet = $this->db->query("SELECT * FROM followers WHERE follower_id = ?", [$id]);
        return $resultSet->getNumRows();
    }
}