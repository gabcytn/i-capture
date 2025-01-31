# Instagram Semi-Clone

A minimalist Instagram-like platform built with a modern tech stack, featuring core functionalities of user authentication, post creation, likes, follows, and search.

https://github.com/user-attachments/assets/372e32e6-1b62-4104-ac94-a85ab93f059e

## Features

* User Authentication: w/ Spring Security.
* Create Posts: upload images handled by Cloudinary.
* Like/Unlike Posts: Engage with content.
* Follow/Unfollow Users: Build a network.
* Search: Find users.
  
## Tech Stack

#### Frontend:

* TypeScript 
  * React
  * React-router
  * React-query

#### Backend:

* Java 
  * Spring Boot
  * Spring Security
  * Spring JDBC

#### Database:

* MySQL

#### Storage:

* Cloudinary

## Getting Started

#### Setup

1. Clone the repository:
```bash
git clone https://github.com/gabcytn/i-capture.git
cd i-capture
```
2. Serve the frontend:
```bash
cd frontend
npm install
npm run dev
```
3. Configure application.properties and .env at:
```
backend/src/main/resources/application.properties
backend/env
```
4. Run the backend:
```bash
cd backend
./mvnw spring-boot:run
```
5. Database:
```
Import the schema from backend/src/main/resources/schema.sql into your MySQL instance.
```
6. Access the Application at:
```
http://localhost:5173
```
