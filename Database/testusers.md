´´´sql
CREATE TABLE `users` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`employee_number` CHAR(6) NOT NULL,
`employee_password` VARCHAR(255) NOT NULL,
`first_name` VARCHAR(50) NOT NULL,
`last_name` VARCHAR(50) NOT NULL,
`email` VARCHAR(100) NOT NULL,
`phone` VARCHAR(20) NOT NULL,
`role` INT(1) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

´´´