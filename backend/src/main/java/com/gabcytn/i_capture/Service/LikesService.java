package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Repository.LikesRepository;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import java.util.UUID;

@Service
public class LikesService {
    private final LikesRepository likesRepository;

    public LikesService(LikesRepository likesRepository) {
        this.likesRepository = likesRepository;
    }

    public ResponseEntity<Void> like (UUID uuid, int postId) {
        try {
            // returns 409 conflict if user is liking a post already liked
            if (likesRepository.isLikedBy(uuid.toString(), postId)) {
                return new ResponseEntity<>(HttpStatus.CONFLICT);
            }
            likesRepository.like(uuid, postId);
            return new ResponseEntity<>(HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error liking post");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public ResponseEntity<Void> unlike (UUID uuid, int postId) {
        try {
            // returns 409 conflict if user is unliking a post not liked in the first place
            if (!likesRepository.isLikedBy(uuid.toString(), postId)) {
                return new ResponseEntity<>(HttpStatus.CONFLICT);
            }
            likesRepository.unlike(uuid, postId);
            return new ResponseEntity<>(HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error unliking post");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
