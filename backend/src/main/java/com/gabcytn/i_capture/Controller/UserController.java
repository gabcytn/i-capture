package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Service.UserService;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RestController;

import java.util.Optional;

@RestController
public class UserController {
    private final UserService userService;

    public UserController(UserService userService) {
        this.userService = userService;
    }

    @GetMapping("/user")
    public User getUser () {
        return new User();
    }

    @GetMapping("/user/{id}")
    public User getUserById (@PathVariable int id) {
        return userService.getUserById(id);
    }
}
