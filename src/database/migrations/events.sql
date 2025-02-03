CREATE TABLE events(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    description  VARCHAR(255) NULL,
    description_to_join_lottery  VARCHAR(255) NULL,
    status TINYINT DEFAULT 1 COMMENT '0 means disable, 1 means enable',
    start_date TIMESTAMP NULL,
    end_date TIMESTAMP NULL,
 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL

);