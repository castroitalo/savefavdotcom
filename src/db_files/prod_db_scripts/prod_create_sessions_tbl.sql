USE savefavdotcom;

CREATE TABLE IF NOT EXISTS savefavdotcom.sessions (
    session_id VARCHAR(26) NOT NULL UNIQUE,
    session_data VARCHAR(250) NOT NULL,
    user_id BIGINT UNIQUE
);
