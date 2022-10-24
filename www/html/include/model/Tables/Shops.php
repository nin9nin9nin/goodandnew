<?php

require_once(MODEL_DIR . '/Messages.php');

//shopsテーブル
class Shops {
    
    public $shop_id;
    public $shop_name;
    public $description;
    public $shop_hp;
    public $shop_link1;
    public $shop_link2;
    public $shop_link3;
    public $shop_link4;
    public $phone_number;
    public $email;
    public $address;
    public $status;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> shop_id = null;
        $this -> shop_name = null;
        $this -> description = null;
        $this -> shop_hp = null;
        $this -> shop_link1 = null;
        $this -> shop_link2 = null;
        $this -> shop_link3 = null;
        $this -> shop_link4 = null;
        $this -> phone_number = null;
        $this -> email = null;
        $this -> address = null;
        $this -> status = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    /**
     * ショップ名　64文字
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkShopName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->shop_name)) {
            return CommonError::errorAdd('ショップ名を入力してください');
        } else if (!Validator::checkLength($this->shop_name, 0, 64)) {
            return CommonError::errorAdd('ショップ名は64文字以内で入力してください');
        }
    }
    /**
     * URL　 任意
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * @param hp,link~
     * return CommonError::errorAdd()
     * 
     * /^(https?|ftp)(://[-_.!~*'()a-zA-Z0-9;/?:@&amp;amp;=+$,%#]+)$/
     */
    public function checkUrl() {
        Validator::paramClear();
        
        if ($this->shop_hp !=="") {
            if (!Validator::checkUrl($this->shop_hp)) {
                return CommonError::errorAdd('ショップHPが正しくありません');
            }
        }
        if ($this->shop_link1 !== "") {
            if (!Validator::checkUrl($this->shop_link1)) {
                return CommonError::errorAdd('ショップLINK_1が正しくありません');
            }
        }
        if ($this->shop_link2 !== "") {
            if (!Validator::checkUrl($this->shop_link2)) {
                return CommonError::errorAdd('ショップLINK_2が正しくありません');
            }
        }
        if ($this->shop_link3 !== "") {
            if (!Validator::checkUrl($this->shop_link3)) {
                return CommonError::errorAdd('ショップLINK3が正しくありません');
            }
        }
        if ($this->shop_link4 !== "") {
            if (!Validator::checkUrl($this->shop_link4)) {
                return CommonError::errorAdd('ショップLINK_4が正しくありません');
            }
        }
        
    }
    
    /**
     * 電話番号 任意
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     * 
     * '/\A0[0-9]{9,10}\z/' ハイフン無し
     */
    public function checkPhonenumber() {
        Validator::paramClear();
        
        if ($this->phone_number !== "") {
            if (!Validator::checkPhonenumber($this->phone_number)) {
                return CommonError::errorAdd('電話番号が正しくありません');
            } 
        }
    }
    
    /**
     * メールアドレス 任意
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     * 
     * '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/' 
     */
    public function checkEmail() {
        Validator::paramClear();
        
        if ($this->email !== "") {
            if (!Validator::checkMailAddress($this->email)) {
                return CommonError::errorAdd('メールアドレスが正しくありません');
            } 
        }
    }
    
    /**
     * 住所 64文字以内　任意
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     * 
     */
    public function checkAddress() {
        Validator::paramClear();
        
        if (!is_null($this->address)) {
            if (!Validator::checkLength($this->address, 0, 64)) {
                return CommonError::errorAdd('住所は64文字以内で入力してください');
            } 
        }
    }
    
    
    /**
     * テーブル一覧の取得（全データ）
     * shops+items結合
     * itemsテーブルにいくつアイテムがあるかカウント
     */
    public function indexShops() 
    {
        $sql = 'SELECT A.shop_id, A.shop_name, A.status, ' .PHP_EOL
             . '       COALESCE(C.item_count,0) AS item_count' . PHP_EOL
             . 'FROM shops AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT shop_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY shop_id) AS C' . PHP_EOL
             . 'ON A.shop_id = C.shop_id';
             
        return Messages::findBySql($sql); 
    }
    
