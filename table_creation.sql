CREATE TABLE `only_project`.`users` (
  `Id` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(150) NOT NULL,
  `PhoneNumber` CHAR(11) NOT NULL,
  `Email` VARCHAR(100) NOT NULL,
  `Password` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE INDEX `Email_UNIQUE` (`Email` ASC) VISIBLE,
  UNIQUE INDEX `PhoneNumber_UNIQUE` (`PhoneNumber` ASC) VISIBLE);