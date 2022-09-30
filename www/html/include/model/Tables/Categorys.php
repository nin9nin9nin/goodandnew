<?php

require_once(MODEL_DIR . '/Models.php');

//categorys テーブル
class Categorys {
    public $category_id;
    public $category_name;
    public $parent_id;
    public $status;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> category_id = null;
        $this -> category_name = null;
        $this -> parent_id = null;
        $this -> status = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    
    /**
     * カテゴリー名　64文字
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkCategoryName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->category_name)) {
            return CommonError::errorAdd('カテゴリー名を入力してください');
        } else if (!Validator::checkLength($this->category_name, 0, 64)) {
            return CommonError::errorAdd('カテゴリー名は64文字以内で入力してください');
        }
    }
    
    
    /**
     * テーブル一覧の取得
     * 
     */
    public function indexCategorys() 
    {
        //自己結合してparent_idからcategory_nameを呼び出す
        $sql = 'SELECT A.category_id, A.category_name, A.parent_id, A.status,' . PHP_EOL
             . '       COALESCE(B.category_name,:null) AS parent_name' . PHP_EOL
             . 'FROM categorys AS A' . PHP_EOL
             . 'LEFT JOIN categorys AS B' . PHP_EOL
             . 'ON A.parent_id = B.category_id';
        
        //NULLを未設定に代替
        $params = [':null' => '未設定'];
        
        return Models::findBySql($sql,$params); 
    } 
    
    /**
     * 新規登録
     * 
     */
    public function createCategory() 
    {
        $sql = 'INSERT INTO categorys (category_name, parent_id, status, create_datetime)'. PHP_EOL
             . 'VALUES(:category_name, :parent_id, :status, :create_datetime)';
        
        
        $params = [
            ':category_name' => $this->category_name,
            ':parent_id' => $this->parent_id,
            ':status' => $this->status,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 編集　指定レコードのみ取得
     */
    public function editCategory() 
    {
        $sql = 'SELECT A.category_id, A.category_name, A.status,' . PHP_EOL
             . '       COALESCE(B.category_id,0) AS parent_id, COALESCE(B.category_name,:null) AS parent_name' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT * FROM categorys WHERE category_id = :category_id) AS A' . PHP_EOL
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT category_id,category_name FROM categorys) AS B' . PHP_EOL
             . 'ON A.parent_id = B.category_id';
        
        $params = [
            ':null' => '未設定',
            ':category_id' => $this->category_id, 
        ];
        
        return Models::retrieveBySql($sql, $params); 
    }
    
    /**
     * フォーム内select-option用
     * idとnameのみ取得
     */
    public function selectOption_Parents() {
        //自己結合してparent_idからcategory_nameを呼び出す
        $sql = 'SELECT category_id, category_name' . PHP_EOL
             . 'FROM categorys';
        
        return Models::findBySql($sql); 
    } 
    
    /**
     * 指定レコードの更新
     */
    public function updateCategory() {
        //categoryテーブル
        $sql = 'UPDATE categorys' . PHP_EOL
             . 'SET category_name = :category_name,'. PHP_EOL
             . '    parent_id = :parent_id,'. PHP_EOL
             . '    status = :status,'. PHP_EOL
             . '    update_datetime = :update_datetime'. PHP_EOL
             . 'WHERE category_id = :category_id';
        
        $params = [
            ':category_name' => $this->category_name,
            ':parent_id' => $this->parent_id,
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':category_id' => $this->category_id,
        ];
        
        Models::executeBySql($sql, $params);
    }
    
    /**
     * 指定レコードの削除
     */
    public function deleteCategory() {
        $sql = 'DELETE FROM categorys' . PHP_EOL
         . 'WHERE category_id = :category_id';
        
        $params = [':category_id' => $this->category_id];
        
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
        $sql = 'UPDATE categorys' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE category_id = :category_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':category_id' => $this->category_id,
            ];
            
        Models::executeBySql($sql, $params);
    }
    
    /**
     * ブランド管理に使用 static
     * 
     * select option用　テーブルの取得
     * マンスリー選択用のためparent_id=2に絞る
     */
    public static function selectOption_Monthly() {
        $sql = 'SELECT category_id, category_name FROM categorys WHERE parent_id = 2';
        
        return Models::findBySql($sql);
    }
    
    /**
     * 商品管理に使用 static
     * 
     * select option用　テーブルの取得
     * ジャンル選択用のためparent_id=1に絞る
     */
    public static function selectOption_Genre() {
        $sql = 'SELECT category_id, category_name FROM categorys  WHERE parent_id NOT IN (2)';
        
        return Models::findBySql($sql);
    }
}