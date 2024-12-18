package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Service.UserService;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;
import java.util.Map;
import java.util.UUID;

@RestController
public class UserController {
    private final UserService userService;

    public UserController(UserService userService) {
        this.userService = userService;
    }

    @PostMapping(path = "/profile-image", consumes = "multipart/form-data")
    public ResponseEntity<Void> changeDisplayImage (@RequestParam UUID id, @RequestParam MultipartFile file) {
        if (file != null && id != null) {
            return userService.changeDisplayImage(id,file);
        }
        return new ResponseEntity<>(HttpStatus.NOT_FOUND);
    }

    @GetMapping(path = "/search/{keyword}")
    public List<User> searchFor (@PathVariable String keyword) {
        return userService.searchFor(keyword);
    }

    @GetMapping(path = "/{username}")
    public ResponseEntity<Map<String, Object>> getUser (
            @PathVariable String username,
            HttpServletRequest request
    ) {
        return userService.getUserCredentialsByUsername(username, request);
    }
}
