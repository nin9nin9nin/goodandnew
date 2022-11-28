<?php

require_once(MODEL_DIR . '/Messages.php');

//adminに追加する機能
class Orders {
    public $order_id;
    public $user_id; //customer_id
    public $order_number;
    public $item_id;
    public $quantity;
    public $price;
    public $sub_total;
    public $create_datetime;
    public $update_datetime;
    
    public function __construct() {
        $this -> order_id = null;
        $this -> user_id = null; //customer_id
        $this -> order_number = null;
        $this -> item_id = null;
        $this -> quantity = null;
        $this -> price = null;
        $this -> sub_total = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
        
    }

    // insert ------------------------------------------------------------------------
    /**
     * 登録処理をまとめた関数（rollback）
     * 
     * ordersの登録
     * order_detailの登録
     */
    public function insertOrder($records = []) {
        try {
            $now_date = date('Y-m-d H:i:s');
            
            //注文番号、登録日時
            $this -> order_number = mt_rand();
            $this -> create_datetime = $now_date;

            //新規オーダーの登録(orders)
            $this -> insertUserOrder();

            //登録したorder_idの取得
            $order_id = Database::lastInsertId();
            
            //プロパティに登録
            $this -> order_id = $order_id;

            //カートからオーダーテーブルに登録
            foreach ($records as $record) {
                $this -> item_id = $record -> item_id;
                $this -> quantity = $record -> quantity;
                $this -> price = $record -> price;
                $this -> sub_total = $record -> price * $record -> quantity;

                
                //新規アイテムを登録(cart_detail)
                $this -> insertUserOrderDetail();
            }

        } catch (Exception $e) {

        $e = new Exception('オーダーを確定できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
        }
    }

    /**
     * 新規ordersの作成
     * 
     * user_idから
     */
    public function insertUserOrder()
    {
        $sql = 'INSERT INTO orders' . PHP_EOL
             . '(user_id, order_number, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '(:user_id, :order_number, :create_datetime)';
        
        $params = [
            ':user_id' => $this->user_id,
            ':order_number' => $this->order_number,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * 新規order_detailの作成
     * 
     * lasrInsertIdでorder_id取得
     */
    public function insertUserOrderDetail()
    {
        $sql = 'INSERT INTO order_detail' . PHP_EOL
             . '(order_id, item_id, quantity, price, sub_total, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '(:order_id, :item_id, :quantity, :price, :sub_total, :create_datetime)';
        
        $params = [
            ':order_id' => $this->order_id,
            ':item_id' => $this->item_id,
            ':quantity' => $this->quantity,
            ':price' => $this->price,
            ':sub_total' => $this->sub_total,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    // index ------------------------------------------------------------------------
    /**
     * index.php
     * user_idでオーダー履歴を取得
     * 
     * GROUP BY SELECT前の命令のため別名は使用できない
     * GROUP BY MySQL 5.7 から仕様変更
     * GROUP BYで指定したカラム以外をSELECTで指定できない（集計関数を除く）
     * 
     */
    public function indexUserOrders() 
    {
        $sql = 'SELECT A.order_id, A.user_id, A.order_number, A.create_datetime,' . PHP_EOL
             . '       SUM(B.quantity) AS total_quantity, SUM(B.sub_total) AS total_amount' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT * FROM orders WHERE user_id = :user_id) AS A' . PHP_EOL
             . 'LEFT JOIN order_detail AS B' . PHP_EOL
             . 'ON A.order_id = B.order_id' . PHP_EOL
             . 'GROUP BY order_id, user_id, order_number, create_datetime' . PHP_EOL
             . 'ORDER BY A.create_datetime DESC';
             
        $params = [
            ':user_id' => $this->user_id,
        ];
        
        return Messages::findBySql($sql, $params);
    }

    /**
     * index.php
     * order_idでオーダー詳細情報を取得
     * 
     */
    public function indexUserOrderDetail() 
    {
        $sql = 'SELECT A.order_id, A.user_id, A.order_number, A.create_datetime,' . PHP_EOL
             . '       B.item_id, B.quantity, B.price, B.sub_total,' . PHP_EOL
             . '       C.item_name, C.price, C.icon_img,' . PHP_EOL
             . '       D.category_id, D.category_name,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . '       F.event_id, F.event_name' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT * FROM orders WHERE order_id = :order_id) AS A' . PHP_EOL
             . 'LEFT JOIN order_detail AS B' . PHP_EOL
             . 'ON A.order_id = B.order_id' . PHP_EOL
             . 'LEFT JOIN items AS C' . PHP_EOL
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' . PHP_EOL
             . 'ON C.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' . PHP_EOL
             . 'ON C.brand_id = E.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS F' . PHP_EOL
             . 'ON C.event_id = F.event_id' . PHP_EOL
             . 'ORDER BY B.item_id ASC';
             
        $params = [
            ':order_id' => $this->order_id,
        ];
        
        return Messages::findBySql($sql, $params);
    }
    
}