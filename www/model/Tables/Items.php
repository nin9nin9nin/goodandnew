<?php

require_once(MODEL_DIR . '/Messages.php');

//itemsテーブル
class Items {
    
    public $page_id; //ページ番号
    public $display_record = 20; //１ページの表示件数
    public $item_id;
    public $item_name;
    public $category_id;
    public $brand_id;
    public $event_id;
    public $price;
    public $description;
    public $icon_img;
    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $img5;
    public $img6;
    public $img7;
    public $img8;
    public $status;
    public $enabled;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> page_id = null;
        $this -> item_id = null;
        $this -> item_name = null;
        $this -> category_id = null;
        $this -> brand_id = null;
        $this -> event_id = null;
        $this -> price = null;
        $this -> description = null;
        $this -> icon_img = null;
        $this -> img1 = null;
        $this -> img2 = null;
        $this -> img3 = null;
        $this -> img4 = null;
        $this -> img5 = null;
        $this -> img6 = null;
        $this -> img7 = null;
        $this -> img8 = null;
        $this -> status = null;
        $this -> enabled = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    /**
     * 商品名　varchar(64)
     * 入力確認と文字数確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkItemName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->item_name)) {
            return CommonError::errorAdd('アイテム名を入力してください');
        } else if (!Validator::checkLength($this->item_name, 0, 64)) {
            return CommonError::errorAdd('アイテム名は64文字以内で入力してください');
        }
    }
    
    /**
     * カテゴリーID　int(11)
     * 入力確認と数字確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkCategoryId() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->category_id)) {
            return CommonError::errorAdd('カテゴリーを選択してください');
        } else if (!Validator::checkNumeric($this->category_id)) {
            return CommonError::errorAdd('カテゴリーIDが正しくありません');
        }
    }

    /**
     * ブランドID　int(11)
     * 入力確認と数字確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkBrandId() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->brand_id)) {
            return CommonError::errorAdd('ブランドを選択してください');
        } else if (!Validator::checkNumeric($this->brand_id)) {
            return CommonError::errorAdd('ブランドIDが正しくありません');
        }
    }

    /**
     * ブランドID　int(11)
     * 入力確認と数字確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkEventId() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->event_id)) {
            $this -> event_id = NULL;
        } else if (!Validator::checkNumeric($this->event_id)) {
            return CommonError::errorAdd('イベントIDが正しくありません');
        }
    }

    /**
     * 値段　int(11)　必須
     * -- int(11)の11は、カラムの表示幅であり、2147483647まで格納が可能。
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkPrice() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->price)) {
            return CommonError::errorAdd('価格を入力してください');
        } else if (!Validator::checkRange($this->price, 1, 10)) {
            return CommonError::errorAdd('価格は半角数字、10桁以内で入力してください');
        }
    }

    /**
     * アップロードファイルのチェック (アップロードがなければNULL)
     * 拡張子の確認とファイル名(ユニーク)の確認     * 
     * file_dir 保存先フォルダ指定
     * @param array
     */
    public function checkFileName($files = [], $default = NULL) {
        Validator::paramClear();
        $new_file_name = $default;
        $file_dir = ITEMS_ICON_DIR;
        
        if (!isset($files)) {
            CommonError::errorAdd('アイコン画像をアップロードしてください');
        } else {
            // is_uploaded_file($_FILES[] === true)
            if (empty($files) !== true) {
                // 内部で正しくアップロードされたか確認
                // 拡張子の確認とユニークなファイル名の生成
                $new_file_name = Validator::checkFileName($files, $file_dir);
            }
        }
        //
        return $new_file_name;
    }

    /**
     * 複数ファイルのアップロード
     * reArrayされたファイルのエラーチェック
     * 
     */
    public function checkMultipleFileName($re_files = []) {
        Validator::paramClear();
        $new_file_names = [];
        $file_dir = ITEMS_IMG_DIR;
        
        if (!Validator::checkFileCount($re_files)) {
            CommonError::errorAdd('画像のアップロードは最大８枚までです');
        } else {
            // is_uploaded_file($_FILES[] === true)であれば
            if (empty($re_files) !== true) {
                foreach ($re_files as $files) {
                    //順番にファイルのチェックを行うと同時にファイル名を生成
                    $new_file_names[] = Validator::checkFileName($files, $file_dir);
                }
            }
        }
        //アップロード自体なければ空の配列を返す
        return $new_file_names;
    }

