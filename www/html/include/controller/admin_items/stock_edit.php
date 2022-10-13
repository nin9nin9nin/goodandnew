<?php
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //items,stocks 結合テーブルの取得
    $records['items'] = $classItems -> indexItems();
    
        
    return View::render('stock_edit', ['records' => $records]);
}
