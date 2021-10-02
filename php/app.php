<?php

namespace user {
    class User {
        public int $id;
        public function __construct(public string $email)
        {
        }
    }

    interface Repository {
        public function createUser(User $user): void;
    }

    class PdoRepository implements Repository {
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

    interface UserCreator {
        public function createUser(user\User $user): void;
    }

    /**
     * 処理を user\Repository に委譲するだけ.
     */
    class DelegatingToRepoUserCreator implements UserCreator {
        public function __construct(private user\Repository $userRepo) {} // PHP 8 で追加されたオブジェクト初期化子
        public function createUser(user\User $user): void {
            $this->userRepo->createUser($user);
        }
    }

    /**
     * $email で user\User モデルを初期化し、 UserCreator を使って保存します. 成功した場合、作成した user\User モデルを返します.
     * 失敗した場合、 RuntimeException がスローされます.
     */
    function registerUser(UserCreator $creator, string $email): ?user\User {
        $user = new user\User(email: $email); // PHP 8 で追加された名前付き引数
        $creator->createUser($user);

        return $user;
    }
}
