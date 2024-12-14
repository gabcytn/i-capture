package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Service.UserService;
import org.springframework.http.HttpStatus;
import org.springframework.http.HttpStatusCode;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

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
}
