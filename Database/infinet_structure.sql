CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `document` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL CHECK (`state` IN (0, 1)),
  UNIQUE KEY `unique_document` (`document`),
  UNIQUE KEY `unique_phone` (`phone`),
  UNIQUE KEY `unique_email` (`email`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `client_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` tinyint(4) NOT NULL CHECK (`state` IN (0, 1, 2, 3)),
  `installation` tinyint(1) NOT NULL CHECK (`installation` IN (0, 1)),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `client_service_id` int(11) NOT NULL,
  `type` int(11) NOT NULL CHECK (`type` BETWEEN 0 AND 4),
  `price_service` decimal(10,2) NOT NULL,
  `price_installation` decimal(10,2),
  `surcharge` decimal(10,2),
  `state` int(11) NOT NULL CHECK (`state` BETWEEN 0 AND 3),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` decimal(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `stock` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL UNIQUE,
  `type` varchar(255) NOT NULL,
  `upload_speed` int(11) NOT NULL,
  `download_speed` int(11) NOT NULL,
  `monthly_fee` decimal(10,2) NOT NULL,
  `installation_fee` decimal(10,2) NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `technical_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `problem` text NOT NULL,
  `status` int(11) NOT NULL CHECK (`status` BETWEEN 0 AND 4),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` int(11) NOT NULL CHECK (`type` BETWEEN 0 AND 2),
  `client_service_id` int(11) NOT NULL,
  `technician_id` int(11),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`),
  FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `technical_request_details` (
  `id` int(11) NOT NULL,
  `technical_request_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity_used` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_number` char(6) NOT NULL,
  `employee_password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `client_services`
  ADD CONSTRAINT `client_services_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `client_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`);

ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_service_price` FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`),
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`);

ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

ALTER TABLE `purchase_orders`
  ADD CONSTRAINT `fk_purchase_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `technical_requests`
  ADD CONSTRAINT `technical_requests_ibfk_1` FOREIGN KEY (`client_service_id`) REFERENCES `client_services` (`id`),
  ADD CONSTRAINT `technical_requests_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`id`);

ALTER TABLE `technical_request_details`
  ADD CONSTRAINT `technical_request_details_ibfk_1` FOREIGN KEY (`technical_request_id`) REFERENCES `technical_requests` (`id`),
  ADD CONSTRAINT `technical_request_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
