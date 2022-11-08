<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

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

        return View::redirectTo('admin_brands', 'index');
        exit;
    }

    $id = Request::get('brand_id');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_id = $id;
        
    //指定レコードの削除
    $classBrands -> deleteBrand();
    
    //フラッシュメッセージをセット
    Session::setFlash('イベントを削除しました');    
    
    return View::redirectTo('admin_brands', 'index');
}
