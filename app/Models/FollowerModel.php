<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowerModel extends Model
{
    protected $table = "followers";
    protected $allowedFields = ["following_id", "follower_id"];
    protected bool $updateOnlyChanged = true;

    public function getFollowerCount (string $username): int
    {
        $resultSet = $this->db->query("SELECT * FROM followers WHERE following_id = ?", [$username]);
        return $resultSet->getNumRows();
    }

    public function getFollowingCount (string $username): int
    {
        $resultSet = $this->db->query("SELECT * FROM followers WHERE follower_id = ?", [$username]);
        return $resultSet->getNumRows();
    }

    public function isFollowing ($followingId, $followerId): bool
    {
        $resultSet = $this->db->query("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?", [$followerId, $followingId]);
        return $resultSet->getNumRows() == 1;
    }

    public function removeFollower ($followingId, $followerId): void
    {
        $this->db->query("DELETE FROM followers WHERE follower_id = ? AND following_id = ?", [$followerId, $followingId]);
    }
}