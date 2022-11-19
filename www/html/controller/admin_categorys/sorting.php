<?php

require_once(MODEL_DIR . '/Tables/Categorys.php');

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
    $classCategorys = new Categorys();

    //プロパティに値をセット(ページネーション)
    $classCategorys -> page_id = $page_id;

    //recordの取得 (searchの内容で検索を行う)
    $records['categorys'] = $classCategorys -> sortingCategorys($sorting);

    //親カテゴリー取得
    $records['parents'] = $classCategorys -> indexParentCategorys();

    //ページネーションに必要な値一式
    $paginations = $classCategorys -> getPaginations();

    //index.tpl.phpにrecords,page_id,paginationsを渡す
    return View::render('index', ['records' => $records, 'paginations' => $paginations]);
}