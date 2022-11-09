-- 管理者
CREATE TABLE admin (
  admin_id int(11) NOT NULL COMMENT'管理者ID' AUTO_INCREMENT,
  admin_name varchar(128) NOT NULL unique COMMENT '管理者名' COLLATE utf8_general_ci,
  email varchar(128) NOT NULL COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  password varchar(255) NOT NULL COMMENT 'パスワードハッシュ' COLLATE utf8_general_ci,
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(admin_id)
);
-- 論理削除にしておく（同じ管理者名を使用できなくする）

 -- イベント管理
CREATE TABLE  events (
  event_id int(11) NOT NULL COMMENT 'イベントID' AUTO_INCREMENT,
  event_name varchar(64) NOT NULL COMMENT 'イベント名' COLLATE utf8_general_ci,
  description text COMMENT 'イベント説明' COLLATE utf8_general_ci,
  event_date varchar(64) NOT NULL COMMENT '開催期間' COLLATE utf8_general_ci,
  event_tag int(11) NOT NULL default 0 COMMENT 'タグ（0:ポップアップ、1:イベント）',
  event_svg varchar(128) COMMENT 'svg画像',
  event_png varchar(128) COMMENT 'png画像',
  img1 varchar(128) COMMENT '画像1',
  img2 varchar(128) COMMENT '画像2',
  img3 varchar(128) COMMENT '画像3',
  img4 varchar(128) COMMENT '画像4',
  img5 varchar(128) COMMENT '画像5',
  img6 varchar(128) COMMENT '画像6',
  img7 varchar(128) COMMENT '画像7',
  img8 varchar(128) COMMENT '画像8',
  status int(11) NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(event_id)
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
  description text COMMENT 'ブランド説明' COLLATE utf8_general_ci,
  brand_logo varchar(128) COMMENT 'ブランドロゴ',
  img1 varchar(128) COMMENT '画像1',
  img2 varchar(128) COMMENT '画像2',
  img3 varchar(128) COMMENT '画像3',
  img4 varchar(128) COMMENT '画像4',
  img5 varchar(128) COMMENT '画像5',
  img6 varchar(128) COMMENT '画像6',
  img7 varchar(128) COMMENT '画像7',
  img8 varchar(128) COMMENT '画像8',
  brand_hp text COMMENT 'ブランドHP' COLLATE utf8_general_ci,
  brand_instagram text COMMENT 'ブランドinstagram' COLLATE utf8_general_ci,
  brand_twitter text COMMENT 'ブランドtwitter' COLLATE utf8_general_ci,
  brand_facebook text COMMENT 'ブランドfacebook' COLLATE utf8_general_ci,
  brand_youtube text COMMENT 'ブランドyoutube' COLLATE utf8_general_ci,
  brand_line text COMMENT 'ブランドline' COLLATE utf8_general_ci,
  phone_number varchar(11) COMMENT '電話番号' COLLATE utf8_general_ci,
  email varchar(128) COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  address varchar(64) COMMENT '住所' COLLATE utf8_general_ci,
  status int(11) NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(brand_id)
);

-- アイテム
CREATE TABLE items (
  item_id int(11) NOT NULL COMMENT 'アイテムID' AUTO_INCREMENT,
  item_name varchar(64) NOT NULL COMMENT 'アイテム名' COLLATE utf8_general_ci,
  category_id int(11) NOT NULL default 0 COMMENT 'カテゴリーID',
  brand_id int(11) NOT NULL default 0 COMMENT 'ブランドID',
  event_id int(11) default 0 COMMENT 'イベントID',
  price int(11) NOT NULL COMMENT '値段',
  description text COMMENT 'アイテム説明' COLLATE utf8_general_ci,
  icon_img varchar(128) NOT NULL COMMENT 'アイコン画像',
  img1 varchar(128) COMMENT '画像1',
  img2 varchar(128) COMMENT '画像2',
  img3 varchar(128) COMMENT '画像3',
  img4 varchar(128) COMMENT '画像4',
  img5 varchar(128) COMMENT '画像5',
  img6 varchar(128) COMMENT '画像6',
  img7 varchar(128) COMMENT '画像7',
  img8 varchar(128) COMMENT '画像8',
  status int NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(brand_id) references brands (brand_id),
  foreign key(category_id) references categorys (category_id),
  foreign key(event_id) references events (event_id) on delete set null on update cascade,
  primary key(item_id)
);
-- int(11)の11は、カラムの表示幅であり、2147483647まで格納が可能。
-- 外部制約キー　event_idのみNULLを許容する

