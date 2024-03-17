CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `tags` TEXT, -- Here is the added tags column
  `votes` INT DEFAULT 0,
  `views` INT DEFAULT 0,
  `is_answered` BOOLEAN NOT NULL DEFAULT FALSE,
  `asked_dt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Updated to have a default value
  `image_path` TEXT,
  `user_id` INT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
