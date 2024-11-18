<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AccountsController::index');
$routes->get("/login", "AuthController::login");
$routes->get("/register", "AuthController::register");
$routes->get("/logout", "AuthController::logoutUser");
$routes->get("/posts/(:num)", "PostsController::posts/$1");

$routes->post("/register", "AuthController::createUser");
$routes->post("/login", "AuthController::checkUser");
$routes->post("/logout", "AuthController::logoutUser");
$routes->post("/posts/(:num)/unlike", "PostsController::unlike/$1");
$routes->post("/posts/(:num)/like", "PostsController::like/$1");

$routes->put("/change-password", "AccountsController::changePassword");
$routes->put("/change-picture", "AccountsController::changePicture");


$routes->delete("/posts/(:num)/delete", "PostsController::delete/$1");


$routes->get("/(:segment)", "AccountsController::profile/$1");