<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
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

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('category_name');
    $parent_id = Request::get('parent_id');
    $status = Request::getStatus('status'); //初期値設定0
    
    //クラス生成（初期化）
    $classCategorys = new Categorys();
    
    //プロパティに値をセット
    $classCategorys -> page_id = $page_id;
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
        
        $records['categorys'] = $classCategorys->indexCategorys();
        $records['parents'] = $classCategorys->indexParentCategorys();
        $paginations = $classCategorys -> getPaginations();
        
        //エラーがあれば再度indexページへ戻りエラーメッセージを表示
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    } 
    
    //登録処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classCategorys -> create_datetime = $now_date;
    
    //categorysテーブルに新規登録　executeBySql()
    $classCategorys -> insertCategory();

    //フラッシュメッセージをセット
    Session::setFlash('商品を登録しました');
    
    return View::redirectTo('admin_categorys', 'index');
}
