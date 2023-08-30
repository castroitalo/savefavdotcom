USE savefavdotcom;

CREATE TABLE IF NOT EXISTS savefavdotcom.favs (
    fav_id BIGINT NOT NULL AUTO_INCREMENT UNIQUE,
    fav_url TEXT NOT NULL,
    user_id BIGINT NOT NULL,
    PRIMARY KEY (fav_id),
    FOREIGN KEY (user_id) REFERENCES (savefavdotcom.users)
);
