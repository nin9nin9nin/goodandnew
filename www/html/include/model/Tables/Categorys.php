<?php

require_once(MODEL_DIR . '/Messages.php');

//categorys テーブル
class Categorys {

    public $page_id; //ページ番号
    public $display_record = 10; //１ページの表示件数
    public $category_id;
    public $category_name;
    public $parent_id;
    public $status;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> page_id = null;
        $this -> category_id = null;
        $this -> category_name = null;
        $this -> parent_id = null;
        $this -> status = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    
    /**
     * カテゴリー名　varchar(64)
     * 入力確認と文字数確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
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
     * 親カテゴリー　int(11)
     * 入力確認と数字確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkParentCategory() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->parent_id)) {
            return CommonError::errorAdd('親カテゴリーを選択してください');
        } else if (!Validator::checkNumeric($this->parent_id)) {
            return CommonError::errorAdd('親カテゴリーが正しくありません');
        }
    }
    
    // index ------------------------------------------------------------------------
    /**
     * 各テーブルのトータルレコード数を返す
     * return $record['cnt']
     */
    public static function getTotalRecord() {
        // テーブルから全レコードの数をカウント(indexのsql文に合わせる)
        $sql ='SELECT COUNT(*) as cnt FROM categorys AS A LEFT JOIN categorys AS B ON A.parent_id = B.category_id';
        
        // cnt取得
        $record = Messages::retrieveBySql($sql);
        
        // カウントした数を返す
        return $record->cnt;
    }
    
