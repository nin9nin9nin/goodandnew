<?php

require_once(MODEL_DIR . '/Messages.php');

//customersテーブル
class Customers {
    public $customer_id;
    public $user_id;
    public $name_kanji;
    public $name_kana;
    public $sex;
    public $birthday;
    public $phone_number;
    public $email;
    public $post_code;
    public $xmpf;
    public $address1;
    public $address2;
    public $enabled;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> customer_id = null;
        $this -> user_id = null;
        $this -> name_kanji = null;
        $this -> name_kana = null;
        $this -> sex = null;
        $this -> birthday = null;
        $this -> phone_number = null;
        $this -> email = null;
        $this -> post_code = null;
        $this -> xmpf = null;
        $this -> address1 = null;
        $this -> address2 = null;
        $this -> enabled = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    //バリデーション
    
    /**
     * テーブル一覧の取得
     */
    public function indexCustomers() 
    {
        //A customers, B orders
        $sql = 'SELECT A.customer_id, A.name_kanji, A.name_kana, A.create_datetime, A.enabled,' . PHP_EOL
             . '       B.order_date, B.order_count' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    customers AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT customer_id, MAX(order_date) AS order_date, COUNT(order_id) AS order_count' . PHP_EOL
             . '     FROM orders GROUP BY customer_id) AS B' . PHP_EOL
             . 'ON A.customer_id = B.customer_id';
             //Max(order_date)で最終利用日、COUNT(order_id)で利用回数を取得
        
        return Messages::findBySql($sql);
    }
    
    
}