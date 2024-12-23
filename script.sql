CREATE DATABASE The_Pierre_Palate;

USE The_Pierre_Palate;

CREATE TABLE Users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  
    role ENUM('client','chef') NOT NULL DEFAULT 'client');


CREATE TABLE Menus (
     id_menu INT PRIMARY KEY AUTO_INCREMENT,
     title VARCHAR(255) NOT NULL UNIQUE,
     description TEXT,
     price DECIMAL(10,2) NOT NULL);


CREATE TABLE Dishes (
	id_dish INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE
);	

     
CREATE TABLE bookings (
    id_bookings INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_menu INT NOT NULL,
    booking_time DATETIME NOT NULL,
    guests INT NOT NULL,
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    FOREIGN KEY (id_user) REFERENCES Users (id_user),
    FOREIGN KEY (id_menu) REFERENCES Menus (id_menu)
);

CREATE TABLE menu_dishes (
    id_menu INT NOT NULL,
    id_dish INT NOT NULL,
    PRIMARY KEY (id_menu, id_dish),
    FOREIGN KEY (id_menu) REFERENCES Menus (id_menu),
    FOREIGN KEY (id_dish) REFERENCES Dishes (id_dish)
);
