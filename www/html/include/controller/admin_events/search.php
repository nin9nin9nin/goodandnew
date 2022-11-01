<?php

require_once(MODEL_DIR . '/Tables/Events.php');

function execute_action() {
    if (!Request::isGet()) {
        return View::render404();
    }

    $keyword = Request::get('keyword');
    $event_tag = Request::get('event_tag');
    $sorting = Request::get('sorting');

    //ページIDの取得（なければ1が格納される）
    $page_id = Request::getPageId('page_id');
    if (preg_match('/^\d+$/', $page_id) !== 1) {
        return View::render404();
    }

    //クラスの生成（初期化）
    $classEvents = new Events();

    //プロパティに値をセット(ページネーション)
    $classEvents -> page_id = $page_id;

    //recordの取得　（page_idから指定した分だけ/10アイテムのみ）
    $records['events'] = $classEvents -> indexEvents();
    print 'records';
    var_dump($records);

    //ページネーションに必要な値一式
    $paginations = $classEvents -> getPaginations();
    var_dump($paginations);

    //index.tpl.phpにrecords,page_id,paginationsを渡す
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}