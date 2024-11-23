<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get("/login", "AuthController::login");
$routes->get("/register", "AuthController::register");
$routes->get("/posts/(:num)", "PostsController::posts/$1");
$routes->get("/search", "HomeController::search");
$routes->get("/followers", "AccountsController::followers");
$routes->get("/followings", "AccountsController::followings");

$routes->post("/logout", "AuthController::logoutUser");
$routes->post("/register", "AuthController::createUser");
$routes->post("/login", "AuthController::checkUser");
$routes->post("/posts/(:num)/unlike", "PostsController::unlike/$1");
$routes->post("/posts/(:num)/like", "PostsController::like/$1");
$routes->post("/change-picture", "AccountsController::changePicture");
$routes->post("/(:segment)/follow", "AccountsController::follow/$1");
$routes->post("/(:segment)/unfollow", "AccountsController::unfollow/$1");
$routes->post("/post", "PostsController::createPost");

$routes->put("/change-password", "AccountsController::changePassword");
$routes->delete("/posts/(:num)/delete", "PostsController::delete/$1");


$routes->get("/(:segment)", "AccountsController::profile/$1");