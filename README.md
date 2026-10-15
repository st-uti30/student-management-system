# Student Management — Relational CRUD & User Management

PHP + MySQL project updated to follow the Session 6 module.

## Files
- `config.php`: MySQL connection
- `schema_fresh_install.sql`: schema for a fresh/empty database only
- `seed_admin.php`: creates the first admin once; delete it immediately after running
- `auth.php`, `navbar.php`, `login.php`, `logout.php`: authentication and shared navigation
- `index.php`, `create.php`, `edit.php`, `delete.php`: relational student CRUD
- `users.php`: admin-only user creation/listing

## Setup in XAMPP
1. Back up your current database before changing its structure.
2. Put this folder in `E:\xampp\htdocs\Student` (or your XAMPP `htdocs` folder).
3. Start Apache and MySQL in XAMPP.
4. Open phpMyAdmin at `http://localhost/phpmyadmin`.
5. If you are setting up a **new/empty** database, import `schema_fresh_install.sql`. **Do not import this fresh-install schema over your existing database without a backup**, because table creation/data may conflict.
6. For the existing Session 1–2 database, follow the migration instructions in your class module: back up first; create `majors`; migrate the old `students.major` text field to `major_id`; create `users`. The module's example truncates practice student data before altering the table, so save any data you need before doing that.
7. Check the values in `config.php` match your local MySQL setup.
8. Open `http://localhost/Student/seed_admin.php` **once**. Default account: username `admin`, password `admin123`.
9. Immediately delete `seed_admin.php` from the project folder.
10. Open `http://localhost/Student/login.php` and sign in. Create a staff account from the **Users** page, then test both roles.

## Role rules
- Admin: view, add, edit, delete students, and manage users.
- Staff: view, add, and edit students; cannot delete students or manage users.

## Before GitHub submission
- Do not commit real passwords, secrets, or private database credentials.
- Test login, add/edit student, staff restrictions, logout, and SQL injection/XSS protections locally.
- Commit all required PHP files and README to your repository.

For the existing database, `migration_existing_db.sql` reproduces the module's migration sequence. Read its warning first: it truncates the current `students` table and drops its old `major` column. Back up the database and only run it if clearing the existing practice data is acceptable. If `majors` or `users` already exist, do not run it unchanged.
