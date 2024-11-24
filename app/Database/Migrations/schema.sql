-- CREATE A DATABASE NAMED

-- i_capture
-- i_capture
-- i_capture
-- i_capture
-- i_capture

-- THEN RUN THESE QUERIES:

CREATE TABLE users (
    id VARCHAR(100) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255) DEFAULT "images/default-profile.jpg"
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_owner VARCHAR(100) NOT NULL,
    likes INT DEFAULT 0,
    photo_url VARCHAR(255) NOT NULL,
    photo_public_id VARCHAR(100) NOT NULL,
    FOREIGN KEY (post_owner) REFERENCES users(id)
);

CREATE TABLE followers (
    following_id VARCHAR(100),
    follower_id VARCHAR(100),
    FOREIGN KEY (following_id) REFERENCES users(id),
    FOREIGN KEY (follower_id) REFERENCES users(id)
);

CREATE TABLE likes (
    post_id INT,
    liker_id VARCHAR(100),
    FOREIGN KEY (post_id) REFERENCES posts(id),
    FOREIGN KEY (liker_id) REFERENCES users(id)
);

