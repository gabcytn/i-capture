# Instagram Semi-Clone

A minimalist Instagram-like platform built with a modern tech stack, featuring core functionalities of user authentication, post creation, likes, follows, and search.

https://github.com/user-attachments/assets/bc223722-525f-4eee-b91b-d21812b70051

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

**Prerequisites:**

* Node.js (v16 or higher)
* Java (v17 or higher)
* MySQL
* Cloudinary Account

#### Setup

1. Clone the repository:
```bash
git clone https://github.com/your-username/instagram-semi-clone.git
cd instagram-semi-clone
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
Import the schema from backend/sql/schema.sql into your MySQL instance.
```
6. Access the Application at:
```
http://localhost:5173
```
