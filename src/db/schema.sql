DROP DATABASE IF EXISTS taskforce;

CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;

USE taskforce;

-- simple tables --

-- таблица городов
CREATE TABLE city
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    lat DECIMAL (11, 8),
    lng DECIMAL (11, 8)
);

-- файлы задач
CREATE TABLE file
(
    id  INT AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NULL
);

-- таблица категорий работ
CREATE TABLE category
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    icon VARCHAR(255) NOT NULL
);

-- main tables --

-- таблица пользователей
CREATE TABLE user
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    name           VARCHAR(255) NOT NULL,
    birth_date     TIMESTAMP,
    city_id        INT          NOT NULL,
    reg_date       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    avatar_file_id INT          NULL,
    email          VARCHAR(255) NOT NULL,
    password       VARCHAR(255) NOT NULL,
    phone          VARCHAR(50)  NOT NULL,
    telegram       VARCHAR(255) NOT NULL,
    done_task      INT          NULL,
    failed_task    INT          NULL,
    rating         DECIMAL      NULL,
    is_performer   BOOLEAN      NOT NULL,
    is_private     BOOLEAN   DEFAULT 0,
    is_free        BOOLEAN      NOT NULL,

    UNIQUE INDEX user_email (email),

    CONSTRAINT user_fk_city_id FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT user_fk_avatar_file_id FOREIGN KEY (avatar_file_id) REFERENCES file (id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- таблица зад/**/ач
CREATE TABLE task
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    public_date  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status       VARCHAR(128) NOT NULL,
    title        VARCHAR(255) NOT NULL,
    description  VARCHAR(255) NOT NULL,
    category_id  INT          NOT NULL,
    city_id      INT          NOT NULL,
    address      VARCHAR(255) NULL,
    location     POINT        NULL,
    price        INT UNSIGNED NULL,
    deadline     TIMESTAMP,
    customer_id  INT          NOT NULL,
    performer_id INT          NULL,

    CONSTRAINT task_fk_category_id FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT task_fk_customer_id FOREIGN KEY (customer_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT task_fk_performer_id FOREIGN KEY (performer_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT task_fk_city_id FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE CASCADE ON DELETE CASCADE

);
--

-- связь задач и файлов задач
CREATE TABLE task_file
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT NOT NULL,
    file_id INT NOT NULL,

    UNIQUE INDEX (task_id, file_id),
    FOREIGN KEY (task_id) REFERENCES task (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (file_id) REFERENCES file (id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- связь категорий работ и категорий исполнителей
CREATE TABLE user_perform_category
(
    user_id     INT NOT NULL,
    category_id INT NOT NULL,

    PRIMARY KEY (user_id, category_id),
    FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- отзывы на задания
CREATE TABLE review
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    grade       INT UNSIGNED NOT NULL,
    task_id     INT          NOT NULL,

    FOREIGN KEY (task_id) REFERENCES task (id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- отклики на задания
CREATE TABLE response
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    task_id     INT          NOT NULL,
    task_budget INT UNSIGNED NULL,
    user_id     INT          NOT NULL,
    comment     VARCHAR(255) NULL,
    create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    price       INT UNSIGNED NULL,
    is_blocked  BOOL     DEFAULT 0,

    FOREIGN KEY (task_id) REFERENCES task (id) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE
)
