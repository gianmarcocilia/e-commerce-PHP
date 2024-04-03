CREATE TABLE `categories` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id`)
);

CREATE TABLE `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `category_id` INT NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.50',
  `img` VARCHAR(255) NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY (`category_id`) REFERENCES categories(`id`)
);

CREATE TABLE carts (
    `id` INT NOT NULL AUTO_INCREMENT,
    `client_id` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id`)
);

CREATE TABLE cart_product (
    `id` INT NOT NULL AUTO_INCREMENT,
    `cart_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY (`cart_id`) REFERENCES carts(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES products(`id`) ON DELETE CASCADE
);

CREATE TABLE roles (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

INSERT INTO roles (`id`, `name`) VALUES (1, 'Admin'), (2, 'Customer');

CREATE TABLE users (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role_id` INT NOT NULL DEFAULT '2',
    PRIMARY KEY(`id`),
    FOREIGN KEY (`role_id`) REFERENCES roles(`id`)
);

INSERT INTO users (`name`, `email`, `password`, `role_id`) VALUES ('Admin User', 'admin@gmail.com', MD5('password'), 1), ('Customer User', 'customer@gmail.com', MD5('password'), 2);

CREATE TABLE `discounts` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(15) NOT NULL,
    `discount` DECIMAL(3,2) NOT NULL,
    PRIMARY KEY(`id`)
);

INSERT INTO discounts (`code`, `discount`) VALUES ('discount-15', 0.15), ('discount-20', 0.20);

CREATE TABLE `addresses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL DEFAULT NULL,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `street` VARCHAR(255) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  `cap` VARCHAR(5) NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`user_id`) REFERENCES users(`id`) ON DELETE SET NULL
);

CREATE TABLE `orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL DEFAULT NULL,
  `address_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` VARCHAR(50) NOT NULL,
  `tot_price` decimal(11,2) NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`user_id`) REFERENCES users(`id`),
  FOREIGN KEY(`address_id`) REFERENCES addresses(`id`)
);

CREATE TABLE `order_product` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  PRIMARY KEY(`id`),
  FOREIGN KEY(`order_id`) REFERENCES orders(`id`),
  FOREIGN KEY(`product_id`) REFERENCES products(`id`)
);


