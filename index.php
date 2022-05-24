<?php 

    require __DIR__ . '/App/config.php';

    require __DIR__ . '/Core/Router.php';
    require __DIR__ . '/Core/Controller.php';
    require __DIR__ . '/Core/Model.php';

    $router = new Router();

    $router -> add('/', ['controller' => 'Home', 'method' => 'index'], ['GET', 'POST']);
    $router -> add ('/user/:username', ['controller' => 'User', 'method' => 'getUser']);
    $router -> add('404', ['controller' => 'NotFound', 'method' => 'index']);

    $router -> run();
?>