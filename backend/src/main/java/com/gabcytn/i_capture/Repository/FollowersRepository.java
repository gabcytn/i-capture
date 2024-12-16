package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.User;
import org.springframework.jdbc.core.JdbcTemplate;
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
