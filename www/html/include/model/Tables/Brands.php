<?php

require_once(MODEL_DIR . '/Messages.php');

//brands テーブル
class Brands {
    
    public $page_id; //ページ番号
    public $display_record = 10; //１ページの表示件数
    public $brand_id;
    public $brand_name;
    public $description;
    public $brand_logo;
    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $img5;
    public $img6;
    public $img7;
    public $img8;
    public $brand_hp;
    public $brand_instagram;
    public $brand_twitter;
    public $brand_facebook;
    public $brand_youtube;
    public $brand_line;
    public $phone_number;
    public $email;
    public $address;
    public $status;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> page_id = null;
        $this -> brand_id = null;
        $this -> brand_name = null;
        $this -> description = null;
        $this -> brand_logo = null;
        $this -> img1 = null;
        $this -> img2 = null;
        $this -> img3 = null;
        $this -> img4 = null;
        $this -> img5 = null;
        $this -> img6 = null;
        $this -> img7 = null;
        $this -> img8 = null;
        $this -> brand_hp = null;
        $this -> brand_instagram = null;
        $this -> brand_twitter = null;
        $this -> brand_facebook = null;
        $this -> brand_youtube = null;
        $this -> brand_line = null;
        $this -> phone_number = null;
        $this -> email = null;
        $this -> address = null;
        $this -> status = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }
    
    /**
     * ブランド名　varchar(64)
     * 入力確認と文字数確認
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkBrandName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->brand_name)) {
            return CommonError::errorAdd('ブランド名を入力してください');
        } else if (!Validator::checkLength($this->brand_name, 0, 64)) {
            return CommonError::errorAdd('ブランド名は64文字以内で入力してください');
        }
    }

    /**
     * URL(hp,instagram,twitter,facebook,youtube,line) 
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * /^(https?|ftp)(://[-_.!~*'()a-zA-Z0-9;/?:@&amp;amp;=+$,%#]+)$/
     */
    public function checkUrl() {
        Validator::paramClear();
        
        if ($this->brand_hp !== "") {
            if (!Validator::checkUrl($this->brand_hp)) {
                return CommonError::errorAdd('ブランドHPが正しくありません');
            }
        }
        if ($this->brand_instagram !== "") {
            if (!Validator::checkUrl($this->brand_instagram)) {
                return CommonError::errorAdd('リンクinstagramが正しくありません');
            }
        }
        if ($this->brand_twitter !== "") {
            if (!Validator::checkUrl($this->brand_twitter)) {
                return CommonError::errorAdd('リンクtwitterが正しくありません');
            }
        }
        if ($this->brand_facebook !== "") {
            if (!Validator::checkUrl($this->brand_facebook)) {
                return CommonError::errorAdd('リンクfacebookが正しくありません');
            }
        }
        if ($this->brand_youtube !== "") {
            if (!Validator::checkUrl($this->brand_youtube)) {
                return CommonError::errorAdd('リンクyoutubeが正しくありません');
            }
        }
        if ($this->brand_line !== "") {
            if (!Validator::checkUrl($this->brand_line)) {
                return CommonError::errorAdd('リンクlineが正しくありません');
            }
        }
    }
    
    /**
     * 電話番号
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * '/\A0[0-9]{9,10}\z/' ハイフン無し
     */
    public function checkPhonenumber() {
        Validator::paramClear();
        
        if ($this->phone_number !== "") {
            if (!Validator::checkPhonenumber($this->phone_number)) {
                return CommonError::errorAdd('電話番号が正しくありません');
            } 
        }
    }
    
    /**
     * メールアドレス
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/' 
     */
    public function checkEmail() {
        Validator::paramClear();
        
        if ($this->email !== "") {
            if (!Validator::checkMailAddress($this->email)) {
                return CommonError::errorAdd('メールアドレスが正しくありません');
            } 
        }
    }
    
    /**
     * 住所 varchar(64)
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     */
    public function checkAddress() {
        Validator::paramClear();
        
        if ($this->address !== "") {
            if (!Validator::checkLength($this->address, 0, 64)) {
                return CommonError::errorAdd('住所は64文字以内で入力してください');
            } 
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
        $file_dir = './include/images/brands/logo/';
        
        // is_uploaded_file($_FILES[] === true)であれば
        if (empty($files) !== true) {
            // 内部で正しくアップロードされたか確認
            // 拡張子の確認とユニークなファイル名の生成
            $new_file_name = Validator::checkFileName($files, $file_dir);
        }
        //アップロード自体なければNULLを返す
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
        $file_dir = './include/images/brands/img/';
        
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
        $file_dir = './include/images/brands/img/';
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
        $sql = 'SELECT COUNT(*) as cnt' . PHP_EOL
             . 'FROM brands';
        
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
        //(indexのsql文に合わせる)
        $searchSql = 'SELECT COUNT(*) as cnt' . PHP_EOL
                   . 'FROM brands AS A';

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
     * brands
     * itemsテーブルにいくつアイテムがあるかカウント
     */
    public function indexBrands() {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        $sql = 'SELECT A.brand_id, A.brand_name, A.brand_logo, A.status,' . PHP_EOL
             . '       COALESCE(B.item_count,0) AS item_count' . PHP_EOL //結合できない(商品がない)場合0を表示
             . 'FROM brands AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT brand_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY brand_id) AS B' . PHP_EOL
             . 'ON A.brand_id = B.brand_id' . PHP_EOL
             . 'ORDER BY A.brand_id DESC' . PHP_EOL 
             . 'LIMIT :display_record OFFSET :start_record';
        
        $params = [
            ':display_record' => $display_record,
            ':start_record' => $start_record,
        ];
        
        return Messages::findBySql($sql,$params); 
    }
    
    // search ------------------------------------------------------------------------
    /**
     * 検索・絞り込み
     * 
     */
    public function searchBrands($search = []) {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //ベースとなるSQL文を準備
        $searchSql = 'SELECT A.brand_id, A.brand_name, A.brand_logo, A.status,' . PHP_EOL
                   . '       COALESCE(B.item_count,0) AS item_count' . PHP_EOL
                   . 'FROM brands AS A' . PHP_EOL
                   . 'LEFT JOIN ' .PHP_EOL
                   . '    (SELECT brand_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY brand_id) AS B' . PHP_EOL
                   . 'ON A.brand_id = B.brand_id';

        //検索項目を確認　SQL文作成し結合代入
        $searchSql .= self::setSearchSql($search);
        
        //さらにページネーション用のSQL文を結合代入
        $searchSql .= ' ORDER BY A.brand_id DESC LIMIT :display_record OFFSET :start_record';
        
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
            $searchSql = ' WHERE A.brand_name LIKE :search_value';
        } else if (array_key_exists('filter', $search)) { //filterの場合
            // $searchSql = ' WHERE  = :search_value';
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
        } else if (array_key_exists('filter', $search)) {
            foreach ($search as $key => $value) {
                $value = (int)$value; //intに変換
                $searchParams = [':search_value' => $value,];
            }
        }
        return $searchParams;
    }

    // sorting ------------------------------------------------------------------------
    /**
     * 並べ替え
     */
    public function sortingBrands($sorting = []) {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //PHP_EOL 実行環境のOSに対応する改行コードを出力する定数
        $sortingSql = 'SELECT A.brand_id, A.brand_name, A.brand_logo, A.status,' . PHP_EOL
                    . '       COALESCE(B.item_count,0) AS item_count' . PHP_EOL
                    . 'FROM brands AS A' . PHP_EOL
                    . 'LEFT JOIN ' .PHP_EOL
                    . '    (SELECT brand_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY brand_id) AS B' . PHP_EOL
                    . 'ON A.brand_id = B.brand_id';

        //sortingのSQL文を結合代入
        $sortingSql .= self::setSortingSql($sorting);

        //sortingのbindはしない(直接SQL文に書き込む)
        $params = [':display_record' => $display_record, ':start_record' => $start_record];

        return Messages::findBySql($sortingSql,$params);
    }
    
    /**
     * 0:ブランド名順
     * 1:昇順
     * 2:降順
     * 
     */
    public static function setSortingSql($sorting = []) {
        if ($sorting === '0') {
            $sortingSql = ' ORDER BY A.brand_name ASC';
        } else if ($sorting === '1') {
            $sortingSql = ' ORDER BY A.brand_id ASC';
        } else if ($sorting === '2') {
            $sortingSql = ' ORDER BY A.brand_id DESC';
        } 
        $sortingSql .= ', A.brand_id DESC LIMIT :display_record OFFSET :start_record';

        return $sortingSql;
    }

    // insert ------------------------------------------------------------------------

    /**
     * 新規ブランド登録
     */
    public function insertBrand() 
        {
        $sql = 'INSERT INTO brands ' . PHP_EOL
             . '    (brand_name, description, brand_logo, img1, img2, img3, img4, img5, img6, img7, img8,' . PHP_EOL
             . '    brand_hp, brand_instagram, brand_twitter, brand_facebook, brand_youtube, brand_line,' . PHP_EOL
             . '    phone_number, email, address, status, create_datetime)' . PHP_EOL
             . 'VALUES ' . PHP_EOL
             . '    (:brand_name, :description, :brand_logo, :img1, :img2, :img3, :img4, :img5, :img6, :img7, :img8,' . PHP_EOL
             . '     :brand_hp, :brand_instagram, :brand_twitter, :brand_facebook, :brand_youtube, :brand_line,' . PHP_EOL
             . '     :phone_number, :email, :address, :status, :create_datetime)';
             
        $params = [
            ':brand_name' => $this->brand_name,
            ':description' => $this->description,
            ':brand_logo' => $this->brand_logo,
            ':img1' => $this->img1,
            ':img2' => $this->img2,
            ':img3' => $this->img3,
            ':img4' => $this->img4,
            ':img5' => $this->img5,
            ':img6' => $this->img6,
            ':img7' => $this->img7,
            ':img8' => $this->img8,
            ':brand_hp' => $this->brand_hp,
            ':brand_instagram' => $this->brand_instagram,
            ':brand_twitter' => $this->brand_twitter,
            ':brand_facebook' => $this->brand_facebook,
            ':brand_youtube' => $this->brand_youtube,
            ':brand_line' => $this->brand_line,
            ':phone_number' => $this->phone_number,
            ':email' => $this->email,
            ':address' => $this->address,
            ':status' => $this->status,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * ブランドロゴのアップロード
     * アップロードできなければロールバック(コミットさせない)
     */
    public function uploadFiles($files, $new_file_name) {
        $file_dir = './include/images/brands/logo/';
        $to = $file_dir . $new_file_name;
        
        if (empty($files) !== true) {
            Messages::uploadFiles($files, $to);
        }
    }

    /**
     * 複数ファイルのアップロード
     */
    public function uploadMultipleFiles($re_files = [], $new_file_names = []) {
        $file_dir = './include/images/brands/img/';

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
     */
    public function editBrand() {
        $sql = 'SELECT A.brand_id, A.brand_name, A.description, A.brand_logo, A.img1,' . PHP_EOL
             . '       A.brand_hp, A.brand_instagram, A.brand_twitter, A.brand_facebook, A.brand_youtube, A.brand_line,' . PHP_EOL
             . '       A.phone_number, A.email, A.address, A.status, A.create_datetime, A.update_datetime,' . PHP_EOL
             . '       COALESCE(B.item_count,0) AS item_count' . PHP_EOL //結合できない(商品がない)場合0を表示
             . 'FROM' . PHP_EOL
             . '    (SELECT * FROM brands WHERE brand_id = :brand_id) AS A' . PHP_EOL
             . 'LEFT JOIN ' .PHP_EOL
             . '    (SELECT brand_id, COUNT(*) AS item_count FROM items WHERE enabled = true GROUP BY brand_id) AS B' . PHP_EOL
             . 'ON A.brand_id = B.brand_id';
                
        $params = [
            ':brand_id' => $this->brand_id,
        ];
        //return $records[0]のみ
        return Messages::retrieveBySql($sql,$params); 
    }

    /**
     * 指定レコードの画像取得
     * 
     */
    public function editBrandImg() {
        $sql = 'SELECT brand_id, brand_name, img1, img2, img3, img4, img5, img6, img7, img8' . PHP_EOL
             . 'FROM brands' .PHP_EOL
             . 'WHERE brand_id = :brand_id';
        
          
        $params = [
            ':brand_id' => $this->brand_id, 
        ];
        
        return Messages::retrieveBySql($sql,$params); 
    }
    
    // update ------------------------------------------------------------------------
    /**
     * 指定レコードの更新
     */
    public function updateBrand() 
        {
        $sql = 'UPDATE brands' . PHP_EOL
             . 'SET brand_name = :brand_name,'. PHP_EOL
             . '    description = :description,'. PHP_EOL
             . '    brand_logo = :brand_logo,'. PHP_EOL
             . '    brand_hp = :brand_hp,'. PHP_EOL
             . '    brand_instagram = :brand_instagram,'. PHP_EOL
             . '    brand_twitter = :brand_twitter,'. PHP_EOL
             . '    brand_facebook = :brand_facebook,'. PHP_EOL
             . '    brand_youtube = :brand_youtube,'. PHP_EOL
             . '    brand_line = :brand_line,'. PHP_EOL
             . '    phone_number = :phone_number,'. PHP_EOL
             . '    email = :email,'. PHP_EOL
             . '    address = :address,'. PHP_EOL
             . '    status = :status,'. PHP_EOL
             . '    update_datetime = :update_datetime'. PHP_EOL
             . 'WHERE brand_id = :brand_id';
             
        $params = [
            ':brand_name' => $this->brand_name,
            ':description' => $this->description,
            ':brand_logo' => $this->brand_logo,
            ':brand_hp' => $this->brand_hp,
            ':brand_instagram' => $this->brand_instagram,
            ':brand_twitter' => $this->brand_twitter,
            ':brand_facebook' => $this->brand_facebook,
            ':brand_youtube' => $this->brand_youtube,
            ':brand_line' => $this->brand_line,
            ':phone_number' => $this->phone_number,
            ':email' => $this->email,
            ':address' => $this->address,
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':brand_id' => $this->brand_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * imgの更新
     */
    public function updateBrandImg() 
    {
        $sql = 'UPDATE brands' . PHP_EOL
             . 'SET img1 = :img1,' . PHP_EOL
             . '    img2 = :img2,' . PHP_EOL
             . '    img3 = :img3,' . PHP_EOL
             . '    img4 = :img4,' . PHP_EOL
             . '    img5 = :img5,' . PHP_EOL
             . '    img6 = :img6,' . PHP_EOL
             . '    img7 = :img7,' . PHP_EOL
             . '    img8 = :img8,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE brand_id = :brand_id' . PHP_EOL;
        
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
            ':brand_id' => $this->brand_id,
        ];
    
        Messages::executeBySql($sql, $params);
    }

    /**
     * 複数ファイルの更新(更新のあったファイルのみ)
     * 
     */
    public function updateMultipleFiles($files = [], $new_file_names = []) {
        $file_dir = './include/images/brands/img/';

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
    public function updateBrandStatus() {
        $sql = 'UPDATE brands' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE brand_id = :brand_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':brand_id' => $this->brand_id,
            ];
            
        Messages::executeBySql($sql, $params);
    }

    // delete ------------------------------------------------------------------------
    /**
     * 指定レコードの削除
     */
    public function deleteBrand() {
        $sql = 'DELETE FROM brands' . PHP_EOL
             . 'WHERE brand_id = :brand_id';
        
        $params = [':brand_id' => $this->brand_id];
        
        Messages::executeBySql($sql, $params);
    }

    // select ------------------------------------------------------------------------
    /**
     * 商品管理に使用 static
     * 
     * select option用　テーブルの取得
     */
    public static function selectOption_Brands() {
        $sql = 'SELECT brand_id, brand_name FROM brands';
        
        return Messages::findBySql($sql);
    }
    
    // ユーザー側　-------------------------------------------
    
    /**
     * 指定してブランド情報取得 static
     * 
     * items/detail.tpl.php
     */
    public static function detailBrand($id) {
        $sql = 'SELECT * FROM brands WHERE brand_id = :brand_id';
        
        $params = [':brand_id' => $id];
        
        return Messages::findBySql($sql, $params);
    }
}