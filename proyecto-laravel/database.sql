CREATE DATABASE IF NOT EXISTS proyecto_laravel;
USE proyecto_laravel;

CREATE TABLE IF NOT EXISTS users(
    id int(255) auto_increment not null,
    role varchar(20),
    name varchar(100),
    surname varchar(200),
    nick varchar(100),
    email varchar(255),
    password varchar(255),
    image varchar(255),
    created_at datetime,
    updated_at datetime,
    remember_token varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDB;

INSERT INTO users VALUES(null, "user", "Gabriel", "Gutierrez", "gegutierrez", "gabogutz@gmail.com", "123", null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, "user", "Andreina", "Carrillo", "acarrillo", "acarrillo@gmail.com", "123", null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, "user", "Jose", "Andres", "jfrandres", "jfrandres@gmail.com", "123", null, CURTIME(), CURTIME(), null);

CREATE TABLE IF NOT EXISTS images(
    id int(255) auto_increment not null,
    user_id int(255),
    image_path varchar(255),
    description text,
    created_at datetime,
    updated_at datetime,
    CONSTRAINT pk_image PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDB;

INSERT INTO images VALUES(null, 1, "test.jpg", "test", CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, "playa.jpg", "Playa", CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, "rio.jpg", "Río", CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 3, "volcan.jpg", "Volcan", CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS comments(
    id int(255) auto_increment not null,
    user_id int(255),
    image_id int(255),
    content text,
    created_at datetime,
    updated_at datetime,
    CONSTRAINT pk_image PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

INSERT INTO comments VALUES(null, 1, 1, "Testeo increible", CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 1, 2, "Que playa tan bonita", CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 1, 3, "Que Río tan bonito", CURTIME(), CURTIME());
INSERT INTO comments VALUES(null, 3, 4, "Que Volcan tan bonito", CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(
    id int(255) auto_increment not null,
    user_id int(255),
    image_id int(255),
    created_at datetime,
    updated_at datetime,
    CONSTRAINT pk_like PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDB;

INSERT INTO likes VALUES(null, 1, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 1, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 1, 3, CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 3, 4, CURTIME(), CURTIME());

DROP TABLE IF EXISTS follows;
CREATE TABLE IF NOT EXISTS follows(
    id int(255) auto_increment not null,
    follower_id int(255) not null,
    following_id int(255) not null,
    created_at datetime not null DEFAULT '0000-00-00 00:00:00',
    updated_at datetime not null DEFAULT '0000-00-00 00:00:00',
    CONSTRAINT pk_follows PRIMARY KEY(id),
    UNIQUE KEY follow_unique (follower_id,following_id),
    CONSTRAINT fk_follows_users_follower FOREIGN KEY(follower_id) REFERENCES users(id),
    CONSTRAINT fk_follows_users_following FOREIGN KEY(following_id) REFERENCES users(id)
)ENGINE=InnoDB;

delimiter //
DROP TRIGGER IF EXISTS delete_likes_and_comments_of_image;
CREATE TRIGGER delete_likes_and_comments_of_image BEFORE delete ON images
FOR EACH ROW
BEGIN
DELETE FROM likes WHERE image_id = OLD.id;
DELETE FROM comments WHERE image_id = OLD.id;
END //
delimiter ;
