-- Fresh-install schema for db_school. Use only if creating a new/empty database.
CREATE DATABASE IF NOT EXISTS db_school CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_school;

CREATE TABLE majors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO majors (name) VALUES
('Informatics'), ('Information Systems'), ('Computer Science');

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(30) NOT NULL,
    name VARCHAR(100) NOT NULL,
    major_id INT NOT NULL,
    CONSTRAINT fk_students_major FOREIGN KEY (major_id) REFERENCES majors(id) ON DELETE RESTRICT
);

INSERT INTO students (nim, name, major_id) VALUES
('2301001', 'Andi Pratama', 1),
('2301002', 'Siti Rahma', 2),
('2301003', 'Budi Santoso', 1),
('2301004', 'Dewi Lestari', 3);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff'
);
