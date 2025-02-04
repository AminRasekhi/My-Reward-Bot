CREATE TABLE users(
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NULL,
    username VARCHAR(255) NULL,
    step TEXT NULL,
    invited_by_user_id INT,
    tokens INT DEFAULT 0,
    invite_link TEXT NOT NULL UNIQUE,
    is_banned TINYINT DEFAULT 0 COMMENT '0 means not banned, 1 means is banned',
    is_admin TINYINT DEFAULT 0 COMMENT '0 means not admin, 1 means is admin',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL,

    FOREIGN KEY (invited_by_user_id) REFERENCES users(id) ON DELETE SET NULL
);