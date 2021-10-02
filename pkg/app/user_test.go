package app

import (
	"goapp/pkg/user"
	"testing"
)

type mockedUserRepository struct{}

func (r *mockedUserRepository) CreateUser(_ *user.User) error {
	return nil
}

func TestRegisterUser(t *testing.T) {
	creator := &mockedUserRepository{}
	u, err := RegisterUser(creator, "foo@example.com")
	if err != nil {
		t.Fatalf("err must not be presented, but presented: %v", err)
	}
	if u.Email != "foo@example.com" {
		t.Fatalf("u returned from the func must have the same email as we passed, but has: %s", u.Email)
	}
}
