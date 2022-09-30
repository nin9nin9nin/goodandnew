<?php

require_once(MODEL_DIR . '/Models.php');

//brands テーブル
class Brands {
    
    public $brand_id;
    public $brand_name;
    public $category_id;
    public $description;
    public $brand_hp;
    public $brand_link1;
    public $brand_link2;
    public $brand_link3;
    public $brand_link4;
    public $phone_number;
    public $email;
    public $address;
    public $status;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> brand_id = null;
        $this -> brand_name = null;
        $this -> category_id = null;
        $this -> description = null;
        $this -> brand_hp = null;
        $this -> brand_link1 = null;
        $this -> brand_link2 = null;
        $this -> brand_link3 = null;
        $this -> brand_link4 = null;
        $this -> phone_number = null;
        $this -> email = null;
        $this -> address = null;
        $this -> status = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    /**
     * ブランド名　64文字
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkBrandName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->brand_name)) {
            return CommonError::errorAdd('ブランド名を入力してください');
        } else if (!Validator::checkLength($this->brand_name, 0, 64)) {
            return CommonError::errorAdd('ブランド名は64文字以内で入力してください');
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
        
        if ($this->brand_hp !== "") {
            if (!Validator::checkUrl($this->brand_hp)) {
                return CommonError::errorAdd('ブランドHPが正しくありません');
            }
        }
        if ($this->brand_link1 !== "") {
            if (!Validator::checkUrl($this->brand_link1)) {
                return CommonError::errorAdd('ブランドLINK_1が正しくありません');
            }
        }
        if ($this->brand_link2 !== "") {
            if (!Validator::checkUrl($this->brand_link2)) {
                return CommonError::errorAdd('ブランドLINK_2が正しくありません');
            }
        }
        if ($this->brand_link3 !== "") {
            if (!Validator::checkUrl($this->brand_link3)) {
                return CommonError::errorAdd('ブランドLINK3が正しくありません');
            }
        }
        if ($this->brand_link4 !== "") {
            if (!Validator::checkUrl($this->brand_link4)) {
                return CommonError::errorAdd('ブランドLINK_4が正しくありません');
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
        
        if ($this->address !== "") {
            if (!Validator::checkLength($this->address, 0, 64)) {
                return CommonError::errorAdd('住所は64文字以内で入力してください');
            } 
        }
    }
    
    
    /**
     * テーブル一覧の取得
     * brands+categorys+items結合
     * itemsテーブルにいくつアイテムがあるかカウント
     */
    public function indexBrands() {
        $sql = 'SELECT A.brand_id, A.brand_name, A.status,' . PHP_EOL
             . '       COALESCE(B.category_id,0) AS category_id, COALESCE(B.category_name,:null) AS category_name,' . PHP_EOL
             . '       COALESCE(C.item_count,0) AS item_count' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    brands AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT category_id, category_name FROM categorys) AS B' . PHP_EOL
             . 'ON A.category_id = B.category_id' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT brand_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY brand_id) AS C' . PHP_EOL
             . 'ON A.brand_id = C.brand_id';
            //  . PHP_EOL . 'ORDER BY A.brand_id DESC';
        
        //NULLを未設定に代替
        $params = [':null' => '未設定'];
        
        return Models::findBySql($sql,$params); 
    }
    
    
    /**
     * 新規ブランド登録
     */
    public function insertBrand() 
        {
        $sql = 'INSERT INTO brands ' . PHP_EOL
             . '    (brand_name, category_id, description, brand_hp, brand_link1, brand_link2, brand_link3, brand_link4,' . PHP_EOL
             . '    phone_number, email, address, status, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '    (:brand_name, :category_id, :description, :brand_hp, :brand_link1, :brand_link2, :brand_link3, :brand_link4,' . PHP_EOL
             . '    :phone_number, :email, :address, :status, :create_datetime)';
             
        $params = [
            ':brand_name' => $this->brand_name,
            ':category_id' => $this->category_id,
            ':description' => $this->description,
            ':brand_hp' => $this->brand_hp,
            ':brand_link1' => $this->brand_link1,
            ':brand_link2' => $this->brand_link2,
            ':brand_link3' => $this->brand_link3,
            ':brand_link4' => $this->brand_link4,
            ':phone_number' => $this->phone_number,
            ':email' => $this->email,
            ':address' => $this->address,
            ':status' => $this->status,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードの取得
     */
    public function editBrand() {
        //A brands+ B categorys+ C itemsで左辺結合
        $sql = 'SELECT A.brand_id, A.brand_name, A.status,' . PHP_EOL
             . '       description, brand_hp, brand_link1, brand_link2, brand_link3, brand_link4,' . PHP_EOL
             . '       phone_number, email, address,' . PHP_EOL
             . '       COALESCE(B.category_id,0) AS category_id, COALESCE(B.category_name,:null) AS category_name,' . PHP_EOL
             . '       COALESCE(C.item_count, 0) AS item_count' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM brands WHERE brand_id = :brand_id) AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT category_id, category_name FROM categorys) AS B' . PHP_EOL
             . 'ON A.category_id = B.category_id' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT brand_id, COUNT(*) AS item_count FROM items GROUP BY brand_id) AS C' . PHP_EOL
             . 'ON A.brand_id = C.brand_id';
        
        $params = [':null' => '未設定', ':brand_id' => $this->brand_id ];
        //return $records[0]のみ
        return Models::retrieveBySql($sql,$params); 
    }
    
    /**
     * 指定レコードの更新
     */
    public function updateBrand() 
        {
        $sql = 'UPDATE brands' . PHP_EOL
             . 'SET brand_name = :brand_name,'. PHP_EOL
             . '    category_id = :category_id,'. PHP_EOL
             . '    description = :description,'. PHP_EOL
             . '    brand_hp = :brand_hp,'. PHP_EOL
             . '    brand_link1 = :brand_link1,'. PHP_EOL
             . '    brand_link2 = :brand_link2,'. PHP_EOL
             . '    brand_link3 = :brand_link3,'. PHP_EOL
             . '    brand_link4 = :brand_link4,'. PHP_EOL
             . '    phone_number = :phone_number,'. PHP_EOL
             . '    email = :email,'. PHP_EOL
             . '    address = :address,'. PHP_EOL
             . '    status = :status,'. PHP_EOL
             . '    update_datetime = :update_datetime'. PHP_EOL
             . 'WHERE brand_id = :brand_id';
             
        $params = [
            ':brand_name' => $this->brand_name,
            ':category_id' => $this->category_id,
            ':description' => $this->description,
            ':brand_hp' => $this->brand_hp,
            ':brand_link1' => $this->brand_link1,
            ':brand_link2' => $this->brand_link2,
            ':brand_link3' => $this->brand_link3,
            ':brand_link4' => $this->brand_link4,
            ':phone_number' => $this->phone_number,
            ':email' => $this->email,
            ':address' => $this->address,
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':brand_id' => $this->brand_id,
        ];
        
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードの削除
     */
    public function deleteBrand() {
        $sql = 'DELETE FROM brands' . PHP_EOL
         . 'WHERE brand_id = :brand_id';
        
        $params = [':brand_id' => $this->brand_id];
        
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 全レコード削除
     */
    public function deleteAll($table) {
        $sql = 'TRUNCATE TABLE :table';
    
        $params = [':table' => $table];
        
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードのステータス更新
     */
    public function updateStatus() {
        $sql = 'UPDATE brands' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE brand_id = :brand_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':brand_id' => $this->brand_id,
            ];
            
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 商品管理に使用 static
     * 
     * select option用　テーブルの取得
     */
    public static function selectOption_Brands() {
        $sql = 'SELECT brand_id, brand_name FROM brands';
        
        return Models::findBySql($sql);
    }
    
    // ユーザー側　-------------------------------------------
    
    /**
     * 指定してブランド情報取得 static
     * 
     * items/detail.tpl.php
     */
    public static function detailBrand($id) {
        $sql = 'SELECT * FROM brands WHERE brand_id = :brand_id';
        
        $params = [':brand_id' => $id];
        
        return Models::findBySql($sql, $params);
    }
}