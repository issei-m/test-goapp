package main

import (
	"database/sql"
	"fmt"
	_ "github.com/go-sql-driver/mysql"
	"goapp/pkg/app"
	"goapp/pkg/user"
)

func main() {
	db, err := sql.Open("mysql", "root@tcp(127.0.0.1:13306)/goapp")
	if err != nil {
		panic(err)
	}

	repo := &user.Repository{DB: db}

	user, err := app.RegisterUser(repo, "foo@example.com")
	if err != nil {
		panic(err)
	}

	fmt.Printf("created: %v", user)

	if err := repo.DeleteUserByID(user.ID); err != nil {
		panic(err)
	}

	fmt.Printf("deleted: %v", user)
}
