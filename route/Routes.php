<?php
include_once 'src/controllers/ProductController.php';
return $routes = array(
    'home' => [
        'options' => [
            'route'    => '/',
            'controller' => ProductController::class,
            'action'     => 'index',
            'type' => 'POST'
        ],
    ],
    'product' => [
        'options' => [
            'route'    => '/product',
            'controller' => ProductController::class,
            'action'     => 'index',
            'type' => 'POST'
        ],
    ]);

