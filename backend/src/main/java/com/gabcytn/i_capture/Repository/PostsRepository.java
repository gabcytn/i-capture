package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.Post;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.stereotype.Repository;

import java.sql.ResultSet;
import java.util.*;

@Repository
public class PostsRepository {
    private final JdbcTemplate jdbcTemplate;

    public PostsRepository(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public void save (Post post) {
        String sql = "INSERT INTO posts (post_owner, photo_url, photo_public_id) VALUES (?, ?, ?)";
        jdbcTemplate.update(sql, post.getPostOwner().toString(), post.getPhotoUrl(), post.getPhotoPublicId());
    }

    public List<Post> findAllByPostOwner (UUID id) {
        String sql = "SELECT * FROM posts WHERE post_owner = ?";
        RowMapper<Post> rowMapper = (ResultSet rs, int rowNum)  -> {
                Post post = new Post();
                post.setId(rs.getInt("id"));
                post.setPostOwner(UUID.fromString(rs.getString("post_owner")));
                post.setLikes(rs.getInt("likes"));
                post.setPhotoUrl(rs.getString("photo_url"));
                post.setPhotoPublicId(rs.getString("photo_public_id"));
                return post;
        };
        return jdbcTemplate.query(sql, rowMapper, id.toString());
    }

    public Map<String, Object> findById (Integer id) {
        final String sql = " SELECT posts.id AS post_id, " +
                "posts.likes, posts.photo_url, " +
                "posts.photo_public_id, users.id AS uuid, " +
                "users.username, users.profile_pic " +
                "FROM posts " +
                "JOIN users " +
                "ON users.id = posts.post_owner " +
                "WHERE posts.id = ?";

        ResultSetExtractor<Map<String, Object>> extractor = (rs) -> {
            Map<String, Object> objectMap = new HashMap<>();
            if (rs.next()) {
                objectMap.put("profile_pic", rs.getString("profile_pic"));
                objectMap.put("post_owner", rs.getString("username"));
                objectMap.put("photo_url", rs.getString("photo_url"));
                objectMap.put("likes", rs.getInt("likes"));
            }
            return objectMap;
        };

        return jdbcTemplate.query(sql, extractor, id.toString());
    }
}
