<?php

require_once(MODEL_DIR . '/Tables/Events.php');

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
    $classEvents = new Events();

    //プロパティに値をセット(ページネーション)
    $classEvents -> page_id = $page_id;

    //recordの取得 (searchの内容で検索を行う)
    $records['events'] = $classEvents -> sortingEvents($sorting);

    //recordの取得　（公開中のイベント）
    $records['release'] = $classEvents -> releaseEvent();
    
    //ページネーションに必要な値一式
    $paginations = $classEvents -> getPaginations();

    //index.tpl.phpにrecords,page_id,paginationsを渡す
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}