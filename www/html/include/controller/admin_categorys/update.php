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

        return View::redirectTo('admin_events', 'index');
        exit;
    }
    
    //hidden
    $id = Request::get('category_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('category_name');
    $parent_id = Request::get('parent_id');
    $status = Request::getStatus('status');
        
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
        $classCategorys -> checkParentCategory();
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        $records[0] = $classCategorys -> editCategory();
        $records['parents'] = $classCategorys->indexParentCategorys();
        
        //エラーメッセージを表示
        return View::render('edit', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //更新処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classCategorys -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classCategorys -> updateCategory();
    
    //フラッシュメッセージ
    Session::setFlash('ID' . h($id) .':カテゴリー情報を変更しました');
    
    return View::redirectTo('admin_categorys', 'index');
    
}
