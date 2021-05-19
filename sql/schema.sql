CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE taskforce;



/*
Таблица содержит все доступные для задач категории
*/
CREATE TABLE category (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    icon VARCHAR(128) NOT NULL
);

/*
Все доступные города
*/
CREATE TABLE city (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    latitude VARCHAR(128) NOT NULL,
    longitude VARCHAR(128) NOT NULL
);

/*
Таблица пользователей, содержит информацию о пользователях
*/
CREATE TABLE user (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(128) NOT NULL,
    name VARCHAR(128) NOT NULL,
    city_id INT UNSIGNED NOT NULL,
    password VARCHAR(128) NOT NULL,
    avatar VARCHAR(128),
    description VARCHAR(512),
    address VARCHAR(256),
    birthday DATETIME,
    phone VARCHAR(128),
    skype VARCHAR(128),
    telegram VARCHAR(128),
    
    FOREIGN KEY (city_id) REFERENCES city (id)
);

/*
Содержит фото работ исполнителей
*/
CREATE TABLE portfolio (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(128) NOT NULL,
    user_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (user_id) REFERENCES user (id)
);

/*
Таблица с задчами, содержит всю информацию о задаче.
*/
CREATE TABLE task (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(128) NOT NULL,
    description VARCHAR(512),
    budget INT UNSIGNED,
    deadline TIMESTAMP,
    category_id INT UNSIGNED NOT NULL,
    owner_id INT UNSIGNED NOT NULL,
    city_id INT UNSIGNED,
    address VARCHAR(128),
    latitude VARCHAR(128) NOT NULL,
    longitude VARCHAR(128) NOT NULL,

    FOREIGN KEY (category_id) REFERENCES category (id),
    FOREIGN KEY (owner_id) REFERENCES user (id),
    FOREIGN KEY (city_id) REFERENCES city (id)
);

/*
Таблица с прекрипленными к задаче файлами
*/
CREATE TABLE task_file (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(128) NOT NULL,
    title VARCHAR(128) NOT NULL,
    task_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (task_id) REFERENCES task (id) 
);

/*
Таблица содержит все доступные специализации для пользователей
*/
CREATE TABLE specialization (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    specialization VARCHAR(128) NOT NULL
);

/*
Таблица содержит информацию о том какие специализации выбрали исполнители
*/
CREATE TABLE user_specialization (
    specialization_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    
    PRIMARY KEY (specialization_id, user_id),
    FOREIGN KEY (specialization_id) REFERENCES specialization (id),
    FOREIGN KEY (user_id) REFERENCES user (id)
);
/*
Таблица с отзывами о проделаной работе
*/

CREATE TABLE feedback (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    feedback VARCHAR(512) NOT NULL,
    rate INT UNSIGNED NOT NULL,
    user_who_id INT UNSIGNED NOT NULL,
    user_to_id INT UNSIGNED NOT NULL,
    feedback_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_who_id) REFERENCES user (id),
    FOREIGN KEY (user_to_id) REFERENCES user (id) 
);


/*
Таблица содержит отклик на задачу
*/
CREATE TABLE response (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    response_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description VARCHAR(1024),
    price INT UNSIGNED,
    user_from_id INT UNSIGNED NOT NULL,
    task_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (user_from_id)  REFERENCES user (id),
    FOREIGN KEY (task_id)  REFERENCES task (id)
);

/*
Таблица сообщений
*/
CREATE TABLE message (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content VARCHAR(512) NOT NULL,

    user_from_id INT UNSIGNED NOT NULL,
    user_to_id INT UNSIGNED NOT NULL,

    FOREIGN KEY (user_from_id) REFERENCES user (id),
    FOREIGN KEY (user_to_id) REFERENCES user (id) 
);


/*
Таблица содержит настройки аккаунта для пользователя
*/
CREATE TABLE user_setup (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    show_profile BOOLEAN DEFAULT 0,
    new_message_notification BOOLEAN,
    new_feedback_notification BOOLEAN,
    show_profile_only_to_client BOOLEAN DEFAULT 0,
    user_id INT UNSIGNED NOT NUll,

    FOREIGN KEY (user_id) REFERENCES user (id)
);