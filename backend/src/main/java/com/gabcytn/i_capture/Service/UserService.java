package com.gabcytn.i_capture.Service;

import com.cloudinary.Cloudinary;
import com.cloudinary.utils.ObjectUtils;
import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.FollowersRepository;
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
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.util.List;
import java.util.Map;
import java.util.UUID;

@Service
public class UserService{
    private final UserRepository userRepository;
    private final FollowersRepository followersRepository;
    private final AuthenticationManager authenticationManager;
    private final SecurityContextRepository securityContextRepository;
    private final PasswordEncoder passwordEncoder;
    private final CloudinaryService cloudinaryService;

    public UserService(UserRepository userRepository,
                       AuthenticationManager authenticationManager,
                       SecurityContextRepository securityContextRepository,
                       PasswordEncoder passwordEncoder,
                       CloudinaryService cloudinaryService,
                       FollowersRepository followersRepository
    ) {
        this.userRepository = userRepository;
        this.followersRepository = followersRepository;
        this.authenticationManager = authenticationManager;
        this.securityContextRepository = securityContextRepository;
        this.passwordEncoder = passwordEncoder;
        this.cloudinaryService = cloudinaryService;
    }

    public User getUserById (UUID id) {
        return userRepository.findById(id);
    }

    public User getUserByUsername (String username) {
        return userRepository.findByUsername(username);
    }

    public ResponseEntity<User> getUserCredentialsByUsername (String username) {
        try {
            User user = userRepository.findByUsername(username);
            if (user == null) {
                return new ResponseEntity<>(HttpStatus.NOT_FOUND);
            } else {
                System.err.println("user is not null");
            }
            user.setFollowerCount(followersRepository.findFollowerCountOf(user.getId()));
            user.setFollowingCount(followersRepository.findFollowingCountOf(user.getId()));
            return new ResponseEntity<>(user, HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error retrieving user credentials");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
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

            String currentSessionId = request.getSession().getId();
            User returnedUser = getUserByUsername(user.getUsername());
            request.getSession().setAttribute(currentSessionId, returnedUser.getId().toString());
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

    public ResponseEntity<Void> changeDisplayImage (UUID id, MultipartFile file) {
        try {
            String[] uploadDetails = cloudinaryService.uploadImageToCloudinary(file);
            if (uploadDetails.length > 0) {
                userRepository.changeProfile(id, uploadDetails[0]);
                return new ResponseEntity<>(HttpStatus.ACCEPTED);
            }
            throw new RuntimeException("Error Uploading to Cloudinary");
        } catch (Exception e) {
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public List<User> searchFor (String keyword) {
        return userRepository.findByUsernameContainingIgnoreCase(keyword);
    }

}
