<?php

namespace test {
    require 'app.php';

    use user;

    $userRepo = new class implements user\Repository {
        public function createUser(user\User $user): void {}
    };

    $user = \app\registerUser($userRepo, 'foo@example.com');
    print_r($user);
}
