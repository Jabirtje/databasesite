CREATE DATABASE IF NOT EXISTS netland;
USE netland;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES
('admin', '$2y$10$lvXLwpsu7qp6H52gWnuYWOF2Trfmr21ou0m9IkdyPlqLXPfpLX3Nu'); -- wachtwoord is admin
