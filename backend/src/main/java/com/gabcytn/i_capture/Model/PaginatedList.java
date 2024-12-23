package com.gabcytn.i_capture.Model;

import java.util.List;
import java.util.Map;

public class PaginatedList {
    private List<Map<String, Object>> posts;
    private int nextCursor;

    public PaginatedList() {
    }

    public PaginatedList(List<Map<String, Object>> posts, int nextCursor) {
        this.posts = posts;
        this.nextCursor = nextCursor;
    }

    public List<Map<String, Object>> getPosts() {
        return posts;
    }

    public void setPosts(List<Map<String, Object>> posts) {
        this.posts = posts;
    }

    public int getNextCursor() {
        return nextCursor;
    }

    public void setNextCursor(int nextCursor) {
        this.nextCursor = nextCursor;
    }
}
