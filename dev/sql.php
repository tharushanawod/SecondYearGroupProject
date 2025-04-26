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


CREATE TABLE withdrawals (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id int NOT NULL,
    withdrawal_amount DECIMAL(10, 2) NOT NULL,
    farmer_confirmed BOOLEAN DEFAULT FALSE,  -- Indicates if the farmer confirmed
    buyer_confirmed BOOLEAN DEFAULT FALSE,  -- Indicates if the buyer confirmed
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    withdrawal_status ENUM('Pending', 'Confirmed', 'Rejected') DEFAULT 'Pending',
    FOREIGN KEY (order_id) REFERENCES orders_from_buyers(order_id)
);


CREATE TABLE restriction_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reason VARCHAR(255) NOT NULL,
    logged_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


DELIMITER //
CREATE EVENT IF NOT EXISTS check_order_expiration
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN
    -- Update only pending orders that expired
    UPDATE orders_from_buyers
    SET payment_status = 'failed'
    WHERE order_closing_date < NOW()
      AND payment_status = 'pending';

    -- Insert logs for restricted users (only for newly failed orders)
    INSERT INTO restriction_logs (user_id, reason)
    SELECT DISTINCT o.buyer_id,
           CONCAT('Order ID ', o.order_id, ' expired without payment') AS reason
    FROM orders_from_buyers o
    JOIN users u ON u.user_id = o.buyer_id
    WHERE o.order_closing_date < NOW()
      AND o.payment_status = 'failed'
      AND u.user_status <> 'restricted';

    -- Restrict users who failed payment
    UPDATE users u
    JOIN orders_from_buyers o ON u.user_id = o.buyer_id
    SET u.user_status = 'restricted'
    WHERE o.order_closing_date < NOW()
      AND o.payment_status = 'failed';
END //
DELIMITER ;


CREATE TABLE wallets (
    wallet_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    balance DECIMAL(10,2) DEFAULT 0.00,
    last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);


DELIMITER //

CREATE EVENT add_to_wallet_every_minute
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN
    -- 1. Update wallet balances
    UPDATE wallets w
    JOIN (
        SELECT o.farmer_id, SUM(b.paid_amount) AS total_amount
        FROM buyer_payments b
        JOIN orders_from_buyers o ON b.order_id = o.order_id
        WHERE b.buyer_confirmed = 1
          AND b.farmer_confirmed = 1
          AND b.wallet_status = 'not_added'
        GROUP BY o.farmer_id
    ) AS t ON w.user_id = t.farmer_id
    SET w.balance = w.balance + t.total_amount;

    -- 2. Mark those payments as 'added'
    UPDATE buyer_payments
    SET wallet_status = 'added'
    WHERE buyer_confirmed = 1 AND farmer_confirmed = 1 AND wallet_status = 'not_added';
END;
//

DELIMITER ;

DELIMITER //

CREATE TRIGGER extend_closing_time_if_sniped
AFTER INSERT ON bids
FOR EACH ROW
BEGIN
    DECLARE bid_time DATETIME;
    DECLARE closing_time DATETIME;

    -- Get the time of the new bid
    SET bid_time = NEW.bid_time;

    -- Get the closing date of the product
    SELECT closing_date INTO closing_time
    FROM corn_products
    WHERE product_id = NEW.product_id;

    -- Check if the bid was placed in the last 5 minutes
    IF TIMESTAMPDIFF(MINUTE, bid_time, closing_time) BETWEEN 0 AND 5 THEN
        -- Extend closing time by 5 minutes
        UPDATE corn_products
        SET closing_date = DATE_ADD(closing_date, INTERVAL 5 MINUTE)
        WHERE product_id = NEW.product_id;
    END IF;
END;
//

DELIMITER ;


CREATE EVENT auto_complete_jobs
ON SCHEDULE EVERY 1 HOUR
DO
  UPDATE job_requests
  SET status = 'Completed'
  WHERE status = 'Confirmed' AND end_date < NOW();




  
  CREATE TABLE transaction (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    payment_method VARCHAR(50),
    amount_paid DECIMAL(10, 2),
    payment_date DATETIME,
    withdraw_status ENUM('not_withdrawn', 'withdrawn') DEFAULT 'not_withdrawn',
    wallet_status ENUM('not_added', 'added') DEFAULT 'not_added',
    delivery_confirmed BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);


