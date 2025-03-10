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
    farmer_id INT NOT NULL,                       -- ID of the farmer who posted the job (foreign key)
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
    FOREIGN KEY (farmer_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (worker_id) REFERENCES users(user_id) ON DELETE CASCADE
);


CREATE TABLE bids (
    bid_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    buyer_id INT NOT NULL,
    bid_amount DECIMAL(10,2) NOT NULL,
    bid_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES corn_products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE buyer_reviews_farmer (
    id INT AUTO_INCREMENT PRIMARY KEY,         -- Unique ID for each review
    review_text TEXT NOT NULL,                 -- Stores the review text
    rating INT NOT NULL,                       -- Stores the star rating (1 to 5)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    buyer_id INT NOT NULL,                    -- Farmer's ID (foreign key)
    farmer_id INT NOT NULL,                    -- Worker's ID (foreign key)
    FOREIGN KEY (buyer_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (farmer_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE orders_from_buyers (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT NOT NULL,
    buyer_id INT NOT NULL,
    product_id INT NOT NULL,  -- Added product_id
    bid_price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES corn_products(product_id) ON DELETE CASCADE -- Added foreign key for product_id
);


CREATE TABLE farmer_add_products_notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,  -- Buyer or admin who should be notified
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,  -- 0 = Unread, 1 = Read
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


DELIMITER $$

CREATE TRIGGER after_product_insert
AFTER INSERT ON corn_products 
FOR EACH ROW
BEGIN
    -- Insert notification for all buyers (assuming all buyers get notified)
    INSERT INTO notifications_for_buyers (farmer_id, message)
    SELECT NEW.user_id, CONCAT('New Corn product added: ',' (', NEW.quantity, ' Kilograms)') 

END $$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER after_buyer_wins_bid
AFTER INSERT ON orders_from_buyers
FOR EACH ROW
BEGIN
    -- Insert notification for the buyer who won the bid
    INSERT INTO notifications_for_buyers (farmer_id,buyer_id, message)
    SELECT NEW.farmer_id, NEW.buyer_id,
           CONCAT('You Have Won quantity of ', NEW.quantity, 
                  ' (', NEW.quantity, ' Kilograms) At RS: ', NEW.bid_price, 
                  ' please pay within 24 hours to avoid your account getting restricted')
    FROM users 
    WHERE user_type = 'buyer' AND user_id = NEW.buyer_id;  -- Assuming buyer_id is in the new row

END $$

DELIMITER ;


DELIMITER //

CREATE EVENT insert_winners_every_minute
ON SCHEDULE EVERY 1 MINUTE
DO 
BEGIN
    -- Insert winners into the orders_from_buyers table
    INSERT INTO orders_from_buyers (
        farmer_id, buyer_id, bid_price, quantity, payment_status, order_date, order_closing_date, product_id
    )
    SELECT 
        p.user_id AS farmer_id, 
        b.buyer_id, 
        b.bid_amount AS bid_price, 
        p.quantity, 
        'pending', 
        CURRENT_TIMESTAMP, 
        CURRENT_TIMESTAMP + INTERVAL 1 DAY,  -- Adding 1 day to order_date
        p.product_id
    FROM 
        bids b
    JOIN (
        -- Find the maximum bid for each product
        SELECT product_id, MAX(bid_amount) AS max_bid
        FROM bids
        GROUP BY product_id
    ) max_bids 
        ON b.product_id = max_bids.product_id AND b.bid_amount = max_bids.max_bid
    JOIN corn_products p 
        ON b.product_id = p.product_id
    WHERE 
        p.closing_date <= NOW() -- Check if the auction has ended
        AND NOT EXISTS (
            -- Ensure no duplicate orders for the same product
            SELECT 1 
            FROM orders_from_buyers o 
            WHERE o.product_id = p.product_id
        );
END;

//

DELIMITER ;
