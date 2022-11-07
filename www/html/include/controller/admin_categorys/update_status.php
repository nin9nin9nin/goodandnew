<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    // postされたトークンの取得
    $token = Request::get('token');
    
    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_categorys', 'index');
        exit;
    }

    $status = Request::getStatus('status');
    $id = Request::get('category_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
    $classCategorys -> category_id = $id;
    $classCategorys -> status = $status;
    
    //更新処理 -----------------------------------------------------
    $now_date = date('Y-m-d H:i:s');
    
    $classCategorys -> update_datetime = $now_date;
    
    //指定レコードのステータスを更新
    $classCategorys -> updateCategoryStatus();
    
    //フラッシュメッセージをセット
    Session::setFlash('ID' . h($id) .'のステータスを更新しました');    
    
    return View::redirectTo('admin_categorys', 'index');
}
