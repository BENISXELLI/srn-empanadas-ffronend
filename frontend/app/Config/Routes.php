<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');        // Página principal
$routes->get('/empanadas', 'Empanadas::index');  // Lista de empanadas