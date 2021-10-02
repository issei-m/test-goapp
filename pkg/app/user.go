package app

import (
	"fmt"
	"goapp/pkg/user"
)

// RegisterUser email で user.User モデルを初期化し、 user.UserRepository を使って保存します. 成功した場合、作成した user.User モデルを返します.
func RegisterUser(repo *user.Repository, email string) (*user.User, error) {
	u := &user.User{Email: email}
	if err := repo.CreateUser(u); err != nil {
		return nil, fmt.Errorf("unable to create u %w", err)
	}
	return u, nil
}
