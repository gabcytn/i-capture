package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.User;
import org.springframework.dao.DuplicateKeyException;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.stereotype.Repository;

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

    public ResponseEntity<Void> save (String username, String password) {
        String sqlQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
        try {
            jdbcTemplate.update(sqlQuery, username, password);
        } catch (DuplicateKeyException e) {
            System.err.println("Duplicate key exception");
            return new ResponseEntity<>(HttpStatus.CONFLICT);
        } catch (Exception e) {
            System.err.println("Unknown error in registration");
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
        return new ResponseEntity<>(HttpStatus.CREATED);
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
