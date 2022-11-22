<?php

require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    //クラス生成（初期化）
    $classItems = new Items();
    
    //オリジナルアイテム一覧の取得
    $records['originals'] = $classItems -> getOriginalItems(); 
    
    return View::render('index', ['records' => $records]);
}