    /**
     * 更新時のチェック
     * 更新のあったファイルのみファイル名の生成
     * 更新がなければ既存のファイル名を使用
     */
    public function checkUpdateFileName($files = [], $exists_file_names = []) {
        Validator::paramClear();
        $new_file_names = [];
        $file_dir = ITEMS_IMG_DIR;
        $file_count = count($files); //int(10)

        for ($i=0; $i < $file_count; $i++) {
            if (isset($files[$i]) === true) {
                $new_file_names[$i] = Validator::checkFileName($files[$i], $file_dir);
            } else {
                $new_file_names[$i] = $exists_file_names[$i];
            }
        }
        
        return $new_file_names;//（ファイルがなければ空文字が代入される）
    }

    // paginations ------------------------------------------------------------------------
    /**
     * トータルレコードを取得し、ページネーションの値をセットして返す
     * return array
     */
    public function getPaginations() {
        //トータルレコードの取得
        $total_record = self::getTotalRecord();
        
        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record, $this->display_record, $this->page_id);
        
    }
    
    /**
     * 各テーブルのトータルレコード数を返す
     * return $record['cnt']
     */
    public static function getTotalRecord() {
        // テーブルから全レコードの数をカウント
        $sql ='SELECT COUNT(*) as cnt' . PHP_EOL
            . 'FROM items WHERE enabled = true';
        
        $record = Messages::retrieveBySql($sql);
        
        // カウントした数を返す
        return $record->cnt;
    }

    /**
     * 検索時のページネーション
     * トータルレコードを取得し、ページネーションの値をセットして返す
     * return array
     */
    public function getSearchPaginations($search = []) {
        //トータルレコードの取得
        $total_record = self::getSearchRecord($search);
        
        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record, $this->display_record, $this->page_id);
        
    }
    
    /**
     * 検索時のページネーション
     * トータルレコード数の取得
     * 
     */
    public static function getSearchRecord($search = []) {
        // テーブルから全レコードの数をカウント
        //(indexのSQL文に合わせる)
        $searchSql ='SELECT COUNT(*) as cnt' . PHP_EOL
                  . 'FROM (SELECT * FROM items WHERE enabled = true) AS A' . PHP_EOL
                  . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
                  . 'ON A.item_id = B.item_id' . PHP_EOL
                  . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
                  . 'ON A.category_id = C.category_id' . PHP_EOL
                  . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
                  . 'ON A.brand_id = D.brand_id' . PHP_EOL
                  . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
                  . 'ON A.event_id = E.event_id';

        //$sqlに結合代入
        $searchSql .= self::setSearchSql($search);

        //bindValue
        $searchParams = self::setSearchParams($search);
        
        //トータルレコード数の取得
        $record = Messages::retrieveBySql($searchSql, $searchParams);
        
        // カウントした数を返す
        return $record->cnt;
    }
    
    // index ------------------------------------------------------------------------
    /**
     * テーブル一覧の取得
     * 4テーブルの結合
     * 論理有効のみ(enabled = true)
     * 未設定表示なし
     * 
     * データの取得数を表示分だけに変更
     */
    //items-index stocks-edit
    public function indexItems() {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //A=items,B=stocks,C=brands,D=categorys,E=events  enabled=trueのみ
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.icon_img, A.status, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id' . PHP_EOL
             . 'ORDER BY A.item_id DESC' . PHP_EOL //itemu_idで降順
             . 'LIMIT :display_record OFFSET :start_record'; //OFFSET １件目からの取得は[0]を指定、11件目からの取得は[10]まで除外

        $params = [
            ':start_record' => $start_record,
            ':display_record' => $this->display_record,
        ];
            
        return Messages::findBySql($sql, $params);
    }

    // search ------------------------------------------------------------------------
    /**
     * 検索・絞り込み
     * 
     */
    public function searchItems($search = []) {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //ベースとなるSQL文を準備
        $searchSql = 'SELECT A.item_id, A.item_name, A.price, A.icon_img, A.status, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //検索項目を確認　SQL文作成し結合代入
        $searchSql .= self::setSearchSql($search);
        
        //さらにページネーション用のSQL文を結合代入
        $searchSql .= ' ORDER BY A.item_id DESC LIMIT :display_record OFFSET :start_record';
        
        //検索項目を確認　bindする配列を作成
        $searchParams = self::setSearchParams($search);
        
        //searchParamsにページネーション用の配列追加
        $searchParams += [':display_record' => $display_record, ':start_record' => $start_record];

        //検索・絞り込みに応じたレコードの取得
        return Messages::findBySql($searchSql,$searchParams); 
    }
    
    /**
     * SQL文
     * getで受け取った値からSQL文を作成
     * 
     * カラムはテーブルによって異なる(カラム名はbindできない)
     */
    public static function setSearchSql ($search = []) {
        // 指定したキーが配列にあるか調べる
        if (array_key_exists('keyword', $search)) { // keywordの場合
            $searchSql = ' WHERE A.item_name LIKE :search_value';
        } else if (array_key_exists('filter_categorys', $search)) { //filterの場合
            $searchSql = ' WHERE C.category_id = :search_value1 OR C.parent_id = :search_value2';
        } else if (array_key_exists('filter_brands', $search)) { //filterの場合
            $searchSql = ' WHERE D.brand_id = :search_value';
        } else if (array_key_exists('filter_events', $search)) { //filterの場合
            $searchSql = ' WHERE E.event_id = :search_value';
        }

        return $searchSql;
    }

    /**
     * bindValue
     * getで受け取った値からbindする配列を作成
     * 
     */
    public static function setSearchParams ($search = []) {
        // 指定したキーが配列にあるか調べる
        if (array_key_exists('keyword', $search)) {
            foreach ($search as $key => $value) {
                $value = "%{$value}%"; //前後0文字以上検索
                $searchParams = [':search_value' => $value,];
            } 
        } else if (array_key_exists('filter_categorys', $search)) {
            foreach ($search as $key => $value) {
                $value = (int)$value; //intに変換
                $searchParams = [':search_value1' => $value, ':search_value2' => $value,]; //カテゴリーの場合2つbind
            } 
        } else if (array_key_exists('filter_brands', $search) || array_key_exists('filter_events', $search)) {
            foreach ($search as $key => $value) {
                $value = (int)$value; //intに変換
                $searchParams = [':search_value' => $value];
            } 
        }
        return $searchParams;
    }

    // sorting ------------------------------------------------------------------------
    /**
     * 並べ替え
     */
    public function sortingItems($sorting = []) {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //PHP_EOL 実行環境のOSに対応する改行コードを出力する定数
        $sortingSql = 'SELECT A.item_id, A.item_name, A.price, A.icon_img, A.status, A.create_datetime, A.update_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //sortingのSQL文を結合代入
        $sortingSql .= self::setSortingSql($sorting);

        //sortingのbindはしない(直接SQL文に書き込む)
        $params = [':display_record' => $display_record, ':start_record' => $start_record];

        return Messages::findBySql($sortingSql,$params);
    }

    /**
     * 0:新着順
     * 1:価格の安い順
     * 2:価格の高い順
     * 3.アイテム名順　AS A
     * 4.カテゴリー名順 AS C
     * 5.ブランド名順 AS D
     * 6.イベント名順 AS E
     * 7.昇順
     * 8.降順
     * 
     */
    public static function setSortingSql($sorting = []) {
        if ($sorting === '0') {
            $sortingSql = ' ORDER BY A.create_datetime DESC';
        } else if ($sorting === '1') {
            $sortingSql = ' ORDER BY A.price ASC';
        } else if ($sorting === '2') {
            $sortingSql = ' ORDER BY A.price DESC';
        } else if ($sorting === '3') {
            $sortingSql = ' ORDER BY A.item_name ASC';
        } else if ($sorting === '4') {
            $sortingSql = ' ORDER BY C.category_name ASC';
        } else if ($sorting === '5') {
            $sortingSql = ' ORDER BY D.brand_name ASC';
        } else if ($sorting === '6') {
            $sortingSql = ' ORDER BY E.event_name ASC';
        } else if ($sorting === '7') {
            $sortingSql = ' ORDER BY A.item_id ASC';
        } else if ($sorting === '8') {
            $sortingSql = ' ORDER BY A.item_id DESC';
        }
        //最後の文を追加
        $sortingSql .= ', A.item_id DESC LIMIT :display_record OFFSET :start_record';

        return $sortingSql;
    }
    
    // insert ------------------------------------------------------------------------
    /**
     * itemsテーブルに新規登録
     */
    public function insertItem() {
        //itemsテーブル
        $sql = 'INSERT INTO items' .PHP_EOL
             . '    (item_name, category_id, brand_id, event_id, price, description,' . PHP_EOL
             . '     icon_img, img1, img2, img3, img4, img5, img6, img7, img8,' . PHP_EOL
             . '     status, create_datetime)' .PHP_EOL
             . 'VALUES' .PHP_EOL
             . '    (:item_name, :category_id, :brand_id, :event_id, :price, :description,' . PHP_EOL
             . '     :icon_img, :img1, :img2, :img3, :img4, :img5, :img6, :img7, :img8,' . PHP_EOL
             . '     :status, :create_datetime)';
        
        // bindValue
        $params = [
            ':item_name' => $this->item_name,
            ':category_id' => $this->category_id,
            ':brand_id' => $this->brand_id,
            ':event_id' => $this->event_id,
            ':price' => $this->price,
            ':description' => $this->description,
            ':icon_img' => $this->icon_img,
            ':img1' => $this->img1,
            ':img2' => $this->img2,
            ':img3' => $this->img3,
            ':img4' => $this->img4,
            ':img5' => $this->img5,
            ':img6' => $this->img6,
            ':img7' => $this->img7,
            ':img8' => $this->img8,
            ':status' => $this->status,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * 画像のファイルアップロード
     * アップロードできなければロールバック(コミットさせない)
     */
    public function uploadFiles($files, $new_file_name) {
        $file_dir = ITEMS_ICON_DIR;
        $to = $file_dir . $new_file_name;
        
        if (empty($files) !== true) {
            Messages::uploadFiles($files, $to);
        }
    }

    /**
     * 複数ファイルのアップロード
     */
    public function uploadMultipleFiles($re_files = [], $new_file_names = []) {
        $file_dir = ITEMS_IMG_DIR;

        if (empty($re_files) !== true) {
            $file_count = count($re_files);

            for ($i=0; $i<$file_count; $i++) {
                //
                $to = $file_dir . $new_file_names[$i];
                $files = $re_files[$i];
                //エラーがあればロールバックを行う  
                Messages::uploadFiles($files, $to);
            }
        }
    }    

    /**
     * 複数ファイルのファイル名プロパティ登録
     */
    public function registerMultipleFiles($new_file_names = []) {
        $file_count = count($new_file_names); //配列の数をカウント
        
        for ($i=0; $i<$file_count; $i++) {
            //プロパティ名が1から始まるため変更
            $no = $i+1;
            //参照プロパティ
            $property = 'img'.$no;
            //プロパティに格納
            $this -> $property = $new_file_names[$i];
        }
    }
    
    // edit ------------------------------------------------------------------------
    /**
     * 指定レコードの取得
     * A=items,B=stocks,C=brands,D=categorys,E=events　結合
     */
    public function editItem() {
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.img1, A.status, A.create_datetime, A.update_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE item_id = :item_id) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';
        
        $params = [
            ':item_id' => $this->item_id
        ];

        //1レコードのみ
        return Messages::retrieveBySql($sql,$params); 
    }

    /**
     * 指定レコードの画像取得
     * 
     */
    public function editItemImg() {
        $sql = 'SELECT item_id, item_name, img1, img2, img3, img4, img5, img6, img7, img8' . PHP_EOL
             . 'FROM items' .PHP_EOL
             . 'WHERE item_id = :item_id';
        
          
        $params = [
            ':item_id' => $this->item_id, 
        ];
        
        return Messages::retrieveBySql($sql,$params); 
    }
    
    // update ------------------------------------------------------------------------
    /**
     * 指定レコードの編集（itemsテーブル）
     */
    public function updateItem() 
    {
        $sql = 'UPDATE items' . PHP_EOL
             . 'SET item_name = :item_name,' . PHP_EOL
             . '    category_id = :category_id,' . PHP_EOL
             . '    brand_id = :brand_id,' . PHP_EOL
             . '    event_id = :event_id,' . PHP_EOL
             . '    price = :price,' . PHP_EOL
             . '    description = :description,' . PHP_EOL
             . '    icon_img = :icon_img,' . PHP_EOL
             . '    status = :status,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id' . PHP_EOL;
        
        $params = [
            ':item_name' => $this->item_name,
            ':price' => $this->price,
            ':category_id' => $this->category_id,
            ':brand_id' => $this->brand_id,
            ':event_id' => $this->event_id,
            ':description' => $this->description,
            ':icon_img' => $this->icon_img,
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':item_id' => $this->item_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * imgの更新
     */
    public function updateItemImg() 
    {
        $sql = 'UPDATE items' . PHP_EOL
             . 'SET img1 = :img1,' . PHP_EOL
             . '    img2 = :img2,' . PHP_EOL
             . '    img3 = :img3,' . PHP_EOL
             . '    img4 = :img4,' . PHP_EOL
             . '    img5 = :img5,' . PHP_EOL
             . '    img6 = :img6,' . PHP_EOL
             . '    img7 = :img7,' . PHP_EOL
             . '    img8 = :img8,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id' . PHP_EOL;
        
        $params = [
            ':img1' => $this->img1,
            ':img2' => $this->img2,
            ':img3' => $this->img3,
            ':img4' => $this->img4,
            ':img5' => $this->img5,
            ':img6' => $this->img6,
            ':img7' => $this->img7,
            ':img8' => $this->img8,
            ':update_datetime' => $this->update_datetime,
            ':item_id' => $this->item_id,
        ];
    
        Messages::executeBySql($sql, $params);
    }

    /**
     * 複数ファイルの更新(更新のあったファイルのみ)
     * 
     */
    public function updateMultipleFiles($files = [], $new_file_names = []) {
        $file_dir = ITEMS_IMG_DIR;

        if (empty($files) !== true) {
            $file_count = count($files);
            for ($i=0; $i<$file_count; $i++) {
                //アップロードのあったファイルのみ処理を行う
                if (isset($files[$i]) === true) {
                    $to = $file_dir . $new_file_names[$i];

                    //エラーがあればロールバックを行う  
                    Messages::uploadFiles($files[$i], $to);
                }
            }
        }
    }

    /**
     * 指定レコードのステータス更新
     */
    public function updateItemStatus() {
        $sql = 'UPDATE items' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':item_id' => $this->item_id,
            ];
            
        Messages::executeBySql($sql, $params);
    }
    
    // delete ------------------------------------------------------------------------
    /**
     * 指定レコードの削除
     * 論理削除　enabledをfalseにして有効を解く
     */
    public function deleteItem() {
        $sql = 'UPDATE items' . PHP_EOL
             . 'SET enabled = false, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE item_id = :item_id';
        
        $params = [
            ':update_datetime' => $this->update_datetime,
            ':item_id' => $this->item_id
        ];
        
        Messages::executeBySql($sql, $params);
    }

    // ショップ画面設定 exclusive ------------------------------------------------------------------------
    /**
     * 指定イベントIDのアイテムを取得
     */
    public function indexExclusiveItems() {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        $sql = 'SELECT A.item_id, A.item_name, A.price, A.icon_img, A.status, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id' . PHP_EOL
             . 'ORDER BY A.item_id ASC' ; //itemu_idで降順
        
        $params = [
            ':event_id' => $this->event_id
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * 指定イベントIDのブランドを取得
     */
    public function indexExclusiveBrands() {
        $sql = 'SELECT COUNT(*) AS item_count,' . PHP_EOL //アイテム数のカウント
             . '    B.brand_id, B.brand_name, B.brand_logo, B.status' . PHP_EOL
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN brands AS B' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = B.brand_id' . PHP_EOL
             . 'GROUP BY A.brand_id' . PHP_EOL //brand_idでグルーピング
             . 'ORDER BY A.brand_id ASC';
            
        
        $params = [
            ':event_id' => $this->event_id
        ];

        return Messages::findBySql($sql, $params);
    }
    
    //ユーザー画面 ---------------------------------------------------------------------------
    //get exclusive (event_id指定 + status = 1) 

    /**
     * 指定イベントIDのアイテムを取得
     * get ユーザー用(status = 1のみ取得) 
     */
    public function getExclusiveItems() {
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id' . PHP_EOL
             . 'ORDER BY A.item_id ASC';
        
        $params = [
            ':event_id' => $this->event_id,
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * 指定イベントIDのブランドを取得
     * get ユーザー用(status = 1のみ取得) 
     */
    public function getExclusiveBrands() {
        $sql = 'SELECT COUNT(*) AS item_count,' . PHP_EOL
             . '    B.brand_id, B.brand_name, B.brand_logo, B.img1, B.description' . PHP_EOL
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN brands AS B' .PHP_EOL 
             . 'ON A.brand_id = B.brand_id' . PHP_EOL
             . 'GROUP BY A.brand_id' . PHP_EOL
             . 'ORDER BY A.brand_id ASC'; 
        
        $params = [
            ':event_id' => $this->event_id
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * 専用カテゴリーの取得
     */
    public function getExclusiveCategorys() {
        $sql = 'SELECT B.category_id, B.category_name' . PHP_EOL
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN categorys AS B' .PHP_EOL 
             . 'ON A.category_id = B.category_id' . PHP_EOL
             . 'GROUP BY A.category_id' . PHP_EOL
             . 'ORDER BY A.category_id ASC'; 
        
        $params = [
            ':event_id' => $this->event_id
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * ブランド指定 アイテム一覧
     * get ユーザー用(status = 1のみ取得) 
     */
    public function getBrandItems() {
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE brand_id = :brand_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id' . PHP_EOL
             . 'ORDER BY A.item_id ASC';
        
        $params = [
            ':brand_id' => $this -> brand_id,
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * 専用カテゴリーの取得
     */
    public function getBrandCategorys() {
        $sql = 'SELECT B.category_id, B.category_name' . PHP_EOL
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM items WHERE brand_id = :brand_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN categorys AS B' .PHP_EOL 
             . 'ON A.category_id = B.category_id' . PHP_EOL
             . 'GROUP BY A.category_id' . PHP_EOL
             . 'ORDER BY A.category_id ASC'; 
        
        $params = [
            ':brand_id' => $this -> brand_id,
        ];

        return Messages::findBySql($sql, $params);
    }

    /**
     * トップ画面下部
     * オリジナルアイテム一覧(一部) category_id = 8
     * get ユーザー用(status = 1のみ取得) 
     */
    public function getOriginalItemsPart() {
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE category_id = 8 AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id' . PHP_EOL
             . 'ORDER BY A.item_id ASC' . PHP_EOL //itemu_idで降順
             . 'LIMIT 4'; //LIMIT 取得レコード数 
        
        return Messages::findBySql($sql);
    }

    /**
     * オリジナルアイテム一覧 category_id = 8
     * get ユーザー用(status = 1のみ取得) 
     */
    public function getOriginalItems() {
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE category_id = 8 AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id' . PHP_EOL
             . 'ORDER BY A.item_id ASC';
        
        return Messages::findBySql($sql);
    }

    /**
     * 専用カテゴリーの取得
     */
    // public function getOriginalCategorys() {
    //     $sql = 'SELECT B.category_id, B.category_name' . PHP_EOL
    //          . 'FROM' . PHP_EOL
    //          . '    (SELECT * FROM items WHERE event_id = 1 AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
    //          . 'LEFT JOIN categorys AS B' .PHP_EOL 
    //          . 'ON A.category_id = B.category_id' . PHP_EOL
    //          . 'GROUP BY A.category_id' . PHP_EOL
    //          . 'ORDER BY A.category_id ASC'; 
        
    //     return Messages::findBySql($sql);
    // }

    // search ------------------------------------------------------------------------
    /**
     * SQL文
     * getで受け取った値からSQL文を作成
     * 
     * カラムはテーブルによって異なる(カラム名はbindできない)
     */
    public static function setUserSearchSql ($search = []) {
        // 指定したキーが配列にあるか調べる
        if (array_key_exists('keyword', $search)) { // keywordの場合
            $searchSql = ' WHERE A.item_name LIKE :search_value';
        } else if (array_key_exists('filter', $search)) { //filterの場合
            $searchSql = ' WHERE C.category_id = :search_value';
        } 

        return $searchSql;
    }

    /**
     * bindValue
     * getで受け取った値からbindする配列を作成
     * 
     */
    public static function setUserSearchParams ($search = []) {
        // 指定したキーが配列にあるか調べる
        if (array_key_exists('keyword', $search)) {
            foreach ($search as $key => $value) {
                $value = "%{$value}%"; //前後0文字以上検索
                $searchParams = [':search_value' => $value,];
            } 
        } else if (array_key_exists('filter', $search)) {
            foreach ($search as $key => $value) {
                $value = (int)$value; //intに変換
                $searchParams = [':search_value' => $value,];
            } 
        } 

        return $searchParams;
    }

    /**
     * 0:新着順
     * 1:価格の安い順
     * 2:価格の高い順
     */
    public static function setUserSortingSql($sorting = []) {
        if ($sorting === '0') {
            $sortingSql = ' ORDER BY A.create_datetime DESC';
        } else if ($sorting === '1') {
            $sortingSql = ' ORDER BY A.price ASC';
        } else if ($sorting === '2') {
            $sortingSql = ' ORDER BY A.price DESC';
        } 

        return $sortingSql;
    }

    /**
     * 検索時のアイテム取得
     * (event_id指定 + status = 1)
     */
    public function searchExclusiveItems($search = []) {
        //ベースとなるSQL文を準備
        $searchSql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //検索項目を確認　SQL文作成し結合代入
        $searchSql .= self::setUserSearchSql($search);
        
        //さらにページネーション用のSQL文を結合代入
        $searchSql .= ' ORDER BY A.item_id ASC';
        
        //検索項目を確認　bindする配列を作成
        $searchParams = self::setUserSearchParams($search);
        
        //searchParamsにページネーション用の配列追加
        $searchParams += [
            ':event_id' => $this -> event_id
        ];

        //検索・絞り込みに応じたレコードの取得
        return Messages::findBySql($searchSql,$searchParams); 
    }

    /**
     * 検索時のアイテム取得
     * (brand_id指定 + status = 1)
     */
    public function searchBrandItems($search = []) {
        //ベースとなるSQL文を準備
        $searchSql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE brand_id = :brand_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //検索項目を確認　SQL文作成し結合代入
        $searchSql .= self::setUserSearchSql($search);
        
        //さらにページネーション用のSQL文を結合代入
        $searchSql .= ' ORDER BY A.item_id ASC';
        
        //検索項目を確認　bindする配列を作成
        $searchParams = self::setUserSearchParams($search);
        
        //searchParamsにページネーション用の配列追加
        $searchParams += [
            ':brand_id' => $this -> brand_id
        ];

        //検索・絞り込みに応じたレコードの取得
        return Messages::findBySql($searchSql,$searchParams); 
    }

    /**
     * 検索時のアイテム取得
     * (category_id=8 + status = 1)
     */
    public function searchOriginalItems($search = []) {
        //ベースとなるSQL文を準備
        $searchSql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL 
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE category_id = 8 AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //検索項目を確認　SQL文作成し結合代入
        $searchSql .= self::setUserSearchSql($search);
        
        //さらにページネーション用のSQL文を結合代入
        $searchSql .= ' ORDER BY A.item_id ASC';
        
        //検索項目を確認　bindする配列を作成
        $searchParams = self::setUserSearchParams($search);
        
        //検索・絞り込みに応じたレコードの取得
        return Messages::findBySql($searchSql,$searchParams); 
    }
    
    // sorting ------------------------------------------------------------------------
    /**
     * 並べ替え時のアイテム取得
     * (event_id指定 + status = 1)
     */
    public function sortingExclusiveItems($sorting = []) {
        $sortingSql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE event_id = :event_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //sortingのSQL文を結合代入
        $sortingSql .= self::setUserSortingSql($sorting);

        //sortingのbindはしない(直接SQL文に書き込む)
        $params = [
            ':event_id' => $this -> event_id,
        ];

        return Messages::findBySql($sortingSql,$params);
    }

    /**
     * 並べ替え時のアイテム取得
     * (brand_id指定 + status = 1)
     */
    public function sortingBrandItems($sorting = []) {
        $sortingSql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE brand_id = :brand_id AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //sortingのSQL文を結合代入
        $sortingSql .= self::setUserSortingSql($sorting);

        //sortingのbindはしない(直接SQL文に書き込む)
        $params = [
            ':brand_id' => $this -> brand_id,
        ];

        return Messages::findBySql($sortingSql,$params);
    }

    /**
     * 並べ替え時のアイテム取得
     * (category_id = 8 + status = 1)
     */
    public function sortingOriginalItems($sorting = []) {
        $sortingSql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.create_datetime,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE category_id = 8 AND status = 1 AND enabled = true) AS A' . PHP_EOL //有効なアイテムの取得
             . 'LEFT JOIN stocks AS B' .PHP_EOL //stocksテーブル
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' .PHP_EOL //categoryテーブル
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' .PHP_EOL //brandsテーブル
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' .PHP_EOL //eventsテーブル
             . 'ON A.event_id = E.event_id';

        //sortingのSQL文を結合代入
        $sortingSql .= self::setUserSortingSql($sorting);

        return Messages::findBySql($sortingSql,$params);
    }
    
    // detail -------------------------------------------------------------
    /**
     * アイテム詳細の取得
     */
    public function getItemDetail() {
        $sql = 'SELECT A.item_id, A.item_name, A.price, A.description, A.icon_img, A.status, A.create_datetime,' . PHP_EOL
             . '       A.img1, A.img2, A.img3, A.img4, A.img5, A.img6, A.img7, A.img8,' . PHP_EOL
             . '       B.stock,' . PHP_EOL
             . '       C.category_id, C.category_name, C.parent_id,' . PHP_EOL
             . '       D.brand_id, D.brand_name,' . PHP_EOL
             . '       E.event_id, E.event_name' . PHP_EOL
             . 'FROM ' .PHP_EOL
             . '    (SELECT * FROM items WHERE item_id = :item_id AND status = 1 AND enabled = true) AS A' . PHP_EOL
             . 'LEFT JOIN stocks AS B' . PHP_EOL
             . 'ON A.item_id = B.item_id' . PHP_EOL
             . 'LEFT JOIN categorys AS C' . PHP_EOL
             . 'ON A.category_id = C.category_id' . PHP_EOL
             . 'LEFT JOIN brands AS D' . PHP_EOL
             . 'ON A.brand_id = D.brand_id' . PHP_EOL
             . 'LEFT JOIN events AS E' . PHP_EOL
             . 'ON A.event_id = E.event_id';
        
        $params = [
            ':item_id' => $this->item_id,
        ];

        //1レコードのみ
        return Messages::retrieveBySql($sql,$params); 
    }
    
}