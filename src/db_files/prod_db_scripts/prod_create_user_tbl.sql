USE savefavdotcom;

CREATE TABLE IF NOT EXISTS savefavdotcom.users (
    user_id BIGINT NOT NULL AUTO_INCREMENT UNIQUE,
    user_email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(250) NOT NULL,
    user_created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    user_active TINYINT(1) DEFAULT 0,
    user_activation_code VARCHAR(255) NOT NULL,
    user_activation_expiry TIMESTAMP NOT NULL,
    user_activated_at TIMESTAMP,
    PRIMARY KEY (user_id)
);
