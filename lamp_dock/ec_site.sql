-- 管理者
CREATE TABLE admin (
  admin_id int(11) NOT NULL COMMENT'管理者ID' AUTO_INCREMENT,
  admin_name varchar(128) NOT NULL unique COMMENT '管理者名' COLLATE utf8_general_ci,
  email varchar(128) NOT NULL COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  password varchar(255) NOT NULL COMMENT 'パスワード' COLLATE utf8_general_ci,
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(admin_id)
);
       
-- カテゴリー管理
CREATE TABLE  categorys (
  category_id int(11) NOT NULL COMMENT 'カテゴリーID' AUTO_INCREMENT,
  category_name varchar(64) NOT NULL COMMENT 'カテゴリー名' COLLATE utf8_general_ci,
  parent_id int(11) NOT NULL COMMENT '親カテゴリーID',
  status int(11) NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(category_id)
);

-- ブランド管理
CREATE TABLE  brands (
  brand_id int(11) NOT NULL COMMENT 'ブランドID' AUTO_INCREMENT,
  brand_name varchar(64) NOT NULL COMMENT 'ブランド名' COLLATE utf8_general_ci,
  category_id int(11) NOT NULL default 0 COMMENT 'カテゴリーID（マンスリー）',
  description text COMMENT 'ブランド説明' COLLATE utf8_general_ci,
  brand_hp text COMMENT 'ブランドHP' COLLATE utf8_general_ci,
  brand_link1 text COMMENT 'ブランドLINK1' COLLATE utf8_general_ci,
  brand_link2 text COMMENT 'ブランドLINK2' COLLATE utf8_general_ci,
  brand_link3 text COMMENT 'ブランドLINK3' COLLATE utf8_general_ci,
  brand_link4 text COMMENT 'ブランドLINK4' COLLATE utf8_general_ci,
  phone_number varchar(11) COMMENT '電話番号' COLLATE utf8_general_ci,
  email varchar(128) COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  address varchar(64) COMMENT '住所' COLLATE utf8_general_ci,
  status int(11) NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  -- foreign key(category_id) references categorys (category_id) on delete set null on update cascade,
  primary key(brand_id)
);

-- ショップ管理
CREATE TABLE  shops (
  shop_id int(11) NOT NULL COMMENT 'ショップID' AUTO_INCREMENT,
  shop_name varchar(64) NOT NULL COMMENT 'ショップ名' COLLATE utf8_general_ci,
  description text COMMENT 'ショップ説明' COLLATE utf8_general_ci,
  shop_hp text COMMENT 'ショップHP' COLLATE utf8_general_ci,
  shop_link1 text COMMENT 'ショップLINK1' COLLATE utf8_general_ci,
  shop_link2 text COMMENT 'ショップLINK2' COLLATE utf8_general_ci,
  shop_link3 text COMMENT 'ショップLINK3' COLLATE utf8_general_ci,
  shop_link4 text COMMENT 'ショップLINK4' COLLATE utf8_general_ci,
  phone_number varchar(11) COMMENT '電話番号' COLLATE utf8_general_ci,
  email varchar(128) COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  address varchar(64) COMMENT '住所' COLLATE utf8_general_ci,
  status int(11) NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(shop_id)
);

-- 商品
CREATE TABLE items (
  item_id int(11) NOT NULL COMMENT '商品ID' AUTO_INCREMENT,
  item_name varchar(64) NOT NULL COMMENT '商品名' COLLATE utf8_general_ci,
  category_id int(11) NOT NULL default 0 COMMENT 'カテゴリーID（ジャンル）',
  brand_id int(11) NOT NULL default 0 COMMENT 'ブランドID（マンスリー）',
  shop_id int(11) NOT NULL default 0 COMMENT 'ショップID',
  price int(11) NOT NULL COMMENT '値段',
  description text COMMENT '商品説明' COLLATE utf8_general_ci,
  icon_img varchar(128) NOT NULL COMMENT 'アイコン画像',
  img1 varchar(128) COMMENT '画像1',
  img2 varchar(128) COMMENT '画像2',
  img3 varchar(128) COMMENT '画像3',
  img4 varchar(128) COMMENT '画像4',
  img5 varchar(128) COMMENT '画像5',
  img6 varchar(128) COMMENT '画像6',
  img7 varchar(128) COMMENT '画像7',
  img8 varchar(128) COMMENT '画像8',
  img9 varchar(128) COMMENT '画像9',
  img10 varchar(128) COMMENT '画像10',
  status int NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  -- foreign key(brand_id) references brands (brand_id) on delete set null on update cascade,
  -- foreign key(category_id) references categorys (category_id) on delete set null on update cascade,
  -- foreign key(shop_id) references shops (shop_id) on delete set null on update cascade,
  primary key(item_id)
);
-- int(11)の11は、カラムの表示幅であり、2147483647まで格納が可能。

