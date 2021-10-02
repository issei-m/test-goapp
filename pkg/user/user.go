package user

import (
	"database/sql"
	"fmt"
)

type User struct {
	ID    int64
	Email string
}

type Repository struct{ DB *sql.DB }

func (r *Repository) CreateUser(user *User) error {
	result, err := r.DB.Exec("INSERT INTO users(email) VALUES(?)", user.Email)
	if err != nil {
		return fmt.Errorf("database error %w", err)
	}

	id, err := result.LastInsertId()
	if err != nil {
		return fmt.Errorf("unable to get lastIsertId %w", err)
	}

	user.ID = id

	return nil
}
