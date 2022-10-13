<?php
require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $id = Request::get('shop_id');
    $name = Request::get('shop_name');
    $description = Request::get('description');
    $hp = Request::get('shop_hp');
    $link1 = Request::get('shop_link1');
    $link2 = Request::get('shop_link2');
    $link3 = Request::get('shop_link3');
    $link4 = Request::get('shop_link4');
    $phone_number = Request::get('phone_number');
    $email = Request::get('email');
    $address = Request::get('address');
    $status = Request::get('status');
    
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classShops = new Shops();
    
    //プロパティに値をセット
    $classShops -> shop_id = $id;
    $classShops -> shop_name = $name;
    $classShops -> description = $description;
    $classShops -> shop_hp = $hp;
    $classShops -> shop_link1 = $link1;
    $classShops -> shop_link2 = $link2;
    $classShops -> shop_link3 = $link3;
    $classShops -> shop_link4 = $link4;
    $classShops -> phone_number = $phone_number;
    $classShops -> email = $email;
    $classShops -> address = $address;
    $classShops -> status = $status;
    
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
            
        //バリデーション（エラーがあればCommonErrorにメッセージを入れる）
        $classShops -> checkShopName();
        $classShops -> checkUrl();
        $classShops -> checkPhonenumber();
        $classShops -> checkEmail();
        $classShops -> checkAddress();
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //指定レコードの取得
        $records[0] = $classShops -> editShop();
            
        
        return View::render('edit', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //更新処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classShops -> update_datetime = $now_date;
    
    //データベース接続（update）
    $classShops -> updateShop();
    
    
    return View::redirectTo('admin_shops', 'index');
    
}
