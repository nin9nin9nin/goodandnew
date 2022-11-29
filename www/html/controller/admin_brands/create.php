<?php

require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }

    // CSRF対策(POST投稿を行うフォームに対して必ず行う)
    $token = Request::get('token');

    Session::start();
    // postとsessionのトークンを照合（有効か確認）
    if (Session::isValidCsrfToken($token) !== true) {
        // 有効でなければリダイレクト
        Session::setFlash('不正な処理が行われました');

        return View::redirectTo('admin_brands', 'index');
        exit;
    }

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('brand_name');
    $description = Request::get('description');
    $brand_logo = Request::getFiles('brand_logo'); //初期値NULL
    $imgs = Request::getMultipleFiles('img'); //reArray処理済み
    $hp = Request::get('brand_hp');
    $instagram = Request::get('brand_instagram');
    $twitter = Request::get('brand_twitter');
    $facebook = Request::get('brand_facebook');
    $youtube = Request::get('brand_youtube');
    $line = Request::get('brand_line');
    $phone_number = Request::get('phone_number');
    $email = Request::get('email');
    $address = Request::get('address');
    $status = Request::getStatus('status'); //初期値設定0
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> page_id = $page_id;
    $classBrands -> brand_name = $name;
    $classBrands -> description = $description;
    $classBrands -> brand_hp = $hp;
    $classBrands -> brand_instagram = $instagram;
    $classBrands -> brand_twitter = $twitter;
    $classBrands -> brand_facebook = $facebook;
    $classBrands -> brand_youtube = $youtube;
    $classBrands -> brand_line = $line;
    $classBrands -> phone_number = $phone_number;
    $classBrands -> email = $email;
    $classBrands -> address = $address;
    $classBrands -> status = $status;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classBrands -> checkBrandName();
        $classBrands -> checkUrl();
        $classBrands -> checkPhonenumber();
        $classBrands -> checkEmail();
        $classBrands -> checkAddress();
        //生成したファイル名の受け取り
        $logo_name = $classBrands -> checkFileName($brand_logo);
        $img_names = $classBrands -> checkMultipleFileName($imgs);
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        $records['brands'] = $classBrands->indexBrands();
        $paginations = $classBrands -> getPaginations();
        
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //登録処理 -----------------------------------------------------
    
    //データベース接続
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        //プロパティ日時登録+生成したファイル名登録
        $classBrands -> create_datetime = $now_date;
        $classBrands -> brand_logo = $logo_name;
        //複数ファイルのプロパティ登録
        $classBrands -> registerMultipleFiles($img_names);

        //brandsテーブルに新規登録　executeBySql()
        $classBrands -> insertBrand();
        
        //画像のファイルアップロード（できなければrollback）
        $classBrands -> uploadFiles($brand_logo, $logo_name);
        $classBrands -> uploadMultipleFiles($imgs, $img_names);

        Database::commit();
      
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //フラッシュメッセージをセット
    Session::setFlash('ブランドを登録しました');
    
    return View::redirectTo('admin_brands', 'index');
}
