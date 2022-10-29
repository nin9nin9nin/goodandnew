<?php
/**
* 特殊文字をHTMLエンティティに変換する
*/
function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * URLパラメータ(GETパラメータ/リクエストパラメータ)作成
 * (ベースurl)?名前1=値1&名前2=値2&名前3=値3
 * データ取得のみが目的の場合
 * dispatch()値が付与される
 * return $url
 */
function url_for($module_name = null, $action_name = null, $params = []) {
    return View::urlFor($module_name, $action_name, $params);
}

/**
 * URL作成しリダイレクトを行う
 * $filename = 各controllerへ
 * header('Location: ' . $filename);
 */
function redirect_to($module_name = null, $action_name = null, $params = []) {
    return View::redirectTo($module_name, $action_name, $params);
}

// クラス定義 ------------------------------------------------------------------------
/** 
 * 各viewファイルへのファイルパスを作成
 * エラーページへのrender()
 * controllerにアクセスするためのurlエンコードを作成
 * そのままリダイレクトする関数も作成
 */
class View {
    /**
     * viewファイルを選択するための関数
     * $filenameを作成・読み込み = 各viewページにアクセス
     * include_once($filename);
     * 
     * $params fetchObjectの配列
     * index.php View::render('index', ['records' => $records]);
     * detail.php View::render('detail', ['record' => $record]);
     * edit.php View::render('edit', ['record' => $record]);
     */
    public static function render($view_name, $params = [], $module_name = null) {
        //dispatch()にてMODULE_NAMEを定数定義
        if (is_null($module_name)) {
            $module_name = MODULE_NAME;
        }
        
        //viewファイルの決定
        $filename = VIEW_DIR . '/' . $module_name . '/' . $view_name . '.tpl.php';
        
        //$paramsに['errors']キーがなければキーを作成
        //array_key_exists(調べる値,キーの存在を調べたい配列):bool
        if (!array_key_exists('errors', $params)) {
            $params['errors'] = [];
        }
        
        //配列からシンボルテーブルに変数をインポートした状態にしておく
        //$params fetchObjectの配列 $params['records'] = $records[]
        //extract シンボルテーブルにインポートした変数の数を返す
        extract($params);
        //警告:ユーザーの入力、例えば $_GET や $_FILES のような、 信頼できないデータに extract() を使用しないでください
        
        //viewファイルを読み込み
        include_once($filename);
    }


    /**
     * ページエラー
     * HTTP レスポンスコードを取得または設定
     * （HTTPヘッダフィールドにレスポンスを追加され画面表示に使われる）
     * $_REQUEST[]にエラーがある/指定したファイルが存在しない
     * $filename= VIEW_DIR/default/404.tpl.phpにアクセス
     */
    public static function render404() {
        http_response_code(404);
        self::render('404', [], 'default');
    }
    
    /**
     * 入力エラー
     * controllerのexecute_action()時に発生したエラー
     * $errors[] = $e->getMessage()を受け取る
     * if 受け取ったエラーメッセージを表示
     * else 引数の配列がなければ直接パラメータにメッセージを入れる
     * $filename= VIEW_DIR/default/error.tpl.phpにアクセス
     */
    public static function renderError($message) {
        if (is_array($message)) {
            self::render('error', ['errors' => $message], 'default');
        } else {
            self::render('error', ['errors' => [$message]], 'default');
        }
    }
    
    
    /**
     * controllerへ繋がるurlエンコードを作成
     * 
     * index.php?module=message&action=detail&id=1
     * update.php View::redirectTo('message', 'detail', ['id' => $id])
     * return $url
     */
    public static function urlFor($module_name = null, $action_name = null, $params = []) {
        $url_params = [];
        
        //url エンコードを作成　controllerへ変数を渡す
        //$params['id' => $id]//$url_params[] = 'id=1'
        //$paramsに配列が入っていれば、$url_params[]にエンコードしたURLを入れる
        if (count($params) > 0) {
            foreach ($params as $key => $value) {
                $url_params[] = $key . '=' . urlencode($value); 
            //urlencode() URLの問い合わせ部分に使用する文字列のエンコードや次のページへ変数を渡す際に便利
            }
        }

        //頭のindex.php
        // $url = 'index.php';
        
        //dashboardかindexか
        $url = BASE_URL;

        //パラメータがnullでなければ
        //$url_params[] = 'module=message'
        //$url_params[] = 'action=index'
        if (!is_null($module_name) || !is_null($action_name)) {
            $url_params[] = 'module=' . $module_name;
            $url_params[] = 'action=' . $action_name;
        }

        //&を使って連結させる(配列要素を文字列として)
        if (count($url_params) > 0) {
            $url .= '?' . implode('&', $url_params); 
            //.= (+=などと一緒)
            //implode()配列要素を文字列により連結する
            //すべての配列要素の順序を変えずに、各要素間に separator 文字列をはさんで 1 つの文字列にして返します。
        }

        return $url;
    }

    /**
     * controllerへリダイレクト処理を行う
     * self::urlForでリダイレクト時のurlを取得（$filename=return $url)
     * 
     * create.php View::redirectTo('message', 'index')
     * delete.php View::redirectTo('message', 'index')
     * update.php View::redirectTo('message', 'detail', ['id' => $id])
     */
    public static function redirectTo($module_name = null, $action_name = null, $params = []) {
        $filename = self::urlFor($module_name, $action_name, $params);
        
        header('Location: ' . $filename);
    }
}