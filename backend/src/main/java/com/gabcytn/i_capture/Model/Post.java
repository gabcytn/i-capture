package com.gabcytn.i_capture.Model;

import java.util.UUID;

public class Post {
    private int id;
    private UUID postOwner;
    private String photoUrl;
    private String photoPublicId;
    private int likes;

    public Post() {
    }

    public Post(int id, UUID postOwner, String photoUrl, String photoPublicId, int likes) {
        this.id = id;
        this.postOwner = postOwner;
        this.photoUrl = photoUrl;
        this.photoPublicId = photoPublicId;
        this.likes = likes;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public UUID getPostOwner() {
        return postOwner;
    }

    public void setPostOwner(UUID postOwner) {
        this.postOwner = postOwner;
    }

    public String getPhotoUrl() {
        return photoUrl;
    }

    public void setPhotoUrl(String photoUrl) {
        this.photoUrl = photoUrl;
    }

    public String getPhotoPublicId() {
        return photoPublicId;
    }

    public void setPhotoPublicId(String photoPublicId) {
        this.photoPublicId = photoPublicId;
    }

    public int getLikes() {
        return likes;
    }

    public void setLikes(int likes) {
        this.likes = likes;
    }
}
