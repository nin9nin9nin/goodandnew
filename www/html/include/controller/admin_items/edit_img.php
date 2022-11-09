<?php

require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    $id = Request::get('item_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    Session::start();
    //トークンの作成
    Session::setCsrfToken();
   
   //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    
    //指定レコードの取得
    $record = $classItems -> editItemImg();
    
    return View::render('edit_img', ['record' => $record]);
}