package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.AuthRequest;
import com.gabcytn.i_capture.Service.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.web.context.SecurityContextRepository;
import org.springframework.web.bind.annotation.*;

@RestController
public class AuthController {
    private final UserService userService;

    public AuthController(UserService userService,
                          AuthenticationManager authenticationManager,
                          SecurityContextRepository securityContextRepository
    ) {
        this.userService = userService;
    }

    @GetMapping("/session-id")
    public String getSessionId (HttpServletRequest request){
        return request.getSession().getId();
    }

    @PostMapping("/login")
    public ResponseEntity<Void> login(
            @RequestBody AuthRequest loginRequest,
            HttpServletRequest request,
            HttpServletResponse response)
    {
        return userService.handleAuthentication(loginRequest, request, response);
    }

    @PostMapping("/register")
    public ResponseEntity<Void> register (@RequestBody AuthRequest registerRequest) {

        return new ResponseEntity<>(HttpStatus.ACCEPTED);
    }

}