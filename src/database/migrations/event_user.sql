CREATE TABLE event_user(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    event_id INT,
    lottery_token INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);