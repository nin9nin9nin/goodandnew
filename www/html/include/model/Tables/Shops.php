<?php

require_once(MODEL_DIR . '/Messages.php');

//shopsテーブル&shop_recommendテーブル
class Shops {
    
    public $page_id; //ページ番号
    public $display_record = 10; //１ページの表示件数
    public $event_id;
    public $brand_id; //exclusive_brands
    public $item_id; //exclusive_items
    public $recommend_id; //recommend_items
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> page_id = null;
        $this -> event_id = null;
        $this -> brand_id = null;
        $this -> item_id = null;
        $this -> recommend_id = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }

    // paginations ------------------------------------------------------------------------
    
    /**
     * イベント属性のアイテム数をカウント
     * トータルレコード数を返す
     * return $record['cnt']
     */
    public function getTotalRecord() {
        // テーブルから全レコードの数をカウント
        $sql ='SELECT COUNT(*) as cnt' . PHP_EOL
        . 'FROM exclusive_items AS A' . PHP_EOL
        . 'LEFT JOIN items AS B' . PHP_EOL
        . 'WHERE A.event_id = :event_id' . PHP_EOL
        . 'AND B.enabled = true';
        
        $params = [
            ':event_id' => $this -> event_id
        ];
        
        $record = Messages::retrieveBySql($sql);
        
        // カウントした数を返す
        return $record->cnt;
    }

    /**
     * トータルレコードを取得
     * ページネーションの値をセットして返す
     * return array
     */
    public function getPaginations() {
        //トータルレコードの取得
        $total_record = self::getTotalRecord();
        
        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record, $this->display_record, $this->page_id);
        
    }

    // index ------------------------------------------------------------------------
    /**
     * Events.php releaseEvent()で公開中イベントを取得
     */

    /**
     * Events.php indexEvent()でイベント一覧を取得
     */

    // exclusive ------------------------------------------------------------------------

    /**
     * Events.php editEvent()で指定idのイベント情報を取得
     */

    /**
     * イベント属性のブランドを取得
     * index　管理者用
     * get ユーザー用(item/status = 1のみ取得)
     */
    public function indexExclusiveBrands() {

        $sql = 'SELECT A.event_id, A.brand_id,' . PHP_EOL
             . '       B.brand_name, B.brand_logo, B.status,' . PHP_EOL
             . '       COALESCE(C.item_count,0) AS item_count' . PHP_EOL //結合できない(商品がない)場合0を表示
             . 'FROM exclusive_brands AS A' . PHP_EOL
             . 'LEFT JOIN brands AS B' . PHP_EOL
             . 'ON A.brand_id = B.brand_id' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT brand_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY brand_id) AS C' . PHP_EOL
             . 'ON B.brand_id = C.brand_id' . PHP_EOL
             . 'WHERE A.event_id = :event_id';
        
        $params = [
            ':event_id' => $this -> event_id
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * イベント属性のアイテムを取得
     * index　管理者用
     * get ユーザー用(item/status = 1のみ取得)
     */
    public function indexExclusiveItems() {
        $sql = 'SELECT A.event_id, A.item_id,' . PHP_EOL
             . '       B.item_name, B.price, B.icon_img, B.status, B.create_datetime,' . PHP_EOL
             . '       C.stock,' . PHP_EOL
             . '       D.category_id, D.category_name, C.parent_id,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . 'FROM exclusive_items AS A' .PHP_EOL
             . 'LEFT JOIN (SELECT * FROM items WHERE enabled = true) AS B' . PHP_EOL //有効なアイテムの取得
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS C' .PHP_EOL //stocksテーブル
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' .PHP_EOL //categoryテーブル
             . 'ON B.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' .PHP_EOL //brandsテーブル
             . 'ON B.brand_id = E.brand_id' . PHP_EOL
             . 'WHERE A.event_id = :event_id';
        
        $params = [
            ':event_id' => $this -> event_id
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * レコメンドアイテムを取得
     * index　管理者用
     * get ユーザー用(item/status = 1のみ取得)
     */
    public function indexRecommendItems() {
        $sql = 'SELECT A.event_id, A.item_id,' . PHP_EOL
             . '       B.item_name, B.price, B.icon_img, B.status, B.create_datetime,' . PHP_EOL
             . '       C.stock,' . PHP_EOL
             . '       D.category_id, D.category_name, C.parent_id,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . 'FROM recommend_items AS A' .PHP_EOL
             . 'LEFT JOIN (SELECT * FROM items WHERE enabled = true) AS B' . PHP_EOL //有効なアイテムの取得
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS C' .PHP_EOL //stocksテーブル
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' .PHP_EOL //categoryテーブル
             . 'ON B.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' .PHP_EOL //brandsテーブル
             . 'ON B.brand_id = E.brand_id' . PHP_EOL
             . 'WHERE A.event_id = :event_id';
        
        $params = [
            ':event_id' => $this -> event_id
        ];

        return Messages::findBySql($sql, $params);
    }


    // edit ------------------------------------------------------------------------
    /**
     * イベント情報の取得
     */
    

    // create ------------------------------------------------------------------------
    /**
     * 選択したイベントの情報取得
     */

    /**
     * イベントに紐づいたアイテムの情報取得
     */

    /**
     * レコメンドアイテム登録
     * 取得したアイテムからレコメンドアイテムを選択・登録
     * @param array $recommend_items[]
     */

    /** 
     * アイテムに紐づいたブランドの情報取得
     */

    /** 
     * ジョインブランド登録
     * 取得したブランド情報からジョインテーブルに登録
     */




    
}