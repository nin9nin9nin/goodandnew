<?php 

class Cookie {
    
    // public $cookie_check;
    // public $name;
    
    // /**
    //  * コンストラクタ
    //  */
    // public function __construct() {
    //     $this->cookie_check = null;
    //     $this->name = null;
    // }
    
    /**
     * クッキーの保存or削除
     */
    public static function setCookie($cookie_check, $name) {
        $now = time();
        if ($cookie_check === 'checked') {
          // Cookieへ保存する
          setcookie('cookie_check', $cookie_check, $now + 60 * 60 * 24 * 365);
          setcookie('cookie_name', $name, $now + 60 * 60 * 24 * 365);
        } else {
          // Cookieを削除する
          setcookie('cookie_check', '', $now - 3600);
          setcookie('cookie_name', '', $now - 3600);
        }
    }
    
    /**
     * クッキーの取得or空文字
     */
    public static function getCookieCheck() {
        //クッキーを取得
        if (isset($_COOKIE['cookie_check'])) {
          return $cookie_check = 'checked';
        } else {
          return $cookie_check = '';
        }
    }
    
    public static function getCookieName() {
        //クッキーを取得
        if (isset($_COOKIE['cookie_name'])) {
          return $name = $_COOKIE['cookie_name'];
        } else {
          return $name = '';
        }
    }
    
    /**
     * クッキーの削除
     */
    public static function clearCookieCheck() {
        $now = time();
        if (isset($_COOKIE['cookie_check'])) {
            setcookie('cookie_check', '', $now - 3600);
        }
    }
    /**
     * クッキーの削除
     */
    public static function clearCookieName() {
        $now = time();
        if (isset($_COOKIE['cookie_name'])) {
            setcookie('cookie_name', '', $now - 3600);
        }
    }
    
    public static function deleteCookieSessionId($session_name) {
        // ユーザのCookieに保存されているセッションIDを削除
        if (isset($_COOKIE[$session_name])) {
          // sessionに関連する設定を取得
          $params = session_get_cookie_params();
         
          // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
          setcookie($session_name, '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
          );
        }
    }
    
    //ユーザー側----------------------------------------
    /**
     * クッキーの保存or削除
     */
    public static function setUserCookie($cookie_check, $name) {
        $now = time();
        if ($cookie_check === 'checked') {
          // Cookieへ保存する
          setcookie('cookie_check', $cookie_check, $now + 60 * 60 * 24 * 365);
          setcookie('user_name', $name, $now + 60 * 60 * 24 * 365);
        } else {
          // Cookieを削除する
          setcookie('cookie_check', '', $now - 3600);
          setcookie('user_name', '', $now - 3600);
        }
    }
    
    /**
     * クッキーの取得or空文字
     */
    public static function getUserCookieCheck() {
        //クッキーを取得
        if (isset($_COOKIE['cookie_check'])) {
          return $cookie_check = 'checked';
        } else {
          return $cookie_check = '';
        }
    }
    public static function getUserCookieName() {
        //クッキーを取得
        if (isset($_COOKIE['user_name'])) {
          return $cookie_name = $_COOKIE['user_name'];
        } else {
          return $cookie_name = '';
        }
    }
    
    /**
     * クッキーの削除
     */
    public static function clearUserCookieCheck() {
        $now = time();
        if (isset($_COOKIE['cookie_check'])) {
            setcookie('cookie_check', '', $now - 3600);
        }
    }
    /**
     * クッキーの削除
     */
    public static function clearUserCookieName() {
        $now = time();
        if (isset($_COOKIE['user_name'])) {
            setcookie('user_name', '', $now - 3600);
        }
    }
    
    

}