CREATE DATABASE IF NOT EXISTS agriadvisory
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE agriadvisory;

CREATE TABLE IF NOT EXISTS farmers (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    fullname      VARCHAR(255)        NOT NULL,
    email         VARCHAR(255)        NOT NULL UNIQUE,
    phone         VARCHAR(20),
    password      VARCHAR(255)        NOT NULL,
    address       TEXT,
    land_area     DECIMAL(10,2)       DEFAULT 0,
    service       VARCHAR(100),
    state         VARCHAR(100),
    district      VARCHAR(100),
    pincode       VARCHAR(10),
    is_active     TINYINT(1)          DEFAULT 1,
    created_at    TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP           DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS farmer_privacy_settings (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id       INT           NOT NULL UNIQUE,
    share_soil_data TINYINT(1)    DEFAULT 1,
    weather_sms     TINYINT(1)    DEFAULT 1,
    store_cookies   TINYINT(1)    DEFAULT 1,
    updated_at      TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS products (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(255)        NOT NULL,
    description   TEXT,
    price         DECIMAL(10,2)       NOT NULL,
    category      VARCHAR(100),
    unit          VARCHAR(50),
    stock_qty     INT                 DEFAULT 100,
    image         VARCHAR(255),
    supplier      VARCHAR(255)        DEFAULT 'AgriAdvisory Hub',
    is_available  TINYINT(1)          DEFAULT 1,
    created_at    TIMESTAMP           DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id       INT,
    customer_name   VARCHAR(255)        NOT NULL,
    phone           VARCHAR(20)         NOT NULL,
    address         TEXT                NOT NULL,
    items           TEXT                NOT NULL,
    total           DECIMAL(10,2)       NOT NULL,
    payment_mode    VARCHAR(50)         DEFAULT 'Cash on Delivery',
    status          VARCHAR(50)         DEFAULT 'pending',
    notes           TEXT,
    created_at      TIMESTAMP           DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP           DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    order_id     INT             NOT NULL,
    product_id   INT,
    product_name VARCHAR(255)   NOT NULL,
    unit_price   DECIMAL(10,2)  NOT NULL,
    quantity     INT             DEFAULT 1,
    line_total   DECIMAL(10,2)  AS (unit_price * quantity) STORED,
    FOREIGN KEY (order_id)   REFERENCES orders(id)   ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS soil_tests (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id           INT,
    soil_type           VARCHAR(50)     NOT NULL,
    ph_value            DECIMAL(4,2),
    nitrogen_mg_kg      DECIMAL(8,2),
    phosphorus_mg_kg    DECIMAL(8,2),
    potassium_mg_kg     DECIMAL(8,2),
    moisture_percent    DECIMAL(5,2),
    organic_matter      DECIMAL(5,2),
    recommended_crop    VARCHAR(255),
    recommendation_note TEXT,
    farm_location       VARCHAR(255),
    tested_at           TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS weather_logs (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    location_name       VARCHAR(255),
    temperature_c       DECIMAL(5,2),
    condition_text      VARCHAR(100),
    humidity_percent    DECIMAL(5,2),
    wind_speed_kmh      DECIMAL(6,2),
    soil_temp_c         DECIMAL(5,2),
    precipitation_pct   DECIMAL(5,2),
    advisory_note       TEXT,
    logged_at           TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS advisory_experts (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(255)    NOT NULL,
    specialisation  VARCHAR(255),
    qualification   VARCHAR(255),
    experience_yrs  INT             DEFAULT 0,
    state_coverage  VARCHAR(255),
    contact_email   VARCHAR(255),
    contact_phone   VARCHAR(20),
    is_available    TINYINT(1)      DEFAULT 1,
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS advisory_requests (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id       INT,
    farmer_name     VARCHAR(255)    NOT NULL,
    farmer_phone    VARCHAR(20),
    farmer_email    VARCHAR(255),
    crop_type       VARCHAR(255),
    issue_desc      TEXT,
    preferred_date  DATE,
    expert_id       INT,
    status          VARCHAR(50)     DEFAULT 'pending',
    expert_notes    TEXT,
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id)  REFERENCES farmers(id)          ON DELETE SET NULL,
    FOREIGN KEY (expert_id)  REFERENCES advisory_experts(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS cart_sessions (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id    INT             NOT NULL,
    product_id   INT,
    product_name VARCHAR(255)   NOT NULL,
    unit_price   DECIMAL(10,2)  NOT NULL,
    quantity     INT             DEFAULT 1,
    added_at     TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id)  REFERENCES farmers(id)  ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS site_activity_log (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id   INT,
    action      VARCHAR(100)    NOT NULL,
    meta        TEXT,
    ip_address  VARCHAR(45),
    user_agent  VARCHAR(500),
    created_at  TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE SET NULL
);

INSERT INTO products (name, description, price, category, unit, stock_qty, image, supplier)
VALUES
  ('Premium Paddy Seeds (1 kg)',       'High-yield HYV paddy seeds suitable for Kharif season.',           249.00,  'Seeds',      '1 kg',     500, 'images/seeds_paddy.png',    'National Seeds Corporation'),
  ('NPK Fertilizer 5 kg Bag',          'Balanced 19-19-19 granulated fertilizer for all crops.',            595.00,  'Fertilizers','5 kg bag',  300, 'images/fertilizer_npk.png', 'IFFCO'),
  ('Stainless Steel Hand Tool Set',    'Trowel and cultivator set with hardwood handles.',                  385.00,  'Tools',      'Set of 3',  200, 'images/garden_tools.png',   'AgriAdvisory Hub'),
  ('Knapsack Sprayer 16 L',            'HDPE backpack sprayer with adjustable brass nozzle.',               990.00,  'Tools',      '16 Litre',  150, 'images/sprayer_pump.png',   'Kisancraft'),
  ('Drip Irrigation Kit (50 plants)',  'Complete drip kit — mainline, emitters and connectors.',           1250.00, 'Irrigation', 'Kit',       100, 'images/drip_irrigation.png','Netafim India'),
  ('Digital Soil pH & Moisture Tester','Instant-read dual meter for soil pH and moisture levels.',          749.00,  'Tools',      '1 Unit',    250, 'images/soil_tester.png',    'AgriAdvisory Hub')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO advisory_experts (name, specialisation, qualification, experience_yrs, state_coverage, contact_email)
VALUES
  ('Dr. Priya Nair',       'Soil Science & Fertility',  'Ph.D. Soil Science, ICAR',        14, 'Kerala, Karnataka, Tamil Nadu', 'priya.nair@agriadvisory.in'),
  ('Dr. Amit Kulkarni',    'Crop Protection & Pests',   'M.Sc. Plant Pathology, IARI',     10, 'Maharashtra, Madhya Pradesh',   'amit.kulkarni@agriadvisory.in'),
  ('Dr. Sunita Rao',       'Water Management & Drip',   'M.Tech. Irrigation, IIT Roorkee',  8, 'Andhra Pradesh, Telangana',     'sunita.rao@agriadvisory.in'),
  ('Mr. Harjinder Singh',  'Wheat & Rice Cultivation',  'B.Sc. Agriculture, PAU Ludhiana', 16, 'Punjab, Haryana',               'harjinder.singh@agriadvisory.in'),
  ('Dr. Meena Patel',      'Organic Farming & Biochar', 'Ph.D. Agronomy, ANGRAU',           9, 'Gujarat, Rajasthan',            'meena.patel@agriadvisory.in')
ON DUPLICATE KEY UPDATE name = VALUES(name);

CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    rating INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_id INT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    issue_type VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(50) DEFAULT 'open',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (farmer_id) REFERENCES farmers(id) ON DELETE SET NULL
);
