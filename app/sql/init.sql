-- Active: 1708420841815@@127.0.0.1@3306@shoesstore
DROP DATABASE IF EXISTS shoesstore;

CREATE DATABASE shoesstore;

USE shoesstore;

CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    email varchar(50) NOT NULL,
    name varchar(50) NOT NULL,
    phone varchar(10) DEFAULT NULL,
    gender tinyint NOT NULL DEFAULT "0",
    image varchar(255) DEFAULT NULL,
    role_id int,
    status enum('active', 'inactive', 'banned') not null DEFAULT "active",
    address varchar(255) NOT NUll,
    UNIQUE KEY email (email)
);

CREATE TABLE permissions (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL
);

CREATE TABLE roles (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name enum('admin', 'manager', 'employee') not null default "employee"
);

CREATE TABLE roles_permissions (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    permission_id int NOT NULL,
    role_id int
);

CREATE TABLE users_permissions (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    permission_id int NOT NULL,
    user_id int NOT NULL,
    status enum('active', 'inactive') NOT NULL DEFAULT "inactive"
);

CREATE TABLE customers (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    phone VARCHAR(11) DEFAULT NULL,
    email VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `orders` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `customer_id` INT,
    `user_id` INT,
    `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total_amount` DOUBLE NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `order_items` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `order_id` INT,
    `product_id` INT,
    `size_id` INT,
    `quantity` INT,
    `price` DOUBLE NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `payment_methods` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `method_name` VARCHAR(50),
    PRIMARY KEY (`id`)
);

CREATE TABLE `payments` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `order_id` INT,
    `method_id` INT,
    `payment_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `total_price` DOUBLE NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE categories (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(100) NOT NULL
);

CREATE TABLE products (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(100) NOT NULL,
    category_id INT not NULL,
    price DOUBLE NOT NULL,
    description text NOT NULL,
    image varchar(255) NOT NULL,
    gender int not null DEFAULT 1
);

CREATE TABLE import (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_price double NOT NULL,
    import_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE import_items (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    import_id INT NOT NULL,
    product_id INT NOT NULL,
    size_id int,
    quantity INT NOT NULL,
    price double NOT NULL
);

CREATE TABLE `sizes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `size_items` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `product_id` INT,
    `size_id` INT,
    `quantity` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
);

-- Cart
CREATE TABLE carts (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id int NOT NULL,
    product_id int NOT NULL,
    quantity int NOT NULL
);

CREATE TABLE settings (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name text NOT NULL,
    value text NOT NULL
);

CREATE TABLE reviews (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id int NOT NULL,
    product_id int NOT NULL,
    content text NOT NULL,
    rating int NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE review_status (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    status INT NOT NULL
);

CREATE TABLE coupons (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL,
    quantity int NOT NULL,
    required int(11) NOT NULL,
    percent int(3) NOT NULL,
    expired date NOT NULL,
    description VARCHAR(255) NOT NULL,
    deleted_at DATETIME DEFAULT NULL
);