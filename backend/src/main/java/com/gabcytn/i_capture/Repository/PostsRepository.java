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
                post.setPhotoUrl(rs.getString("photo_url"));
                post.setPhotoPublicId(rs.getString("photo_public_id"));
                return post;
        };
        return jdbcTemplate.query(sql, rowMapper, id.toString());
    }

    public Map<String, Object> findPostToDisplayById (Integer id, String uuid) {
        final String sql = " SELECT posts.id AS post_id, " +
                "posts.photo_url, " +
                "posts.photo_public_id, users.id AS uuid, " +
                "users.username, users.profile_pic " +
                "FROM posts " +
                "JOIN users " +
                "ON users.id = posts.post_owner " +
                "WHERE posts.id = ?";

        ResultSetExtractor<Map<String, Object>> extractor = (rs) -> {
            Map<String, Object> objectMap = new HashMap<>();
            if (rs.next()) {
                objectMap.put("profilePic", rs.getString("profile_pic"));
                objectMap.put("postOwner", rs.getString("username"));
                objectMap.put("photoUrl", rs.getString("photo_url"));
                objectMap.put("isOwned", uuid.equals(rs.getString("uuid")));
                objectMap.put("photoPublicId", rs.getString("photo_public_id"));
            }
            return objectMap;
        };

        return jdbcTemplate.query(sql, extractor, id.toString());
    }

    public Optional<Post> findById (int id) {
        String sql = "SELECT post_owner, photo_public_id FROM posts WHERE id = ?";

        ResultSetExtractor<Post> extractor = (rs) -> {
            if (rs.next()) {
                Post post = new Post();
                post.setId(id);
                post.setPhotoPublicId(rs.getString("photo_public_id"));
                post.setPostOwner(UUID.fromString(rs.getString("post_owner")));
                return post;
            }

            return null;
        };

        return Optional.ofNullable(jdbcTemplate.query(sql, extractor, id));
    }

    public void deletePost (int id) {
        String sql = "DELETE FROM posts WHERE id = ?";
        jdbcTemplate.update(sql, id);
    }

    public boolean isPostOwnedBy (int postId, UUID uuid) {
        String sql = "SELECT post_owner FROM posts WHERE id = ?";
        ResultSetExtractor<String> extractor = (rs) -> {
            if (rs.next()) return rs.getString("post_owner");
            return null;
        };

        String postOwner = jdbcTemplate.query(sql, extractor, postId);
        return uuid.toString().equals(postOwner);
    }

    public List<Map<String, Object>> findPostsForYou (UUID uuid, int lastViewedPostId) {
        String sql = "SELECT posts.id, posts.photo_url, users.username AS post_owner, users.profile_pic " +
                "FROM posts " +
                "JOIN users " +
                "ON posts.post_owner = users.id " +
                "LEFT JOIN likes " +
                "ON posts.id = likes.post_id " +
                "AND likes.liker_id = ? " +
                "WHERE likes.post_id IS NULL " +
                "AND posts.post_owner != ? " +
                "AND posts.id < ? " +
                "ORDER BY posts.id DESC " +
                "LIMIT 10";

        return jdbcTemplate.query(sql, rowMapper(), uuid.toString(), uuid.toString(), lastViewedPostId);
    }


    // row mapper for posts in home page
    private RowMapper<Map<String, Object>> rowMapper() {
        return (rs, rowNum) -> {
            Map<String, Object> postMap = new HashMap<>();
            postMap.put("postId", rs.getInt("id"));
            postMap.put("photoUrl", rs.getString("photo_url"));
            postMap.put("postOwner", rs.getString("post_owner"));
            postMap.put("profilePic", rs.getString("profile_pic"));
            return postMap;
        };
    }

    public int getLastPostId () {
        String sql = "SELECT id FROM posts ORDER BY id DESC LIMIT 1";
        ResultSetExtractor<Integer> extractor = rs -> {
            if (rs.next()) {
                return rs.getInt("id");
            }
            return null;
        };

        Integer lastId = jdbcTemplate.query(sql, extractor);
        return lastId != null ? lastId : 0;
    }
}
