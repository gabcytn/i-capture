package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Service.LikesService;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.UUID;

@RestController
public class LikesController {
    private final LikesService likesService;

    public LikesController(LikesService likesService) {
        this.likesService = likesService;
    }

    @PostMapping("/post/like/{id}")
    public ResponseEntity<Void> likePost (@PathVariable int id, HttpServletRequest request) {
        return likesService.like(getStoredUuid(request), id);
    }

    @PostMapping("/post/unlike/{id}")
    public ResponseEntity<Void> unlikePost (@PathVariable int id, HttpServletRequest request) {
        return likesService.unlike(getStoredUuid(request), id);
    }

    private UUID getStoredUuid (HttpServletRequest request) {
        String sessionId = request.getSession().getId();
        return UUID.fromString((String) request.getSession().getAttribute(sessionId));
    }

}
