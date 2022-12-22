<?php

//ユーザー情報 DSN 各ディレクトリの定数定義
require_once('../config/const.php');

//各種classの入ったファイル
require_once(LIB_DIR.'/View.php');
require_once(LIB_DIR.'/Request.php');
require_once(LIB_DIR.'/Database.php');
require_once(LIB_DIR.'/Session.php');
require_once(LIB_DIR.'/Cookie.php');
require_once(LIB_DIR.'/CommonError.php');
require_once(LIB_DIR.'/Validator.php');

/**
 * ['module']['action']の値を受け取る
 * 各コントローラーへ繋がる$filenameを作成
 * try-catchにて各コントローラーファイルの読み込み
 * コントローラーファイル内のexecute_actionを実行
 */
function dispatch($default_module, $default_action) {

    //$_REQUEST['']を代入
    $module_name = Request::get('module');
    $action_name = Request::get('action');

    //$_REQUEST['']がなければ、パラメータの値を使用
    if ($module_name === '') {
        $module_name = $default_module;
    }
    if ($action_name === '') {
        $action_name = $default_action;
    }
    
    //バリデーター初期化
    Validator::paramClear();
    
    //半角英数字、ハイフン、アンダースコア以外の使用はfalse
    //404「Webページが見つからない」
    if(!Validator::checkAlphaunderscore($module_name)) {
        return View::render404();
    }
    if(!Validator::checkAlphaunderscore($action_name)) {
        return View::render404();
    }
    
    //['module']を定数定義
    define('MODULE_NAME', $module_name);
    
    //controllerのファイルパスを決定
    $filename = CONTROLLER_DIR . '/' . $module_name . '/' . $action_name . '.php';
    
    //ファイルがなければ、404「Webページが見つからない」
    if (!file_exists($filename)) {
        return View::render404();
    }
    
    ///$filename = controller/['module']/['action'].phpを読み込み
    //各controller内のexecute_action()を実行
    try {
    
        require_once($filename);
        execute_action();
        
    //エラー処理excute_action()内でthrowされた$eを受け取る
    } catch (Exception $e) {
        //do-whileループ　最後にチェックを行う/最低１回の実行が保証される
        //$errors[]配列にエラーメッセージを入れる
        do {
            $errors[] = $e->getMessage(); //メッセージ取得
        } while ($e = $e->getPrevious()); //前の例外を返す

        //array_reverse()を行うのは、catchした$eは後から追加されたものが上に入っているから
        $errors = array_reverse($errors);

        //$filename= VIEW_DIR/default/error.tpl.phpにアクセス(入力エラーページ)
        //is_array($errors) ~ extract
        return View::renderError($errors);
        
    }
}