-- 在庫
CREATE TABLE stocks (
  stock_id int(11) NOT NULL COMMENT '在庫ID' AUTO_INCREMENT,
  item_id int(11) COMMENT '商品ID',
  stock int(11) NOT NULL COMMENT '在庫数',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(item_id) references items (item_id) on delete set null on update cascade,
  primary key(stock_id)
);

-- ユーザー
CREATE TABLE users (
  user_id int(11) NOT NULL COMMENT 'ユーザーID' AUTO_INCREMENT,
  user_name varchar(128) NOT NULL unique COMMENT 'ユーザー名' COLLATE utf8_general_ci,
  password varchar(255) NOT NULL COMMENT 'パスワード' COLLATE utf8_general_ci,
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(user_id)
);
ALTER TABLE users ADD email varchar(128) NOT NULL COMMENT 'メールアドレス' COLLATE utf8_general_ci;

-- お気に入り
CREATE TABLE favorites (
  favorite_id int(11) NOT NULL COMMENT 'お気に入りID' AUTO_INCREMENT,
  user_id int(11) COMMENT 'ユーザーID',
  item_id int(11) COMMENT '商品ID',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(user_id) references users (user_id) on delete set null on update cascade,
  foreign key(item_id) references items (item_id) on delete set null on update cascade,
  primary key(favorite_id)
);
-- 顧客
CREATE TABLE customers (
  customer_id int(11) NOT NULL COMMENT '顧客ID' AUTO_INCREMENT,
  user_id int(11) COMMENT 'ユーザーID',
  name_kanji varchar(32) NOT NULL COMMENT '名前（漢字）' COLLATE utf8_general_ci,
  name_kana varchar(32) NOT NULL COMMENT '名前（カナ）' COLLATE utf8_general_ci,
  sex int(11) NOT NULL COMMENT '性別（0:男性 1:女性）',
  birthday datetime NOT NULL COMMENT '生年月日',
  phone_number varchar(11) NOT NULL COMMENT '電話番号' COLLATE utf8_general_ci,
  email varchar(128) NOT NULL COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  post_code varchar(7) NOT NULL COMMENT '郵便番号' COLLATE utf8_general_ci,
  xmpf int(11) NOT NULL COMMENT '住所',
  address1 varchar(64) NOT NULL COMMENT '住所1' COLLATE utf8_general_ci,
  address2 varchar(64) COMMENT '住所2' COLLATE utf8_general_ci,
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(user_id) references users (user_id) on delete set null on update cascade,
  primary key(customer_id)
);
-- 注文管理
CREATE TABLE orders (
  order_id int(11) NOT NULL COMMENT '注文ID' AUTO_INCREMENT,
  customer_id int(11) COMMENT '顧客ID',
  order_date datetime NOT NULL COMMENT '注文日',
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(customer_id) references customers (customer_id) on delete set null on update cascade,
  primary key(order_id)
);
-- 注文詳細
CREATE TABLE order_detail (
  order_id int(11) NOT NULL COMMENT '注文ID',
  item_id int(11) NOT NULL COMMENT '商品ID',
  quantity int(11) NOT NULL COMMENT '注文数',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(order_id, item_id)
);
-- カート
CREATE TABLE carts (
  cart_id int(11) NOT NULL COMMENT 'カートID' AUTO_INCREMENT,
  user_id int(11) COMMENT 'ユーザーID',
  enabled boolean NOT NULL default true COMMENT '有効',
  cart_date datetime NOT NULL COMMENT '追加日',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(user_id) references users (user_id) on delete set null on update cascade,
  primary key(cart_id)
);
-- カート詳細
CREATE TABLE cart_detail (
  cart_id int(11) NOT NULL COMMENT 'カートID',
  item_id int(11) NOT NULL COMMENT '商品ID',
  quantity int(11) NOT NULL COMMENT '数量',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(cart_id, item_id)
);

-- ダッシュボード
CREATE TABLE dashboards (
  id int(11) NOT NULL COMMENT 'ID',
  news text NOT NULL COMMENT 'ニュース',
  topics text NOT NULL COMMENT 'トピックス',
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(id)
);
-- AUTO_INCREMENT 初期化
ALTER TABLE `tablename` auto_increment = 1;