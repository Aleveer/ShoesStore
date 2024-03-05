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
    address varchar(100) NOT NUll,
    created_at datetime DEFAULT NULL,
    deleted_at datetime DEFAULT NULL,
    UNIQUE KEY email (email)
);

CREATE TABLE permissions (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL,
    deleted_at datetime DEFAULT NULL
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
    status enum('active', 'inactive') NOT NULL DEFAULT "inactive",
    FOREIGN KEY (permission_id) REFERENCES permissions (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE `customers` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(10) NOT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`)
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
    quantity int NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id)
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
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (product_id) REFERENCES products (id)
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

-- Roles_Permissions Table
ALTER TABLE
    roles_permissions
ADD
    CONSTRAINT fk_role_id_roles_permissions FOREIGN KEY (role_id) REFERENCES roles(id),
ADD
    CONSTRAINT fk_permission_id_roles_permissions FOREIGN KEY (permission_id) REFERENCES permissions(id);

-- Users_Permissions Table
ALTER TABLE
    users_permissions
ADD
    CONSTRAINT fk_permission_id_users_permissions FOREIGN KEY (permission_id) REFERENCES permissions(id),
ADD
    CONSTRAINT fk_user_id_users_permissions FOREIGN KEY (user_id) REFERENCES users(id);

-- Orders Table
ALTER TABLE
    orders
ADD
    CONSTRAINT fk_customer_id_orders FOREIGN KEY (customer_id) REFERENCES customers(id),
ADD
    CONSTRAINT fk_user_id_orders FOREIGN KEY (user_id) REFERENCES users(id);

-- Order_Items Table
ALTER TABLE
    order_items
ADD
    CONSTRAINT fk_order_id_order_items FOREIGN KEY (order_id) REFERENCES orders(id),
ADD
    CONSTRAINT fk_product_id_order_items FOREIGN KEY (product_id) REFERENCES products(id),
ADD
    CONSTRAINT fk_size_id_order_items FOREIGN KEY (size_id) REFERENCES sizes(id);

-- Payments Table
ALTER TABLE
    payments
ADD
    CONSTRAINT fk_order_id_payments FOREIGN KEY (order_id) REFERENCES orders(id),
ADD
    CONSTRAINT fk_method_id_payments FOREIGN KEY (method_id) REFERENCES payment_methods(id);

-- Import Table
ALTER TABLE
    import
ADD
    CONSTRAINT fk_user_id_import FOREIGN KEY (user_id) REFERENCES users(id);

-- Import_Items Table
ALTER TABLE
    import_items
ADD
    CONSTRAINT fk_import_id_import_items FOREIGN KEY (import_id) REFERENCES import(id),
ADD
    CONSTRAINT fk_product_id_import_items FOREIGN KEY (product_id) REFERENCES products(id),
ADD
    CONSTRAINT fk_size_id_import_items FOREIGN KEY (size_id) REFERENCES sizes(id);

-- Size_Items Table
ALTER TABLE
    size_items
ADD
    CONSTRAINT fk_product_id_size_items FOREIGN KEY (product_id) REFERENCES products(id),
ADD
    CONSTRAINT fk_size_id_size_items FOREIGN KEY (size_id) REFERENCES sizes(id);

-- Carts Table
ALTER TABLE
    carts
ADD
    CONSTRAINT fk_user_id_carts FOREIGN KEY (user_id) REFERENCES users(id),
ADD
    CONSTRAINT fk_product_id_carts FOREIGN KEY (product_id) REFERENCES products(id);

-- Reviews Table
ALTER TABLE
    reviews
ADD
    CONSTRAINT fk_user_id_reviews FOREIGN KEY (user_id) REFERENCES users(id),
ADD
    CONSTRAINT fk_product_id_reviews FOREIGN KEY (product_id) REFERENCES products(id);

-- Review_Status Table
ALTER TABLE
    review_status
ADD
    CONSTRAINT fk_product_id_review_status FOREIGN KEY (product_id) REFERENCES products(id);

-- Products Table
ALTER TABLE
    products
ADD
    CONSTRAINT fk_category_id_products FOREIGN KEY (category_id) REFERENCES categories(id);

-- Coupons Table
ALTER TABLE
    coupons
ADD
    CONSTRAINT fk_required_coupons FOREIGN KEY (required) REFERENCES products(id);

ALTER TABLE
    users
ADD
    FOREIGN KEY (role_id) REFERENCES roles (id);

-- Categories Table
ALTER TABLE
    categories
ADD
    CONSTRAINT fk_product_id_categories FOREIGN KEY (id) REFERENCES products(category_id);