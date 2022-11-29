-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: mysql
-- 生成日時: 2022 年 11 月 28 日 09:22
-- サーバのバージョン： 5.7.39
-- PHP のバージョン: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `sample`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL COMMENT '管理者ID',
  `admin_name` varchar(128) NOT NULL COMMENT '管理者名',
  `email` varchar(128) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'パスワードハッシュ',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有効',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_name`, `email`, `password`, `enabled`, `create_datetime`, `update_datetime`) VALUES
(1, 'admin1', 'admin@mail.com', '$2y$10$3QY4h/hj0geACNKxO6znceDHanSH3d5p6h5RBu9i226v0QrwJzb4e', 1, '2022-11-15 17:46:59', NULL),
(2, 'goodandnew', 'goodandnew@mail.com', '$2y$10$5jMmRQzJ/ki8cAQQg1R.DuJOMalVtud9LHS3WFYAE7JVoB4a73SoK', 1, '2022-11-16 12:40:39', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL COMMENT 'ブランドID',
  `brand_name` varchar(64) NOT NULL COMMENT 'ブランド名',
  `description` text COMMENT 'ブランド説明',
  `brand_logo` varchar(128) DEFAULT NULL COMMENT 'ブランドロゴ',
  `brand_hp` text COMMENT 'ブランドHP',
  `brand_instagram` text COMMENT 'ブランドinstagram',
  `brand_twitter` text COMMENT 'ブランドtwitter',
  `brand_facebook` text COMMENT 'ブランドfacebook',
  `brand_youtube` text COMMENT 'ブランドyoutube',
  `brand_line` text COMMENT 'ブランドline',
  `phone_number` varchar(11) DEFAULT NULL COMMENT '電話番号',
  `email` varchar(128) DEFAULT NULL COMMENT 'メールアドレス',
  `address` varchar(64) DEFAULT NULL COMMENT '住所',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'ステータス（0:非公開、1:公開）',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日',
  `img1` varchar(128) DEFAULT NULL COMMENT '画像1',
  `img2` varchar(128) DEFAULT NULL COMMENT '画像2',
  `img3` varchar(128) DEFAULT NULL COMMENT '画像3',
  `img4` varchar(128) DEFAULT NULL COMMENT '画像4',
  `img5` varchar(128) DEFAULT NULL COMMENT '画像5',
  `img6` varchar(128) DEFAULT NULL COMMENT '画像6',
  `img7` varchar(128) DEFAULT NULL COMMENT '画像7',
  `img8` varchar(128) DEFAULT NULL COMMENT '画像8'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `description`, `brand_logo`, `brand_hp`, `brand_instagram`, `brand_twitter`, `brand_facebook`, `brand_youtube`, `brand_line`, `phone_number`, `email`, `address`, `status`, `create_datetime`, `update_datetime`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `img7`, `img8`) VALUES
