package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.Post;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.LikesRepository;
import com.gabcytn.i_capture.Repository.PostsRepository;
import com.gabcytn.i_capture.Repository.UserRepository;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.UUID;

@Service
public class PostsService {
    private final PostsRepository postsRepository;
    private final CloudinaryService cloudinaryService;
    private final UserRepository userRepository;
    private final LikesRepository likesRepository;

    public PostsService(
            PostsRepository postsRepository,
            CloudinaryService cloudinaryService,
            UserRepository userRepository,
            LikesRepository likesRepository
    ) {
        this.postsRepository = postsRepository;
        this.cloudinaryService = cloudinaryService;
        this.userRepository = userRepository;
        this.likesRepository = likesRepository;
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

    public ResponseEntity<List<Post>> getPostsByPostOwner (String username) {
        try {
            User user = userRepository.findByUsername(username);
            if (user == null)
                return new ResponseEntity<>(HttpStatus.NOT_FOUND);

            List<Post> postList = postsRepository.findAllByPostOwner(user.getId());
            return new ResponseEntity<>(postList, HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error retrieving posts");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public ResponseEntity<Map<String, Object>> getPost (String uuid, int postId) {
        final Map<String, Object> post = postsRepository.findById(postId);

        if (post.isEmpty()) {
            return new ResponseEntity<>(new HashMap<>(), HttpStatus.OK);
        }

        final boolean isLiked = likesRepository.isLikedBy(uuid, postId);
        final int likeCount = likesRepository.findLikeCount(postId);
        post.put("isLiked", isLiked);
        post.put("likes", likeCount);

        return new ResponseEntity<>(post, HttpStatus.OK);
    }
}
