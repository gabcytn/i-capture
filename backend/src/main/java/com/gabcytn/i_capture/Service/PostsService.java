package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.Post;
import com.gabcytn.i_capture.Repository.PostsRepository;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.util.UUID;

@Service
public class PostsService {
    private final PostsRepository postsRepository;
    private final CloudinaryService cloudinaryService;

    public PostsService(PostsRepository postsRepository, CloudinaryService cloudinaryService) {
        this.postsRepository = postsRepository;
        this.cloudinaryService = cloudinaryService;
    }

    public ResponseEntity<Void> createPost (UUID id, MultipartFile file) {
        try {
            String[] uploadDetails = cloudinaryService.uploadImageToCloudinary(file);
            Post post = new Post();
            post.setPostOwner(id);
            post.setPhotoUrl(uploadDetails[0]);
            post.setPhotoPublicId(uploadDetails[1]);
            postsRepository.save(post);
            return new ResponseEntity<>(HttpStatus.CREATED);
        } catch (Exception e) {
            System.err.println("Error uploading post to cloudinary");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