-- 在庫
CREATE TABLE stocks (
  stock_id int(11) NOT NULL COMMENT '在庫ID' AUTO_INCREMENT,
  item_id int(11) COMMENT 'アイテムID',
  stock int(11) NOT NULL COMMENT '在庫数',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(item_id) references items (item_id) on update cascade,
  primary key(stock_id)
);
-- 外部制約キーの指定(delete set nullだと)

-- ユーザー
CREATE TABLE users (
  user_id int(11) NOT NULL COMMENT 'ユーザーID' AUTO_INCREMENT,
  user_name varchar(128) NOT NULL unique COMMENT 'ユーザー名' COLLATE utf8_general_ci,
  email varchar(128) NOT NULL COMMENT 'メールアドレス' COLLATE utf8_general_ci,
  password varchar(255) NOT NULL COMMENT 'パスワードハッシュ' COLLATE utf8_general_ci,
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(user_id)
);
-- 論理削除にしておく（同じユーザー名を使用できなくする）

-- お気に入り
CREATE TABLE favorites (
  favorite_id int(11) NOT NULL COMMENT 'お気に入りID' AUTO_INCREMENT,
  user_id int(11) COMMENT 'ユーザーID',
  item_id int(11) COMMENT 'アイテムID',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(favorite_id)
);
-- 柔軟性を考慮し外部制約はなしにしておく

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
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(customer_id) references customers (customer_id),
  primary key(order_id, customer_id)
);
ALTER TABLE orders ADD order_number int(11) NOT NULL unique COMMENT '注文番号';
ALTER TABLE orders ADD total_quantity int(11) NOT NULL COMMENT '合計数量';
ALTER TABLE orders ADD total_amount int(11) NOT NULL COMMENT '合計金額';

-- 注文詳細
CREATE TABLE order_detail (
  order_id int(11) NOT NULL COMMENT '注文ID',
  item_id int(11) NOT NULL COMMENT 'アイテムID',
  quantity int(11) NOT NULL COMMENT '注文数',
  price int(11) NOT NULL COMMENT '注文時の値段',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(order_id,item_id)
);
-- 集約　結果整合性を考慮し値段も含めたアイテムデータを格納(item_idに外部制約キーは使用しない)

-- カート
CREATE TABLE carts (
  cart_id int(11) NOT NULL COMMENT 'カートID' AUTO_INCREMENT,
  user_id int(11) COMMENT 'ユーザーID',
  cart_date datetime NOT NULL COMMENT '追加日',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(user_id) references users (user_id),
  primary key(cart_id)
);

-- カート詳細
CREATE TABLE cart_detail (
  cart_id int(11) NOT NULL COMMENT 'カートID',
  item_id int(11) NOT NULL COMMENT 'アイテムID',
  quantity int(11) NOT NULL COMMENT '数量',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(cart_id, item_id)
);

-- ダッシュボード
CREATE TABLE dashboards (
  dashboard_id int(11) NOT NULL COMMENT 'ID',
  news text NOT NULL COMMENT 'ニュース',
  topics text NOT NULL COMMENT 'トピックス',
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(dashboard_id)
);

-- ショップ画面トップページ（イベント）
CREATE TABLE shops (
  shop_id int(11) NOT NULL COMMENT 'ID' AUTO_INCREMENT,
  event_id int(11) NOT NULL COMMENT 'イベントID',
  status int(11) NOT NULL default 0 COMMENT 'ステータス（0:非公開、1:公開）',
  enabled boolean NOT NULL default true COMMENT '有効',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  foreign key(event_id) references events (event_id),
  primary key(shop_id)
);

-- ショップ画面トップページ（レコメンドアイテム）
CREATE TABLE shop_recommend (
  shop_id int(11) NOT NULL COMMENT 'ショップID',
  item_id int(11) NOT NULL COMMENT 'アイテムID',
  create_datetime DATETIME COMMENT 'レコードの作成日',
  update_datetime DATETIME COMMENT 'レコードの更新日',
  primary key(shop_id, item_id)
);


-- memo
-- AUTO_INCREMENT 初期化
-- ALTER TABLE `tablename` auto_increment = 1;

-- 今後の課題
-- customer情報にpayment,deliveryを追加（支払い情報、お届け先情報）
-- orderに対して管理者側で集計が行えるよう集計テーブルを作る