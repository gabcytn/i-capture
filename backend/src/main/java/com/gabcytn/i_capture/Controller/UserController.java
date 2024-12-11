package com.gabcytn.i_capture.Controller;

import com.gabcytn.i_capture.Model.LoginRequest;
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
    public ResponseEntity<Void> login(@RequestBody LoginRequest loginRequest,
                                      HttpServletRequest request,
                                      HttpServletResponse response)
    {
        try
        {
            String username = loginRequest.getUsername();
            String password = loginRequest.getPassword();

            System.out.println(username);
            System.out.println(password);

//            UsernamePasswordAuthenticationToken authToken =
//                    new UsernamePasswordAuthenticationToken(username, password);
//
//            Authentication auth = authenticationManager.authenticate(authToken);
//
//            // Create a new SecurityContext
//            SecurityContext securityContext = SecurityContextHolder.createEmptyContext();
//            securityContext.setAuthentication(auth);
//
//            // Store the SecurityContext in the SecurityContextRepository
//            securityContextRepository.saveContext(securityContext, request, response);

            Authentication authenticationRequest =
                    UsernamePasswordAuthenticationToken.unauthenticated(loginRequest.getUsername(), loginRequest.getPassword());

            Authentication authenticationResponse =
                    authenticationManager.authenticate(authenticationRequest);

            return new ResponseEntity<>(HttpStatus.OK);
        }
        catch (Exception e)
        {
            System.err.println(e + e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
