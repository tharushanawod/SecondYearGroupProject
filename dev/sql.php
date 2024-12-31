CREATE TABLE farmworkers (
    user_id INT(11) PRIMARY KEY,
    working_area VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE manufacturers (
    user_id INT(11) PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    document_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);