    /**
     * 新規登録
     */
    public function insertShop() 
    {
        $sql = 'INSERT INTO shops ' . PHP_EOL
             . '    (shop_name, description, shop_hp, shop_link1, shop_link2, shop_link3, shop_link4,' . PHP_EOL
             . '    phone_number, email, address, status, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '    (:shop_name, :description, :shop_hp, :shop_link1, :shop_link2, :shop_link3, :shop_link4,' . PHP_EOL
             . '    :phone_number, :email, :address, :status, :create_datetime)';
             
        $params = [
            ':shop_name' => $this->shop_name,
            ':description' => $this->description,
            ':shop_hp' => $this->shop_hp,
            ':shop_link1' => $this->shop_link1,
            ':shop_link2' => $this->shop_link2,
            ':shop_link3' => $this->shop_link3,
            ':shop_link4' => $this->shop_link4,
            ':phone_number' => $this->phone_number,
            ':email' => $this->email,
            ':address' => $this->address,
            ':status' => $this->status,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードの取得
     */
    public function editShop() 
    {
        //A shops+ C itemsで左辺結合
        $sql = 'SELECT A.shop_id, A.shop_name, A.status,' . PHP_EOL
             . '       description, shop_hp, shop_link1, shop_link2, shop_link3, shop_link4,' . PHP_EOL
             . '       phone_number, email, address,' . PHP_EOL
             . '       COALESCE(C.item_count, 0) AS item_count' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM shops WHERE shop_id = :shop_id) AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT shop_id, COUNT(*) AS item_count FROM items GROUP BY shop_id) AS C' . PHP_EOL
             . 'ON A.shop_id = C.shop_id';
        
        $params = [':shop_id' => $this->shop_id ];
        //return $records[0]のみ
        return Messages::retrieveBySql($sql,$params);
    }
    
    /**
     * 指定レコードの更新
     */
    public function updateShop() 
    {
        $sql = 'UPDATE shops' . PHP_EOL
             . 'SET shop_name = :shop_name,'. PHP_EOL
             . '    description = :description,'. PHP_EOL
             . '    shop_hp = :shop_hp,'. PHP_EOL
             . '    shop_link1 = :shop_link1,'. PHP_EOL
             . '    shop_link2 = :shop_link2,'. PHP_EOL
             . '    shop_link3 = :shop_link3,'. PHP_EOL
             . '    shop_link4 = :shop_link4,'. PHP_EOL
             . '    phone_number = :phone_number,'. PHP_EOL
             . '    email = :email,'. PHP_EOL
             . '    address = :address,'. PHP_EOL
             . '    status = :status,'. PHP_EOL
             . '    update_datetime = :update_datetime'. PHP_EOL
             . 'WHERE shop_id = :shop_id';
             
        $params = [
            ':shop_name' => $this->shop_name,
            ':description' => $this->description,
            ':shop_hp' => $this->shop_hp,
            ':shop_link1' => $this->shop_link1,
            ':shop_link2' => $this->shop_link2,
            ':shop_link3' => $this->shop_link3,
            ':shop_link4' => $this->shop_link4,
            ':phone_number' => $this->phone_number,
            ':email' => $this->email,
            ':address' => $this->address,
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':shop_id' => $this->shop_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードの削除
     */
    public function deleteShop() {
        $sql = 'DELETE FROM shops' . PHP_EOL
         . 'WHERE shop_id = :shop_id';
        
        $params = [':shop_id' => $this->shop_id];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * 全レコード削除
     */
    public function deleteAll($table) {
        $sql = 'TRUNCATE TABLE :table';
    
        $params = [':table' => $table];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードのステータス更新
     */
    public function updateStatus() {
        $sql = 'UPDATE shops' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE shop_id = :shop_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':shop_id' => $this->shop_id,
            ];
            
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * 商品管理に使用 static
     * 
     * select option用　テーブルの取得
     */
    public static function selectOption_Shops() {
        $sql = 'SELECT shop_id, shop_name FROM shops';
        
        return Messages::findBySql($sql);
    }
    
    // ユーザー側　-------------------------------------------
    
    /**
     * 指定してショップ情報取得 static
     * 
     * items/detail.tpl.php
     */
    public static function detailShop($id) {
        $sql = 'SELECT * FROM shops WHERE shop_id = :shop_id';
        
        $params = [':shop_id' => $id];
        
        return Messages::findBySql($sql, $params);
    }
}