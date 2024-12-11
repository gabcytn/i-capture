package com.gabcytn.i_capture.Controller;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Model.UserPrincipal;
import com.gabcytn.i_capture.Service.UserService;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.web.context.SecurityContextRepository;
import org.springframework.web.bind.annotation.*;

import java.io.IOException;
import java.io.InputStream;
import java.util.Map;

@RestController
public class UserController {
    private final UserService userService;
    private final AuthenticationManager authenticationManager;
    private final SecurityContextRepository securityContextRepository;

    public UserController(UserService userService,
                          AuthenticationManager authenticationManager,
                          SecurityContextRepository securityContextRepository
    ) {
        this.userService = userService;
        this.authenticationManager = authenticationManager;
        this.securityContextRepository = securityContextRepository;
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
    public ResponseEntity<Void> login(HttpServletRequest request, HttpServletResponse response) {
        final ObjectMapper objectMapper = new ObjectMapper();
        try (InputStream inputStream = request.getInputStream()) {
            Map<String, String> authRequest = objectMapper.readValue(inputStream, Map.class);
            String username = authRequest.get("username");
            String password = authRequest.get("password");

            UsernamePasswordAuthenticationToken authToken =
                    new UsernamePasswordAuthenticationToken(username, password);

            Authentication auth = this.authenticationManager.authenticate(authToken);
            System.out.println(auth);

            // Create a new SecurityContext
            SecurityContext securityContext = SecurityContextHolder.createEmptyContext();
            securityContext.setAuthentication(auth);

            // Store the SecurityContext in the SecurityContextRepository
            this.securityContextRepository.saveContext(securityContext, request, response);

            return new ResponseEntity<>(HttpStatus.OK);
        } catch (IOException e) {
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
