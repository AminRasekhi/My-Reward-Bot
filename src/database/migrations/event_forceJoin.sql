CREATE TABLE event_forceJoins(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    forceJoin_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (forceJoin_id) REFERENCES forceJoins(id) ON DELETE SET NULL
);