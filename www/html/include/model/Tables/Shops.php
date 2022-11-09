<?php

require_once(MODEL_DIR . '/Messages.php');

//shopsテーブル&shop_recommendテーブル
class Shops {
    
    public $shop_id;
    public $event_id;
    public $item_id;
    public $status;
    public $enabled;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> shop_id = null;
        $this -> event_id = null;
        $this -> item_id = null;
        $this -> status = null;
        $this -> enabled = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }

    /**
     * レコメンドアイテムID　int(11)
     * @param array $recommend_items[]
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */

    /**
     * ジョインブランドID　int(11)
     * @param array $join_brands[]
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */


    // index ------------------------------------------------------------------------
    /**
     * 公開中shop_idの取得
     * status（0:非公開、1:公開）
     */
    public function getReleaseShopId() {
        $sql = 'SELECT shop_id FROM shops WHERE status = 1';

        return Messages::findBySql($sql);
    }

    /**
     * 公開中イベント情報取得
     * アイテム数も取得
     */
    public function releaseEvent() {
        //イベントに集中して情報を取得
        $sql = 'SELECT A.shop_id, A.status,' . PHP_EOL
             . '       B.event_id, B.event_name, B.description, B.event_date, B.event_tag, B.event_svg, B.event_png,' . PHP_EOL
             . '       B.img1, B.img2, B.img3, B.img4, B.img5, B.img6, B.img7, B.img8,' . PHP_EOL
             . '       C.item_count'
             . 'FROM shops AS A' . PHP_EOL
             . 'LEFT JOIN events AS B' . PHP_EOL
             . 'ON A.event_id = B.event_id'
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT event_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY event_id) AS C' . PHP_EOL
             . 'ON B.event_id = C.event_id' . PHP_EOL
             . 'WHERE A.shop_id = :shop_id';

        $params = [
            'shop_id' => $this -> shop_id,
        ];
        
        return Messages::findBySql($sql);

    }

    /**
     * shop_recommend　情報取得
     */
    public function recommendItems() {
        //アイテムに集中して情報を取得
        $sql = 'SELECT A.shop_id, A.item_id,' . PHP_EOL
             . '       B.event_id, B.event_name, B.description, B.event_date, B.event_tag, B.event_svg, B.event_png,' . PHP_EOL
             . '       B.img1, B.img2, B.img3, B.img4, B.img5, B.img6, B.img7, B.img8,' . PHP_EOL
             . 'FROM shop_recommend AS A' . PHP_EOL
             . 'LEFT JOIN items AS B' . PHP_EOL
             . 'ON A.item_id = B.item_id'
             . 'WHERE A.shop_id = :shop_id';

        $params = [
            'shop_id' => $this -> shop_id,
        ];
        
        return Messages::findBySql($sql);
    }

    /**
     * ブランド情報
     */
    public function joinBrands() {

        $sql = 'SELECT A.shop_id, A.status,' . PHP_EOL
             . '       B.event_id, B.event_name, B.event_date, B.event_tag, B.event_png,' . PHP_EOL
             . '       C.item_count' . PHP_EOL
             . 'FROM shops AS A' . PHP_EOL
             . 'LEFT JOIN events AS B' . PHP_EOL
             . 'ON A.event_id = B.event_id' . PHP_EOL
             . 'LEFT JOIN ' . PHP_EOL
             . '    (SELECT event_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY event_id) AS C' . PHP_EOL
             . 'ON B.event_id = C.event_id';
        
        return Messages::findBySql($sql);

    }

    
}