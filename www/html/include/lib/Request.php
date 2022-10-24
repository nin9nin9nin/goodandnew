<?php
//ユーザーのリクエスト情報を制御するクラス
//URLもリクエスト情報の一部と見なせるため、Requestクラスにメソッド追加
class Request {
    /**
     * リクエストメゾット(POST)
     * return bool
     */
    public static function isPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }

        return false;
    }

    /**
     * リクエストメゾット(GET)
     * return bool
     */
    public static function isGet() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return true;
        }

        return false;
    }

    /**
     * $_GET,$_POSTの内容を受け取る
     * フィルタリング　先頭と末尾の空白を削除
     * param str
     * return str $value $_REQUEST 連想配列
     */
    public static function get($name, $default = '') {
        $value = $default;

        if (isset($_REQUEST[$name]) === true) {
            $value = $_REQUEST[$name];
        }
        
        //前後全角半角空白文字の無効関数
        $value = preg_replace('/^[　\s]*|[　\s]*$/u', '', $value);

        return $value;
    }
    
    /**
     * サーバーのホスト名を取得するメソッド
     */
    public static function getHost() {
        
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SEVER['HTTP_HOST'];
        }
    }

    /**
     * HTTPSでアクセスされたかどうかの判定
     */
    public static function isSsl() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }
        return false;
    }

    /**
     * リクエストされたURLの情報を格納
     */
    //urlの制御を行う元の値（ホスト部分以降）
    public static function getRequestUri() {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * ベースURLの特定 (index.phpなど)
     * SCRIPT_NAME,REQUEST_URLの値を用いて取得
     * strpos()第1引数の文字列中から第2引数の文字列が最初に出現する位置を調べる
     * rtrim()右側に続く/を削除
     */
    public static function getBaseUrl() {
        //$_SERVER['SCRIPT_NAME'] "/php/ec_site/dashboard.php"
        $script_name = $_SERVER['SCRIPT_NAME'];
        //$_SERVER['REQUEST_URI'] "/php/ec_site/dashboard.php""
        $request_uri = $_SERVER['REQUEST_URI'];
        
        //$request_uri = self::getRequsetUri();
        
        // basename(__FILE__); // index.php
        
        //下記の表記はしないほうが良い？（0はfalseに変換されるから）
        if (0 === strpos($request_uri, $script_name)) {
            return $script_name;
        } else if (0 === strpos($request_uri, dirname($script_name))) {
            return rtrim(dirname($script_name), '/');
        }
        return '';
    }

    /**
     * PATH_INFOの特定 (/itemsなど)
     * 基本REQUEST_URIからベースURLを除いた値になる
     * substr()第2引数で指定した位置から第3引数で指定した文字数分取得する
     */
    public static function getPathInfo() {
        $base_url = self::getBaseUrl();
        $request_uri = self::getRequsetUri();
        
        if (false !== ($pos = strpos($request_uri, '?'))) {
            $request_uri = substr($request_uri, 0, $pos);
        }
        $path_info = (string)substr($request_uri, strlen($base_url));
        
        return $path_info;
    }

    /**
     * ページネーション
     * page_idの取得と決定
     * $_GET['page_id'] はURLに渡された現在のページ数
     */
    public static function getPageId($name, $default = '') {
        $value = $default;

        if (isset($_REQUEST[$name]) === true) {
            $value = 1;// 設定されてない場合は1ページ目にする
        } else {
            $value = $_REQUEST[$name];
        }

        return $value;
    }
}