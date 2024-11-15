<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get("/login", "AuthController::login");
$routes->get("/register", "AuthController::register");
$routes->get("/logout", "AuthController::logoutUser");

$routes->post("/register", "AuthController::createUser");
$routes->post("/login", "AuthController::checkUser");
$routes->post("/logout", "AuthController::logoutUser");