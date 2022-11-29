<?php

require_once(MODEL_DIR . '/Messages.php');

//favorites テーブル
class Favorites {

    public $page_id; //ページ番号
    public $display_record = 12; //１ページの表示件数
    public $favorite_id;
    public $user_id;
    public $item_id;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> page_id = null;
        $this -> favorite_id = null;
        $this -> user_id = null;
        $this -> item_id = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
        
    // paginations ------------------------------------------------------------------------
    /**
     * トータルレコードを取得し、ページネーションの値をセットして返す
     * return array
     */
    public function getPaginations() {
        //トータルレコードの取得
        $total_record = $this->getTotalRecord();
        
        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record, $this->display_record, $this->page_id);
        
    }

    /**
     * 各テーブルのトータルレコード数を返す
     * return $record['cnt']
     */
    public function getTotalRecord() {
        // テーブルから全レコードの数をカウント
        $sql ='SELECT COUNT(*) as cnt' . PHP_EOL
            . 'FROM favorites' . PHP_EOL
            . 'WHERE user_id = :user_id';

        $params = [
            ':user_id' => $this->user_id
        ];
        
        // cnt取得
        $record = Messages::retrieveBySql($sql, $params);
        
        // カウントした数を返す
        return $record->cnt;
    }

    // index ------------------------------------------------------------------------
    /**
     * テーブル一覧の取得
     * 
     */
    public function indexFavorites() 
    {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        $sql = 'SELECT A.favorite_id, A.user_id,' . PHP_EOL
             . '       B.item_id, B.item_name, B.price, B.description, B.icon_img, B.status,' . PHP_EOL
             . '       C.stock,' . PHP_EOL
             . '       D.category_id, D.category_name, D.parent_id,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . '       F.event_id, F.event_name' . PHP_EOL 
             . 'FROM ' . PHP_EOL
             . '    (SELECT * FROM favorites WHERE user_id = :user_id) AS A' . PHP_EOL //有効なユーザーの指定
             . 'LEFT JOIN items AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS C' .PHP_EOL //categoryテーブル
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' .PHP_EOL //categoryテーブル
             . 'ON B.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' .PHP_EOL //brandsテーブル
             . 'ON B.brand_id = E.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS F' .PHP_EOL //eventsテーブル
             . 'ON B.event_id = F.event_id' . PHP_EOL
             . 'ORDER BY A.favorite_id DESC' . PHP_EOL
             . 'LIMIT :display_record OFFSET :start_record';
        
        $params = [
            ':user_id' => $this -> user_id,
            ':display_record' => $display_record,
            ':start_record' => $start_record,
        ];
        
        return Messages::findBySql($sql,$params); 
    } 

    // insert ------------------------------------------------------------------------
    /**
     * 新規登録
     * 
     */
    public function insertFavorite() 
    {
        $sql = 'INSERT INTO favorites (user_id, item_id, create_datetime)'. PHP_EOL
             . 'VALUES(:user_id, :item_id, :create_datetime)';
        
        
        $params = [
            ':user_id' => $this->user_id,
            ':item_id' => $this->item_id,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    // delete ------------------------------------------------------------------------
    /**
     * 指定レコードの削除
     */
    public function deleteFavorite() {
        $sql = 'DELETE FROM favorites' . PHP_EOL
             . 'WHERE favorite_id = :favorite_id';
        
        $params = [':favorite_id' => $this->favorite_id];
        
        Messages::executeBySql($sql, $params);
    }
    

}