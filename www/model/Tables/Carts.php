<?php

require_once(MODEL_DIR . '/Messages.php');

//cartsテーブル+cart_detailテーブル
class Carts {
    public $cart_id;
    public $user_id;
    public $item_id;
    public $quantity;
    public $create_datetime;
    public $update_datetime;
    
    public function __construct() {
        $this -> cart_id = null;
        $this -> user_id = null;
        $this -> item_id = null;
        $this -> quantity = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
        
    }
    
    /**
     * 数量　半角数字　10桁　必須
     * -- int(11)の11は、カラムの表示幅であり、2147483647まで格納が可能。
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkQuantity() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->quantity)) {
            return CommonError::errorAdd('数量を入力してください(0を除く）');
        } else if (!Validator::checkRangeNotZero($this->quantity, 1, 10)) {
            return CommonError::errorAdd('数量は半角数字、10桁以内で入力してください');
        }
    }

    /**
     * CONFIRM,ORDER時のカート確認
     */
    public function checkCarts($records = []) {

        //カートの中身の確認
        if ($records === false) {
            return CommonError::errorAdd('カートに商品がありません');

            foreach ($records as $record) {
                if ($record -> event_status === 0) { //イベントステータスの確認
                    return CommonError::errorAdd($record->item_name . 'はイベント開催期間が終了しています');
                } else if ($record -> item_status === 0) { //アイテムステータスの確認
                    return CommonError::errorAdd($record->item_name . 'は現在購入できません');   
                } else if ($record->stock - $record->quantity < 0) { //在庫の確認
                    return CommonError::errorAdd($record->item_name . 'は在庫が不足しています');
                }
            } 
        }
    }
    
    // index ------------------------------------------------------------------------
    /**
     * index.php
     * user_idでカート情報とアイテム情報を取得
     * 
     * 在庫数とイベントステータスも取得
     */
    public function indexUserCartDetail() 
    {
        $sql = 'SELECT A.cart_id, A.user_id,' . PHP_EOL
             . '       B.item_id, B.quantity, B.create_datetime,' . PHP_EOL
             . '       C.item_name, C.price, C.icon_img, C.status AS item_status,' . PHP_EOL
             . '       D.stock,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . '       F.event_id, F.event_name, F.status AS event_status' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT * FROM carts WHERE user_id = :user_id) AS A' . PHP_EOL
             . 'LEFT JOIN cart_detail AS B' . PHP_EOL
             . 'ON A.cart_id = B.cart_id' . PHP_EOL
             . 'LEFT JOIN items AS C' . PHP_EOL
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS D' . PHP_EOL
             . 'ON C.item_id = D.item_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' . PHP_EOL
             . 'ON C.brand_id = E.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS F' . PHP_EOL
             . 'ON C.event_id = F.event_id' . PHP_EOL
             . 'ORDER BY B.create_datetime DESC'; //cart_detailに登録された日時順
             
        $params = [
            ':user_id' => $this->user_id,
        ];
        
        return Messages::findBySql($sql, $params);
    }

    // check ----------------------------------------------
    /**
     * カートの存在確認
     * 
     * 存在すればオブジェクトを、存在しなければfalse
     */
    public function checkUserCart()
    {
        $sql = 'SELECT cart_id, user_id' . PHP_EOL
             . 'FROM carts' . PHP_EOL
             . 'WHERE user_id = :user_id';
             
        $params = [':user_id' => $this->user_id];
        
        return Messages::retrieveBySql($sql, $params);
    }
    
    /**
     * ユーザーの既存カートで同一アイテムがないか確認
     * レコードがあればそこからcart_idなどを使用
     * 
     * 存在すればオブジェクトを、存在しなければfalse
     */
    public function checkUserCartDetail()
    {
        $sql = 'SELECT cart_id, item_id, quantity' . PHP_EOL
             . 'FROM cart_detail' . PHP_EOL
             . 'WHERE cart_id = :cart_id' . PHP_EOL
             . 'AND item_id = :item_id';
        
        $params = [
            ':cart_id' => $this -> cart_id,
            ':item_id' => $this -> item_id,
        ];
        
        return Messages::retrieveBySql($sql, $params);
    }

