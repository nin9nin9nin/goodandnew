<?php 


//セッション情報を管理するクラス
//コンストラクタ実行でセッション自動スタート
//複数回呼び出されないように、静的プロパティを使ってチェック
class Session {
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;
    
    /**
     * コンストラクタ
     * セッションを開始する
     * 値をtrueに
     */
    public function __construct()
    {   
        if (!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }
    
    
    /**
     * インスタントとsession_start()
     * getInstanceを実行することで、コンストラクトでsession_start()される
     * $sessionStarted = trueになる
     * return new Session();
     */
    public static function getInstance() {
        //static として宣言することで、 クラスのインスタンス化の必要なしにアクセスできる
        static $instance;
        
        if ($instance === null) {
            $instance = new self();
        }
        
        return $instance;
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
    
    // ----------------------------------------------------------------------
    // /**
    //  * セッションに値を設定
    //  * $_SESSION['$name']を作成し$valueを入れる
    //  */
    // public static function setSession($name, $value) {
    //     //session_start()
    //     return self::getInstance() ->set($name, $value);
        
    // }
    
    // /**
    //  * セッションから値を取得
    //  * return $_SESSION[$name] or $default
    //  */
    // public static function getSession($name, $default = null) {
    //     //session_start()
    //     return self::getInstance() ->get($name, $default);
        
    // }
    
    // /**
    //  * 認証状態を設定
    //  * session_start()からsetAuthenticated()まで行う
    //  * $_SESSION['_authenticated']をtrueにする(認証済みの状態に)
    //  * session_regenerate_idで現在のセッションIDを新しく生成したものと置き換える
    //  * $sessionIdRegenerated = trueにする
    //  * return 
    //  */
    // public static function setAuthentication($bool) {
    //     //session_start()
    //     return self::getInstance() -> setAuthenticated($bool);
        
    // }
    // /**
    //  * 認証済みか判定
    //  * session_start() からisAuthenticated()で認証確認を行う
    //  * $_SESSION['_authenticated']を取得（セットされていなければfalseが返る）
    //  * return 
    //  */
    // public static function getAuthentication() {
    //     //session_start()
    //     return self::getInstance() -> isAuthenticated();
        
    // }
    
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
     * 配列と値を空に
     */
    public static function getFlash() {
        
        $flash_message = '';

        if (isset($_SESSION['flash_message']) === TRUE) {
            $flash_message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        return $flash_message;
    }

}