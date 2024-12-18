package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.User;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.UUID;

@Repository
public class FollowersRepository {
    private final JdbcTemplate jdbcTemplate;

    public FollowersRepository(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public List<User> findFollowersById (UUID uuid) {
        String sql = "SELECT id, username, profile_pic " +
                "FROM followers " +
                "JOIN users " +
                "ON users.id = followers.follower_id " +
                "WHERE following_id = ?";
        return jdbcTemplate.query(sql, rowMapper(), uuid.toString());
    }

    public List<User> findFollowingsById (UUID uuid) {
        String sql = "SELECT id, username, profile_pic " +
                "FROM followers " +
                "JOIN users " +
                "ON users.id = followers.following_id " +
                "WHERE follower_id = ?";
        return jdbcTemplate.query(sql, rowMapper(), uuid.toString());
    }

    public int findFollowerCountOf (UUID uuid) {
        String sql = "SELECT COUNT(*) AS count FROM followers " +
                "WHERE following_id = ?";

        return resultSetExtractor(uuid, sql);
    }

    private int resultSetExtractor(UUID uuid, String sql) {
        ResultSetExtractor<Integer> extractor = rs -> {
            if (rs.next()) {
                return rs.getInt("count");
            }

            return 0;
        };

        Object followerCount = jdbcTemplate.query(sql, extractor, uuid.toString());
        if (followerCount != null) {
            return (int) followerCount;
        }

        return 0;
    }


    public int findFollowingCountOf (UUID uuid) {
        String sql = "SELECT COUNT(*) AS count FROM followers " +
                "WHERE follower_id = ?";

        return resultSetExtractor(uuid, sql);
    }

    public boolean isFollowedBy (String followingId, String followerId) {
        String sql = "SELECT COUNT(*) AS count FROM followers WHERE following_id = ? AND follower_id = ?";

        ResultSetExtractor<Integer> extractor = rs -> {
            if (rs.next()) {
                return rs.getInt("count");
            }
            return 0;
        };

        Object object = jdbcTemplate.query(sql, extractor, followingId, followerId);
        if (object == null)
            throw new Error("Error getting is followed by");
        else if ((int) object == 1) {
            return true;
        }
        else if ((int) object == 0) {
            return false;
        }
        else {
            throw new Error("Error value generated is isFollowedBy");
        }
    }

    private RowMapper<User> rowMapper () {
        return (rs, rowNum) -> {
            User user = new User();
            user.setId(UUID.fromString(rs.getString("id")));
            user.setUsername(rs.getString("username"));
            user.setProfilePic(rs.getString("profile_pic"));
            return user;
        };
    }
}
