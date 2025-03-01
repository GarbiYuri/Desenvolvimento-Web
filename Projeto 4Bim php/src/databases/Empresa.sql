create database empresa;

use empresa;

create table usuario(
    id int primary key auto_increment,
    username varchar(50), 
    passwords varchar(255));

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
