CREATE TABLE IF NOT EXISTS questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    tags TEXT,
    votes INT DEFAULT 0,
    views INT DEFAULT 0,
    answers INT DEFAULT 0,
    is_answered TINYINT(1) DEFAULT 0,
    asked_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
    image_path TEXT,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(25) NOT NULL,
    last_name VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    status TINYINT(1) DEFAULT 1 COMMENT '1=Active, 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    votes INT DEFAULT 0,
    is_accepted BOOLEAN NOT NULL DEFAULT FALSE,
    answered_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
    question_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS user_votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    component_id INT NOT NULL,
    component_type ENUM('question', 'answer') NOT NULL,
    vote_direction ENUM('up', 'down') NOT NULL,
    UNIQUE KEY user_component_vote (user_id, component_id, component_type),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;






















CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(25) NOT NULL,
    last_name VARCHAR(25) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(200) NOT NULL,
    created DATETIME NOT NULL,
    modified DATETIME NOT NULL,
    status TINYINT(1) DEFAULT 1 COMMENT '1=Active, 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS questions (
    question_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    tags TEXT,
    views INT DEFAULT 0,
    answers INT DEFAULT 0,
    is_answered TINYINT(1) DEFAULT 0,
    asked_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
    image_path TEXT,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS answers (
    answer_id INT AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    is_accepted BOOLEAN NOT NULL DEFAULT FALSE,
    answered_dt DATETIME DEFAULT CURRENT_TIMESTAMP,
    question_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS user_votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    component_id INT NOT NULL,
    component_type ENUM('question', 'answer') NOT NULL,
    vote_direction ENUM('up', 'down') NOT NULL,
    UNIQUE KEY user_component_vote (user_id, component_id, component_type),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO users (first_name, last_name, email, password, created, modified, status) VALUES
('Alice', 'Johnson', 'a@gmail.com', MD5('pasindu900'), NOW(), NOW(), 1),
('Bob', 'Smith', 'b@gmail.com', MD5('pasindu900'), NOW(), NOW(), 1),
('Carol', 'White', 'c@gmail.com', MD5('pasindu900'), NOW(), NOW(), 1);


INSERT INTO questions (title, body, tags, views, answers, is_answered, asked_dt, user_id) VALUES
('How to reset a forgotten password in MySQL?', 'I forgot my MySQL root password. How can I reset it?', 'MySQL,Password,Reset', 150, 2, 1, NOW(), 1),
('Best practices for securing a REST API?', 'What are some of the best practices for securing a REST API?', 'API,Security,REST', 200, 3, 1, NOW(), 2),
('Handling concurrent requests in a web application?', 'How do you handle concurrent requests in a web application to avoid data inconsistency?', 'Web,Concurrency,Requests', 100, 1, 0, NOW(), 3);


INSERT INTO answers (body, is_accepted, answered_dt, question_id, user_id) VALUES
('You can reset it by restarting MySQL with a skip-grant-tables option, then reset the password.', TRUE, NOW(), 1, 2),
('Make sure to use HTTPS, authenticate users via tokens, and validate all inputs.', TRUE, NOW(), 2, 1),
('Use locking mechanisms or databases that support ACID properties to handle concurrency.', FALSE, NOW(), 3, 1);


INSERT INTO user_votes (user_id, component_id, component_type, vote_direction) VALUES
(1, 1, 'question', 'up'),
(2, 1, 'question', 'down'),
(3, 2, 'answer', 'up'),
(1, 3, 'question', 'up');
