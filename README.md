# PHP CRUD Web App with User Authentication

A simple blog-style web application built with PHP and MySQL that supports full CRUD operations (Create, Read, Update, Delete) and basic user authentication.

## 🚀 Features

- User registration and login with password hashing
- Session-based authentication (login/logout)
- Create new blog posts
- Read/display all posts on the home page
- Update existing posts
- Delete posts (only by the post creator)
- GitHub version control with a clean folder structure

## 🧱 Folder Structure

crud-app/
├── index.php ← Displays all blog posts
├── config/
│ └── db.php ← MySQL connection setup
├── auth/
│ ├── login.php ← User login form
│ └── register.php ← User registration form
├── posts/
│ ├── create.php ← Create new post
│ ├── update.php ← Edit existing post
│ └── delete.php ← Delete a post
└── README.md


## 🛠️ Technologies Used

- PHP (Procedural)
- MySQL
- HTML/CSS
- Apache (via XAMPP)
- Git & GitHub for version control

## ⚙️ How to Run Locally

1. Install [XAMPP](https://www.apachefriends.org/)
2. Start Apache & MySQL from the XAMPP Control Panel
3. Navigate to http://localhost/phpmyadmin/
4. Create a new database named `blog`
5. Create two tables:

```sql
-- Users Table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL
);

-- Posts Table
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

github 
git init
git add .
git commit -m "Initial commit - PHP CRUD App"
git branch -M main
git remote add origin https://github.com/yourusername/your-repo.git
git push -u origin main
