package app

import (
	"fmt"
	"goapp/pkg/user"
)

type userCreator interface {
	CreateUser(user *user.User) error
}

// RegisterUser email で user.User モデルを初期化し、 userCreator を使って保存します. 成功した場合、作成した user.User モデルを返します.
func RegisterUser(repo userCreator, email string) (*user.User, error) {
	u := &user.User{Email: email}
	if err := repo.CreateUser(u); err != nil {
		return nil, fmt.Errorf("unable to create u %w", err)
	}
	return u, nil
}
