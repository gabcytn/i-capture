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
        final List<User> listOfFollowers = followersRepository.findFollowersById(uuid);
        if (listOfFollowers.isEmpty())
            return new ResponseEntity<>(HttpStatus.NOT_FOUND);

        return new ResponseEntity<>(listOfFollowers, HttpStatus.OK);
    }

    public ResponseEntity<List<User>> getFollowingsOf (UUID uuid) {
        final List<User> listOfFollowers = followersRepository.findFollowingsById(uuid);
        if (listOfFollowers.isEmpty())
            return new ResponseEntity<>(HttpStatus.NOT_FOUND);

        return new ResponseEntity<>(listOfFollowers, HttpStatus.OK);
    }
}
