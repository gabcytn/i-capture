-- Create table for users
CREATE TABLE users (
    id VARCHAR(255) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255)
);

-- Create table for posts
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_owner VARCHAR(255),
    likes INT DEFAULT 0,
    photo_url VARCHAR(255),
    FOREIGN KEY (post_owner) REFERENCES users(id)
);

-- Create table for followers
CREATE TABLE followers (
    following_id VARCHAR(255),
    follower_id VARCHAR(255),
    PRIMARY KEY (following_id, follower_id),
    FOREIGN KEY (following_id) REFERENCES users(id),
    FOREIGN KEY (follower_id) REFERENCES users(id)
);

