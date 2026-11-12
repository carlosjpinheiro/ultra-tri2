CREATE TABLE site_admin_users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(30) NOT NULL DEFAULT 'admin',
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY site_admin_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE site_admin_login_limits (
    key_hash CHAR(64) NOT NULL,
    bucket BIGINT UNSIGNED NOT NULL,
    attempts INT UNSIGNED NOT NULL,
    PRIMARY KEY (key_hash, bucket),
    KEY admin_limit_bucket (bucket)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
