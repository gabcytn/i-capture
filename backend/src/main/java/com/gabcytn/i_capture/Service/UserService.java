package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.AuthRequest;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.UserRepository;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.BadCredentialsException;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.context.SecurityContext;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.security.web.context.SecurityContextRepository;
import org.springframework.stereotype.Service;

import java.util.UUID;

@Service
public class UserService {
    private final UserRepository userRepository;
    private final AuthenticationManager authenticationManager;
    private final SecurityContextRepository securityContextRepository;
    private final PasswordEncoder passwordEncoder;

    public UserService(UserRepository userRepository,
                       AuthenticationManager authenticationManager,
                       SecurityContextRepository securityContextRepository,
                       PasswordEncoder passwordEncoder
    ) {
        this.userRepository = userRepository;
        this.authenticationManager = authenticationManager;
        this.securityContextRepository = securityContextRepository;
        this.passwordEncoder = passwordEncoder;
    }

    public User getUserById (UUID id) {
        return userRepository.findById(id);
    }

    public User getUserByUsername (String username) {
        return userRepository.findByUsername(username);
    }

    public ResponseEntity<User> handleAuthentication (
            User user,
            HttpServletRequest request,
            HttpServletResponse response
    )
    {
        try
        {
            Authentication authenticationRequest =
                    UsernamePasswordAuthenticationToken.unauthenticated(user.getUsername(), user.getPassword());

            Authentication authenticationResponse =
                    authenticationManager.authenticate(authenticationRequest); // throws error if not valid

            // Create a new SecurityContext
            SecurityContext securityContext = SecurityContextHolder.createEmptyContext();
            securityContext.setAuthentication(authenticationResponse);

            // Store the SecurityContext in the SecurityContextRepository
            SecurityContextHolder.setContext(securityContext);
            securityContextRepository.saveContext(securityContext, request, response);
            User returnedUser = getUserByUsername(user.getUsername());
            return new ResponseEntity<>(returnedUser, HttpStatus.OK);
        }
        catch (BadCredentialsException e)
        {
            return new ResponseEntity<>(new User(), HttpStatus.UNAUTHORIZED);
        }
        catch (Exception e)
        {
            return new ResponseEntity<>(new User(), HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public ResponseEntity<Void> registerUser (User user) {
        // encrypt password with bcrypt (strength of 10)
        user.setPassword(passwordEncoder.encode(user.getPassword()));
        return userRepository.save(user.getId(), user.getUsername(), user.getPassword());
    }

    public ResponseEntity<Void> changePassword (String id, String oldPassword, String newPassword) {
        UUID uuid = UUID.fromString(id);
        User user = userRepository.findById(uuid);
        try {
            if (passwordEncoder.matches(oldPassword, user.getPassword()) && user.getId().equals(uuid)) {
                newPassword = passwordEncoder.encode(newPassword);
                userRepository.changePassword(uuid, newPassword);
                return new ResponseEntity<>(HttpStatus.ACCEPTED);
            }
            return new ResponseEntity<>(HttpStatus.BAD_REQUEST);
        } catch (Exception e) {
            System.err.println("Error in changePassword() service");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
