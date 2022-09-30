<?php
//ディレクトリを定数定義
define('INCLUDE_DIR',dirname(__FILE__));
//''=/include+/各ディレクトリ
define('CONFIG_DIR', INCLUDE_DIR . '/config');
define('LIB_DIR', INCLUDE_DIR . '/lib');
define('CONTROLLER_DIR', INCLUDE_DIR . '/controller');
define('VIEW_DIR', INCLUDE_DIR . '/view');
define('MODEL_DIR', INCLUDE_DIR . '/model');
define('IMG_DIR', INCLUDE_DIR.'/img');

//ユーザー情報+DSN
require_once(CONFIG_DIR.'/const.php');

//各種classの入ったファイル
require_once(LIB_DIR.'/View.php');
require_once(LIB_DIR.'/Request.php');
require_once(LIB_DIR.'/Database.php');
require_once(LIB_DIR.'/Session.php');
require_once(LIB_DIR.'/Cookie.php');
require_once(LIB_DIR.'/CommonError.php');
require_once(LIB_DIR.'/Validator.php');


/**
 * dashboard.php/index.phpにて使用
 * ['module']['action']に値を入れる
 * 各種controllerへ繋がる$filenameを作成
 * try-catchにてファイル読み込み。
 * ファイル内動作の実行 execute_action
 */
function dispatch($default_module, $default_action) {

    //フラッシュメッセージを受け取る
    // $falsh_message = Session::getFlash();

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
        
    //関数内でthrowされた$eを受け取る
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