(1, 'cottonbro', 'オランダ発のアパレルブランド。2014年テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '28a3c94b6ae2f3c7bae6345df9402375277cc65c.jpg', 'https://www.cottonbro/', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.facebook.com', 'https://www.youtube.com', 'https://line.me/', '0311112222', 'cottonbro@mail.com', '東京都渋谷区○○○○○○○○○○○○○○○', 1, '2022-11-15 19:18:06', '2022-11-24 17:13:28', '955d8582acb2a1d91d0a8ab9d5c95bdd5e89e77b.jpg', 'b6fa4611e97404e9e91ea11781d1a38409c4d44c.jpg', '8a2ce8b2b9dc664e005f8aab539754b73bc53b7d.jpg', '2d625b60d3db25ac6d5d86a58c135d30e404d296.jpg', 'a68cf00c020948b3de75021f992adc980308f778.jpg', '0e1123185cf9fad2bac4412843a5e9d606f7db2a.jpg', '99db4383d2888e0353a10b73de230926bdee259c.jpg', 'abe2c29f67a6965d4bb90b8c3f4851b5dc615ae7.jpg'),
(2, 'studio glass', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '61b53059e271ce2653c4e161184a39938604d887.jpg', 'https://studio_glass/com', 'https://www.instagram.com', 'https://www.twitter.com', '', 'https://www.youtube.com', '', '', 'studioglass@mail.com', '', 1, '2022-11-16 12:55:08', '2022-11-24 17:13:14', '97e4642021db4ac1cf5647882af6c1501fdcd163.jpg', 'c4b560a0cd5eacd4477d74db3a27b5e7edd80833.jpg', '31af31118790a105697deb07603dec174c7e4eff.jpg', '4497da8c1ce7e64d01680fe8811013e350620856.jpg', NULL, NULL, NULL, NULL),
(3, '.lacie', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '57a133a1a4de8e29b45ef7b7cffe8088307af522.jpg', 'https://www.lacie/', 'https://www.instagram.com', '', '', '', '', '0311112222', 'lacie@mail.com', '東京都渋谷区○○○○○○○○○○○○○○○', 1, '2022-11-16 13:12:03', '2022-11-24 17:12:45', '5347ce4ddabd54c949157dbee3e09e40582fe9f2.jpg', 'f9a4ba4aee7cc1a3d8295ce735305095df1ed1be.jpg', 'c4d5fcf7d282c8d10595d32f6abd32beb41c43c2.jpg', '117539c8f2d15d52a05ca8faa2586020b15ee19e.jpg', NULL, NULL, NULL, NULL),
(4, 'eight club', 'テキスト○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○○', 'fc61e94657be6d0ba03a59d09c6add87db3de5fc.jpg', 'https://www.eightclub/', 'https://www.instagram.com', 'https://www.twitter.com', '', 'https://www.youtube.com', '', '0311112222', 'eightclub@mail.com', '', 1, '2022-11-16 13:33:09', '2022-11-24 17:12:04', '3ea429444714c457e1cf6c5ca338a8f32df9637b.jpg', '4b700eb046c6a7e800becef4fc83fe0f52653e28.jpg', '43f26b34d4b2d967f5914078f7cad4ecdda8dd89.jpg', 'fa9ab9b72adc90f9c2b2f13596acb3c24b0e94a7.jpg', NULL, NULL, NULL, NULL),
(5, 'THE SHAKESPEARE', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '7e07cacaac5ccb3d7bea1b10cd2c9b512242d573.jpg', 'https://www.theshakespeare/', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.facebook.com', '', '', '', 'theshakespeare@mail.com', '東京都渋谷区○○○○○○○○○○○○○○○', 1, '2022-11-16 13:43:32', '2022-11-24 17:11:10', '113100d2bf47fab5fbe06bdf82d90b28f6664253.jpg', 'd8796d9912481ea14c46e0deada93be567a9456b.jpg', 'bce9ef1fb4783c5418b9e472f8160138a858c45f.jpg', '225d380087994490887cf2cb4ddcd76ed000dc86.jpg', 'a94dfaf4b9469f62a37970db5e0061de99288b02.jpg', '7f455f1a55c172036f5265aaa99b5fa14f1f70f9.jpg', 'f3e001c0be1616eb0ae9a88dac8e5e63c1464829.jpg', '4394d513c1fd82a8f75c84d74bf89ca65003522b.jpg'),
(6, 'ISM PRODUCTS', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'd40dcf900ad95eac25a11e0680c15f6387e8c0f1.jpg', 'https://www.ismproducts/', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.facebook.com', 'https://www.youtube.com', '', '0311112222', 'ismproducts@mail.com', '', 1, '2022-11-16 13:57:26', '2022-11-24 17:10:04', '7578f2b55f2ee92bd7231a2e8f09160d4b5e1ad8.jpg', '8e02ad5e26d9ba884d1f6cbf85c99624c6c126d3.jpg', '12211fe986a312ba298f81f760c5097a60e6417a.jpg', 'a0de7f42682cfde4172901ea37b0ebe9f57fd3ad.jpg', 'b515071cfedce992c08e8b7775464b303b8bd591.jpg', 'ff9cf6360cbd48a290ddb93a7b180beff421ef7e.jpg', '330676a060c649716d6847833b47de41b05ce19c.jpg', '46e72ef56693de0ac4bf68c16ec4b607b9dc092c.jpg'),
(7, 'GOOD & NEW', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '2ba5a5369567f8e6feea6f2172700c4f5291961c.png', '', '', '', '', '', '', '', '', '', 1, '2022-11-16 14:04:42', NULL, '307de116f76e82f3ddfc646c08b6d6fddc90ea83.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'stationery Labo', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '86e03e8215659cbff4eb4b424d2e2a482c498634.jpg', 'https://www.stationerylabo/', 'https://www.instagram.com', 'https://www.twitter.com', '', '', '', '0311112222', 'stationerylabo@mail.com', '東京都渋谷区○○○○○○○○○○○○○○○', 1, '2022-11-16 14:13:22', '2022-11-24 17:08:54', '2eafc4d9a49f8ca33c75092d537f931274bce04b.jpg', 'd1aa910e0969f3f5e472ba527e00dd71ff12314b.jpg', '94df80dc681143cbf14d79b642b53a80574b5dd9.jpg', '774988c2adb6869d00167a3a9d137c44881569b1.jpg', '504cd79a0e0c2ff08d3a6eb8d54b301fd2c69fac.jpg', 'cc0e935d67b6cfde0fafd780cad166cdeb90628a.jpg', '194747a789db52a14bece8a85704dff1e3942c14.jpg', '9931b1db872ac07d22d487ce6ce88b842fdeec36.jpg'),
(9, 'whoecho', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '0efeaf5f56a86f478155002f5894b2180275b8d1.jpg', 'https://www.whoecho/', 'https://www.instagram.com', 'https://www.twitter.com', 'https://www.facebook.com', 'https://www.youtube.com', 'https://line.me/', '0311112222', 'whoecho@mail.com', '東京都渋谷区○○○○○○○○○○○○○○○', 1, '2022-11-16 14:49:26', '2022-11-16 17:16:28', '9e0b8ba9824388e4926034444958fa2d0c11b9b5.jpg', '49a3af9cd34c542658b691aa06c6d0467a5bf6c7.jpg', 'cad54cb7d2d64d19fb07d090eeea0c80abd3668d.jpg', 'a1a0d0d43512bdd4c3cf7185e6812e63011af8b7.jpg', 'b8b07c53010b954fcd759a2b703d56e12d6004d4.jpg', 'c906da8bca68d19c8aa1d35194dfff8ebfcadd78.jpg', '94babec4e1ff3bdfbca77ba0e62b798ec4b56bed.jpg', '2143227d2e1c65bbd282997474ec51bc97b986e8.jpg'),
(10, 'test', '', '0ff4241800a787518be281e3536b12dd1130bee5.png', '', '', '', '', '', '', '', '', '', 0, '2022-11-20 18:16:00', NULL, 'ec784cdf5cca37cdd3247336fd566207f226cfb8.jpg', 'fd93ad98711ba3860374f409895113c63dafc862.jpg', '11ee46173b8616e638297fa3d287c63c1dbf4a13.jpg', '054b15c9bbac8a9ac9ca1ead094bf8f1a3a5b8c6.jpg', '1d25f2cef57659c5edf1811f61458b87bf1b06b1.jpg', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL COMMENT 'カートID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザーID',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `cart_detail`
--

CREATE TABLE `cart_detail` (
  `cart_id` int(11) NOT NULL COMMENT 'カートID',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `quantity` int(11) NOT NULL COMMENT '数量',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `categorys`
--

CREATE TABLE `categorys` (
  `category_id` int(11) NOT NULL COMMENT 'カテゴリーID',
  `category_name` varchar(64) NOT NULL COMMENT 'カテゴリー名',
  `parent_id` int(11) NOT NULL COMMENT '親カテゴリーID',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'ステータス（0:非公開、1:公開）',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `categorys`
--

INSERT INTO `categorys` (`category_id`, `category_name`, `parent_id`, `status`, `create_datetime`, `update_datetime`) VALUES
(1, '書籍/CD', 0, 1, NULL, NULL),
(2, 'ステーショナリー', 0, 1, NULL, NULL),
(3, 'ファッション', 0, 1, NULL, NULL),
(4, 'インテリア', 0, 1, NULL, NULL),
(5, '食器', 0, 1, NULL, NULL),
(6, 'フード', 0, 1, NULL, NULL),
(7, 'ヘルスケア', 0, 1, NULL, NULL),
(8, 'オリジナルアイテム', 0, 1, NULL, NULL),
(9, 'ギフト', 0, 1, NULL, NULL),
(10, 'ポストカード', 2, 1, '2022-11-14 16:30:07', NULL),
(11, '手帳', 2, 1, '2022-11-14 16:30:18', NULL),
(12, '年賀状', 2, 0, '2022-11-14 16:30:29', NULL),
(13, 'ソックス', 3, 1, '2022-11-14 16:30:41', NULL),
(14, 'アクセサリー', 3, 1, '2022-11-14 16:31:18', NULL),
(15, 'ストール/マフラー', 3, 1, '2022-11-14 16:31:42', NULL),
(16, '帽子', 3, 1, '2022-11-14 16:31:54', NULL),
(17, 'バック', 3, 1, '2022-11-14 16:32:12', NULL),
(18, '手袋', 3, 1, '2022-11-14 16:32:23', NULL),
(19, 'その他　ファッション', 3, 1, '2022-11-14 16:33:04', NULL),
(20, 'ラグ/マット', 4, 1, '2022-11-14 16:33:48', NULL),
(21, 'フラワーベース', 4, 1, '2022-11-14 16:34:01', NULL),
(22, 'ブランケット', 4, 1, '2022-11-14 16:34:39', NULL),
(23, 'オブジェ', 4, 1, '2022-11-14 16:34:59', NULL),
(24, 'フォトフレーム', 4, 1, '2022-11-14 16:35:28', NULL),
(25, '鏡', 4, 1, '2022-11-14 16:35:38', NULL),
(26, '収納/ラック', 4, 1, '2022-11-14 16:36:05', NULL),
(27, 'テーブル', 4, 0, '2022-11-14 16:36:20', NULL),
(28, 'チェア', 4, 0, '2022-11-14 16:36:31', NULL),
(29, 'その他　インテリア', 4, 1, '2022-11-14 16:36:47', NULL),
(30, 'test', 1, 0, '2022-11-20 18:16:44', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL COMMENT '顧客ID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザーID',
  `name_kanji` varchar(32) NOT NULL COMMENT '名前（漢字）',
  `name_kana` varchar(32) NOT NULL COMMENT '名前（カナ）',
  `sex` int(11) NOT NULL COMMENT '性別（0:男性 1:女性）',
  `birthday` datetime NOT NULL COMMENT '生年月日',
  `phone_number` varchar(11) NOT NULL COMMENT '電話番号',
  `email` varchar(128) NOT NULL COMMENT 'メールアドレス',
  `post_code` varchar(7) NOT NULL COMMENT '郵便番号',
  `xmpf` int(11) NOT NULL COMMENT '住所',
  `address1` varchar(64) NOT NULL COMMENT '住所1',
  `address2` varchar(64) DEFAULT NULL COMMENT '住所2',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有効',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `dashboards`
--

CREATE TABLE `dashboards` (
  `dashboard_id` int(11) NOT NULL COMMENT 'ID',
  `news` text NOT NULL COMMENT 'ニュース',
  `topics` text NOT NULL COMMENT 'トピックス',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有効',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL COMMENT 'イベントID',
  `event_name` varchar(64) NOT NULL COMMENT 'イベント名',
  `description` text COMMENT 'イベント説明',
  `event_date` varchar(64) NOT NULL COMMENT '開催期間',
  `event_tag` int(11) NOT NULL DEFAULT '0' COMMENT 'タグ（0:ポップアップ、1:イベント）',
  `event_svg` varchar(128) DEFAULT NULL COMMENT 'svg画像',
  `event_png` varchar(128) DEFAULT NULL COMMENT 'png画像',
  `img1` varchar(128) DEFAULT NULL COMMENT '画像1',
  `img2` varchar(128) DEFAULT NULL COMMENT '画像2',
  `img3` varchar(128) DEFAULT NULL COMMENT '画像3',
  `img4` varchar(128) DEFAULT NULL COMMENT '画像4',
  `img5` varchar(128) DEFAULT NULL COMMENT '画像5',
  `img6` varchar(128) DEFAULT NULL COMMENT '画像6',
  `img7` varchar(128) DEFAULT NULL COMMENT '画像7',
  `img8` varchar(128) DEFAULT NULL COMMENT '画像8',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'ステータス（0:非公開、1:公開）',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `description`, `event_date`, `event_tag`, `event_svg`, `event_png`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `img7`, `img8`, `status`, `create_datetime`, `update_datetime`) VALUES
(2, 'cottonbroのセットアップ', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'March 2022', 0, '', 'dc85cd114647dde966b1e6207dbc3f95eec8f151.png', '41fcc6fc241403e336fee25ee23a9b62abeeaae4.jpg', 'ebd8ba0ffc278630a99947f5c602b24cfaafcc30.jpg', '48fb0e3e484d5c0cba87918a231b1f1b4f6c1458.jpg', '63cfa9bed9f5d59adb520b8a1048c7076a7bee24.jpg', '78166f1a66cbc2c96957fed35929cd1182a61883.jpg', '4d1b3e55e3d57ca5b9346b83f0c5535c870804f2.jpg', '8f7d92d10957aa7c23e300aa1842d4e9632589bf.jpg', '0bb11d2916fbcf04496f65ff5d1b710c230c7ec1.jpg', 0, '2022-11-15 19:13:05', '2022-11-16 18:20:21'),
(3, 'studio glassのグラス', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'April 2022', 0, '', '2555154ed6dc4ddca1f8335d18c8029e77e66e50.png', 'ed9dab6b3bd7bfbd47c91a39f590c01381438c88.jpg', '787a6d5972d83f94bde7e846dc27920d4ddf2972.jpg', 'f7da981741fdab6bffc9eaa554ab6522f40267a4.jpg', 'b27e5885375445a02b32a0acfa5198bdcfa8dfc9.jpg\r\n', 'ecc3d7a9e5eb272cc385c2a16f5cc50e9ca0f36b.jpg\r\n', '4aa9edd24f952c936955e4176d8072988b988341.jpg', 'f4e9a9250a5d25ac1c86f80b7263af297bde3bc9.jpg', '9a3981b49166f0459575f5b41a11e2d44f2a4cb7.jpg', 0, '2022-11-16 12:58:59', '2022-11-16 15:39:38'),
(4, '.lacie　アールヌーヴォーアクセサリー展', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'May 12th - June 3rd', 1, '', '9def843f1a38ed83b3dbe26788806d299b021635.png', 'f61c58c7da237ccec0f4d6a0d7789c301570269b.jpg', 'f37044fb74b96c2736c7e0d5e6d373a5eacb69b6.jpg', 'f545e439a63a28bcce4880f04bc784ca1ee74e69.jpg', 'a09be4180e229c1a93dc7c13370839d1bc7e98bd.jpg', '9d84fce276c6ad46b338f9ad98b46c0a41e05c32.jpg\r\n', '0c7581931b398c3b4589879ee4fc2fef2bdff56f.jpg\r\n', '3739dc01b9f4f264fb523dc9a0692388b697b8cd.jpg\r\n', '5d1d0f688f2511244cfba64c0a7eaf25354614f3.jpg\r\n', 0, '2022-11-16 13:16:02', '2022-11-16 15:35:09'),
(5, 'eight club 22ss collection', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'June 2022', 0, '', '605f94b89990a9e1792dbce12798f5d0e5f986a2.png', 'a42d25c4e96627ec077d4d2f5b8e299af4464f55.jpg', '3e8d73ed713c8e3beae23729c5368b3bee7ac4ec.jpg', 'b1a13b7d277770c8b779da56620afff41196b41b.jpg', 'c477e65414e605d369feab8910d7d20ab46f10a8.jpg\r\n', '0151995c7faca3932d207d00501d4a1a50f45220.jpg', '447974a3c456da3402f519b950dfa0e5a326738c.jpg', '11d1dcaaa995f7f149fcf6b982aa431191d242a3.jpg', NULL, 0, '2022-11-16 13:35:44', '2022-11-16 15:34:49'),
(6, 'THE SHAKESPEAREのデニム', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'July 2022', 0, '', '256c4179d063c63524679a3ba87114be0e5f279e.png', 'a2dec6510ae8185fbbc1a3043a3746ac7dcdb4e3.jpg', '351d4d039d7d6c2c315068ed96100a3511c69875.jpg', 'fe6d6558002226bd78d1871296293fe9205ba39f.jpg', '211088c7381333225c5a213131f98708233dadef.jpg', '398717aa488bc24c1bdbc3fca6c3a90f353bbfb3.jpg', 'e24c834ba21fb1544b5632c70ecf73d41c408d00.jpg', 'c267707dfc2b86b0b5fef70f77dbb92764219664.jpg', '5e3d8d654ca6d6f313748790c34f3c4290981fbb.jpg', 0, '2022-11-16 13:46:18', '2022-11-16 15:34:38'),
(7, 'ISM PRODUCTS　リサイクルプラカップ', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'August 2022', 0, NULL, 'e8de8782edeb9f277266b254b3d4fd3d305b7d17.png', '0d697191f4e3221c7aa36cb60510b62738ca9ea1.jpg\r\n', '08daa045ee335ed5830b48851244efcb99c5da68.jpg', '1bb7d010212fd4274f890dbd14fb07e06c2a9af9.jpg', '7df2a2272d5b0f9ef799efa784571319ab29ecdb.jpg', 'bda2e787b5644731ca6ff14d51a218714d867400.jpg', '8c32404bef0126372e50dbff9f089a47c1f480b3.jpg', 'd1d1088d9271e315f11972c0df646f3517706aa9.jpg', 'e81c64e6ed59633057aafa85ab839b976daa9145.jpg', 0, '2022-11-16 13:59:08', '2022-11-16 13:59:46'),
(8, 'stationery Labo パンとコーヒーとステーショナリー', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'September 2022', 0, NULL, 'f41f63bf38f71d2636edb09c209a7282be6978e6.png', 'ef9630ae1347bb66211a92ccdd1afcb610621e49.jpg\r\n', '4a0aedc4c1f12d683cfb372e5f9d623afaa06edd.jpg\r\n', '4503e4cadca2862306d5ff75447d054790a01cce.jpg', '249e69c528e8a98163efa4644f303e5893e0f15f.jpg', 'abfdc56003f0b287e1e85543f3e1c731e17fbcf3.jpg', '28f93304084bf1b54cd1d04400e513833a8593d5.jpg', '1faab74ad02604784b0b85b32e844b5ea2f0ac2a.jpg', '2e741064535dd7f58e806a601fe6eaf133fbaf98.jpg', 0, '2022-11-16 14:16:54', '2022-11-24 14:20:45'),
(9, 'whoechoの新作ブランケット', 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'October 2022', 0, '053930b31a66215753e92666ee2aa85328a154f2.svg', 'ff60040c6cbb6233235d2754d9032d19cd441b55.png', '3bc170ef1189e1e2f3504bc5ce1c27f2d61005db.jpg', 'cd736683e3cccafe08c020ea01f9d76f60fec07e.jpg', '13530e31b755f9baa6503e8e26a28cc9173b67fc.jpg', '4689e27b653c643166ad2215b21db7e623281673.jpg', '273283993090567baddc4e4a298ed7f31ddb26ad.jpg', 'fc648a2461ddcb082a5a579f8501dfc0adf13ca6.jpg', 'b93a377eb21b48915324a20314551d61a47b952d.jpg', '734e20e905d7a10dd50f740f1ae3676c3532176f.jpg', 1, '2022-11-16 14:51:10', '2022-11-26 18:40:39');

-- --------------------------------------------------------

--
-- テーブルの構造 `exclusive_brands`
--

CREATE TABLE `exclusive_brands` (
  `event_id` int(11) NOT NULL COMMENT 'イベントID',
  `brand_id` int(11) NOT NULL COMMENT 'ブランドID',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `exclusive_items`
--

CREATE TABLE `exclusive_items` (
  `event_id` int(11) NOT NULL COMMENT 'イベントID',
  `item_id` int(11) NOT NULL COMMENT 'アイテムID',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL COMMENT 'お気に入りID',
  `user_id` int(11) DEFAULT NULL COMMENT 'ユーザーID',
  `item_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `item_id`, `create_datetime`, `update_datetime`) VALUES
(1, NULL, 43, '2022-11-24 18:19:10', NULL),
(2, NULL, 42, '2022-11-24 18:34:53', NULL),
(3, NULL, 42, '2022-11-24 18:59:20', NULL),
(4, 2, 42, '2022-11-24 19:06:40', NULL),
(6, 2, 45, '2022-11-24 19:28:03', NULL),
(7, 2, 43, '2022-11-26 16:47:28', NULL),
(8, 2, 33, '2022-11-28 13:28:56', NULL),
(9, 2, 28, '2022-11-28 13:31:27', NULL),
(10, 2, 23, '2022-11-28 13:32:56', NULL),
(11, 2, 25, '2022-11-28 16:46:19', NULL),
(12, 2, 14, '2022-11-28 16:46:53', NULL),
(13, 2, 16, '2022-11-28 16:47:22', NULL),
(14, 2, 10, '2022-11-28 16:47:49', NULL),
(15, 2, 11, '2022-11-28 16:47:59', NULL),
(16, 2, 1, '2022-11-28 16:48:19', NULL),
(17, 2, 5, '2022-11-28 16:48:35', NULL),
(18, 2, 7, '2022-11-28 16:48:46', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `item_name` varchar(64) NOT NULL COMMENT '商品名',
  `category_id` int(11) DEFAULT '0' COMMENT 'カテゴリーID',
  `brand_id` int(11) DEFAULT '0' COMMENT 'ブランドID',
  `event_id` int(11) DEFAULT '0' COMMENT 'イベントID',
  `price` int(11) NOT NULL COMMENT '値段',
  `description` text COMMENT '商品説明',
  `icon_img` varchar(128) NOT NULL COMMENT 'アイコン画像',
  `img1` varchar(128) DEFAULT NULL COMMENT '画像1',
  `img2` varchar(128) DEFAULT NULL COMMENT '画像2',
  `img3` varchar(128) DEFAULT NULL COMMENT '画像3',
  `img4` varchar(128) DEFAULT NULL COMMENT '画像4',
  `img5` varchar(128) DEFAULT NULL COMMENT '画像5',
  `img6` varchar(128) DEFAULT NULL COMMENT '画像6',
  `img7` varchar(128) DEFAULT NULL COMMENT '画像7',
  `img8` varchar(128) DEFAULT NULL COMMENT '画像8',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'ステータス（0:非公開、1:公開）',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有効',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `category_id`, `brand_id`, `event_id`, `price`, `description`, `icon_img`, `img1`, `img2`, `img3`, `img4`, `img5`, `img6`, `img7`, `img8`, `status`, `enabled`, `create_datetime`, `update_datetime`) VALUES
(1, 'cottonbro 001', 3, 1, 2, 126000, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '84b6a89331cb388aa277e90e0275db2224b3f2ac.jpg', '021d6ffd6a8a93b3e8419db86c55da2a258ee9e1.jpg', 'dbbb33440f019ccd2a04d64ed12c7b89e9046004.jpg', '7a2803b972ed8787dfdb43424e142d104382ebf7.jpg', 'c38fe28904617b304d6cc1dab82f76736d90abcb.jpg', '4d693b25b67a974723bf0f33591aa81920927b1e.jpg', 'c38b0625eb7980dfbc86a4ccc714f59aeb25667a.jpg', '166441262227dc92f67d39d5deca16e2f7248407.jpg', '7d01fb475b6426ab9cdc7d88ac3c9e6e60eed3f1.jpg', 1, 1, '2022-11-15 19:23:31', '2022-11-16 15:49:03'),
(2, 'cottonbro 002', 3, 1, 2, 126000, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'bb5486311d9bec761ae2ea963e4097ebcfcffdbf.jpg', '0f0db9ca6ff2d59582189604d2abe0ac3bf5f727.jpg', '8afc3353347628547cbdb41b90b4a6eb5503ff23.jpg', '080adc80c6f6717149939cfe7a34c830e7f93cd6.jpg', '9904ddeaf969e0d0e5ad4addee41eefd7f77dc52.jpg', 'fe4bd3e83820ffb8a8083afa70e09deb6fa26a1f.jpg', '895139bb3d7a4a9ed17e3728cafafc573b3d6954.jpg', '9ee13a697a14480876edebfa0d2fff9d2875d7fc.jpg', '331943817a1fbf5e298a8c21bc4bc5ec417032d8.jpg', 1, 1, '2022-11-15 19:31:17', '2022-11-16 15:48:48'),
(3, 'cottonbro 003', 3, 1, 2, 136000, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'f60da3112592e5fc9ee009ab98cd7eda0a423329.jpg', '0b1a2d6416da9b0d5185d05fd53c88ca133e44f7.jpg', '3656e81a4027810dd95451fdf6123b41b2d52cae.jpg', '8778501677c98132e9e782280efc9b153964cbd5.jpg', 'd913a3d8e6c390a25c48e4950687945ad39e450e.jpg', 'f8f00c83bb9972a5e3d7fc08e38ff433ed0cd6b5.jpg', '529d08a6f234cdce44c37ba1a375cec13aaefee4.jpg', '61e226e79f808dc4d7172720a08b7dc278af9b12.jpg', '691a3d183629027b9aa6eba20e67bf1116390860.jpg', 1, 1, '2022-11-15 19:56:53', '2022-11-16 15:48:32'),
(5, 'cottonbro 004', 3, 1, 2, 136000, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '548a20c378e78a831cedcd1185fb4c843fe83cc8.jpg', '7f00c1f9ed2646811ab395904c1a6c9ff6deadd4.jpg', '91f547323743616a2b917991b134f62db40e0883.jpg', 'e492a39ce9b14003cb64814d64057019600a6514.jpg', '989021e1da2fea56045faaa5c6d5f332af59b51f.jpg', '9d3cebdfeab8d6a828101a0ecfe6e2f21c7cda45.jpg', 'fe4d3ce25c61dfc92f669b7fdad587c062c9cce5.jpg', 'e949bf74629792adac8693c54d17bd8bbf78d573.jpg', 'b4502192dc6d622da1808738e3f2394535739641.jpg', 1, 1, '2022-11-15 20:01:39', '2022-11-16 15:48:19'),
(6, 'cottonbro 005pink', 3, 1, 2, 8800, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'af46f0b62217b7142acb7895a32fc1c3d23f23ce.jpg', 'e8943988f19fc687076c7d7635063bca41c86375.jpg', '5eba796c88f0cc8c1f9b28d3f3124dda6bfd71c5.jpg', 'f42ed192cf45f11fb7ef60d6f4e9246c56f87646.jpg', 'd36edb2aab14b80d4d5f74c7f528ce5dc3996f39.jpg', 'ba581cabc4b40e9ecdb466f8086b5f9f6959d037.jpg', 'd1a62466a64789e6b581fcb80de7200c2c5f7f87.jpg', 'b549953c910602d9cdd36d368e1751e681062276.jpg', '14025973413146d8da93b5221b5443c9423fbd80.jpg', 1, 1, '2022-11-16 12:45:45', '2022-11-16 15:48:06'),
(7, 'cottonbro 005blue', 3, 1, 2, 8800, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'f5a862a2a1393f1b7f2b39481758f159fba7a5db.jpg', '8d8824910d8e31ed5abb1a8d217020aed98f9c14.jpg', 'd8898b4b1d282c33a73a99701a6400d7c5d21e49.jpg', '1c281e9899da8f76c5e19f3cc32577f3e62f452c.jpg', 'e61e9189705ec6e475816f7c4a7b570caed44e78.jpg', '66bb3d16bda546fae8b88dbf47614895fc485756.jpg', '1f3933ff660356de38801c732ff0c1c44cfe1ea6.jpg', '9e7c2d0ed8ea2a8bba058c8ed709b1bb6ea7ba25.jpg', '6cb460e25b03a41281cc59900db75d8a090a11e1.jpg', 1, 1, '2022-11-16 12:47:27', '2022-11-16 15:47:51'),
(8, 'cottonbro 005green', 3, 1, 2, 8800, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '8218fd261eb45832d448b04d1ea7bf816941e0ae.jpg', 'fc2b8d2f0806b3e92b8aed9f9c04dfe931e012c1.jpg', '45fbd684d893e327ad95e0771e163047a5234e6d.jpg', '89983f1d21d5e8a879ff99757ea0e8b04b7a7c97.jpg', 'ca50e22c3690bae512076bc983067e8aee57ddc6.jpg', '4f3c8281ebbb9253203768857506db4cfaa4f485.jpg', '94838dfa9eae21778427aa90fb8b3745bd6a54e6.jpg', '7cd047d93278526b8cfdb5c1c269a80a25068208.jpg', '828066b3dc4bb96934cb0cb0e77a0ffe7db05efe.jpg', 1, 1, '2022-11-16 12:49:48', '2022-11-16 15:47:36'),
(9, 'cottonbro 005black', 3, 1, 2, 8800, '上質な生地にこだわりテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '633cf8c4b84a036189375f1245f7896ee5ad5d22.jpg', '07af8d5eb433a9110adfc4966892014ea5d2473e.jpg', 'b5e0ee027788b854887f40bd9768d550ffc75c11.jpg', '04d0909f5a721d71299ea5bcc49e5f4982f0733e.jpg', '936187a774dfeb70becc3e303bb463a5ffff9306.jpg', '94727090b093677444fe94743711102a1178c8ad.jpg', '08b92efefa589de4578be8c7584484825e5b0aba.jpg', '85fa65a656e04c14b4b68d0301a58c5305994e43.jpg', '7663b39ee2ec33e791d4f32daded8e127789d22a.jpg', 1, 1, '2022-11-16 12:50:57', '2022-11-16 15:47:22'),
(10, 'glass', 5, 2, 3, 5500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'a4bb49fb2d81c0f57ed268fe39da2f784e424898.jpg', '861d9649f2c2cb0de9978adc66a33acdf5e249ff.jpg', '8adb5f6f2a67cb25ce810e0a3e4c9c64e873fc39.jpg', '17b050c61f0b85051ab2fc8e8a305e00d1bbc18d.jpg', '641f1cc518feab6bba9a8a3e1535c644ff03a186.jpg', '69f9abfa8f590260c511cc81910381f2093492b3.jpg', 'bb34af16f8811cebb8c6fc6c69de4184bbb04eed.jpg', '0d4ab5bff0e44a81b32e15795d3c44c1034d8aaf.jpg', '01f3e78924d25c21b0cef492bfd55c3be4e27161.jpg', 1, 1, '2022-11-16 13:01:37', '2022-11-16 15:47:08'),
(11, 'decanter', 5, 2, 3, 7700, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '36c6bc18615bd80976568da11b56fb1579817a6c.jpg', '11c9adc740ec87994ca4f7935f70ce8dba3c7011.jpg', 'db340393e14303e65b71381b8e4a9ff92afe814f.jpg', '637eb606f76352fe96d5c11fed95d4e93978f836.jpg', '187102a52cc839f3e15818fa319ebb601e9bf392.jpg', '59cfa77435a36fea39aedfa7c84bc68eb5654226.jpg', 'b10fcebe98aa3ea04aa9411ee785e9aa6cce220e.jpg', 'b79d5948a98d2728b83e9138608e2e2c8b26ad1e.jpg', '7abcc725c459e674d322ea96c911b2f378a75476.jpg', 1, 1, '2022-11-16 13:03:12', '2022-11-16 15:46:53'),
(12, 'glass & decanter', 5, 2, 3, 17500, 'グラス２個/デキャンタ１個テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '4c143281fa54a6378c35969fd3b18107907a6dcc.jpg', '357206047f92f8376859cbf40333bad013834a51.jpg', 'cf9f93ad8db2fbb6bab1e3c09c2ab363974560fb.jpg', 'fbf0e3f0a5ceab4b94ee27d6cd6ea0d841a7de3b.jpg', '702636223ff5cfef14b97921a957c31c879db56b.jpg', '53c929449a9277b547c393597c97ba2a52b1a69c.jpg', 'bdf89c57b2d9bf5a3f43cc4befa640179e3b3d20.jpg', 'd9e9f6ca61a32edc87e32c411dfe28608f54a5cc.jpg', '7ab9a7c01b2d7617d94e5f9e88478727e14d60e5.jpg', 1, 1, '2022-11-16 13:06:32', '2022-11-16 15:46:38'),
(13, 'flower', 14, 2, 3, 3500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '7769c24f59d62733ca98a989e2c025ddde02c8c4.jpg', '81a384073c93dc8a2104b9bc30b7d472d9bd9748.jpg', '635aa7cac3c081156926b88f853262e5cbbacc26.jpg', '3b6d7e9bba4a24bd52b7c409364137fb490b43b1.jpg', '1e5756041750e371a1464af4773e220c46660a8e.jpg', 'ed980373f2fbff7a6ed05ab29ca58247919c7ce8.jpg', '731d986586a6de99d2e846cadb7fda7580de235f.jpg', 'c158b15375128aaa919da1d9f07459142d3f8117.jpg', 'b39018f0892bf24985d27bbf3ff42a7f22a74c60.jpg', 1, 1, '2022-11-16 13:08:04', '2022-11-16 15:46:25'),
(14, 'LA2201', 14, 3, 4, 7700, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '3a767b6a98e954cdb4e63532d35c21d8d8e400b8.jpg', '523b07b761da5d9dade7a0dc1c524cc44b0486a2.jpg', 'ff60d3a9dce2c1c8b694d95fa63b91432dbc4bab.jpg', 'd01ee7824ccbc44d178bff845110b935e034c3c6.jpg', 'f202e238e22298f50150b0a409a214976e4d248d.jpg', NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:18:08', '2022-11-16 15:46:13'),
(15, 'LA2301', 14, 3, 4, 5500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '5f4bd837d187cd2e7134a64e051ae4300c512944.jpg', '7fac1c2f5d478b46e2a94268dc897bd2a11e69b0.jpg', '0d2938663b3ce25117e6c7c9edfe2393ba843306.jpg', '339de19b3ad07a5c3372954c4bc5de145ed33e12.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:19:39', '2022-11-16 15:46:00'),
(16, 'LA2204', 14, 3, 4, 7700, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'd938e84ab02ea9cfece5cade8d8a3fbc46f391d5.jpg', 'dc682ce7f9ebb65d784e596e7d655d4abc2dc49c.jpg', '45b9e0d347e960e18e70fd62b098b9c69b7c8e02.jpg', '5ed296ab16b77a12a3beb4ff63c6be61b656a46b.jpg', 'bec5e7896c4c01568c1bc0bafb4ee964d74d91a6.jpg', NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:20:50', '2022-11-16 15:45:46'),
(17, 'LA5401', 14, 3, 4, 15500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'a2ae9e57734fb202456a8eb5452a3b5e72413814.jpg', '669440eec266dacddc0e38104a944a149e03716f.jpg', '9f8c772b2f86ac865c6a244707f8ee8f7a3e0745.jpg', '22fbcc47a449901450f606315be8e16c38f88809.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:22:36', '2022-11-16 15:45:34'),
(18, 'LA2001', 14, 3, 4, 4400, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '9e67c23b2be290c5dadabaedac4a3f9d30827adb.jpg', '5fa1cdaa739f74b2b362c6a0b9dc27930b5d7955.jpg', '9fcb654428eec5fe8a43e0ebb67433b9eb71a3de.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:23:36', '2022-11-16 15:45:20'),
(19, 'LA2101', 14, 3, 4, 6600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'a0552c35d6314a295ee23fa501b54076612e874f.jpg', 'dc92a3050931da6bb6b06db297af09b3bc0252ab.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:24:28', '2022-11-16 15:45:08'),
(20, 'LA3301', 14, 3, 4, 5500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '29430d9e658c7d6fe447d811f14ebf847ae81989.jpg', 'ad39b59f555201753ba950f81ab087873b7403e4.jpg', '991e8892fab060cbfab48ddbc91255ab92c584cd.jpg', 'd05c33544608ba2686fdb52b92c0d968e64b9a4e.jpg', '780d8f7a8a7aca88ba8180ac1311a5c4adcee140.jpg', '8c972e43960dc2e06037f2b9d8146b0a535ef1c7.jpg', NULL, NULL, NULL, 1, 1, '2022-11-16 13:25:41', '2022-11-16 15:44:54'),
(21, 'LA3304', 14, 3, 4, 3800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '82cea1a2561b221f3379e93310d400730ac74f9c.jpg', '0165d02fd00a1f20592c18f5058a34ae719eea99.jpg', '2530813ac434bbdb38edc59e80e0fa3c288be90a.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-11-16 13:26:36', '2022-11-16 15:44:39'),
(22, 'LA3303', 14, 3, 4, 4400, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'a85f04555ad4857204419aa8899e7ff13dac6953.jpg', '781bcf13cc80b6af775513e48c4377488e877500.jpg', 'b8d525d1a25b859fdcfde757b3e3be39333276c6.jpg', '9a70061f5655614146be84e55de39b381d137e65.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 13:28:17', '2022-11-16 15:44:09'),
(23, 'knitベスト', 3, 4, 5, 11000, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '55d642f33d3f3796ca590e12ac266641e1d85e7e.jpg', '1aadf54f40ee8ad7cce021a07140e9030b0c22b6.jpg', '2b2720c2c3c77d186017e88c7edaaadabb609c93.jpg', 'f9fd94043f120a4894eb5c99fd1e7a313a6d7c1a.jpg', '3460346db636f7903d8ee20d81f0dc7d95c05749.jpg', 'cbaf475873b7ef311736550da8067f274884430e.jpg', '0a7290114cee4ec242696eb4589f722104fe6d88.jpg', 'a00d163ffb311348014220d905466763384811a4.jpg', '1e577956f42dd4959be20e790ae9693f8f538683.jpg', 1, 1, '2022-11-16 13:37:24', '2022-11-16 15:43:58'),
(24, 'knitシャツ', 3, 4, 5, 16000, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'b41121b9d139150a193e078cb5e0c49880314c2f.jpg', '59d79384e0e8058054a7285fdcdd378635df9fdf.jpg', '6b62f634c9c07d659b9df811ed2f0117c6889758.jpg', '1922902a863d0f7e55443fffc51f11c1403cac9f.jpg', '4fe3955f7f2bd4652ac88d755c3cfccac4e33f0d.jpg', '16461de4f413659abef61f847100dec4ca75a578.jpg', '321c8327559246ccbc5570feb390e881b507af01.jpg', '9dfc672ea77ab34ab414c987da1aabe2e542d69e.jpg', 'f07a727d2e45aa618d7a52ad2402e9df5d611f81.jpg', 1, 1, '2022-11-16 13:40:06', '2022-11-16 15:43:41'),
(25, 'DENIM 100', 3, 5, 6, 15600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '6900143872c0ef015375303b8c9156af82d2d70d.jpg', '7e38ce0a5766c27f225145264d19b17808791c3c.jpg', '91b4178fc23f25599c118c74361e6de1c79b1da8.jpg', 'b14758c21f33044f1ff6189f7555b9da59dad151.jpg', '611c14f7323acc442c81ce7fc5d6a152b6d5caa0.jpg', '2082d2184a49ad4b693ce6b373f5bc0c702df70d.jpg', '735522ad96dd21a428a96a771b18cf731883846b.jpg', 'b437dab85349c32d913351bd6383f564b2935a37.jpg', '0e3d7fcbee6a34ce7157f6e89b3f69cf44d23999.jpg', 1, 1, '2022-11-16 13:50:17', NULL),
(26, 'DENIM 120', 3, 5, 6, 15600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'a2994f3c238b70287165571768062dfd83cc6f1a.jpg', '4a226a8873fa10e9d3f2304dc79c695aff5de5c1.jpg', '69bd18203ea8eb94760a2f33c298a79b719485d3.jpg', '09e8e189237792e1bd846bfdc3121d5f3c91e041.jpg', 'a84eeac4ce6fac5226feb951600a6eee26e15a1b.jpg', '8505b60b64591fa635b35d819dc29b30818f24db.jpg', '5a8193b011c771dd53e69443bb48e26e2ee9ed47.jpg', 'c45a1b41fc38cc6bc600f38dc4c3f6578e7f8373.jpg', 'f13ab577815f874d54d70211f61eac677eb64bd0.jpg', 1, 1, '2022-11-16 13:52:08', NULL),
(27, 'DENIM 200', 3, 5, 6, 14600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '19166a47d112f3f0431dd63f58b683f8e5395e72.jpg', '974375def63da8b08c868e1259f8dccb7f6fb7ab.jpg', '8e076627babd6c0f14f3d244233c8e1fbdddd37d.jpg', '81bf480041f5870b8f3741cee754354a61249ea9.jpg', '9861e492b731a5cf128f731570147d979499d2c3.jpg', '092fcdb579ebf9302b2fc811abd928f6711be40a.jpg', '2f78630439b690c3aa923387d23d4449f16f2851.jpg', NULL, NULL, 1, 1, '2022-11-16 13:53:07', NULL),
(28, 'PLASTIC CUP', 5, 6, 7, 500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'c945787b4bae73962d6c913241b36a28db59c816.jpg', 'b5de878c28a54382c5c5c2f5d9aaeb7aa40c1449.jpg', '17b560a4b7b90261b6576c6335c8dccfa3155272.jpg', '232a80b50ac4a32e65cf2b4f0a7c83b773f510a4.jpg', '6bf572658f1cdf02914a97b9fcda065332d2e182.jpg', '2c473ebb69b5954e29267363dd5ba06c6f581951.jpg', '5d9a1bdcfd82eb9867b189b868b2ece6a43dede0.jpg', '30b5e72345f2a99145011e4a7ac2dbe2b6b351e6.jpg', '9ef10d7cdccbfc6cf16ad0a0d0ac6e670a161ed4.jpg', 1, 1, '2022-11-16 14:02:26', NULL),
(29, 'ギフトボックス', 8, 7, NULL, 800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '4c20b15bbcbffcc5b9d58a7fb5c70292043930b7.jpg', '20471add1ea11774eefb3b00b1c60e4a7d25a84d.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:05:52', '2022-11-24 12:36:16'),
(30, 'オリジナルトート', 8, 7, NULL, 1600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '636cf42cfe79bab71cb69dc57987d3c2aed442cf.jpg', '1776d3c2b5aa8c3721ce2923654fedf43b2d5840.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:06:52', '2022-11-24 12:37:01'),
(31, '季節のタルト', 8, 7, NULL, 900, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'f0eba5d185dca4fd3a92da10ee49c91971b3b31e.jpg', 'fa67a8e90fffdeb108a2db6ffb22b37ba7961108.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:08:49', '2022-11-24 12:36:47'),
(32, '季節のフルーツ', 8, 7, NULL, 700, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '76e8f1a952053598ac6395ccef99b076ac06981b.jpg', 'b555c86cff2524219f8bd5e9e6a949c1372e478f.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:09:42', '2022-11-24 12:36:29'),
(33, 'envelope', 2, 8, 8, 300, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '6b32abac67bc2ac9023bab4f0ea3f8f5fbe1bf37.jpg', 'c9fbee22b2280e5adf144a6a17b46d6c720bb284.jpg', '196e24ce333e878ecfc38fb11e3393e3f304b3ef.jpg', '0c60ed6c71ad90c5142712c334796a3c6cdc65bb.jpg', '1fac80f07c5f011c09a86d36aa281982cbb04807.jpg', 'd38361bbad956cae9f6459b346ead7ef762a1435.jpg', '2ae481f13cc282dd54320c043e4f13add8d87c28.jpg', NULL, NULL, 1, 1, '2022-11-16 14:18:05', NULL),
(34, 'sticky note', 2, 8, 8, 600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'bc99cc36ca3a8c49fbd6d6c65e9092ed86aaa5de.jpg', '62c3f3b489aa14d8fc40684590acb38440c569c4.jpg', 'a91e18a47ef7eaf4541f65a6341b7fa8aa39c8e2.jpg', '41a56b11972d35b9d1ae5207fb257e1e4378719c.jpg', 'c090e26534869b2c5b32cc393c98bf5df35a2bdf.jpg', '29b2bc48a0e6b1f579e69f3fbfb6d0ce052a42c4.jpg', NULL, NULL, NULL, 1, 1, '2022-11-16 14:19:15', NULL),
(35, 'pencil set', 2, 8, 8, 800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '1d2b718cbc44e92dbafe1f89e0509205ae3ced15.jpg', 'd663004ee6ce23f27152718d4b41bab733d00240.jpg', '6d50bd89c9359d3fcfa7488ad843d773e7f7cf27.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:20:37', NULL),
(36, 'pen', 2, 8, 8, 300, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'b08b0bc9207d96fe9fb7c1ba822e1a3c75dd7d15.jpg', 'dd50e8fdc7aef7cb919d924bdeea2d98f7f296c4.jpg', '2efb4dabf4dc741e942a0a6d1629792f22f92dd6.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:21:50', NULL),
(37, 'chalk set', 2, 8, 8, 800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '0ebc6dad9b1812de985e834f5fe40e5427d3985c.jpg', '2de36185d3c45cc1543ac7b191bec76810ab7bb4.jpg', 'd96b372b41f5047089daf0aaefe6eac39dfbed1b.jpg', '9fc3049f405d55366ae08aa4d3aed85b9a13e232.jpg', '931170f95512e5c622d11da0b357268c1d0d9e3d.jpg', NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:23:02', NULL),
(38, 'letter set', 2, 8, 8, 330, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '5619bfe6a54742acb35d7732df6669c71e4a051b.jpg', '2cd280702ff5fc4e96744d1fedabd469c52f03a6.jpg', 'da35a4ac86ff864d8c046975fec9ba25dc4c65be.jpg', '96f1a33ada6c02a978c704c67e638d7e185a1867.jpg', '95c443556776d9cff88eeb66ac218170ef3a0a2e.jpg', '24221d05381dc45e30bfd7ae80bb06fa35d70d89.jpg', NULL, NULL, NULL, 1, 1, '2022-11-16 14:39:57', NULL),
(39, 'file', 2, 8, 8, 800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'aea737e507c156e485b0975ae9a664a3c1a3767a.jpg', 'd715dd84446286228fb3384d3461a700206c7d08.jpg', '9a6e0ca1a00182c516f952717c6132ac8ccf9289.jpg', '6a247157b68573f5fb0885783ef199c04df5cef0.jpg', '3011e5319ea805b423284892a8cdadc80f88e6c4.jpg', NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:41:21', NULL),
(40, 'note', 2, 8, 8, 600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '44ce355ce3daafdf0857e9725be91b4acca68c59.jpg', '72666ab79924028bd9a3cdcbcf72f396e1fa0b95.jpg', '821e224d0c461b29750d7386381a1ad9195e81a0.jpg', '3fbe095263bad0624d1ac9dbf4c6e0d335af3fc3.jpg', '4ea8b727912591369b7528bb5dcdb737340c9166.jpg', '9022b12932583d267b3bc66852489dd8afe6ded9.jpg', NULL, NULL, NULL, 1, 1, '2022-11-16 14:42:30', NULL),
(41, 'tray', 4, 8, 8, 2600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '3790cd3faf458d886812d102fa4ae8c425892476.jpg', 'cfa5c1f566c9037e96fe0783cc7eac8eda5194b8.jpg', 'b4a0b97078a876e8512facd1a50bdb53cf50747e.jpg', 'e3315a0603d08302e1c6d0be83f46a980395685c.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 14:43:49', NULL),
(42, 'we001 ブランケット', 4, 9, 9, 11000, 'whoechoの新作ブランケット。\r\nテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'c53e8de789151fd21aa412125dbd6d0f2da73e5b.jpg', 'b4c33551696ef63aa0fb950710ba361622b1c38e.jpg', '144caf6224a5f73ac53406a57bc3b8195359e537.jpg', 'c2102c6a300e1d7c6df115b30f66253504f57105.jpg', '32ac8fade0254883e8732f7d61713763b2cfa410.jpg', '65085972208f2b14f1a6e065e658a356843ad88e.jpg', 'bcc3f51f1485941906477742cad6ece01fc4aeb6.jpg', '153f20fff292b3ae7bd553f00af4e5b952541b91.jpg', 'f1a19e0133142d94177df3c6fb3d52ed4618c3ba.jpg', 1, 1, '2022-11-16 17:23:21', NULL),
(43, 'we301 ブランケット', 4, 9, 9, 8800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'e4c28d697aa9beb80dc062ceaf6dda29d8d79767.jpg', 'ebad69603c4e623c1b8a24b00d754e8121169185.jpg', '91b35d839e198fdb9f3076ba8c9601bd0113289b.jpg', '00da540c933bc67a4483941098ea277706322f9b.jpg', 'f94d8b4ebd6acefc539f4418f09eb936d9af4dd5.jpg', '6ab4d8c7cd32f962b54267d6659fa57268d6f65c.jpg', '8240c146b431d41eab0512c2cd3074c77880c6db.jpg', 'a626345e6070a0f3b04777b877e0c36e3f7686a0.jpg', 'f938f990c40d9cd8b987596af568d922bdbc553f.jpg', 1, 1, '2022-11-16 17:24:56', '2022-11-27 19:33:53'),
(44, 'we500 タオル', 7, 9, 9, 1320, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'bc229d4b3d29ba332a2a89b4b9631b17f3178e4b.jpg', '031d632520f9fe69db6722406b48128f2cd7ce14.jpg', 'c36098e719504139f14da6d68e1b7d094ac22dc9.jpg', '4652302da613b3e75ff5cdeba2dffe73e0c502de.jpg', 'd639c38801509cc51e8e1f99347e44cf7685f8f9.jpg', '7f5e352cf3116ff1c2c3396108460e60efbc4334.jpg', 'b939d0547c5f2be637f8406ae068e3c7b0ee471a.jpg', '42442adc41134a0ab712b2e64992d45bc2462209.jpg', '8d31fb2fa6b98225af9af6ec6d80cc16c2a5375a.jpg', 1, 1, '2022-11-16 17:28:39', NULL),
(45, 'we701 ボディブラシ', 7, 9, 9, 3300, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '90e69d356a977599c6846bfd045703f155a17541.jpg', 'e301d2e9dde245d71cf05a9b658222a7bc818aec.jpg', '0c26d223983bf7c96d66807be9adc4fc6c6ba860.jpg', '38bf366f9403fd9c78324953f2a436a7bdfd13a4.jpg', '00fa94933989b003a1ccde24f12aeedf3bf535c3.jpg', 'a1bd0f75d70d63fe6b28aa0354e8507c1b43a2f0.jpg', NULL, NULL, NULL, 1, 1, '2022-11-16 17:30:48', NULL),
(46, 'we703 トゥースブラシ', 7, 9, 9, 800, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', 'af29ac02c50d443d93bfe059554d285af9e3da9a.jpg', '0bb00d913e26114948657a4211cfe33676ca07fd.jpg', 'cfb5b130c5aa18879bfa2d0913039da950006588.jpg', '5b13d29158618f5275cd1f267966a393b8fbfb78.jpg', '9bbdfb75babe43c74dca4a7da8744924a465a13c.jpg', '6b12d7a02c2f96ca1db2be32614eed8c39df2651.jpg', NULL, NULL, NULL, 1, 1, '2022-11-16 17:34:03', NULL),
(47, 'we601 body soap 2個セット', 7, 9, 9, 2500, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '7811cd6468dfab5be45e2464e6d5d898205b7a16.jpg', '668f65de92bb0ba5b890e8b55f3aa89c9b4f5a1b.jpg', 'd94afbf6836d76c54f787ca5958a152971fef94e.jpg', '6afed65dc746396ff890df12e5ca7410e978b715.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 17:37:50', NULL),
(48, 'we603 body soap (アソート)', 7, 9, 9, 660, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '5e61ae1eed18f89974aadca1923464bc8432ed0f.jpg', '6be6cec44a8ea98c0440f3f1125c5cf90cd8d960.jpg', '1204083800c1e43d6f68ebf475496a69efd19abc.jpg', '37b88fefacce536d90ea4d1b2516650d5fb69743.jpg', 'efe9c49adfcfc14c4bb123cce7471617c2a93a02.jpg', '10963c82bfcf86f230224f38df9e789b54e50e26.jpg', '09865420369379f40b4509e451077ce16e355344.jpg', NULL, NULL, 1, 1, '2022-11-16 17:40:01', NULL),
(49, 'we801 comb', 7, 9, 9, 1600, 'テキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキストテキスト', '3142e1d38afc0fbcd2672a3df3a58f5643eb674e.jpg', 'ac56bb0ccafc92daa837ab0807bd4888ccbf1703.jpg', '1e822848ce4c98e273377fd95dc8b42e7dd4707f.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2022-11-16 17:41:42', '2022-11-24 19:43:05'),
(50, 'test', 30, 10, NULL, 100, '', '9e5939fd93ecfa026725ffd5304d4f92c130f42c.jpg', '392d2c28705a0abb4fa04e6a0693721583e7521a.jpg', 'd12b5055d561596ea10e8ed2c646ce18123d21b1.jpg', '69ea7bf2828fd20c04dd82fa3db03d49cb41158d.jpg', '58cf60d77392d0fccdeecf02e3805aa1411aa020.jpg', '625b059568fa2dacbce4e1673dfc3e959a295776.jpg', '', '', '', 0, 0, '2022-11-20 18:18:59', NULL),
(51, 'test', 8, 7, NULL, 100, '', '9ba9a95f8445aa2cfc49b944d424bfed1bf0efaa.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '2022-11-24 14:25:23', '2022-11-24 14:31:11'),
(52, 'test', 1, 9, 9, 100, '', '03d4d80ad3b5fa2a507a6ad15d04b37f9235f566.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2022-11-24 14:34:58', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL COMMENT '注文ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `order_number` int(11) NOT NULL COMMENT '注文番号',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_number`, `create_datetime`, `update_datetime`) VALUES
(3, 2, 977103465, '2022-11-28 12:15:38', NULL),
(5, 2, 354997253, '2022-11-28 14:39:01', NULL),
(7, 2, 1588137861, '2022-11-28 15:37:07', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` int(11) NOT NULL COMMENT '注文ID',
  `item_id` int(11) NOT NULL COMMENT '商品ID',
  `quantity` int(11) NOT NULL COMMENT '注文数',
  `price` int(11) NOT NULL COMMENT '注文時の値段',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日',
  `sub_total` int(11) NOT NULL COMMENT '小計'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `order_detail`
--

INSERT INTO `order_detail` (`order_id`, `item_id`, `quantity`, `price`, `create_datetime`, `update_datetime`, `sub_total`) VALUES
(3, 42, 1, 11000, '2022-11-28 12:15:38', NULL, 11000),
(3, 43, 2, 8800, '2022-11-28 12:15:38', NULL, 17600),
(3, 45, 2, 3300, '2022-11-28 12:15:38', NULL, 6600),
(5, 46, 1, 800, '2022-11-28 14:39:01', NULL, 800),
(7, 47, 10, 2500, '2022-11-28 15:37:07', NULL, 25000),
(7, 48, 2, 660, '2022-11-28 15:37:07', NULL, 1320);

-- --------------------------------------------------------

--
-- テーブルの構造 `recommend_items`
--

CREATE TABLE `recommend_items` (
  `recommend_id` int(11) NOT NULL COMMENT 'レコメンドID',
  `event_id` int(11) NOT NULL COMMENT 'イベントID',
  `item_id` int(11) NOT NULL COMMENT 'アイテムID',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `recommend_items`
--

INSERT INTO `recommend_items` (`recommend_id`, `event_id`, `item_id`, `create_datetime`, `update_datetime`) VALUES
(1, 2, 2, '2022-11-15 20:51:58', NULL),
(2, 2, 1, '2022-11-15 20:51:58', NULL),
(3, 2, 5, '2022-11-16 12:42:08', NULL),
(4, 2, 3, '2022-11-16 12:42:08', NULL),
(5, 3, 12, '2022-11-16 13:08:56', NULL),
(6, 3, 11, '2022-11-16 13:08:56', NULL),
(7, 3, 10, '2022-11-16 13:08:56', NULL),
(8, 4, 17, '2022-11-16 13:29:22', NULL),
(9, 4, 16, '2022-11-16 13:29:22', NULL),
(10, 4, 15, '2022-11-16 13:29:22', NULL),
(11, 4, 14, '2022-11-16 13:29:22', NULL),
(12, 5, 24, '2022-11-16 13:40:34', NULL),
(13, 5, 23, '2022-11-16 13:40:34', NULL),
(14, 6, 27, '2022-11-16 13:55:54', NULL),
(15, 6, 26, '2022-11-16 13:55:54', NULL),
(16, 6, 25, '2022-11-16 13:55:54', NULL),
(17, 7, 28, '2022-11-16 14:02:49', NULL),
(18, 8, 37, '2022-11-16 14:23:39', NULL),
(19, 8, 36, '2022-11-16 14:23:39', NULL),
(20, 8, 35, '2022-11-16 14:23:39', NULL),
(21, 8, 33, '2022-11-16 14:23:39', NULL),
(22, 9, 46, '2022-11-16 17:43:01', '2022-11-16 17:44:17'),
(23, 9, 45, '2022-11-16 17:43:01', NULL),
(24, 9, 43, '2022-11-16 17:43:01', NULL),
(25, 9, 42, '2022-11-16 17:43:01', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL COMMENT '在庫ID',
  `item_id` int(11) DEFAULT NULL COMMENT '商品ID',
  `stock` int(11) NOT NULL COMMENT '在庫数',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `stocks`
--

INSERT INTO `stocks` (`stock_id`, `item_id`, `stock`, `create_datetime`, `update_datetime`) VALUES
(1, 1, 10, '2022-11-15 19:23:31', '2022-11-16 15:49:03'),
(2, 2, 10, '2022-11-15 19:31:17', '2022-11-16 15:48:48'),
(3, 3, 10, '2022-11-15 19:56:53', '2022-11-16 15:48:32'),
(5, 5, 10, '2022-11-15 20:01:39', '2022-11-16 15:48:19'),
(6, 6, 10, '2022-11-16 12:45:45', '2022-11-16 15:48:06'),
(7, 7, 10, '2022-11-16 12:47:27', '2022-11-16 15:47:51'),
(8, 8, 10, '2022-11-16 12:49:48', '2022-11-16 15:47:36'),
(9, 9, 10, '2022-11-16 12:50:57', '2022-11-16 15:47:22'),
(10, 10, 30, '2022-11-16 13:01:37', '2022-11-16 15:47:08'),
(11, 11, 10, '2022-11-16 13:03:12', '2022-11-16 15:46:53'),
(12, 12, 10, '2022-11-16 13:06:32', '2022-11-16 15:46:38'),
(13, 13, 30, '2022-11-16 13:08:04', '2022-11-16 15:46:25'),
(14, 14, 5, '2022-11-16 13:18:08', '2022-11-16 15:46:13'),
(15, 15, 10, '2022-11-16 13:19:39', '2022-11-16 15:46:00'),
(16, 16, 5, '2022-11-16 13:20:50', '2022-11-16 15:45:46'),
(17, 17, 2, '2022-11-16 13:22:36', '2022-11-16 15:45:34'),
(18, 18, 10, '2022-11-16 13:23:36', '2022-11-16 15:45:20'),
(19, 19, 3, '2022-11-16 13:24:28', '2022-11-16 15:45:08'),
(20, 20, 10, '2022-11-16 13:25:41', '2022-11-16 15:44:54'),
(21, 21, 10, '2022-11-16 13:26:36', '2022-11-16 15:44:39'),
(22, 22, 10, '2022-11-16 13:28:17', '2022-11-16 15:44:09'),
(23, 23, 8, '2022-11-16 13:37:24', '2022-11-16 15:43:58'),
(24, 24, 8, '2022-11-16 13:40:06', '2022-11-16 15:43:41'),
(25, 25, 5, '2022-11-16 13:50:17', NULL),
(26, 26, 5, '2022-11-16 13:52:08', NULL),
(27, 27, 5, '2022-11-16 13:53:07', NULL),
(28, 28, 100, '2022-11-16 14:02:26', NULL),
(29, 29, 50, '2022-11-16 14:05:52', '2022-11-24 12:36:16'),
(30, 30, 30, '2022-11-16 14:06:52', '2022-11-24 12:37:01'),
(31, 31, 10, '2022-11-16 14:08:49', '2022-11-24 12:36:47'),
(32, 32, 10, '2022-11-16 14:09:42', '2022-11-24 12:36:29'),
(33, 33, 100, '2022-11-16 14:18:05', NULL),
(34, 34, 30, '2022-11-16 14:19:15', NULL),
(35, 35, 50, '2022-11-16 14:20:37', NULL),
(36, 36, 50, '2022-11-16 14:21:50', NULL),
(37, 37, 40, '2022-11-16 14:23:02', NULL),
(38, 38, 100, '2022-11-16 14:39:57', NULL),
(39, 39, 30, '2022-11-16 14:41:21', NULL),
(40, 40, 100, '2022-11-16 14:42:30', NULL),
(41, 41, 20, '2022-11-16 14:43:49', NULL),
(42, 42, 9, '2022-11-16 17:23:21', '2022-11-28 12:15:38'),
(43, 43, 18, '2022-11-16 17:24:56', '2022-11-28 12:15:38'),
(44, 44, 40, '2022-11-16 17:28:39', NULL),
(45, 45, 18, '2022-11-16 17:30:48', '2022-11-28 12:15:38'),
(46, 46, 49, '2022-11-16 17:34:03', '2022-11-28 14:39:01'),
(47, 47, 40, '2022-11-16 17:37:50', '2022-11-28 15:37:07'),
(48, 48, 98, '2022-11-16 17:40:01', '2022-11-28 15:37:07'),
(49, 49, 0, '2022-11-16 17:41:42', '2022-11-24 19:43:05'),
(50, 50, 100, '2022-11-20 18:18:59', NULL),
(51, 51, 100, '2022-11-24 14:25:23', NULL),
(52, 52, 100, '2022-11-24 14:34:58', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `user_name` varchar(128) NOT NULL COMMENT 'ユーザー名',
  `email` varchar(128) NOT NULL COMMENT 'メールアドレス',
  `password` varchar(255) NOT NULL COMMENT 'パスワードハッシュ',
  `enabled` tinyint(1) NOT NULL DEFAULT '1' COMMENT '有効',
  `create_datetime` datetime DEFAULT NULL COMMENT 'レコードの作成日',
  `update_datetime` datetime DEFAULT NULL COMMENT 'レコードの更新日'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `enabled`, `create_datetime`, `update_datetime`) VALUES
(1, 'nin9nin9nin', 'nin9nin9nin@gmail.com', '$2y$10$2B.nKhQ.7bnZuqZ8wGc8w.NtcLyOECF1tc62JgEMvArflRDubh6oy', 1, '2022-11-21 15:11:05', NULL),
(2, 'testuser', 'testuser@mail.com', '$2y$10$IvbWRfJMflbNTmOXg2qRkuEh0vFCEv4N9YMLK.LRG0V01pr0syxn2', 1, '2022-11-21 18:31:17', NULL);

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `admin_name` (`admin_name`);

--
-- テーブルのインデックス `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- テーブルのインデックス `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`cart_id`,`item_id`);

--
-- テーブルのインデックス `categorys`
--
ALTER TABLE `categorys`
  ADD PRIMARY KEY (`category_id`);

--
-- テーブルのインデックス `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `dashboards`
--
ALTER TABLE `dashboards`
  ADD PRIMARY KEY (`dashboard_id`);

--
-- テーブルのインデックス `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- テーブルのインデックス `exclusive_brands`
--
ALTER TABLE `exclusive_brands`
  ADD PRIMARY KEY (`event_id`,`brand_id`);

--
-- テーブルのインデックス `exclusive_items`
--
ALTER TABLE `exclusive_items`
  ADD PRIMARY KEY (`event_id`,`item_id`);

--
-- テーブルのインデックス `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`);

--
-- テーブルのインデックス `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `event_id` (`event_id`);

--
-- テーブルのインデックス `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`,`user_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`,`item_id`);

--
-- テーブルのインデックス `recommend_items`
--
ALTER TABLE `recommend_items`
  ADD PRIMARY KEY (`recommend_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `item_id` (`item_id`);

--
-- テーブルのインデックス `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `item_id` (`item_id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理者ID', AUTO_INCREMENT=3;

--
-- テーブルの AUTO_INCREMENT `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ブランドID', AUTO_INCREMENT=11;

--
-- テーブルの AUTO_INCREMENT `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'カートID', AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `categorys`
--
ALTER TABLE `categorys`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'カテゴリーID', AUTO_INCREMENT=31;

--
-- テーブルの AUTO_INCREMENT `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '顧客ID';

--
-- テーブルの AUTO_INCREMENT `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'イベントID', AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'お気に入りID', AUTO_INCREMENT=19;

--
-- テーブルの AUTO_INCREMENT `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品ID', AUTO_INCREMENT=53;

--
-- テーブルの AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '注文ID', AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `recommend_items`
--
ALTER TABLE `recommend_items`
  MODIFY `recommend_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'レコメンドID', AUTO_INCREMENT=26;

--
-- テーブルの AUTO_INCREMENT `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '在庫ID', AUTO_INCREMENT=53;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ユーザーID', AUTO_INCREMENT=3;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- テーブルの制約 `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- テーブルの制約 `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categorys` (`category_id`),
  ADD CONSTRAINT `items_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- テーブルの制約 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- テーブルの制約 `recommend_items`
--
ALTER TABLE `recommend_items`
  ADD CONSTRAINT `recommend_items_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `recommend_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- テーブルの制約 `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
