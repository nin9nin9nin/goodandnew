<?php 


//セッション情報を管理するクラス
//コンストラクタ実行でセッション自動スタート
//複数回呼び出されないように、静的プロパティを使ってチェック
class Session {
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;
    
    /**
     * コンストラクタ
     */
    public function __construct() {

    }  
    
    /**
     * センションスタート
     * 
     */
    public static function start()
    {   
        if (!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }

    /**
     * セッションに値を設定
     *
     * @param string $name
     * @param mixed $value
     */
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    /**
     * セッションから値を取得
     *
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     */
    public static function get($name, $default = null)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }

        return $default;
    }
    
    /**
     * セッションから値を削除
     *
     * @param string $name
     */
    public static function remove($name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * セッションを空にする
     */
    public static function clear()
    {
        $_SESSION = array();
    }

    /**
     * セッションIDを再生成する
     *
     * @param boolean $destroy trueの場合は古いセッションを破棄する
     */
    public static function regenerate($destroy = true)
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);

            self::$sessionIdRegenerated = true;
        }
    }

    /**
     * 認証状態を設定
     *
     * @param boolean
     */
    //セッション内に['_authenticated']でログインしているかどうかのフラグを格納し、これを用いてログイン状態の判定を行う
    public static function setAuthenticated($bool)
    {
        self::set('_authenticated', (bool)$bool);

        self::regenerate();
    }

    /**
     * 認証済みか判定
     *
     * @return boolean
     */
    public static function isAuthenticated()
    {
        return self::get('_authenticated', false);
    }
    
    
    //フラッシュメッセージ-----------------------------------------------------
    /**
     * flashメッセージセット
     *
     */
    public static function setFlash($message)
    {
        $_SESSION['flash_message'] = $message;
    }
    
    /**
     * セッションを変数に入れる
     * 配列の'falsh_message'を破棄
     */
    public static function getFlash() {
        
        $flash_message = '';

        if (isset($_SESSION['flash_message']) === TRUE) {
            $flash_message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        return $flash_message;
    }

    //csrf対策　トークン -----------------------------------------------------
    // トークンの生成
    public static function setCsrfToken() {
        // ランダムトークンを取得
        $token = self::get_random_string();
        // セッションに値をセット
        self::set('csrf_token', $token);
    }

    // ランダムトークン作成(64byteのランダムな文字列)
    public static function get_random_string() {
        // random_bytes()暗号論的に安全な、疑似ランダムなバイト列を生成する
        $bytes = random_bytes(32);
        // bin2hex()関数で16進数のASCII文字列に変換して使用
        return bin2hex($bytes);
    }

    // トークンの取得
    public static function getCsrfToken() {

        return self::get('csrf_token', false);
    }
    
    // トークンのチェック(bool)
    public static function isValidCsrfToken($token){
        if($token === '') {
            return false;
        }
        // トークンの取得
        return $token === self::get('csrf_token');
    }
}