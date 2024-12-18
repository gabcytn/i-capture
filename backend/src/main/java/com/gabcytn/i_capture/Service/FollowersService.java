package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.FollowersRepository;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.UUID;

@Service
public class FollowersService {
    private final FollowersRepository followersRepository;

    public FollowersService(FollowersRepository followersRepository) {
        this.followersRepository = followersRepository;
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
}
