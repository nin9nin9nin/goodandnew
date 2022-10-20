<?php
/**
 * Models機能にメッセージ機能を追加
 * html上で関数をそのまま使用
 * 各モデルでinclude
 * Massages::でオブジェクトの内部からスコープ
 */

require_once(MODEL_DIR . '/Models.php');

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
     * オーダー日時のフォーマット変更
     */
    public function getLastOrderDateTime($format = 'Y年m月d日 H時i分') {
        $time = strtotime($this->order_date);

        return date($format, $time);
    }
    
    /**
     * 3桁カンマ区切り
     * 
     * カンマ区切りになっているため戻り値は数値ではなく文字列であることに注意
     */
    public function getPrice() {
        return number_format($this->price);
    }
    /**
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
     * 税込み価格
     */
    public function getTotalQuantity($records=[]) {
        $total_quantity = 0;
        foreach($records as $record){
            $total_quantity += $record->quantity;
        }
        return number_format($total_quantity);
    }
    
    public function getTotalAmount($records=[]) {
        $total_amount = 0;
        foreach($records as $record){
            $total_amount += $record->price * $record->quantity;
        }
        return number_format($total_amount);
    }
    
    /**
     * descriptionの省略
     * 98文字以上は…
     */
    public function getDescription() {
        return mb_strimwidth( $record->description , 0, 98, '…', 'UTF-8' );
    }
}
