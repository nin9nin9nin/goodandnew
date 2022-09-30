<?php
require_once(MODEL_DIR . '/Tables/Items.php');

function execute_action() {
    if (!Request::isPost()) {
        return View::render404();
    }
    
    $id = Request::get('item_id');
    $icon_img = "";
        
    if (preg_match('/^\d+$/', $id) !== 1) {
        return View::render404();
    }
    
    //クラス生成（初期化）
    $classItems = new Items();
    
    //プロパティに値をセット
    $classItems -> item_id = $id;
    
    //エラーチェック
    try {
        //エラークラス初期化　$e = null
        CommonError::errorClear();
        
        //画像の取得とファイル名の作成
        if (is_uploaded_file($_FILES['icon_img']['tmp_name']) === TRUE) {
            $extension = pathinfo($_FILES['icon_img']['name'], PATHINFO_EXTENSION);
            $extension = strtolower($extension); // あいうえお.JPG => JPG => jpg
            if ($extension === 'jpeg' || $extension === 'jpg' || $extension === 'png') {
                $icon_img = sha1(uniqid(mt_rand(), true)). '.' . $extension;
                if (is_file(IMG_DIR . $icon_img) !== TRUE) {
                    //プロパティに登録
                    $classItems -> icon_img = $icon_img;
                } else {
                    CommonError::errorAdd('ファイルアップロードに失敗しました。再度お試しください');
                }
            } else {
                CommonError::errorAdd('ファイル形式が異なります。画像ファイルはJPEGとPNGが利用可能です');
            }
        } else {
            CommonError::errorAdd('ファイルを選択してください');
        }
        
        //エラーがあればthrow
        CommonError::errorThrow();
        
    } catch (Exception $e) {
        //エラーメッセージ取得
        $errors = CommonError::errorWhile();
        
        //指定レコードの取得
        $records[0] = $classItems -> editItem();
    
        return View::render('img_edit', ['records' => $records, 'errors' => $errors]);
        exit;
    }    
    
    
    //更新処理------------------------------------------------------------------
    
    $now_date = date('Y-m-d H:i:s');
        
    //プロパティ登録日時
    $classItems -> update_datetime = $now_date;
    
    //データベース接続（画像のみ更新）
    $classItems -> updateItemIconImg();
    
    //画像のファイルアップロード
    if (move_uploaded_file($_FILES['icon_img']['tmp_name'], IMG_DIR . $icon_img) !== TRUE) {
        //controllerでキャッチしてもらう(error.tpl.phpへ)
        $e = new Exception('ファイルアップロードに失敗しました', 0, $e);
        throw $e;
    }
    
    //指定レコードの取得
    $records[0] = $classItems -> editItem();
    
    //更新完了ページ
    return View::render('complete', ['records' => $records]);
}
