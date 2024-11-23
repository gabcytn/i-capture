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

    public function getFollowersList ($username): array
    {
        $resultSet = $this->db->query("
                    SELECT users.id, users.profile_pic
                    FROM users
                    INNER JOIN followers
                    ON users.id = followers.follower_id
                    WHERE followers.following_id = ?", $username);
        return $resultSet->getResult();
    }

    public function getFollowingList ($username): array
    {
        $resultSet = $this->db->query("
                    SELECT users.id, users.profile_pic
                    FROM users
                    INNER JOIN followers
                    ON users.id = followers.following_id
                    WHERE followers.follower_id = ?", $username);

        return $resultSet->getResult();
    }
}