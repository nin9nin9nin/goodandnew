<?php

require_once(MODEL_DIR . '/Models.php');
/**
 * Models機能にメッセージ機能を追加
 * html上で関数をそのまま使用
 * 各モデルでinclude
 * Massages::でオブジェクトの内部からスコープ
 */
class Messages extends Models {
    /**
     * 登録日時のフォーマット変更
     * h($record->getCreateDateTime());
     * 
     */
    public function getCreateDateTime($format = 'Y年m月d日 H時i分') {
        $time = strtotime($this->create_datetime);

        return date($format, $time);
    }

    /**
     * 更新日時のフォーマット変更
     * h($record->getCreateDateTime());
     * 
     */
    public function getUpdateDateTime($format = 'Y年m月d日 H時i分') {
        $time = strtotime($this->update_datetime);

        return date($format, $time);
    }

    /**
     * オーダー日時のフォーマット変更
     */
    public function getLastOrderDateTime($format = 'Y年m月d日 H時i分') {
        $time = strtotime($this->order_date);

        return date($format, $time);
    }
    
    /**
     * 値段の3桁カンマ区切り
     * カンマ区切りになっているため戻り値は数値ではなく文字列であることに注意
     * 
     */
    public function getPrice() {
        return number_format($this->price);
    }

    /**
     * 在庫の3桁カンマ区切り
     */
    public function getStock() {
        return number_format($this->stock);
    }
    
    /**
     * 税込み価格
     * echo h($record->getPriceInTax());
     * return $price
     */
    public function getPriceInTax($tax = 1.10) {
        $price = $this->price * $tax;

        return number_format($price);
    }

    /**
     * イベントタグの取得
     * echo h($record->getPriceInTax());
     * return string
     */
    public function getEventTag() {
        $event_tag = $this->event_tag;

        if($event_tag === 0) {
            return 'MONTHLY POP UP';
        } else if ($event_tag === 1) {
            return 'EVENT';
        }
    }

    /**
     * 小計計算
     */
    public function getSubTotal() {
        $sub_total = 0;

        $sub_total = $this->price * $this->quantity;

        return number_format($sub_total);
    }

    /**
     * 合計数量
     */
    public function getTotalQuantity($records = []) {
        $total_quantity = 0;

        foreach ($records as $record) {
            $total_quantity += $record->quantity;
        }
        
        return number_format($total_quantity);
    }
    
    /**
     * 合計金額
     */
    public function getTotalAmount($records = []) {
        $total_amount = '-';

        foreach($records as $record){
            $total_amount += $record->price * $record->quantity;
        }

        return number_format($total_amount);
    }
}