CREATE TABLE delivery_codes (
    code_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    code VARCHAR(10) NOT NULL,
    company VARCHAR(10) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);


DELIMITER //

CREATE EVENT IF NOT EXISTS relist_unpaid_products_every_minute
ON SCHEDULE EVERY 1 MINUTE
DO
BEGIN
  INSERT INTO corn_products (starting_price, quantity, media, user_id, closing_date, created_at)
  SELECT
    cp.starting_price,
    cp.quantity,
    cp.media,
    cp.user_id,
    DATE_ADD(NOW(), INTERVAL 7 DAY),
    NOW()
  FROM corn_products cp
  LEFT JOIN orders_from_buyers ofb ON cp.product_id = ofb.product_id
  LEFT JOIN bids b ON cp.product_id = b.product_id
  WHERE cp.is_relisted = 0
    AND (
      (ofb.payment_status = 'pending' AND ofb.order_closing_date < NOW())
      OR (cp.closing_date < NOW() AND b.product_id IS NULL)
    );

  -- Mark original products as relisted
  UPDATE corn_products cp
  LEFT JOIN orders_from_buyers ofb ON cp.product_id = ofb.product_id
  LEFT JOIN bids b ON cp.product_id = b.product_id
  SET cp.is_relisted = 1
  WHERE cp.is_relisted = 0
    AND (
      (ofb.payment_status = 'pending' AND ofb.order_closing_date < NOW())
      OR (cp.closing_date < NOW() AND b.product_id IS NULL)
    );
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER add_notification_after_job_request_for_worker
AFTER INSERT ON job_requests
FOR EACH ROW
BEGIN
  INSERT INTO notification_for_users (user_id, message)
  VALUES (
     NEW.worker_id,
     CONCAT('You have a new Job request from ', NEW.farmer_id)
  );
END;
//

DELIMITER ;


DELIMITER $$

CREATE EVENT auto_add_to_supplier_wallet
ON SCHEDULE EVERY 1 DAY
DO
BEGIN
  -- Step 1: Update wallet_status to 'added' after 14 days
  UPDATE order_items oi
  JOIN transaction t ON t.order_id = oi.order_id
  SET oi.wallet_status = 'added'
  WHERE oi.wallet_status != 'added'
    AND DATE_ADD(t.payment_date, INTERVAL 14 DAY) <= NOW()
    AND oi.refund_status = 'no'; -- Only items with refund_status = 'no'

  -- Step 2: Add amount to supplier's wallet (quantity * price + 350 per supplier per order)
  UPDATE wallets w
  JOIN (
    SELECT 
      sp.supplier_id AS user_id,
      SUM(oi.quantity * oi.price + 350.00) AS total_amount
    FROM order_items oi
    JOIN transaction t ON t.order_id = oi.order_id
    JOIN supplier_products sp ON sp.product_id = oi.product_id
    WHERE oi.wallet_status = 'added'  -- Only consider orders marked as 'added'
      AND oi.refund_status = 'no'  -- Only items with refund_status = 'no'
      AND oi.wallet_processed = 'no'  -- Only process items not yet added to wallet
    GROUP BY sp.supplier_id, oi.order_id
  ) AS updates ON updates.user_id = w.user_id
  SET w.balance = w.balance + updates.total_amount;

  -- Step 3: Mark processed items as 'wallet_processed = yes'
  UPDATE order_items oi
  JOIN transaction t ON t.order_id = oi.order_id
  SET oi.wallet_processed = 'yes'
  WHERE oi.wallet_status = 'added'
    AND oi.refund_status = 'no'
    AND oi.wallet_processed = 'no';

END$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER after_job_request_insert
AFTER INSERT ON job_requests
FOR EACH ROW
BEGIN
    INSERT INTO notifications_for_workers (user_id, message, is_read)
    VALUES (NEW.worker_id, 'You have a new job request.', FALSE);
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_new_order_happens
AFTER INSERT ON orders_from_buyers
FOR EACH ROW
BEGIN
  INSERT INTO notifications_for_users (user_id, message, is_read, created_at)
  VALUES (
    NEW.farmer_id, 
    CONCAT('You have a new order from Order ID: ', NEW.order_id),
    0,
    NOW()
  );
END$$

DELIMITER ;
