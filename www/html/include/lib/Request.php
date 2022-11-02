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
     * ページネーション用
     * $_GET['page_id'] URLに渡された現在のページ数
     * なければ1ページ目という判定をする
     * 
     */
    public static function getPageId($name, $default = '1') {
        $value = $default;

        if (isset($_REQUEST[$name]) === true) {
            $value = $_REQUEST[$name];
        }

        return $value;
    }

    /**
     * $_FILES[] 画像のファイル名を受け取る
     */
    public static function getFiles($name, $default = NULL) {
        $value = $default;

        if (is_uploaded_file($_FILES[$name]['tmp_name']) === true) {
            $value = $_FILES[$name];
        }
        
        return $value;
    }

    /**
     * $_FILES[] 複数ファイルの受け取り
     */
    public static function getMultipleFiles($name) {
        //再格納とアップロードの確認を行う
        return self::reArray($_FILES[$name]);
    }

    /**
     * 複数ファイルの再格納（配列の再格納）
     * ['name']['0'],['name']['1']/['type']['0']['type']['1']...から
     * ['0']['name']['type'].../['0']['name']['type']...に再編成
     */
    public static function reArray($files) {
        $re_files = [];//['0']['1']..を入れる配列
        $file_count = count($files['tmp_name']);//ファイル数のカウント
        $file_keys = array_keys($files);//keyの抽出['name']['type']etc
        
        //reArray処理 
        for ($i=0; $i < $file_count; $i++) {
            // $_FILES['img']['tmp_name']['0']から順にアップロードの確認
            if (is_uploaded_file($files['tmp_name'][$i]) === true) {
                //$re_files['0']に対してキーをループさせながら再格納
                foreach ($file_keys as $key) {
                    $re_files[$i][$key] = $files[$key][$i];
                }

            }
        }
        return $re_files;  
    }

    /**
     * statusの初期値の設定
     * 開発環境で生じた問題
     * MYSQLにカラムの形式の厳密なチェック
     * default0に設定しているが、型がintのため空文字だとエラーが生じる
     * 0:非公開
     * 
     */
    public static function getStatus($name, $default = '0') {
        $value = $default;

        if (isset($_REQUEST[$name]) === true) {
            $value = $_REQUEST[$name];
        }

        return $value;
    }
}