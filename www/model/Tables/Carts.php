<?php

require_once(MODEL_DIR . '/Messages.php');

//cartsテーブル+cart_detailテーブル
class Carts {
    public $cart_id;
    public $user_id;
    public $enabled;
    public $item_id;
    public $cart_date;
    public $quantity;
    public $create_datetime;
    public $update_datetime;
    
    public function __construct() {
        $this -> cart_id = null;
        $this -> user_id = null;
        $this -> enabled = null;
        $this -> item_id = null;
        $this -> cart_date = null;
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
        } else if (!Validator::checkRange($this->quantity, 1, 10)) {
            return CommonError::errorAdd('数量は半角数字、10桁以内で入力してください');
        }
    }
    
    /**
     * index.php
     * user_idでカート情報と商品情報を取得
     * 
     * enabled=trueのuser_idが存在しなければ新規作成
     */
    public function getUserCartItems() 
    {
        $sql = 'SELECT A.cart_id, A.user_id, B.item_id, B.quantity,' . PHP_EOL
             . '       C.item_name, C.icon_img, C.price, D.brand_name' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT cart_id, user_id FROM carts WHERE cart_id = :cart_id AND enabled = true) AS A' . PHP_EOL
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT cart_id, item_id, quantity FROM cart_detail) AS B' . PHP_EOL
             . 'ON A.cart_id = B.cart_id' . PHP_EOL
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT item_id, item_name, brand_id, price, icon_img FROM items) AS C' . PHP_EOL
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN' . PHP_EOL
             . '    (SELECT brand_id, brand_name FROM brands) AS D' . PHP_EOL
             . 'ON C.brand_id = D.brand_id';
             
        $params = [':cart_id' => $this->cart_id,];
        
        return Messages::findBySql($sql, $params);
    }
    
    
    // チェク関数----------------------------------------------
    /**
     * カートの存在確認
     * 
     * 存在すればオブジェクトを、存在しなければfalse
     */
    public function checkUserCart()
    {
        $sql = 'SELECT cart_id, user_id' . PHP_EOL
             . 'FROM carts' . PHP_EOL
             . 'WHERE user_id = :user_id' . PHP_EOL
             . 'AND enabled = true';
             
        $params = [':user_id' => $this->user_id];
        
        return Messages::retrieveBySql($sql, $params);
    }
    
    /**
     * (すでにカートの存在は確認済み)
     * ユーザーの既存カートで同一アイテムがないか確認
     * レコードがあればそこからcart_idなどを使用
     * 
     * 存在すればオブジェクトを、存在しなければfalse
     */
    public function checkUserCartItem()
    {
        $sql = 'SELECT cart_id, item_id, quantity' . PHP_EOL
             . 'FROM cart_detail' . PHP_EOL
             . 'WHERE cart_id = :cart_id' . PHP_EOL
             . 'AND item_id = :item_id';
        
        $params = [':cart_id' => $this -> cart_id, ':item_id' => $this -> item_id,];
        
        return Messages::retrieveBySql($sql, $params);
    }
    
    // carts テーブル ------------------------------------------------------------------------
    /**
     * 新規cartsの作成
     */
    public function insertUserCart()
    {
        $sql = 'INSERT INTO carts' . PHP_EOL
             . '(user_id, cart_date, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '(:user_id, :cart_date, :create_datetime)';
        
        $params = [
            ':user_id' => $this->user_id,
            ':cart_date' => $this->cart_date,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * cartsテーブルの更新日時のみ更新
     */
    public function updateUserCart()
    {
        $sql = 'UPDATE carts ' . PHP_EOL
             . 'SET update_datetime = :update_datetime ' . PHP_EOL
             . 'WHERE cart_id = :cart_id' . PHP_EOL
             . 'AND enabled = true';
             
        $params = [
            ':cart_id' => $this -> cart_id,
            ':update_datetime' => $this -> update_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    /**
     * カートの削除（無効化）
     * 
     * 履歴などで使用するため論理削除
     */
    public function deleteUserCart()
    {
        $sql = 'UPDATE carts' . PHP_EOL
             . 'SET enabled = false, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE cart_id = :cart_id';
        
        $params = [
            ':cart_id' => $this->cart_id,
            ':update_datetime' => $this->update_datetime,
        ];
        
        return Messages::executeBySql($sql, $params);
    }
    
    /**
     */
    public function purchasedUserOrder()
    {
        $sql = 'SELECT A.cart_id, A.user_id, A.update_datetime, B.item_id, B.quantity,' . PHP_EOL
             . '       C.item_name, C.price, D.brand_name' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT cart_id, user_id, update_datetime FROM carts WHERE cart_id = :cart_id AND enabled = false) AS A' . PHP_EOL
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT cart_id, item_id, quantity FROM cart_detail) AS B' . PHP_EOL
             . 'ON A.cart_id = B.cart_id' . PHP_EOL
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT item_id, item_name, brand_id, price, icon_img FROM items) AS C' . PHP_EOL
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN' . PHP_EOL
             . '    (SELECT brand_id, brand_name FROM brands) AS D' . PHP_EOL
             . 'ON C.brand_id = D.brand_id';
             
        $params = [':cart_id' => $this->cart_id,];
        
        return Messages::findBySql($sql, $params);
    }
    
    // cart_detail --------------------------------------------------------------------
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
    /**
     * cart_detailの更新
     * 
     * quantity=1 づつ加算
     * 
     */
    public function addUserCartDetail()
    {
        $sql = 'UPDATE cart_detail ' . PHP_EOL
             . 'SET ' . PHP_EOL
             . '    quantity = quantity + :quantity, ' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id'. PHP_EOL
             . 'AND cart_id = :cart_id';
             
        $params = [
            ':cart_id' => $this -> cart_id,
            ':update_datetime' => $this -> update_datetime,
            ':quantity' => $this -> quantity,
            ':item_id' => $this -> item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    /**
     * cart_detailの更新
     * 
     * new_quantityの値に変更
     * 
     */
    public function updateUserCartDetail()
    {
        $sql = 'UPDATE cart_detail ' . PHP_EOL
             . 'SET ' . PHP_EOL
             . '    quantity = :quantity, ' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id'. PHP_EOL
             . 'AND cart_id = :cart_id';
             
        $params = [
            ':cart_id' => $this -> cart_id,
            ':update_datetime' => $this -> update_datetime,
            ':quantity' => $this -> quantity,
            ':item_id' => $this -> item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    /**
     * cart_detailの削除
     * 
     */
    public function deleteUserCartDetail()
    {
        $sql = 'DELETE ' . PHP_EOL
             . 'FROM cart_detail ' . PHP_EOL
             . 'WHERE cart_id = :cart_id'. PHP_EOL
             . 'AND item_id = :item_id';
             
        $params = [
            ':cart_id' => $this -> cart_id,
            ':item_id' => $this -> item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    // 動作をまとめた関数 -------------------------------------------------
    /**
     * カートの登録
     */
    public function setUserCart()
    {
        $this -> insertUserCart();
        
        $cart_id = Database::lastInsertId();
        
        $this -> cart_id = $cart_id;
        
        $this -> insertUserCartDetail();
        
    }
    
    
    /**
     * カートの更新
     * 
     * アイテムのチェック後 INSERT or UPDATEに分かれる
     * (cartsテーブルはすでに存在している前提)
     */
    public function setUserCartDetail()
    {
        $record = $this -> checkUserCartItem();
        $cart_id = $record -> cart_id;
        
        //cartsの更新
        $this -> updateUserCart();
        
        //同一アイテムが存在しない場合
        if (!$record->item_id) {
            
            //cart_idを指定して新規登録
            $this -> insertUserCartDetail();
            
        //同一アイテムが存在した場合
        } else {
            
            //cart_detailの更新
            $this -> updateUserCartDetail();
        }
    }
    
    // アイコン用のセッション -----------------------------------------------
    /**
     * カートIDを指定して数量の合計を取得
     * その後セッションに登録
     */
    public function setSessionCartCount() 
    {
        $sql = 'SELECT SUM(quantity) AS cart_count ' .PHP_EOL
              .'FROM cart_detail' .PHP_EOL
              .'WHERE cart_id = :cart_id';
              
        $params = [':cart_id' => $this->cart_id];
        
        $record = Messages::retrieveBySql($sql, $params);
        
        Session::set('cart_count',$record->cart_count);
    }
    
    /**
     * unset($_SESSION['cart_count'])
     */
    public function clearSessionCartCount()
    {
        Session::remove('cart_count');
    }
}