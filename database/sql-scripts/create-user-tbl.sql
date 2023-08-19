USE savefavdotcom;

CREATE TABLE IF NOT EXISTS savefavdotcom.users (
    user_id BIGINT NOT NULL AUTO_INCREMENT UNIQUE,
    user_email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(250) NOT NULL,
    user_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_verified_email TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (user_id)
);
