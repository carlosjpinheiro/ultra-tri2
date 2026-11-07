CREATE TABLE staff_registrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_year SMALLINT UNSIGNED NOT NULL,
    name VARCHAR(180) NOT NULL,
    email VARCHAR(254) NOT NULL,
    birth_date DATE NOT NULL,
    answers JSON NOT NULL,
    specification_version VARCHAR(40) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY staff_event_email (event_year, email),
    KEY staff_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE site_request_limits (
    client_hash CHAR(64) NOT NULL,
    bucket BIGINT UNSIGNED NOT NULL,
    attempts INT UNSIGNED NOT NULL,
    PRIMARY KEY (client_hash, bucket),
    KEY site_limit_bucket (bucket)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
