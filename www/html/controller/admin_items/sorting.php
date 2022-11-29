<?php

require_once(MODEL_DIR . '/Tables/Items.php');
require_once(MODEL_DIR . '/Tables/Categorys.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Brands.php'); //selectOption呼び出し
require_once(MODEL_DIR . '/Tables/Events.php'); //selectOption呼び出し

function execute_action() {
    if (!Request::isGet()) {
        return View::render404();
    }
    //検索項目の取得(キーで判別する)
    $sorting = Request::get('sorting');
    
    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    
    //GETの値を確認
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //クラスの生成（初期化）
    $classItems = new Items();

    //プロパティに値をセット(ページネーション)
    $classItems -> page_id = $page_id;

    //recordの取得 (searchの内容で検索を行う)
    $records['items'] = $classItems -> sortingItems($sorting);

    //categorysテーブルの取得　select/option用
    $records['categorys'] = Categorys::selectOption_Categorys();
    
    //brandsテーブルの取得　select/option用
    $records['brands'] = Brands::selectOption_Brands();
    
    //shopsテーブルの取得　select/option用
    $records['events'] = Events::selectOption_Events();

    //ページネーションに必要な値一式
    $paginations = $classItems -> getPaginations();

    //index.tpl.phpにrecords,page_id,paginationsを渡す
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}