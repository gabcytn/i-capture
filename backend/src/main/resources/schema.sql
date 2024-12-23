CREATE TABLE users (
	id CHAR(36) NOT NULL,
	username VARCHAR (50) NOT NULL,
	password VARCHAR (255) NOT NULL,
	profile_pic VARCHAR (255) DEFAULT 'https://res.cloudinary.com/dfvwoewft/image/upload/v1733883089/default-profile_r4f6xf.jpg',
	PRIMARY KEY (id),
	UNIQUE(username)
);

CREATE TABLE posts (
	id INT AUTO_INCREMENT,
	post_owner CHAR(36) NOT NULL,
	photo_url VARCHAR (255) NOT NULL,
	photo_public_id VARCHAR(255) NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY(post_owner) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE likes (
	post_id INT NOT NULL,
	liker_id CHAR(36) NOT NULL,
	PRIMARY KEY(post_id, liker_id),
	FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(liker_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE followers (
	following_id CHAR(36) NOT NULL,
	follower_id CHAR(36) NOT NULL,
	PRIMARY KEY(following_id, follower_id),
	FOREIGN KEY(following_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(follower_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);
