package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.AuthRequest;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Service.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

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
            @RequestBody AuthRequest loginRequest,
            HttpServletRequest request,
            HttpServletResponse response)
    {
        return userService.handleAuthentication(loginRequest, request, response);
    }

    @PostMapping("/register")
    public ResponseEntity<Void> register (@RequestBody AuthRequest registerRequest) {
        return userService.registerUser(registerRequest);
    }

}