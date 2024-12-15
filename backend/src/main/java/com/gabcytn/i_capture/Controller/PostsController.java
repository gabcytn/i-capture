package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.Post;
import com.gabcytn.i_capture.Service.PostsService;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;
import java.util.Map;
import java.util.UUID;

@RestController
public class PostsController {
    private final PostsService postsService;

    public PostsController(PostsService postsService) {
        this.postsService = postsService;
    }

    @PostMapping(value = "/post/create", consumes = "multipart/form-data")
    public ResponseEntity<Void> createPost (@RequestParam UUID id, @RequestParam MultipartFile file) {
        if (id == null || file.isEmpty()) {
            return new ResponseEntity<>(HttpStatus.NOT_FOUND);
        }

        return postsService.createPost(id, file);
    }

    @GetMapping("/posts/{username}")
    public ResponseEntity<List<Post>> getPostsBy (@PathVariable String username) {
        List<Post> postsList = postsService.getPostsByPostOwner(username);
        if (postsList.isEmpty())
            return new ResponseEntity<>(HttpStatus.NOT_FOUND);

        return new ResponseEntity<>(postsList, HttpStatus.OK);
    }

    @GetMapping("/post/{id}")
    public Map<String, Object> getPostDetails (@PathVariable int id, HttpServletRequest request) {
        String sessionId = request.getSession().getId();
        String uuid = (String) request.getSession().getAttribute(sessionId);

        return postsService.getPost(uuid, id);
    }
}
