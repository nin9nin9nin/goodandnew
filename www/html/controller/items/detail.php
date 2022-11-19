<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Stocks.php');
require_once(MODEL_DIR . '/Tables/Brands.php');
require_once(MODEL_DIR . '/Tables/Shops.php');

function execute_action() {
    $id = Request::get('item_id');

    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    
    //指定レコードの取得
    $records[0] = $classItems -> detailItem();
    
    //別途情報取得------------------------------
    
    $brand_id = $records[0] ->brand_id;
    $shop_id = $records[0] ->shop_id;
    
    //ブランド情報取得
    $records['brand'] = Brands::detailBrand($brand_id);
    
    //ショップ情報取得
    $records['shop'] = Shops::detailShop($shop_id);
    
    
    return View::render('detail', ['records' => $records]);
}