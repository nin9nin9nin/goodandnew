<?php
require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Brands.php');

function execute_action() {
    $item_id = Request::get('item_id');

    if (preg_match('/^\d+$/', $item_id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $item_id;
    
    //指定レコードの取得
    $records['item'] = $classItems -> getItemDetail();
    
    //別途情報取得------------------------------
    $classEvents = new Events();
    $classBrands = new Brands();
    
    
    $classEvents -> event_id = $records['item'] ->event_id;
    $classBrands -> brand_id = $records['item'] ->brand_id;

    //指定IDのイベント情報の取得 (1レコードのみ retrieveBySql())
    $records['event'] = $classEvents -> getEventDetail(); 
    
    //指定IDのブランド情報の取得　(1レコードのみ retrieveBySql())
    $records['brand'] = $classBrands -> getBrandDetail();
    

    return View::render('detail', ['records' => $records]);
}