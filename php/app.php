<?php

namespace user {
    class User {
        public int $id;
        public function __construct(public string $email)
        {
        }
    }

    class Repository {
        public function __construct(private \PDO $pdo)
        {
        }

        public function createUser(User $user): void
        {
            $stmt = $this->pdo->prepare('INSERT INTO users(email) VALUES(?)');
            $stmt->bindValue(1, $user->email);
            $stmt->execute();

            $user->id = $this->pdo->lastInsertId();
        }
    }
}

namespace app {
    use \user;

    /**
     * $email で user\User モデルを初期化し、 user\Repository を使って保存します. 成功した場合、作成した user\User モデルを返します.
     * 失敗した場合、 RuntimeException がスローされます.
     */
    function registerUser(user\Repository $userRepo, string $email): ?user\User {
        $user = new user\User(email: $email); // PHP 8 で追加された名前付き引数
        $userRepo->createUser($user);

        return $user;
    }
}

namespace main {
    $db = new \PDO('mysql:host=host.docker.internal;port=13306;user=root;dbname=goapp');
    $userRepo = new \user\Repository($db);

    $user = \app\registerUser($userRepo, 'foo@example.com');
    print_r($user);
}
