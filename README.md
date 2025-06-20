# PHP MySQL CRUD Application

A simple blog CRUD (Create, Read, Update, Delete) application built with PHP and MySQL.

## Features

- User authentication (register, login, logout)
- Create, read, update, and delete blog posts
- Search posts by title or content
- Pagination for posts listing
- Responsive UI with Bootstrap
- Custom styles via `assests/style.css`

## Folder Structure

```
crud-app/
│
├── assests/
│   └── style.css
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── register.php
├── config/
│   └── db.php
├── posts/
│   ├── create.php
│   ├── delete.php
│   └── update.php
├── index.php
└── README.md
```

## Setup Instructions

1. **Clone the repository:**
   ```sh
   git clone https://github.com/Purna-Sunkara/crud-app.git
   cd crud-app
   ```

2. **Create the database:**
   - Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Create a database named `blog` (or update `config/db.php` with your DB name).

3. **Create tables:**
   - In phpMyAdmin, run the following SQL to create the required tables:
     ```sql
     CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(255) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL
     );

     CREATE TABLE posts (
       id INT AUTO_INCREMENT PRIMARY KEY,
       title VARCHAR(255) NOT NULL,
       content TEXT NOT NULL
     );
     ```

4. **Configure database connection:**
   - Edit `config/db.php` with your local database credentials.

5. **Run the app:**
   - Place the project in your XAMPP `htdocs` folder.
   - Visit [http://localhost/crud-app](http://localhost/crud-app) in your browser.

## Custom Styles

- You can add or modify styles in `assests/style.css`.
- The app also uses Bootstrap for responsive design.

## License

This project is for educational purposes.

---

**Made with ❤️ by [Purna Sunkara](https://github.com/Purna-Sunkara)**
