<?php

namespace main {
    require 'app.php';

    $db = new \PDO('mysql:host=host.docker.internal;port=13306;user=root;dbname=goapp');
    $userRepo = new \user\PdoRepository($db);

    $user = \app\registerUser($userRepo, 'foo@example.com');
    print_r($user);
}
