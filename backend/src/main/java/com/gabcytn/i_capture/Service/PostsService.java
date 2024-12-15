package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.Post;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.PostsRepository;
import com.gabcytn.i_capture.Repository.UserRepository;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;
import java.util.UUID;

@Service
public class PostsService {
    private final PostsRepository postsRepository;
    private final CloudinaryService cloudinaryService;
    private final UserRepository userRepository;

    public PostsService(
            PostsRepository postsRepository,
            CloudinaryService cloudinaryService,
            UserRepository userRepository
    ) {
        this.postsRepository = postsRepository;
        this.cloudinaryService = cloudinaryService;
        this.userRepository = userRepository;
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

    public List<Post> getPostsByPostOwner (String username) {
        User user = userRepository.findByUsername(username);
        if (user == null)
            return List.of();

        return postsRepository.findAllByPostOwner(user.getId());
    }
}
