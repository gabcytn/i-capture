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
import org.springframework.security.web.context.SecurityContextRepository;
import org.springframework.stereotype.Service;

@Service
public class UserService {
    private final UserRepository userRepository;
    private final AuthenticationManager authenticationManager;
    private final SecurityContextRepository securityContextRepository;

    public UserService(UserRepository userRepository,
                       AuthenticationManager authenticationManager,
                       SecurityContextRepository securityContextRepository
    ) {
        this.userRepository = userRepository;
        this.authenticationManager = authenticationManager;
        this.securityContextRepository = securityContextRepository;
    }

    public User getUserById (int id) {
        return userRepository.findById(id);
    }

    public ResponseEntity<Void> handleAuthentication (
            AuthRequest loginRequest,
            HttpServletRequest request,
            HttpServletResponse response
    )
    {
        try
        {
            Authentication authenticationRequest =
                    UsernamePasswordAuthenticationToken.unauthenticated(loginRequest.getUsername(), loginRequest.getPassword());

            Authentication authenticationResponse =
                    authenticationManager.authenticate(authenticationRequest); // throws error if not valid

            // Create a new SecurityContext
            SecurityContext securityContext = SecurityContextHolder.createEmptyContext();
            securityContext.setAuthentication(authenticationResponse);

            // Store the SecurityContext in the SecurityContextRepository
            SecurityContextHolder.setContext(securityContext);
            securityContextRepository.saveContext(securityContext, request, response);
            return new ResponseEntity<>(HttpStatus.OK);
        }
        catch (BadCredentialsException e)
        {
            return new ResponseEntity<>(HttpStatus.UNAUTHORIZED);
        }
        catch (Exception e)
        {
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }
}
