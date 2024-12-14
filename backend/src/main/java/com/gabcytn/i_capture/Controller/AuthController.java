package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.AuthRequest;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Service.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.Map;

@RestController
public class AuthController {
    private final UserService userService;

    public AuthController(UserService userService) {
        this.userService = userService;
    }

    @GetMapping("/session-id")
    public String getSessionId (HttpServletRequest request){
        return request.getSession().getId();
    }

    @PostMapping("/login")
    public ResponseEntity<User> login(
            @RequestBody User user,
            HttpServletRequest request,
            HttpServletResponse response)
    {
        return userService.handleAuthentication(user , request, response);
    }

    @PostMapping("/register")
    public ResponseEntity<Void> register (@RequestBody User user) {
        return userService.registerUser(user);
    }

    @PutMapping("/change-password")
    public ResponseEntity<Void> changePassword (@RequestBody Map<String, String> request) {
        return userService.changePassword(
                request.get("id"),
                request.get("oldPassword"),
                request.get("newPassword")
        );
    }

}