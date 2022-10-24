<?php
/**
 * エラー動作クラス
 * validatorと組み話合わせて各モデルにて使用
 */
class CommonError {
    //クラスの内側からのみ参照可能
    //staticでインスタンス化なしで読み書き可能に（共通の変数）
    public static $e;
    
    /**
     * エラー削除 (初期化)
     * 共通のプロパティのため初期化が必須
     */
    public static function errorClear() {
        self::$e = null;
    }
    
    /**
     * エラー追加関数
     * $message str
     */
    public static function  errorAdd($message) {
        self::$e = new Exception($message, 0, self::$e);
    }
    
    /**
     * エラーを投げる
     */
    public static function errorThrow() {
        if(self::$e !== null) {
            throw self::$e;
        }
    }
    
    /**
     * エラーを回す
     */
    public static function errorWhile() {
        //do-whileループ　最後にチェックを行う/最低１回の実行が保証される
        //$errors[]配列にエラーメッセージを入れる
        do {
            $errors[] = self::$e->getMessage(); //メッセージ取得
        } while (self::$e = self::$e->getPrevious()); //前の例外を返す

        //array_reverse()を行うのは、catchした$eは後から追加されたものが上に入っているから
        return array_reverse($errors);
        
    }
    
    
}