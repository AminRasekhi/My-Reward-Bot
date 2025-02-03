CREATE TABLE events(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    description  VARCHAR(255) NULL,
    rules_description  VARCHAR(255) NULL,
    award_count VARCHAR(255) NULL,
    award_unit VARCHAR(255) NULL,
    status TINYINT DEFAULT 0 COMMENT '0 means disable, 1 means enable',
    start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_date TIMESTAMP NULL,
 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL,
    deleted_at TIMESTAMP NULL

);