    // ------------------------------------------------------------------------
    /**
     * ADD TO CARTボタン時の処理
     * 登録（カートが存在しない場合）
     * 更新+登録（カートは存在するがアイテムは存在しない場合）
     * 更新（カート、アイテム共に存在する場合 1加算）
     */
    public function addToCart() {
        //user_idでカートの確認(あればオブジェクト、なければfalse)
        $cart = $this -> checkUserCart();

        //登録（カートが存在しない）
        if ($cart === false) {

            //登録処理（トランザクション）
            $this -> insertCart();

        //更新（カートが存在する）
        } else {
            //カートIDの取得、プロパティ登録
            $this -> cart_id = $cart -> cart_id;

            //更新処理（トランザクション）
            $this -> addCart();
        }

    }
    
    // insert ------------------------------------------------------------------------
    /**
     * 登録処理をまとめた関数（トランザクション）
     * 
     * cartsの登録
     * cart_detailの登録
     */
    public function insertCart() {
        //トランザクション開始
        Database::beginTransaction();
        try {
            $now_date = date('Y-m-d H:i:s');
            
            //登録日時
            $this -> create_datetime = $now_date;

            //新規カートの登録(carts)
            $this -> insertUserCart();

            //登録したcart_idの取得
            $cart_id = Database::lastInsertId();
            
            //プロパティに登録
            $this -> cart_id = $cart_id;
            
            //新規アイテムを登録(cart_detail)
            $this -> insertUserCartDetail();

            Database::commit();

        } catch (Exception $e) {

        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
        }
    }

