DROP DATABASE IF EXISTS taskforce;

CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE taskforce;

-- таблица задач
CREATE TABLE task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    public_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(128) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    category_id INT NOT NULL,
    location POINT NULL,
    budget UNSIGNED INT NULL,
    deadline TIMESTAMP,
    file VARCHAR(255) NULL,
    customer_id INT NOT NULL,
    performer_id INT NULL,

    CONSTRAINT task_fk_category_id FOREIGN KEY (category_id) REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE,
);

--таблица пользователей
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    telegram VARCHAR(255) NOT NULL,
    is_performer BOOLEAN NOT NULL,

    UNIQUE INDEX user_email (email)
)

--дополение для профилей исполнителей
CREATE TABLE user_perform(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    birth_date TIMESTAMP,
    avatar VARCHAR(255) NULL,
    speciality VARCHAR(255) NULL,
    done_task INT NULL,
    failed_task INT NULL,
    rating DECIMAL NULL,
    user_status BOOLEAN NOT NULL,

    CONSTRAINT user_perform_fk_user_id FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE,
);
-----

--файлы задач
CREATE TABLE file(
    id INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NULL
);

--связь задач и файлов задач
CREATE TABLE task_file(
    task_id INT NOT NULL,
    file_id INT NOT NULL,

    PRIMARY KEY (task_id, file_id),
    FOREIGN KEY (task_id) REFERENCES task(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (file_id) REFERENCES file(id) ON UPDATE CASCADE ON DELETE CASCADE,
);

-- таблица городов
CREATE TABLE city(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    coordinates POINT NOT NULL
);

--таблица категорий работ
CREATE TABLE category(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

--связь категорий работ и категорий исполнителей
CREATE TABLE user_perform_category(
    user_id INT NOT NULL,
    category_id INT NOT NULL,

    PRIMARY KEY (user_id, category_id),
    FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category(id) ON UPDATE CASCADE ON DELETE CASCADE,
);

--связь задач и исполнителей для отклика
CREATE TABLE performer_task(
    task_id INT NOT NULL,
    user_id INT NOT NULL,

    PRIMARY KEY (task_id, user_id),
    FOREIGN KEY (task_id) REFERENCES task(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
);

--отклики на задания
CREATE TABLE respond_task (
    task_id INT NOT NULL,
    task_budget UNSIGNED NULL,
    user_id INT NOT NULL,
    comment VARCHAR(255) NULL,

    PRIMARY KEY (task_id, user_id)
    FOREIGN KEY (task_id) REFERENCES task(id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(id) ON UPDATE CASCADE ON DELETE CASCADE
)