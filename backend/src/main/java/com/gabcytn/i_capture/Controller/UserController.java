package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.LoginRequest;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Service.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.http.ResponseEntity;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.web.context.SecurityContextRepository;
import org.springframework.web.bind.annotation.*;

@RestController
public class UserController {
    private final UserService userService;

    public UserController(UserService userService,
                          AuthenticationManager authenticationManager,
                          SecurityContextRepository securityContextRepository
    ) {
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

    @GetMapping("/session-id")
    public String getSessionId (HttpServletRequest request){
        return request.getSession().getId();
    }

    @PostMapping("/login")
    public ResponseEntity<Void> login(
            @RequestBody LoginRequest loginRequest,
            HttpServletRequest request,
            HttpServletResponse response)
    {
       return userService.handleAuthentication(loginRequest, request, response);
    }
}