    /**
     * 新規cartsの作成
     */
    public function insertUserCart()
    {
        $sql = 'INSERT INTO carts' . PHP_EOL
             . '(user_id, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '(:user_id, :create_datetime)';
        
        $params = [
            ':user_id' => $this->user_id,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * 新規cart_detailの作成
     * 
     * lasrInsertIdでcart_id取得
     */
    public function insertUserCartDetail()
    {
        $sql = 'INSERT INTO cart_detail' . PHP_EOL
             . '(cart_id, item_id, quantity, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '(:cart_id, :item_id, :quantity, :create_datetime)';
        
        $params = [
            ':cart_id' => $this->cart_id,
            ':item_id' => $this->item_id,
            ':quantity' => $this->quantity,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
   
    // update ------------------------------------------------------------------------
    /**
     * add
     * 更新の処理をまとめた関数（トランザクション）
     * 
     */
    public function addCart() {
        //トランザクション
        Database::beginTransaction();
        try {
            $now_date = date('Y-m-d H:i:s');

            //更新日時
            $this -> update_datetime = $now_date;

            //カートの更新(carts)
            $this -> updateUserCart();

            //既存カートに同一アイテムがないか確認
            $cart_item = $this -> checkUserCartDetail();

            //同一アイテムが存在しない
            if ($cart_item === false) {
                //登録日時
                $this -> create_datetime = $now_date;

                //新規アイテムの登録(cart_detail)
                $this -> insertUserCartDetail();

                Database::commit();

            //同一アイテムが存在する
            } else {

                //アイテム数の加算(cart_detail)
                $this -> addUserCartDetail();

                Database::commit();
            }
        } catch (Exception $e) {

            $e = new Exception('データベースに接続できませんでした', 0, $e);
            //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
            throw $e;
            
            Database::rollback();
        }
    
    }

    /**
     * update
     * 更新の処理をまとめた関数（トランザクション）
     * 
     */
    public function updateCart() {
        //トランザクション
        Database::beginTransaction();
        try {
            $now_date = date('Y-m-d H:i:s');

            //更新日時
            $this -> update_datetime = $now_date;

            //カートの更新(carts)
            $this -> updateUserCart();

            //アイテム数の更新(cart_detail)
            $this -> updateUserCartDetail();

            Database::commit();

        } catch (Exception $e) {

        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
        }
    
    }
    
    /**
     * cartsの更新
     * 更新日時のみ
     * 
     */
    public function updateUserCart()
    {
        $sql = 'UPDATE carts ' . PHP_EOL
             . 'SET update_datetime = :update_datetime ' . PHP_EOL
             . 'WHERE cart_id = :cart_id';
             
        $params = [
            ':cart_id' => $this -> cart_id,
            ':update_datetime' => $this -> update_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * cart_detailの加算
     * 
     * +:quantity
     * 
     */
    public function addUserCartDetail() {
        $sql = 'UPDATE cart_detail ' . PHP_EOL
             . 'SET quantity = quantity + :quantity, ' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE cart_id = :cart_id'. PHP_EOL
             . 'AND item_id = :item_id';
             
        $params = [
            ':quantity' => $this -> quantity,
            ':update_datetime' => $this -> update_datetime,
            ':cart_id' => $this -> cart_id,
            ':item_id' => $this -> item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * cart_detailの更新
     * 
     * =:quantity
     * 
     */
    public function updateUserCartDetail() {
        $sql = 'UPDATE cart_detail ' . PHP_EOL
             . 'SET ' . PHP_EOL
             . '    quantity = :quantity, ' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE cart_id = :cart_id'. PHP_EOL
             . 'AND item_id = :item_id';
             
        $params = [
            ':quantity' => $this -> quantity,
            ':update_datetime' => $this -> update_datetime,
            ':cart_id' => $this -> cart_id,
            ':item_id' => $this -> item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }



    // delete ------------------------------------------------------------------------
    /**
     * 削除の処理をまとめた関数（ロールバック）
     * 
     */
    public function deleteCart() {
        try {
            //cartsの削除
            $this -> deleteUserCart();
            
            //cart_detailの削除
            $this -> deleteUserCartDetails();
                                    
        } catch (Exception $e) {

            $e = new Exception('カートを削除できませんでした', 0, $e);
            //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
            throw $e;
            
            Database::rollback();
        }
    }

    /**
     * cartの削除
     * 
     */
    public function deleteUserCart()
    {
        $sql = 'DELETE FROM carts' . PHP_EOL
             . 'WHERE cart_id = :cart_id';
        
        $params = [
            ':cart_id' => $this->cart_id,
        ];
        
        return Messages::executeBySql($sql, $params);
    }

    /**
     * 指定アイテムIDの削除
     * cart_detailの削除
     * 
     */
    public function deleteUserCartDetail()
    {
        $sql = 'DELETE FROM cart_detail' . PHP_EOL
             . 'WHERE cart_id = :cart_id'. PHP_EOL
             . 'AND item_id = :item_id';
             
        $params = [
            ':cart_id' => $this -> cart_id,
            ':item_id' => $this -> item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * 指定カートIDの全アイテム削除
     * cart_detailの削除
     * 
     */
    public function deleteUserCartDetails()
    {
        $sql = 'DELETE FROM cart_detail' . PHP_EOL
             . 'WHERE cart_id = :cart_id';
             
        $params = [
            ':cart_id' => $this -> cart_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    // cart_count -----------------------------------------------
    /**
     * ユーザーIDでカートを検索
     * 合計数量を取得
     * セッションに登録
     */
    public function getUserCartCount($default = NULL) {
        $value = $default;

        //データの取得
        $sql = 'SELECT SUM(B.quantity) AS cart_count ' .PHP_EOL
              .'FROM' .PHP_EOL
              .'    (SELECT * FROM carts WHERE user_id = :user_id) AS A' .PHP_EOL
              .'LEFT JOIN cart_detail AS B' .PHP_EOL
              .'ON A.cart_id = B.cart_id';
              
        $params = [':user_id' => $this->user_id];
        
        $record = Messages::retrieveBySql($sql, $params);
        
        //データがあれば
        if ($record !== false) {
            //合計数量を代入
            $value = $record->cart_count;
        } 

        return $value;
    }
        
}