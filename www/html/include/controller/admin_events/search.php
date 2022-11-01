<?php

require_once(MODEL_DIR . '/Tables/Events.php');

function execute_action() {
    if (!Request::isGet()) {
        return View::render404();
    }
    
    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    
    //GETの値を確認
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //検索項目の取得(どれか一つ送信される/その他は'')
    $search = [];
    $search = Request::get('keyword');
    $search = Request::get('filter');
    $search = Request::get('sorting');
    var_dump($search);

    //クラスの生成（初期化）
    $classEvents = new Events();

    //プロパティに値をセット(ページネーション)
    $classEvents -> page_id = $page_id;

    //recordの取得　（page_idから指定した分だけ/10アイテムのみ）
    $records['events'] = $classEvents -> searchEvents($search);
    print 'records';
    var_dump($records);

    //ページネーションに必要な値一式
    $paginations = $classEvents -> getPaginations();

    //index.tpl.phpにrecords,page_id,paginationsを渡す
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}