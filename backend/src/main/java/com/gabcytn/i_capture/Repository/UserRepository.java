package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.User;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public class UserRepository {
    private final JdbcTemplate jdbcTemplate;

    public UserRepository(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public User findByUsername (String username) {
        String sqlQuery = "SELECT * FROM users WHERE username = ?";
        return jdbcTemplate.query(sqlQuery, getResultSetExtractor(), username);
    }

    public User findById (int id) {
        String sqlQuery = "SELECT * FROM users WHERE id = ?";
        return jdbcTemplate.query(sqlQuery, getResultSetExtractor(), id);
    }


    private ResultSetExtractor<User> getResultSetExtractor() {
        return (resultSet) -> {
            if (resultSet.next()) {
                User user = new User();
                user.setId(resultSet.getInt("id"));
                user.setUsername(resultSet.getString("username"));
                user.setPassword(resultSet.getString("password"));
                user.setProfilePic(resultSet.getString("profile_pic"));

                return user;
            }
            return new User();
        };
    }
}
