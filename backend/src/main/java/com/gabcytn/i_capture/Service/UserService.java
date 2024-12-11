package com.gabcytn.i_capture.Service;

import com.gabcytn.i_capture.Model.User;
import com.gabcytn.i_capture.Repository.UserRepository;
import org.springframework.stereotype.Service;

import java.util.Optional;

@Service
public class UserService {
    private final UserRepository userRepository;

    public UserService(UserRepository userRepository) {
        this.userRepository = userRepository;
    }

    public User getUserById (int id) {
        return userRepository.findById(id);
    }
}
