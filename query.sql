DROP DATABASE IF EXISTS pizza;
CREATE DATABASE IF NOT EXISTS pizza CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS category(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    display VARCHAR(255),
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS topping(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    display VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS size(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    display VARCHAR(255) UNIQUE,
    priority INT,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS base(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    display VARCHAR(255) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS pizza(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    category_id INT,
    display VARCHAR(255) UNIQUE,
    description TEXT,
    image VARCHAR(255),
    PRIMARY KEY(id),
	CONSTRAINT pizza_fk_category_id FOREIGN KEY(category_id) REFERENCES category(id)
);

CREATE TABLE IF NOT EXISTS pizza_detail(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    pizza_id INT,
    size_id INT,
    base_id INT,
    price decimal(16,2),
    quantity int,
	CONSTRAINT pizza_detail_fk_pizza_id FOREIGN KEY(pizza_id) REFERENCES pizza(id),
    CONSTRAINT pizza_detail_fk_size_id FOREIGN KEY(size_id) REFERENCES size(id),
    CONSTRAINT pizza_detail_fk_base_id FOREIGN KEY(base_id) REFERENCES base(id)
);

CREATE TABLE IF NOT EXISTS topping_detail(
	pizza_id INT,
    topping_id INT,
    CONSTRAINT status_details_pk PRIMARY KEY(pizza_id, topping_id),
	CONSTRAINT status_details_fk_pizza_id FOREIGN KEY(pizza_id) REFERENCES pizza(id),
    CONSTRAINT status_details_fk_topping_id FOREIGN KEY(topping_id) REFERENCES topping(id)
);


CREATE TABLE IF NOT EXISTS `group`(
	id INT UNIQUE NOT NULL AUTO_INCREMENT,
	display VARCHAR(255) UNIQUE,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS group_permission(
	id INT UNIQUE NOT NULL AUTO_INCREMENT,
	group_id INT,
	permission VARCHAR(255),
	value TINYINT(1),
	CONSTRAINT group_permission_pk PRIMARY KEY(id),
	CONSTRAINT group_permission_fk_id FOREIGN KEY(group_id) REFERENCES `group`(id)
);

CREATE TABLE IF NOT EXISTS `user`(
	username VARCHAR(32) UNIQUE NOT NULL,
	group_id INT,
	password VARCHAR(255),
	fullname VARCHAR(255),
	birth DATE,
	address VARCHAR(255),
	phone VARCHAR(10),
	email VARCHAR(255),
	CONSTRAINT user_permission_pk PRIMARY KEY(username),
	CONSTRAINT user_permission_fk_group_id FOREIGN KEY(group_id) REFERENCES `group`(id)
);

CREATE TABLE IF NOT EXISTS user_permission(
	id INT UNIQUE NOT NULL AUTO_INCREMENT,
	username VARCHAR(255),
	permission VARCHAR(255),
	value TINYINT(1),
	CONSTRAINT user_permission_pk PRIMARY KEY(id),
	CONSTRAINT user_permission_fk_name FOREIGN KEY(username) REFERENCES user(username)
);

CREATE TABLE IF NOT EXISTS `order`(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    customer VARCHAR(32),
    handler VARCHAR(32),
    total_price decimal(16,2),
    quantity INT,
    fullname VARCHAR(255),
    address VARCHAR(255),
    phone VARCHAR(10),
    payment_type INT,
    order_type INT,
    order_time TIME,
    note TEXT,
    CONSTRAINT order_pk PRIMARY KEY(id),
	CONSTRAINT order_fk_customer FOREIGN KEY(customer) REFERENCES user(username),
    CONSTRAINT order_fk_handler FOREIGN KEY(handler) REFERENCES user(username)
);

CREATE TABLE IF NOT EXISTS order_detail(
    id INT UNIQUE NOT NULL AUTO_INCREMENT,
    order_id INT,
    pizza_detail_id INT,
    price DECIMAL(16,2),
    quantity INT,
    CONSTRAINT order_detail_pk PRIMARY KEY(id),
	CONSTRAINT order_detail_fk_order_id FOREIGN KEY(order_id) REFERENCES `order`(id),
    CONSTRAINT order_detail_fk_pizza_detail_id FOREIGN KEY(pizza_detail_id) REFERENCES pizza_detail(id)
);

CREATE TABLE IF NOT EXISTS status(
	id INT UNIQUE NOT NULL AUTO_INCREMENT,
	display VARCHAR(255) UNIQUE,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS status_detail(
	order_id INT,
    status_id INT,
    time_created datetime,
    CONSTRAINT status_details_pk PRIMARY KEY(order_id, status_id),
	CONSTRAINT status_details_fk_order_id FOREIGN KEY(order_id) REFERENCES `order`(id),
    CONSTRAINT status_details_fk_status_id FOREIGN KEY(status_id) REFERENCES `status`(id)
);

INSERT INTO `group`(display) VALUES
('M???c ?????nh'),
('Th??nh vi??n'),
('Nh??n vi??n'),
('Qu???n tr??? vi??n');

INSERT INTO `user`(username, group_id, password, fullname, birth, address, phone, email) VALUES
('admin', 4, '$2y$10$QXE8xnq.xDIsoGr1rdK6Hel7MCavVyJDQmUMvGBDYI5iZeZTyJiG6', 'Admin', '2001-01-01', 'TP.HCM', '0123456789', 'email@game.com'),
('nhatanh', 2, '$2y$10$QPRf.XycU3Jv9Ot7YHes4.ZhXQCwEIIXJp4X4kbSkh5U89t1CBinO', 'Tr???n Nh???t Anh', '2001-01-01', 'TP.HCM', '0123456789', 'email@game.com');

INSERT INTO `group_permission`(`group_id`, permission, value) VALUES
(4, 'admin.login', 1),
(4, 'admin.group', 1),
(4, 'admin.user', 1),
(4, 'admin.category', 1),
(4, 'admin.size', 1),
(4, 'admin.base', 1),
(4, 'admin.topping', 1),
(4, 'admin.pizza', 1),
(4, 'admin.order', 1),
(4, 'admin.statistic', 1);

INSERT INTO status(display) VALUES
('Ch??? x??c nh???n'),
('??ang chu???n b???'),
('??ang n?????ng b??nh'),
('??ang ????ng h???p'),
('??ang v???n chuy???n'),
('???? giao'),
('H???y ????n');

INSERT INTO category(display) VALUES
('M???i'),
('C??ng Th???c ?????c Bi???t'),
('H???i S???n Cao C???p'),
('Th???p C???m Cao C???p'),
('Truy???n Th???ng');

INSERT INTO topping(display) VALUES
('T??m'),
('Gi??m b??ng'),
('????o'),
('Cua'),
('Th???t ngu???i'),
('X??c x??ch ti??u cay'),
('D???a'),
('Th???t gi??m b??ng'),
('Th???t x??ng kh??i'),
('???t xanh'),
('C?? chua'),
('M???c'),
('B??ng c???i xanh'),
('Ngh??u'),
('Th???t g??'),
('Th???t ???t ng???ng'),
('C???i t??m');

INSERT INTO size(display, priority) VALUES
('Nh??? 6''''', 1),
('V???a 9''''', 2),
('L???n 12''''', 3);

INSERT INTO base(display) VALUES
('D??y'),
('M???ng gi??n'),
('Vi???n ph?? mai'),
('Vi???n t??m n?????ng'),
('Vi???n ph?? mai x??c x??ch');

INSERT INTO pizza(category_id, display, description, image) VALUES
(2, 'Pizza H???i S???n ????o', 'T??m, Gi??m b??ng, ????o h??a quy???n b??ng n??? c??ng s???t Thousand Island', 'haisandao.png'),
(3, 'Pizza H???i S???n Cocktail', 'T??m, cua, gi??m b??ng,... v???i s???t Thousand Island', 'haisancocktail.png'),
(4, 'Pizza Aloha', 'Th???t ngu???i, x??c x??ch ti??u cay v?? d???a h??a quy???n v???i s???t Thousand Island', 'aloha.png'),
(4, 'Pizza Th???t X??ng Kh??i', 'Th???t gi??m b??ng, th???t x??ng kh??i v?? hai lo???i rau c???a ???t xanh, c?? chua', 'thitxongkhoi.png'),
(2, 'Pizza H???i S???n Pesto Xanh', 'T??m, cua, m???c v?? b??ng c???i xanh t????i ngon tr??n n???n s???t Pesto Xanh', 'haisanpestoxanh.png'),
(3, 'Pizza H???i S???n Nhi???t ?????i', 'T??m, ngh??u, m???c, cua, d???a v???i s???t Thousand Island', 'haisannhietdoi.png'),
(5, 'Pizza G?? N?????ng D???a', 'Th???t g?? mang v??? ng???t c???a d???a k???t h???p v???i v??? cay n??ng c???a ???t', 'ganuongdua.png'),
(1, 'Pizza Ph?????ng Ho??ng', 'S??? k???t h???p gi???a th???t ???c ng???ng x??ng kh??i ch??u ??u, c???i t??m v?? c??c lo???i ???t t???o n??n m???t chi???c b??nh tr??n ?????y h????ng v??? m??? ra m???t n??m m???i nhi???u kh???i s???c', 'phuonghoang.png');

INSERT INTO topping_detail(pizza_id, topping_id) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 4),
(3, 5),
(3, 6),
(3, 7),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(5, 1),
(5, 4),
(5, 12),
(5, 13),
(6, 1),
(6, 14),
(6, 12),
(6, 4),
(6, 7),
(7, 15),
(7, 7),
(8, 16),
(8, 17);

INSERT INTO pizza_detail(pizza_id, size_id, base_id, price, quantity) VALUES
(1, 1, 1, 169000, 0),
(1, 2, 1, 249000, 0),
(1, 2, 2, 249000, 0),
(1, 2, 3, 299000, 0),
(1, 2, 4, 349000, 0),
(1, 2, 5, 349000, 0),
(1, 3, 1, 329000, 0),
(1, 3, 2, 329000, 0),
(1, 3, 3, 399000, 0),
(1, 3, 4, 469000, 0),
(1, 3, 5, 469000, 0),
(2, 1, 1, 129000, 5),
(2, 2, 1, 209000, 5),
(2, 2, 2, 209000, 5),
(2, 2, 3, 259000, 0),
(2, 2, 4, 309000, 0),
(2, 2, 5, 309000, 0),
(2, 3, 1, 289000, 5),
(2, 3, 2, 289000, 5),
(2, 3, 3, 359000, 0),
(2, 3, 4, 429000, 0),
(2, 3, 5, 429000, 0),
(3, 1, 1, 119000, 5),
(3, 2, 1, 199000, 5),
(3, 2, 2, 199000, 5),
(3, 2, 3, 249000, 5),
(3, 2, 4, 299000, 5),
(3, 2, 5, 299000, 5),
(3, 3, 1, 279000, 5),
(3, 3, 2, 279000, 5),
(3, 3, 3, 349000, 5),
(3, 3, 4, 419000, 5),
(3, 3, 5, 419000, 5),
(4, 1, 1, 119000, 5),
(4, 2, 1, 199000, 5),
(4, 2, 2, 199000, 5),
(4, 2, 3, 249000, 5),
(4, 2, 4, 299000, 5),
(4, 2, 5, 299000, 5),
(4, 3, 1, 279000, 5),
(4, 3, 2, 279000, 5),
(4, 3, 3, 349000, 5),
(4, 3, 4, 419000, 5),
(4, 3, 5, 419000, 5),
(5, 1, 1, 169000, 5),
(5, 2, 1, 249000, 5),
(5, 2, 2, 249000, 5),
(5, 2, 3, 299000, 5),
(5, 2, 4, 349000, 5),
(5, 2, 5, 349000, 5),
(5, 3, 1, 329000, 5),
(5, 3, 2, 329000, 5),
(5, 3, 3, 399000, 5),
(5, 3, 4, 469000, 5),
(5, 3, 5, 469000, 5),
(6, 1, 1, 139000, 5),
(6, 2, 1, 219000, 5),
(6, 2, 2, 219000, 5),
(6, 2, 3, 269000, 5),
(6, 2, 5, 319000, 5),
(6, 3, 1, 299000, 5),
(6, 3, 2, 299000, 5),
(6, 3, 3, 369000, 5),
(6, 3, 5, 439000, 5),
(7, 1, 1, 119000, 5),
(7, 2, 1, 199000, 5),
(7, 2, 2, 199000, 5),
(7, 2, 3, 249000, 5),
(7, 2, 5, 299000, 5),
(7, 3, 1, 279000, 5),
(7, 3, 2, 279000, 5),
(7, 3, 3, 349000, 5),
(7, 3, 5, 349000, 5),
(8, 2, 1, 219000, 5),
(8, 2, 2, 219000, 5),
(8, 2, 3, 269000, 5),
(8, 2, 5, 269000, 5),
(8, 3, 1, 299000, 5),
(8, 3, 2, 299000, 5),
(8, 3, 3, 369000, 5),
(8, 3, 5, 369000, 5);