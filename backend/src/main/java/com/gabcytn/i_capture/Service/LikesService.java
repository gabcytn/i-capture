package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Repository.LikesRepository;
import com.gabcytn.i_capture.Repository.PostsRepository;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import java.util.UUID;

@Service
public class LikesService {
    private final LikesRepository likesRepository;
    private final PostsRepository postsRepository;

    public LikesService(LikesRepository likesRepository, PostsRepository postsRepository) {
        this.likesRepository = likesRepository;
        this.postsRepository = postsRepository;
    }

    public ResponseEntity<Void> like (UUID uuid, int postId) {
        try {
            likesRepository.like(uuid, postId);
            postsRepository.like(postId);
            return new ResponseEntity<>(HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error liking post");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public ResponseEntity<Void> unlike (UUID uuid, int postId) {
        try {
            likesRepository.unlike(uuid, postId);
            postsRepository.unlike(postId);
            return new ResponseEntity<>(HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error liking post");
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
