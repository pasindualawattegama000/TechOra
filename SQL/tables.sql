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