    /**
     * トータルレコードを取得し、ページネーションの値をセットして返す
     * return array
     */
    public function getPaginations() {
        //トータルレコードの取得
        $total_record = self::getTotalRecord();
        
        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record, $this->display_record, $this->page_id);
        
    }
    
    /**
     * テーブル一覧の取得
     * 
     */
    public function indexCategorys() 
    {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //自己結合してparent_idからcategory_nameを呼び出す
        $sql = 'SELECT A.category_id, A.category_name, A.parent_id, A.status,' . PHP_EOL
             . '       B.category_name AS parent_name' . PHP_EOL
             . 'FROM categorys AS A' . PHP_EOL
             . 'LEFT JOIN categorys AS B' . PHP_EOL
             . 'ON A.parent_id = B.category_id' . PHP_EOL
             . 'ORDER BY A.category_id DESC' . PHP_EOL 
             . 'LIMIT :display_record OFFSET :start_record';
        
        $params = [
            ':display_record' => $display_record,
            ':start_record' => $start_record,
        ];
        
        return Messages::findBySql($sql,$params); 
    } 

    /**
     * 親カテゴリーの取得
     * selectフォームで使用
     * 
     * parent_idが0のレコードのみ取得
     */
    public function indexParentCategorys() 
    {
        $sql = 'SELECT category_id, category_name' . PHP_EOL
             . 'FROM categorys' . PHP_EOL
             . 'WHERE parent_id = 0';
                
        return Messages::findBySql($sql); 
    } 

    // search ------------------------------------------------------------------------
    /**
     * SQL文
     * getで受け取った値からSQL文を作成
     * 
     * カラムはテーブルによって異なる(カラム名はbindできない)
     */
    public static function setSearchSql ($search = []) {
        // 指定したキーが配列にあるか調べる
        if (array_key_exists('keyword', $search)) { // keywordの場合
            $searchSql = ' WHERE A.category_name LIKE :search_value';
        } else if (array_key_exists('filter', $search)) { //filterの場合
            $searchSql = ' WHERE A.parent_id = :search_value';
        } 
        return $searchSql;
    }

    /**
     * bindValue
     * getで受け取った値からbindする配列を作成
     * 
     */
    public static function setSearchParams ($search = []) {
        // 指定したキーが配列にあるか調べる
        if (array_key_exists('keyword', $search)) {
            foreach ($search as $key => $value) {
                $value = "%{$value}%"; //前後0文字以上検索
                $searchParams = [':search_value' => $value,];
            } 
        } else if (array_key_exists('filter', $search)) {
            foreach ($search as $key => $value) {
                $value = (int)$value; //intに変換
                $searchParams = [':search_value' => $value,];
            }
        }
        return $searchParams;
    }

    /**
     * 検索時のページネーション
     * トータルレコード数の取得
     * 
     */
    public static function getSearchRecord($search = []) {
        // テーブルから全レコードの数をカウント
        $searchSql ='SELECT COUNT(*) as cnt FROM categorys AS A LEFT JOIN categorys AS B ON A.parent_id = B.category_id';
        //$sqlに結合代入
        $searchSql .= self::setSearchSql($search);

        //bindValue
        $searchParams = self::setSearchParams($search);
        
        //トータルレコード数の取得
        $record = Messages::retrieveBySql($searchSql, $searchParams);
        
        // カウントした数を返す
        return $record->cnt;
    }
    
    /**
     * トータルレコードを取得し、ページネーションの値をセットして返す
     * return array
     */
    public function getSearchPaginations($search = []) {
        //トータルレコードの取得
        $total_record = self::getSearchRecord($search);
        
        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record, $this->display_record, $this->page_id);
        
    }

    /**
     * 検索・絞り込み
     * 
     */
    public function searchCategorys($search = []) {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //ベースとなるSQL文を準備
        $searchSql = 'SELECT A.category_id, A.category_name, A.parent_id, A.status,' . PHP_EOL
                   . '       B.category_name AS parent_name' . PHP_EOL
                   . 'FROM categorys AS A' . PHP_EOL
                   . 'LEFT JOIN categorys AS B' . PHP_EOL
                   . 'ON A.parent_id = B.category_id';

        //検索項目を確認　SQL文作成し結合代入
        $searchSql .= self::setSearchSql($search);
        
        //さらにページネーション用のSQL文を結合代入
        $searchSql .= ' ORDER BY category_id DESC LIMIT :display_record OFFSET :start_record';
        
        //検索項目を確認　bindする配列を作成
        $searchParams = self::setSearchParams($search);
        
        //searchParamsにページネーション用の配列追加
        $searchParams += [':display_record' => $display_record, ':start_record' => $start_record];

        //検索・絞り込みに応じたレコードの取得
        return Messages::findBySql($searchSql,$searchParams); 
    }

    // sorting ------------------------------------------------------------------------
    /**
     * 0:カテゴリー名順
     * 1:昇順
     * 2:降順
     * 
     */
    public static function setSortingSql($sorting = []) {
        if ($sorting === '0') {
            $sortingSql = ' ORDER BY A.category_name ASC';
        } else if ($sorting === '1') {
            $sortingSql = ' ORDER BY A.category_id ASC';
        } else if ($sorting === '2') {
            $sortingSql = ' ORDER BY A.category_id DESC';
        } 

        $sortingSql .= ', A.category_id DESC LIMIT :display_record OFFSET :start_record';

        return $sortingSql;
    }

    /**
     * 並べ替え
     */
    public function sortingCategorys($sorting = []) {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //PHP_EOL 実行環境のOSに対応する改行コードを出力する定数
        $sortingSql = 'SELECT A.category_id, A.category_name, A.parent_id, A.status,' . PHP_EOL
                   . '       B.category_name AS parent_name' . PHP_EOL
                   . 'FROM categorys AS A' . PHP_EOL
                   . 'LEFT JOIN categorys AS B' . PHP_EOL
                   . 'ON A.parent_id = B.category_id';

        //sortingのSQL文を結合代入
        $sortingSql .= self::setSortingSql($sorting);

        //sortingのbindはしない(直接SQL文に書き込む)
        $params = [':display_record' => $display_record, ':start_record' => $start_record];

        return Messages::findBySql($sortingSql,$params);
    }
    
    // insert ------------------------------------------------------------------------
    /**
     * 新規登録
     * 
     */
    public function insertCategory() 
    {
        $sql = 'INSERT INTO categorys (category_name, parent_id, status, create_datetime)'. PHP_EOL
             . 'VALUES(:category_name, :parent_id, :status, :create_datetime)';
        
        
        $params = [
            ':category_name' => $this->category_name,
            ':parent_id' => $this->parent_id,
            ':status' => $this->status,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    // edit ------------------------------------------------------------------------
    /**
     * 編集　指定レコードのみ取得
     */
    public function editCategory() 
    {
        $sql = 'SELECT A.category_id, A.category_name, A.parent_id, A.status,' . PHP_EOL
             . '       A.create_datetime, A.update_datetime,'
             . '       B.category_name AS parent_name' . PHP_EOL
             . 'FROM ' . PHP_EOL
             . '    (SELECT * FROM categorys WHERE category_id = :category_id) AS A' . PHP_EOL
             . 'LEFT JOIN categorys AS B' . PHP_EOL
             . 'ON A.parent_id = B.category_id';
        
        $params = [
            ':category_id' => $this->category_id, 
        ];
        
        return Messages::retrieveBySql($sql, $params); 
    }
    
    // update ------------------------------------------------------------------------
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
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * 指定レコードのステータス更新
     */
    public function updateCategoryStatus() {
        $sql = 'UPDATE categorys' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE category_id = :category_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':category_id' => $this->category_id,
            ];
            
        Messages::executeBySql($sql, $params);
    }
    
    // delete ------------------------------------------------------------------------
    /**
     * 指定レコードの削除
     */
    public function deleteCategory() {
        $sql = 'DELETE FROM categorys' . PHP_EOL
         . 'WHERE category_id = :category_id';
        
        $params = [':category_id' => $this->category_id];
        
        Messages::executeBySql($sql, $params);
    }
    
    
    /**
     * ブランド管理に使用 static
     * 
     * select option用　テーブルの取得
     * マンスリー選択用のためparent_id=2に絞る
     */
    public static function selectOption_Monthly() {
        $sql = 'SELECT category_id, category_name FROM categorys WHERE parent_id = 2';
        
        return Messages::findBySql($sql);
    }
    
    /**
     * 商品管理に使用 static
     * 
     * select option用　テーブルの取得
     * ジャンル選択用のためparent_id=1に絞る
     */
    public static function selectOption_Genre() {
        $sql = 'SELECT category_id, category_name FROM categorys  WHERE parent_id NOT IN (2)';
        
        return Messages::findBySql($sql);
    }
}