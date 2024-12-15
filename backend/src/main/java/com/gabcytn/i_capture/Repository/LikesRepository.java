package com.gabcytn.i_capture.Repository;

import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.ResultSetExtractor;
import org.springframework.stereotype.Repository;

@Repository
public class LikesRepository {
    private final JdbcTemplate jdbcTemplate;

    public LikesRepository(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public boolean isLikedBy (String uuid, int postId) {
        String sql = "SELECT COUNT(*) AS like_count FROM likes WHERE liker_id = ? AND post_id = ?";

        ResultSetExtractor<Integer> extractor = rs -> {
            if (rs.next()) {
                return rs.getInt("like_count");
            }
            return 0;
        };

        Object count = jdbcTemplate.query(sql, extractor, uuid, postId);
        if (count != null) {
            int finalCount = (int) count;
            return finalCount > 0;
        }

        return false;
    }
}
