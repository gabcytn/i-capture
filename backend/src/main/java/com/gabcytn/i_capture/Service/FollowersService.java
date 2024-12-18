package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.FollowersRepository;
import com.gabcytn.i_capture.Repository.UserRepository;
import jakarta.servlet.http.HttpServletRequest;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.UUID;

@Service
public class FollowersService {
    private final FollowersRepository followersRepository;
    private final UserRepository userRepository;

    public FollowersService(FollowersRepository followersRepository, UserRepository userRepository) {
        this.followersRepository = followersRepository;
        this.userRepository = userRepository;
    }

    public ResponseEntity<List<User>> getFollowersOf (UUID uuid) {
        try {
            final List<User> listOfFollowers = followersRepository.findFollowersById(uuid);
            return new ResponseEntity<>(listOfFollowers, HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error getting followers list");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public ResponseEntity<List<User>> getFollowingsOf (UUID uuid) {
        try {
            final List<User> listOfFollowers = followersRepository.findFollowingsById(uuid);
            return new ResponseEntity<>(listOfFollowers, HttpStatus.OK);
        } catch (Exception e) {
            System.err.println("Error getting followings list");
            System.err.println(e.getMessage());
            return new ResponseEntity<>(HttpStatus.INTERNAL_SERVER_ERROR);
        }
    }

    public ResponseEntity<Void> follow (String usernameToFollow, HttpServletRequest request) {
        User user = userRepository.findByUsername(usernameToFollow);
        if (user == null) {
            return new ResponseEntity<>(HttpStatus.BAD_REQUEST);
        }
        // cannot follow oneself
        else if (user.getId().toString().equals(getStoredUuid(request).toString())) {
            return new ResponseEntity<>(HttpStatus.CONFLICT);
        }
        final boolean isFollowing = isFollowing(request, user.getId().toString());
        // cannot follow already following
        if (isFollowing) {
            return new ResponseEntity<>(HttpStatus.CONFLICT);
        }

        followersRepository.follow(user.getId(), getStoredUuid(request));
        return new ResponseEntity<>(HttpStatus.OK);
    }

    public ResponseEntity<Void> unfollow (String usernameToFollow, HttpServletRequest request) {
        User user = userRepository.findByUsername(usernameToFollow);
        if (user == null) {
            return new ResponseEntity<>(HttpStatus.BAD_REQUEST);
        }
        final boolean isFollowing = isFollowing(request, user.getId().toString());
        // cannot unfollow not following
        if (!isFollowing) {
            return new ResponseEntity<>(HttpStatus.CONFLICT);
        }

        followersRepository.unfollow(user.getId(), getStoredUuid(request));
        return new ResponseEntity<>(HttpStatus.OK);
    }

    private boolean isFollowing (HttpServletRequest request, String followingId) {
        String sessionId = getSessionId(request);
        String storedUuid = (String) request.getSession().getAttribute(sessionId);
        return followersRepository.isFollowedBy(followingId, storedUuid);
    }

    private String getSessionId (HttpServletRequest request) {
        return request.getSession().getId();
    }

    private UUID getStoredUuid (HttpServletRequest request) {
        return UUID.fromString((String) request.getSession().getAttribute(getSessionId(request)));
    }
}
