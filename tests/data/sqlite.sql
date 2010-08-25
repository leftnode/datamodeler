DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (
	product_id integer PRIMARY KEY,
	date_created TEXT NOT NULL,
	date_updated TEXT DEFAULT NULL,
	date_available TEXT NOT NULL,
	`name` TEXT NOT NULL,
	price REAL NOT NULL,
	sku TEXT NOT NULL, 
	description TEXT NOT NULL,
	image TEXT NOT NULL,
	available INTEGER DEFAULT 0,
	store_name TEXT DEFAULT NULL
);
INSERT INTO products VALUES(1, datetime(), NULL, date(), 'Product 1', 19.33, 'SKU_P1', 'Product 1 Description', 'product1.jpg', 1, 'Costco');
INSERT INTO products VALUES(2, datetime(), NULL, date(), 'Product 2', 18.25, 'SKU_P2', 'Product 2 Description', 'product2.jpg', 1, 'Sams');
INSERT INTO products VALUES(3, datetime(), NULL, date(), 'Product 3', 17.96, 'SKU_P3', 'Product 3 Description', 'product3.jpg', 0, 'Wal-Mart');

DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id INTEGER PRIMARY KEY,
	username TEXT,
	password TEXT,
	age INTEGER,
	favorite_book TEXT
);
INSERT INTO users VALUES(NULL, 'vcherubini', 'password1', 25, 'xUnit Test Patterns');
INSERT INTO users VALUES(NULL, 'bsaget', 'password2', 50, 'The Olsen Twins: A Legacy');
INSERT INTO users VALUES(NULL, 'ggottfried', 'password3', 52, 'Its The Whiskey Talkin');
INSERT INTO users VALUES(NULL, 'howard_stern', 'password4', 56, 'Private Parts');

DROP TABLE IF EXISTS large_object;
CREATE TABLE large_object (
	large_object_id INTEGER PRIMARY KEY,
	object_data TEXT
);

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
	order_id INTEGER PRIMARY KEY,
	date_created TEXT,
	date_updated TEXT NULL DEFAULT NULL,
	date_available TEXT,
	customer_id INTEGER default 0,
	total REAL default 0.00,
	name TEXT NOT NULL,
	email_address TEXT NOT NULL
);