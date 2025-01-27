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

CREATE TABLE bankaccounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    bank_name VARCHAR(100) NOT NULL,
    account_number VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


CREATE TABLE carddetails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name_on_card VARCHAR(100) NOT NULL,
    card_number VARCHAR(20) NOT NULL,
    expiry_date DATE NOT NULL,
    cvv VARCHAR(4) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


CREATE TABLE corn_products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    starting_price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    media VARCHAR(255) NOT NULL,
    closing_date DATETIME NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES farmers(user_id)
);

//changed
CREATE TABLE farmworkers (
    user_id INT(11) PRIMARY KEY,
    working_area VARCHAR(255) NOT NULL,  -- Location of the worker
    availability ENUM('Available', 'Unavailable') DEFAULT 'Available',  -- Availability status of the worker
    experience VARCHAR(50) ,  -- Work experience of the worker (e.g., '5+ years')
    skills TEXT,  -- A list of skills (can be stored as comma-separated values or JSON)
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE farmer_reviews_worker (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique ID for each review
    review_text TEXT NOT NULL,                 -- Stores the review text
    rating INT NOT NULL,                       -- Stores the star rating (1 to 5)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    farmer_id INT NOT NULL,                    -- Farmer's ID (foreign key)
    worker_id INT NOT NULL,                    -- Worker's ID (foreign key)
    FOREIGN KEY (farmer_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE job_requests (
    job_id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique identifier for each record
    worker_id INT NOT NULL,                   -- ID of the hired worker (foreign key)
    job_type ENUM('Irrigation Worker', 'Tractor Operator', 'Crop Worker') NOT NULL,  -- Job type with predefined options
    work_duration ENUM('Full Time', 'Part Time') NOT NULL, -- Work duration
    start_date DATE NOT NULL,                 -- Start date of the work
    end_date DATE NOT NULL,                   -- End date of the work
    skills TEXT NOT NULL,                     -- Skills required, stored as a comma-separated string
    location VARCHAR(255) NOT NULL,           -- Location of the work
    accommodation ENUM('Yes', 'No') NOT NULL, -- Accommodation availability
    food ENUM('Yes', 'No') NOT NULL,          -- Food availability
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp of record creation
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Timestamp of record update
    status ENUM('Pending', 'Confirmed', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (worker_id) REFERENCES users(user_id) ON DELETE CASCADE
);
