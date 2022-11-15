CREATE TABLE `user`(
                       `id` INT PRIMARY KEY AUTO_INCREMENT,
                       `username` VARCHAR(255) NOT NULL,
                       `password` VARCHAR(255) NOT NULL
) ENGINE InnoDB;

CREATE TABLE `yachts`(
                         `id` INT PRIMARY KEY AUTO_INCREMENT,
                         `user_id` INT NOT NULL,
                         `params_id` INT NOT NULL,
                         `live_fuel` INT NOT NULL,
                         `live_energy` INT NOT NULL,
                         `live_traveld` INT NOT NULL
) ENGINE InnoDB;

CREATE TABLE `parameters`(
                             `id` INT PRIMARY KEY AUTO_INCREMENT,
                             `fuel` INT NOT NULL,
                             `energy` INT NOT NULL,
                             `traveld` INT NOT NULL,
                             `yacht_id` INT NOT NULL
) ENGINE InnoDB;

ALTER TABLE
    `yachts` ADD CONSTRAINT `yachts_user_id_foreign` FOREIGN KEY(`user_id`) REFERENCES `user`(`id`);
ALTER TABLE
    `yachts` ADD CONSTRAINT `yachts_params_id_foreign` FOREIGN KEY(`params_id`) REFERENCES `parameters`(`id`);