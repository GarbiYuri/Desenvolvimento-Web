
create database sistemadechat;

use sistemadechat;

CREATE TABLE IF NOT EXISTS usuario (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(50) null default null,
  email varchar(50) null default null,
  username VARCHAR(50) NULL DEFAULT NULL,
  password VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));
  
  create table if not exists message (
  message_id int primary key auto_increment,
  user_id_send int,
  user_id_get int,
  message varchar(255) not null,
  foreign key (user_id_send) references usuario(id),
  foreign key (user_id_get) references usuario(id)
  );