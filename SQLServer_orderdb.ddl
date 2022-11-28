CREATE DATABASE orders;
go;

USE orders;
go;

DROP TABLE review;
DROP TABLE shipment;
DROP TABLE productinventory;
DROP TABLE warehouse;
DROP TABLE orderproduct;
DROP TABLE incart;
DROP TABLE product;
DROP TABLE category;
DROP TABLE ordersummary;
DROP TABLE paymentmethod;
DROP TABLE customer;


CREATE TABLE customer (
    customerId          INT IDENTITY,
    firstName           VARCHAR(40),
    lastName            VARCHAR(40),
    email               VARCHAR(50),
    phonenum            VARCHAR(20),
    address             VARCHAR(50),
    city                VARCHAR(40),
    state               VARCHAR(20),
    postalCode          VARCHAR(20),
    country             VARCHAR(40),
    userid              VARCHAR(20),
    password            VARCHAR(30),
    PRIMARY KEY (customerId)
);

CREATE TABLE paymentmethod (
    paymentMethodId     INT IDENTITY,
    paymentType         VARCHAR(20),
    paymentNumber       VARCHAR(30),
    paymentExpiryDate   DATE,
    customerId          INT,
    PRIMARY KEY (paymentMethodId),
    FOREIGN KEY (customerId) REFERENCES customer(customerid)
        ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE ordersummary (
    orderId             INT IDENTITY,
    orderDate           DATETIME,
    totalAmount         DECIMAL(10,2),
    shiptoAddress       VARCHAR(50),
    shiptoCity          VARCHAR(40),
    shiptoState         VARCHAR(20),
    shiptoPostalCode    VARCHAR(20),
    shiptoCountry       VARCHAR(40),
    customerId          INT,
    PRIMARY KEY (orderId),
    FOREIGN KEY (customerId) REFERENCES customer(customerid)
        ON UPDATE CASCADE ON DELETE CASCADE 
);

CREATE TABLE category (
    categoryId          INT IDENTITY,
    categoryName        VARCHAR(50),    
    PRIMARY KEY (categoryId)
);

CREATE TABLE product (
    productId           INT IDENTITY,
    productName         VARCHAR(40),
    productPrice        DECIMAL(10,2),
    productImageURL     VARCHAR(100),
    productImage        VARBINARY(MAX),
    productDesc         VARCHAR(1000),
    categoryId          INT,
    PRIMARY KEY (productId),
    FOREIGN KEY (categoryId) REFERENCES category(categoryId)
);

CREATE TABLE orderproduct (
    orderId             INT,
    productId           INT,
    quantity            INT,
    price               DECIMAL(10,2),  
    PRIMARY KEY (orderId, productId),
    FOREIGN KEY (orderId) REFERENCES ordersummary(orderId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE incart (
    orderId             INT,
    productId           INT,
    quantity            INT,
    price               DECIMAL(10,2),  
    PRIMARY KEY (orderId, productId),
    FOREIGN KEY (orderId) REFERENCES ordersummary(orderId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE warehouse (
    warehouseId         INT IDENTITY,
    warehouseName       VARCHAR(30),    
    PRIMARY KEY (warehouseId)
);

CREATE TABLE shipment (
    shipmentId          INT IDENTITY,
    shipmentDate        DATETIME,   
    shipmentDesc        VARCHAR(100),   
    warehouseId         INT, 
    PRIMARY KEY (shipmentId),
    FOREIGN KEY (warehouseId) REFERENCES warehouse(warehouseId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE productinventory ( 
    productId           INT,
    warehouseId         INT,
    quantity            INT,
    price               DECIMAL(10,2),  
    PRIMARY KEY (productId, warehouseId),   
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE NO ACTION,
    FOREIGN KEY (warehouseId) REFERENCES warehouse(warehouseId)
        ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE review (
    reviewId            INT IDENTITY,
    reviewRating        INT,
    reviewDate          DATETIME,   
    customerId          INT,
    productId           INT,
    reviewComment       VARCHAR(1000),          
    PRIMARY KEY (reviewId),
    FOREIGN KEY (customerId) REFERENCES customer(customerId)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (productId) REFERENCES product(productId)
        ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO category(categoryName) VALUES ('Beverages');
INSERT INTO category(categoryName) VALUES ('Onigiris');
INSERT INTO category(categoryName) VALUES ('Condiments');

INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Dasani Water', 1,'20 oz water', 2.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Calpico', 1,'16.9 oz japanese yogurt drink', 2.75);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Coca Cola', 1,'12 oz can', 2.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Diet coke', 1,'12 oz can', 2.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Minute Maid Orange Juice', 1,'16.9 oz orange juice', 2.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Pepsi', 1,'12 oz can', 2.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Sprite', 1,'12 oz can', 2.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Grilled Beef', 2, 'Grilled beef onigiri (rice ball)', 10.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Ground Chicken', 2,'Ground chicken onigiri (rice ball)', 10.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Plain', 2,'Plain onigiri (rice ball)', 8.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Plum', 2,'Plum onigiri (rice ball)', 8.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Pollock Roe',2,'Pollock Roe onigiri (rice ball)', 9.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Salmon', 2,'Salmon onigiri (rice ball)', 10.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Seaweed', 2,'Seaweed onigiri (rice ball)', 8.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Tuna Mayo', 2,'Tuna Mayo onigiri (rice ball)', 9.00);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Chicken Karaage', 3,'side of japanese fried chicken', 7.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Seaweed Salad', 3,'side of japanese seaweed salad', 5.50);
INSERT product(productName, categoryId, productDesc, productPrice) VALUES ('Edamame', 3,'side of boiled green soybean', 5.50);

INSERT INTO warehouse(warehouseName) VALUES ('Main warehouse');
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (1, 1, 5, 2);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (2, 1, 6, 2.75);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (3, 1, 6, 2);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (4, 1, 3, 2);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (5, 1, 6, 2.50);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (6, 1, 3, 2);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (7, 1, 3, 2);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (8, 1, 4, 10);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (9, 1, 3, 10);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (10, 1, 2, 8);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (11, 1, 2, 8.50);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (12, 1, 3, 9);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (13, 1, 4, 10);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (14, 1, 4, 8.50);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (15, 1, 2, 9);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (16, 1, 1, 7.50);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (17, 1, 3, 5.50);
INSERT INTO productInventory(productId, warehouseId, quantity, price) VALUES (18, 1, 2, 5.50);

INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Arnold', 'Anderson', 'a.anderson@gmail.com', '204-111-2222', '103 AnyWhere Street', 'Winnipeg', 'MB', 'R3X 45T', 'Canada', 'arnold' , 'test');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Bobby', 'Brown', 'bobby.brown@hotmail.ca', '572-342-8911', '222 Bush Avenue', 'Boston', 'MA', '22222', 'United States', 'bobby' , 'test');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Candace', 'Cole', 'cole@charity.org', '333-444-5555', '333 Central Crescent', 'Chicago', 'IL', '33333', 'United States', 'candace' , 'test');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Darren', 'Doe', 'oe@doe.com', '250-807-2222', '444 Dover Lane', 'Kelowna', 'BC', 'V1V 2X9', 'Canada', 'darren' , 'test');
INSERT INTO customer (firstName, lastName, email, phonenum, address, city, state, postalCode, country, userid, password) VALUES ('Elizabeth', 'Elliott', 'engel@uiowa.edu', '555-666-7777', '555 Everwood Street', 'Iowa City', 'IA', '52241', 'United States', 'beth' , 'test');

-- Order 1 can be shipped as have enough inventory
DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (1, '2019-10-15 10:25:55', 15.50)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 1, 1, 2)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 2, 2.75)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 10, 1, 8);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (2, '2019-10-16 18:00:00', 12.50)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 5, 2.50);

-- Order 3 cannot be shipped as do not have enough inventory for item 7
DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (3, '2019-10-15 3:30:22', 12)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 6, 2, 2)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 7, 4, 2);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (2, '2019-10-17 05:45:11', 95.50)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 3, 4, 2)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 8, 3, 10)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 13, 3, 10)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 18, 2, 5.50)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 17, 3, 5.50);

