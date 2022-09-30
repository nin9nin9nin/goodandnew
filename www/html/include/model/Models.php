<?php
//Databaseにて作成した関数たちを命令機能を(接続含む)
//static::classでModelsを$class_nameにする fetchObject($class_name)
class Models {
    public static function retrieveBySql($sql, $params = []) {
        return Database::retrieveBySql($sql, $params, static::class);
    }

    public static function findBySql($sql, $params = []) {
        return Database::findBySql($sql, $params, static::class);
    }

    public static function executeBySql($sql, $params = []) {
        return Database::executeBySql($sql, $params);
    }
    
    /**
     * htmlにて：echo h($record->getCreateDateTime());
     * return $timeを$formatのdateにして返す
     */
    public function getCreateDateTime($format = 'Y年m月d日 H時i分') {
        $time = strtotime($this->create_datetime);

        return date($format, $time);
    }
    
    /**
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