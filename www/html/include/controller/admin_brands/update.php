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
    
    //hidden
    $id = Request::get('brand_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }

    //フォームの値を取得
    $name = Request::get('brand_name');
    $description = Request::get('description');
    $brand_logo = Request::getFiles('brand_logo'); //初期値NULL
    $exists_logo = Request::get('exists_logo'); // $_POST['exists_logo']既存のファイル名
    $hp = Request::get('brand_hp');
    $instagram = Request::get('brand_instagram');
    $twitter = Request::get('brand_twitter');
    $facebook = Request::get('brand_facebook');
    $youtube = Request::get('brand_youtube');
    $line = Request::get('brand_line');
    $phone_number = Request::get('phone_number');
    $email = Request::get('email');
    $address = Request::get('address');
    $status = Request::getStatus('status');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_id = $id;
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
        //ファイル名を生成するか既存のファイル名を使用するか判定
        if (isset($brand_logo) === true) {
            $logo_name = $classBrands -> checkFileName($brand_logo);//拡張子の確認
        } else {
            $logo_name = $exists_logo;
        }
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //指定レコードの取得
        $record = $classBrands -> editBrand();
        
        return View::render('edit', ['record' => $record, 'errors' => $errors]);
        exit;
    }
    
    //更新処理 -----------------------------------------------------
    //データベース接続
    Database::beginTransaction();
    try {
        $now_date = date('Y-m-d H:i:s');
        
        //プロパティ日時登録+生成したファイル名登録
        $classBrands -> update_datetime = $now_date;
        $classBrands -> brand_logo = $logo_name;

        //brandsテーブルに新規登録　executeBySql()
        $classBrands -> updateBrand();
        
        //画像のファイルアップロード（できなければrollback）
        if (isset($brand_logo) === true) {
            $classBrands -> uploadFiles($brand_logo, $logo_name);
        }
        Database::commit();
      
    } catch (Exception $e) {
        $e = new Exception('データベースに接続できませんでした', 0, $e);
        //トランザクションでのエラーはcontrollerでキャッチしてもらう(error.tpl.phpへ)
        throw $e;
        
        Database::rollback();
    }
    
    //フラッシュメッセージをセット
    Session::setFlash('ID' . h($id) .':ブランド情報を変更しました');

    //indexへリダイレクト
    return View::redirectTo('admin_brands', 'index');
}