DECLARE @orderId int
INSERT INTO ordersummary (customerId, orderDate, totalAmount) VALUES (5, '2019-10-15 10:25:55', 54.5)
SELECT @orderId = @@IDENTITY
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 5, 4, 2.75)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 12, 2, 9)
INSERT INTO orderproduct (orderId, productId, quantity, price) VALUES (@orderId, 14, 3, 8.50);

-- New SQL DDL for lab 8
UPDATE Product SET productImageURL = 'img/1.jpg' WHERE ProductId = 1;
UPDATE Product SET productImageURL = 'img/2.jpg' WHERE ProductId = 2;
UPDATE Product SET productImageURL = 'img/3.jpg' WHERE ProductId = 3;
UPDATE Product SET productImageURL = 'img/4.jpg' WHERE ProductId = 4;
UPDATE Product SET productImageURL = 'img/5.jpg' WHERE ProductId = 5;
UPDATE Product SET productImageURL = 'img/6.jpg' WHERE ProductId = 6;
UPDATE Product SET productImageURL = 'img/7.jpg' WHERE ProductId = 7;
UPDATE Product SET productImageURL = 'img/8.jpg' WHERE ProductId = 8;
UPDATE Product SET productImageURL = 'img/9.jpg' WHERE ProductId = 9;
UPDATE Product SET productImageURL = 'img/10.jpg' WHERE ProductId = 10;
UPDATE Product SET productImageURL = 'img/11.jpg' WHERE ProductId = 11;
UPDATE Product SET productImageURL = 'img/12.jpg' WHERE ProductId = 12;
UPDATE Product SET productImageURL = 'img/13.jpg' WHERE ProductId = 13;
UPDATE Product SET productImageURL = 'img/14.jpg' WHERE ProductId = 14;
UPDATE Product SET productImageURL = 'img/15.jpg' WHERE ProductId = 15;
UPDATE Product SET productImageURL = 'img/16.jpg' WHERE ProductId = 16;
UPDATE Product SET productImageURL = 'img/17.jpg' WHERE ProductId = 17;
UPDATE Product SET productImageURL = 'img/18.jpg' WHERE ProductId = 18;

