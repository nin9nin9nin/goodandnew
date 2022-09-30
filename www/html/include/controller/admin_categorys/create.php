<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }

    $name = Request::get('category_name');
    $parent_id = Request::get('parent_id');
    $status = Request::get('status');
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
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
        
        //categorysテーブル取得 (findBySql())
        $records['categorys'] = $classCategorys->indexCategorys();
        
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    } 
    
    //登録処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classCategorys -> create_datetime = $now_date;
    
    //データベース接続（insert into）
    $classCategorys -> createCategory();
    
    
    return View::redirectTo('admin_categorys', 'index');
}
