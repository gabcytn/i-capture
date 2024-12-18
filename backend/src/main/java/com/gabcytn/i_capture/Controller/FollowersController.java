package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Service.FollowersService;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;
import java.util.UUID;

@RestController
public class FollowersController {
    private final FollowersService followersService;

    public FollowersController(FollowersService followersService) {
        this.followersService = followersService;
    }

    @GetMapping("/followers")
    public ResponseEntity<List<User>> findFollowersOf (HttpServletRequest request) {
        return followersService.getFollowersOf(getSessionUuid(request));
    }

    @GetMapping("/followings")
    public ResponseEntity<List<User>> findFollowingsOf (HttpServletRequest request) {
        return followersService.getFollowingsOf(getSessionUuid(request));
    }

    @PostMapping("/follow/{username}")
    public ResponseEntity<Void> follow (@PathVariable String username, HttpServletRequest request) {
        return followersService.follow(username, request);
    }

    @PostMapping("/unfollow/{username}")
    public ResponseEntity<Void> unfollow (@PathVariable String username, HttpServletRequest request) {
        return followersService.unfollow(username, request);
    }

    private UUID getSessionUuid (HttpServletRequest request) {
        String sessionId = request.getSession().getId();
        return UUID.fromString((String) request.getSession().getAttribute(sessionId));
    }
}
