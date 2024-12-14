package com.gabcytn.i_capture.Repository;

import com.gabcytn.i_capture.Model.Post;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Repository;

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
}
