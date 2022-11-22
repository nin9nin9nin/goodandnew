<?php

require_once(MODEL_DIR . '/Tables/Events.php');
require_once(MODEL_DIR . '/Tables/Brands.php');
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    if (!Request::isGet()) {
        return View::render404();
    }

    //検索項目の取得(キーで判別する)
    $search = Request::get('search');
    $brand_id = Request::getEventId('brand_id');
    $event_id = Request::getEventId('event_id');

    if (preg_match('/^\d+$/', $brand_id) !== 1 && preg_match('/^\d+$/', $event_id) !== 1) {
        return View::render404();
    }

    //クラス生成（初期化）
    $classEvents = new Events();
    $classBrands = new Brands();
    $classItems = new Items();
    
    //プロパティに値をセット
    $classEvents -> event_id = $event_id;
    $classBrands -> brand_id = $brand_id;
    $classItems -> brand_id = $brand_id;
    
    //指定IDのイベント情報の取得 (1レコードのみ retrieveBySql())
    $records['event'] = $classEvents -> getEventDetail(); 
    
    //指定IDのブランド情報の取得　(1レコードのみ retrieveBySql())
    $records['brand'] = $classBrands -> getBrandDetail();

    //専用アイテム一覧取得
    $records['items'] = $classItems -> searchBrandItems($search);
    
    //専用カテゴリー一覧の取得
    $records['categorys'] = $classItems -> getBrandCategorys();

    return View::render('index', ['records' => $records]);
}