# iCapture

A semi-clone of Instagram, developed as a final project for IT0049. The application includes the core features of photo sharing, user accounts, followers, and likes. It was built using **CodeIgniter** (PHP framework) and **MySQL** for database management.

## Run Locally:
### :computer: For Windows Users Only:

1. Download [XAMPP](https://www.apachefriends.org/).
2. **Clone this repository**:
    ```bash
   git clone https://github.com/gabcytn/i-capture.git "C:\xampp\htdocs\"
3. Start Apache and MySQL with XAMPP then navigate to `http://localhost/phpmyadmin`.
4. Create a new database named **`i_capture`**.
5. Import the database schema by running the **`schema.sql`** file located at `app/Database/Migrations/schema.sql`.
6. Visit `http://localhost/i-capture/public/` with your favorite browser.

## Features

- **User Accounts**: Users can register, log in, and manage their profile.
- **Photo Sharing**: Users can upload, view, and delete photos.
- **Followers**: Users can follow or unfollow other users.
- **Likes**: Users can like and unlike photos. 

## Tech Stack

- **Backend**: CodeIgniter (PHP framework)
- **Database**: MySQL 
- **Frontend**: HTML, Bootstrap CSS, JavaScript 
- **Authentication**: Session-based login system 
- **Storage**: Cloudinary 
