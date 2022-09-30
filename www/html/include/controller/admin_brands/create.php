<?php
require_once(MODEL_DIR . '/Tables/Brands.php');
require_once(MODEL_DIR . '/Tables/Categorys.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }

    $name = Request::get('brand_name');
    $category_id = Request::get('category_id');
    $description = Request::get('description');
    $hp = Request::get('brand_hp');
    $link1 = Request::get('brand_link1');
    $link2 = Request::get('brand_link2');
    $link3 = Request::get('brand_link3');
    $link4 = Request::get('brand_link4');
    $phone_number = Request::get('phone_number');
    $email = Request::get('email');
    $address = Request::get('address');
    $status = Request::get('status');
    
    //クラス生成（初期化）
    $classBrands = new Brands();
    
    //プロパティに値をセット
    $classBrands -> brand_name = $name;
    $classBrands -> category_id = $category_id;
    $classBrands -> description = $description;
    $classBrands -> brand_hp = $hp;
    $classBrands -> brand_link1 = $link1;
    $classBrands -> brand_link2 = $link2;
    $classBrands -> brand_link3 = $link3;
    $classBrands -> brand_link4 = $link4;
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
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //brandsテーブル取得
        $records['brands'] = $classBrands->indexBrands();
        
        //マンスリー選択用にcategorysテーブル取得(parent_id = 2のみ)
        $records['categorys'] = Categorys::selectOption_Monthly();
        
        return View::render('index', ['records' => $records, 'errors' => $errors]);
        exit;
    }
    
    //登録処理 -----------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
    
    $classBrands -> create_datetime = $now_date;
    
    //データベース接続
    $classBrands -> insertBrand();
    
    return View::redirectTo('admin_brands', 'index');
}
