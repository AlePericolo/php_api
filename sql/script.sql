CREATE TABLE `api_test`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
PRIMARY KEY (`id`));

CREATE TABLE `api_test`.`wishlist` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `title_wishlist` VARCHAR(45) NOT NULL,
  `number_of_items` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_wishlist_1_idx` (`user_id` ASC),
  CONSTRAINT `fk_wishlist_1`
    FOREIGN KEY (`user_id`)
    REFERENCES `api_test`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
