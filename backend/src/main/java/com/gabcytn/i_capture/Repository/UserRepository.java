package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.User;
import org.springframework.dao.DuplicateKeyException;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Repository;

import java.util.List;
import java.util.UUID;

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

    public User findById (UUID id) {
        String sqlQuery = "SELECT * FROM users WHERE id = ?";
        return jdbcTemplate.query(sqlQuery, getResultSetExtractor(), id.toString());
    }

    public ResponseEntity<Void> save (UUID id, String username, String password) {
        String query = "INSERT INTO users (id, username, password) VALUES (?, ?, ?)";
        try {
            jdbcTemplate.update(query, id.toString(), username, password);
        } catch (DuplicateKeyException e) {
            System.err.println("Duplicate key exception");
            return new ResponseEntity<>(HttpStatus.CONFLICT);
        } catch (Exception e) {
            System.err.println("Unknown error in registration");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
        return new ResponseEntity<>(HttpStatus.CREATED);
    }

    public void changePassword (UUID id, String newPassword) {
        String query = "UPDATE users SET password = ? WHERE id = ?";
        try {
            jdbcTemplate.update(query, newPassword, id.toString());
        } catch (Exception e) {
            System.err.println("Error in changePassword() repo");
            System.err.println(e.getMessage());
        }
    }

    public void changeProfile (UUID id, String profileURL) {
        String query = "UPDATE users SET profile_pic = ? WHERE id = ?";
        jdbcTemplate.update(query, profileURL, id.toString());
    }

    public List<User> findByUsernameContainingIgnoreCase (String username) {
        String query = "SELECT id, profile_pic, username " +
                "FROM users " +
                "WHERE LOWER(username) " +
                "LIKE ?";
        RowMapper<User> rowMapper = (rs, rowNum) -> {
            User user = new User();
            user.setId(UUID.fromString(rs.getString("id")));
            user.setUsername(rs.getString("username"));
            user.setProfilePic(rs.getString("profile_pic"));
            return user;
        };

        return jdbcTemplate.query(query, rowMapper, username.toLowerCase() + "%");
    }

    private ResultSetExtractor<User> getResultSetExtractor() {
        return (resultSet) -> {
            if (resultSet.next()) {
                User user = new User();
                user.setId(UUID.fromString(resultSet.getString("id")));
                user.setUsername(resultSet.getString("username"));
                user.setPassword(resultSet.getString("password"));
                user.setProfilePic(resultSet.getString("profile_pic"));

                return user;
            }
            return null;
        };
    }
}
