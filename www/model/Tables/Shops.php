<?php

require_once(MODEL_DIR . '/Messages.php');

//shopsテーブル&shop_recommendテーブル
class Shops {
    
    public $event_id;
    public $brand_id;
    public $item_id;
    public $recommend_id; //recommend_items
    public $brand_ids; //exclusive_brands
    public $item_ids; //exclusive_items
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> event_id = null;
        $this -> brand_id = null;
        $this -> item_id = null;
        $this -> recommend_id = null;
        $this -> brand_ids = array();
        $this -> item_ids = array();
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }

    /**
     * アイテムID　int(11) 
     * array() 入力確認と数字確認
     */
    public function checkItemIds() {
        Validator::paramClear();
        
        if (empty($this->item_ids)) {
            return CommonError::errorAdd('アイテムIDがありません');
        } else {
            foreach ($this -> item_ids as $id) {
                if (!Validator::checkNumeric($id)) {
                    return CommonError::errorAdd('アイテムIDが正しくありません');
                }
            }
        }
    }

    /**
     * ブランドID　int(11) 
     * array() 入力確認と数字確認
     */
    public function checkBranIds() {
        Validator::paramClear();
        
        if (empty($this->brand_ids)) {
            return CommonError::errorAdd('ブランドIDがありません');
        } else {
            foreach ($this -> brand_ids as $id) {
                if (!Validator::checkNumeric($id)) {
                    return CommonError::errorAdd('ブランドIDが正しくありません');
                }
            }
        }
    }

    /**
     * アイテムID　int(11)
     * 配列でない値
     */
    public function checkItemId() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->item_id)) {
            return CommonError::errorAdd('アイテムIDを選択してください');
        } else if (!Validator::checkNumeric($this->item_id)) {
            return CommonError::errorAdd('アイテムIDが正しくありません');
        }
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
     * Events.php editEvent()
     * 指定event_idでイベント情報を取得
     */
    
    /**
     * Items.php indexExclusiveItems()
     * 指定event_idでアイテム一覧を取得
     */

    /**
     * Items.php indexExclusiveBrands()
     * 指定event_idでブランド一覧を取得
     */ 

    /**
     * 指定event_idのレコメンドアイテムを取得
     * index　管理者用
     * get ユーザー用(item/status = 1のみ取得)
     */
    public function indexRecommendItems() {
        $sql = 'SELECT A.recommend_id,' . PHP_EOL
             . '       B.item_id, B.item_name, B.price, B.icon_img, B.status, B.create_datetime,' . PHP_EOL
             . '       C.stock,' . PHP_EOL
             . '       D.category_id, D.category_name, D.parent_id,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . '       F.event_id, F.event_name' . PHP_EOL 
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM recommend_items WHERE event_id = :event_id) AS A' .PHP_EOL
             . 'LEFT JOIN'
             . '    (SELECT * FROM items WHERE enabled = true) AS B' . PHP_EOL //有効なアイテムの取得
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS C' .PHP_EOL //stocksテーブル
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' .PHP_EOL //categoryテーブル
             . 'ON B.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' .PHP_EOL //brandsテーブル
             . 'ON B.brand_id = E.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS F' .PHP_EOL //eventsテーブル
             . 'ON B.event_id = F.event_id' . PHP_EOL
             . 'ORDER BY B.item_id ASC';
        
        $params = [
            ':event_id' => $this->event_id
        ];

        return Messages::findBySql($sql, $params);
    }

    // insert_recommend ------------------------------------------------------------------------
    /**
     * recommend_items新規登録
     */
    public function insertRecommendItems() {
        $sql = 'INSERT INTO recommend_items' . PHP_EOL
             . '    (event_id, item_id, create_datetime)' . PHP_EOL
             . 'VALUES';

        //VALUESの作成
        foreach ($this -> item_ids as $key => $value) {
            $values[] = '(:event_id' . $key . ', :item_id' . $key . ', :create_datetime' . $key . ')';
        }
        //sql文に結合代入
        $sql .= implode(',', $values);

        //paramsの作成
        $params = [];
        foreach ($this -> item_ids as $key => $value) {
            $params += [
                ':event_id'.$key => $this -> event_id,
                ':item_id'.$key => $value,
                ':create_datetime'.$key => $this ->create_datetime,
            ];
        }

        Messages::executeBySql($sql, $params);
    }

    // edit_recommend ------------------------------------------------------------------------
    /**
     * 指定レコメンドアイテムの取得
     */
    public function editRecommendItem() {
        $sql = 'SELECT A.recommend_id,' . PHP_EOL
             . '       B.item_id, B.item_name, B.price, B.icon_img, B.status, B.create_datetime,' . PHP_EOL
             . '       C.stock,' . PHP_EOL
             . '       D.category_id, D.category_name, D.parent_id,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . '       F.event_id, F.event_name' . PHP_EOL 
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM recommend_items WHERE recommend_id = :recommend_id) AS A' .PHP_EOL
             . 'LEFT JOIN'
             . '    (SELECT * FROM items WHERE enabled = true) AS B' . PHP_EOL //有効なアイテムの取得
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS C' .PHP_EOL //stocksテーブル
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' .PHP_EOL //categoryテーブル
             . 'ON B.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' .PHP_EOL //brandsテーブル
             . 'ON B.brand_id = E.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS F' .PHP_EOL //eventsテーブル
             . 'ON B.event_id = F.event_id';
        
        $params = [
            ':recommend_id' => $this->recommend_id
        ];

        return Messages::retrieveBySql($sql,$params); 
    }

    // update_recommend ------------------------------------------------------------------------
    /**
     * 変更　指定レコメンドアイテムを更新
     */
    public function updateRecommendItem() {
        $sql = 'UPDATE recommend_items' . PHP_EOL
             . 'SET item_id = :item_id,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE recommend_id = :recommend_id';

        $params = [
            ':item_id' => $this->item_id,
            ':update_datetime' => $this->update_datetime,
            ':recommend_id' => $this->recommend_id
        ];

        Messages::executeBySql($sql, $params);
    }


    // delete_recommend ------------------------------------------------------------------------
    /**
     * 削除　指定レコメンドアイテムを削除
     */
    public function deleteRecommendItem() {
        $sql = 'DELETE FROM recommend_items' . PHP_EOL
             . 'WHERE recommend_id = :recommend_id';
        
        $params = [':recommend_id' => $this->recommend_id];

        Messages::executeBySql($sql, $params);
    }

    // ユーザー画面 ------------------------------------------------------------------------
    /**
     * 公開中イベントのレコメンドアイテムを取得
     * 
     * get ユーザー用(item/status = 1のみ取得)
     */
    public function getRecommendItems() {
        $sql = 'SELECT A.recommend_id,' . PHP_EOL
             . '       B.item_id, B.item_name, B.price, B.description, B.icon_img, B.status, B.create_datetime,' . PHP_EOL
             . '       C.stock,' . PHP_EOL
             . '       D.category_id, D.category_name, D.parent_id,' . PHP_EOL
             . '       E.brand_id, E.brand_name,' . PHP_EOL
             . '       F.event_id, F.event_name' . PHP_EOL 
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM recommend_items WHERE event_id = :event_id) AS A' .PHP_EOL
             . 'LEFT JOIN'
             . '    (SELECT * FROM items WHERE status= 1 AND enabled = true) AS B' . PHP_EOL //有効なアイテムの取得
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN stocks AS C' .PHP_EOL //stocksテーブル
             . 'ON B.item_id = C.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS D' .PHP_EOL //categoryテーブル
             . 'ON B.category_id = D.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS E' .PHP_EOL //brandsテーブル
             . 'ON B.brand_id = E.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS F' .PHP_EOL //eventsテーブル
             . 'ON B.event_id = F.event_id' . PHP_EOL
             . 'ORDER BY B.item_id ASC';
        
        $params = [
            ':event_id' => $this->event_id
        ];

        return Messages::findBySql($sql, $params);
    }
    
}