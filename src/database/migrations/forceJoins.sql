CREATE TABLE forceJoins(
    id INT AUTO_INCREMENT PRIMARY KEY,
    channel_id VARCHAR(255) NOT NULL,
    channel_name VARCHAR(255) NOT NULL,
    owner_user_id INT,
    type TINYINT DEFAULT 0 COMMENT '0=>channel, 1=>group, 2=>bot',
    status TINYINT DEFAULT 1 COMMENT '0=>disable , 1=>enalbe',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    expired_at TIMESTAMP NULL,

    FOREIGN KEY (owner_user_id) REFERENCES users(id) ON DELETE CASCADE
);  