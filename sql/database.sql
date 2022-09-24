CREATE DATABASE IF NOT EXISTS psicotest
  DEFAULT CHARACTER SET utf8;
USE psicotest;

CREATE TABLE IF NOT EXISTS ranks(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  rank VARCHAR(30) NOT NULL UNIQUE,
  description VARCHAR(255) NOT NULL,
  create_at DATE NOT NULL,
  update_at DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS users(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(25) NOT NULL,
  surname_first VARCHAR(15) NOT NULL,
  surname_second VARCHAR(15) NOT NULL,
  password VARCHAR(255) NOT NULL,
  notes VARCHAR(255),
  rank INT NOT NULL,
  create_at DATE NOT NULL,
  update_at DATE NOT NULL,
  FULLTEXT KEY search(name, surname_first),
  FOREIGN KEY(rank)
    REFERENCES ranks(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS extras(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  gender ENUM('male', 'female') NOT NULL,
  country VARCHAR(30) NOT NULL,
  city VARCHAR(30) NOT NULL,
  address VARCHAR(255) NOT NULL,
  phone JSON,
  map_longitude VARCHAR(100),
  map_latitude VARCHAR(100),
  create_at DATE NOT NULL,
  update_at DATE NOT NULL,
  CHECK (JSON_VALID(phone)),
  user INT NOT NULL,
  FULLTEXT KEY search(country, city),
  FOREIGN KEY(user)
    REFERENCES users(id)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);
