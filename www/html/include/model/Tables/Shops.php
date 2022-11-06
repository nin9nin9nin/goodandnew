<?php

require_once(MODEL_DIR . '/Messages.php');

//shopsテーブル
class Shops {
    
    public $shop_id;
    public $event_id;
    public $recommend_item1;//item_id
    public $recommend_item2;//item_id
    public $recommend_item3;//item_id
    public $recommend_item4;//item_id
    public $join_brand1;//brand_id
    public $join_brand2;//brand_id
    public $join_brand3;//brand_id
    public $join_brand4;//brand_id
    public $join_brand5;//brand_id
    public $status;
    public $enabled;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> shop_id = null;
        $this -> event_id = null;
        $this -> recommend_item1 = null;
        $this -> recommend_item2 = null;
        $this -> recommend_item3 = null;
        $this -> recommend_item4 = null;
        $this -> join_brand1 = null;
        $this -> join_brand2 = null;
        $this -> join_brand3 = null;
        $this -> join_brand4 = null;
        $this -> join_brand5 = null;
        $this -> status = null;
        $this -> enabled = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    /**
     * イベントID　int(11)
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkEventId() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->event_id)) {
            return CommonError::errorAdd('イベントを選択してください');
        } else if (!Validator::checkNumeric($this->event_id)) {
            return CommonError::errorAdd('イベントIDが正しくありません');
        }
    }

    /**
     * アイテムID　int(11)
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkItemId() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->event_id)) {
            return CommonError::errorAdd('イベントを選択してください');
        } else if (!Validator::checkNumeric($this->event_id)) {
            return CommonError::errorAdd('イベントIDが正しくありません');
        }
    }
    
}