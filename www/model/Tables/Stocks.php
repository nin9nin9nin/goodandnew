<?php

require_once(MODEL_DIR . '/Messages.php');

//stocksテーブル
class Stocks {
    public $stock_id;
    public $item_id;
    public $stock;
    public $quantity;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> stock_id = null;
        $this -> item_id = null;
        $this -> stock = null;
        $this -> quantity = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    /**
     * 在庫　半角数字　10桁　必須
     * -- int(11)の11は、カラムの表示幅であり、2147483647まで格納が可能。
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkStock() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->stock)) {
            return CommonError::errorAdd('在庫数を入力してください');
        } else if (!Validator::checkRange($this->stock, 1, 10)) {
            return CommonError::errorAdd('在庫数は半角数字、10桁以内で入力してください');
        }
    }

    // index ------------------------------------------------------------------------
    //class Items内で結合して呼び出し

    // insert ------------------------------------------------------------------------
    /**
     * stocksテーブルに新規登録
     * item_id = lastInsertId();
     */
    public function insertStock() {
        //stockテーブル
        $sql = 'INSERT INTO stocks' .PHP_EOL
             . '    (item_id, stock, create_datetime)' .PHP_EOL
             . 'VALUES' .PHP_EOL
             . '    (:item_id, :stock, :create_datetime)';
        
        $params = [
            ':item_id' => $this->item_id,
            ':stock' => $this->stock,
            ':create_datetime' => $this->create_datetime,
        ];
    
        Messages::executeBySql($sql, $params);
    }
    
    // edit ------------------------------------------------------------------------
    //class Items内で結合して呼び出し

    // update ------------------------------------------------------------------------
    /**
     * 指定レコードの編集（stockテーブル）
     */
    public function updateStock() 
    {
        $sql = 'UPDATE stocks' . PHP_EOL
             . 'SET stock = :stock,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id' . PHP_EOL;
        
        $params = [
            ':stock' => $this->stock,
            ':update_datetime' => $this->update_datetime,
            ':item_id' => $this->item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    //ユーザー側-------------------------------------------------------
    /**
     * カート追加時の在庫確認
     * 
     * return object or false
     */
    public function checkAddItemStock() {        
        $sql = 'SELECT item_id, stock' . PHP_EOL
             . 'FROM stocks' . PHP_EOL
             . 'WHERE item_id = :item_id' . PHP_EOL
             . 'AND stock >= :quantity';
        
        $params = [
            ':item_id' => $this -> item_id,
            ':quantity' => $this -> quantity,
        ];
        
        return Messages::retrieveBySql($sql, $params);
    }

    /**
     * カート数量変更時の在庫確認
     * 
     * （エラーメッセージを返す）
     */
    public function checkUpdateItemStock() {        
        $sql = 'SELECT item_id, stock' . PHP_EOL
             . 'FROM stocks' . PHP_EOL
             . 'WHERE item_id = :item_id' . PHP_EOL
             . 'AND stock >= :quantity';
        
        $params = [
            ':item_id' => $this -> item_id,
            ':quantity' => $this -> quantity,
        ];
        
        $record = Messages::retrieveBySql($sql, $params);

        //falseの場合エラーを返す
        if ($record === false) {
            return CommonError::errorAdd('申し訳ございません。在庫が不足しております。');
        }
    }
    
    /**
     * オーダー時の在庫数変更(rollback)
     */
    public function orderStocks($records = []) {
        try {
            $now_date = date('Y-m-d H:i:s');
            
            //登録日時
            $this -> update_datetime = $now_date;

            foreach ($records as $record) {
                $item_id = $record -> item_id;
                $quantity = $record -> quantity;

                $sql = 'UPDATE stocks' . PHP_EOL
                    . 'SET stock = stock - :quantity,' . PHP_EOL
                    . '    update_datetime = :update_datetime' . PHP_EOL
                    . 'WHERE item_id = :item_id' . PHP_EOL;
                
                $params = [
                    ':quantity' => $quantity,
                    ':update_datetime' => $this->update_datetime,
                    ':item_id' => $item_id,
                ];
                
                Messages::executeBySql($sql, $params);
            }

        } catch (Exception $e) {

        $e = new Exception('在庫の変更ができませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
        }
    }


    



    /**
     * セレクト（在庫確認）できれば更新
     * セレクト（false）できければエラーを投げる
     * 
     * 在庫数が０より大きければ在庫数を１減らす
     */
    // public static function editItemStock_add($id)
    // {
    //     //チェックがtrueであればupdate
    //     if (self::checkItemStock_add($id)) {
            
    //         $sql = 'UPDATE stocks' . PHP_EOL
    //              . 'SET stock = stock-1' . PHP_EOL
    //              . 'WHERE item_id = :item_id' . PHP_EOL
    //              . 'AND stock > 0';
            
    //         $params = [':item_id' => $id];
            
    //         Messages::executeBySql($sql, $params);
            
    //     } else {
    //         CommonError::errorAdd('申し訳ございません。更新時にエラーが発生しました。');
    //         //先に入れてあるエラーを投げる
    //         CommonError::errorThrow();
    //     }
    // }
    
    /**
     * カートインデックス時の在庫確認
     * quantityを選択できる
     * 
     * return bool
     */
    // public static function checkItemStock_update($id, $subtraction)
    // {
    //     $sql = 'SELECT stock_id, item_id, stock' . PHP_EOL
    //          . 'FROM stocks' . PHP_EOL
    //          . 'WHERE item_id = :item_id' . PHP_EOL
    //          . 'AND stock >= :subtraction';
        
    //     $params = [
    //         ':item_id' => $id,
    //         ':subtraction' => $subtraction,
    //     ];
        
    //     $record = Messages::retrieveBySql($sql, $params);
        
    //     if ($record !== false) {
    //         return true;
    //     } else {
    //         CommonError::errorAdd('申し訳ございません。在庫数を超えています。');
    //         return false;
    //     }
    // }
    
    /**
     * 在庫数が更新の値以上であれば更新する
     * 在庫数が足りなければエラーを投げる
     * 
     */
    // public static function editItemStock_update($id, $subtraction) 
    // {
    //     //チェックがtrueであればupdate
    //     if (self::checkItemStock_update($id, $subtraction)) {
            
    //         $sql = 'UPDATE stocks' . PHP_EOL
    //              . 'SET stock = stock - :subtraction' . PHP_EOL
    //              . 'WHERE item_id = :item_id';
            
    //         $params = [
    //             ':item_id' => $id,
    //             ':subtraction' => $subtraction,
    //         ];
            
    //         Messages::executeBySql($sql, $params);
            
    //     } else {
    //         CommonError::errorAdd('申し訳ございません。更新時にエラーが発生しました。');
    //         CommonError::errorThrow();
    //     }
    // }
    
    /**
     * カートアイテムの削除時に在庫に戻す
     */
    // public static function editItemStock_return($id, $quantity)
    // {
    //     $sql = 'UPDATE stocks' . PHP_EOL
    //          . 'SET stock = stock + :quantity' . PHP_EOL
    //          . 'WHERE item_id = :item_id';
        
    //     $params = [
    //         ':item_id' => $id,
    //         ':quantity' => $quantity,
    //     ];
        
    //     Messages::executeBySql($sql, $params);
    // }
}