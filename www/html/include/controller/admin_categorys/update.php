<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $id = Request::get('category_id');
    $name = Request::get('category_name');
    $parent_id = Request::get('parent_id');
    $status = Request::get('status');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
    $classCategorys -> category_id = $id;
    $classCategorys -> category_name = $name;
    $classCategorys -> parent_id = $parent_id;
    $classCategorys -> status = $status;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classCategorys -> checkCategoryName();
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //指定レコードの取得 retrieveBySql()
        $records[0] = $classCategorys -> editCategory();
        
        //parent_id select用 findBySql()
        $records['parents'] = $classCategorys -> selectOption_Parents();
        
        //エラー追加
        return View::render('edit', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //更新処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classCategorys -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classCategorys -> updateCategory();
    
    
    return View::redirectTo('admin_categorys', 'index');
    
}
