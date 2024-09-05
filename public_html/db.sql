CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30),
    email VARCHAR(100) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    phone VARCHAR(10),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME
);

CREATE TABLE orders (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    product_ids VARCHAR(255) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    phone VARCHAR(10),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME
);

CREATE TABLE employees (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    phone VARCHAR(10),
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME
);
