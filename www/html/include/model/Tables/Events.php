<?php

require_once(MODEL_DIR . '/Messages.php');

//events テーブル
class Events {
    
    public $table_name = 'events'; //count(*)するテーブル
    public $display_record = '10'; //１ページの表示件数
    public $page_id; //ページ番号
    public $event_id;
    public $event_name;
    public $description;
    public $event_date;
    public $event_tag; //（0:ポップアップ、1:イベント）
    public $event_svg; // monthly text
    public $event_png; // baby illustration
    public $img1;
    public $img2;
    public $img3;
    public $img4;
    public $img5;
    public $img6;
    public $img7;
    public $img8;
    public $img9;
    public $img10;
    public $status;
    public $create_datetime;
    public $update_datetime;
    
    
    public function __construct() {
        $this -> page_id = null;
        $this -> event_id = null;
        $this -> event_name = null;
        $this -> description = null;
        $this -> event_date = null;
        $this -> event_tag = null;
        $this -> event_svg = null;
        $this -> event_png = null;
        $this -> img1 = null;
        $this -> img2 = null;
        $this -> img3 = null;
        $this -> img4 = null;
        $this -> img5 = null;
        $this -> img6 = null;
        $this -> img7 = null;
        $this -> img8 = null;
        $this -> img9 = null;
        $this -> img10 = null;
        $this -> status = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
    }

    /**
     * イベント名　64文字
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkEventName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->event_name)) {
            return CommonError::errorAdd('商品名を入力してください');
        } else if (!Validator::checkLength($this->event_name, 0, 64)) {
            return CommonError::errorAdd('ブランド名は64文字以内で入力してください');
        }
    }

    /**
     * 開催期間　64文字
     * 表示のためだけなので文字列として扱う
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkEventDate() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->event_date)) {
            return CommonError::errorAdd('開催期間を入力してください');
        } else if (!Validator::checkLength($this->event_date, 0, 64)) {
            return CommonError::errorAdd('開催期間は64文字以内で入力してください');
        }
    }

    /**
     * アップロードファイルのチェック (アップロードがなければNULL)
     * 拡張子の確認とファイル名(ユニーク)の確認     * 
     * file_dir 保存先フォルダ指定
     * @param array
     */
    public function checkFileName($files = [], $default = NULL) {
        $new_file_name = $default;
        $file_dir = './include/images/events/visual/';
        
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
    public function checkImgFileName($re_files = []) {
        $img_names = [];//配列にしておく
        $file_dir = './include/images/events/img/';
        
        // is_uploaded_file($_FILES[] === true)であれば
        if (empty($re_files) !== true) {
            foreach ($re_files as $files) {

                $img_names = Validator::checkFileName($files, $file_dir);
            }
        }
        //アップロード自体なければ空の配列を返す
        return $img_names;
    }

    // index ------------------------------------------------------------------------
    /**
     * public $table_name プロパティから
     * 各テーブルのトータルレコード数を返す
     * return $count['cnt']
     */
    public static function getTotalRecord() {
        // テーブルから全レコードの数をカウント
        $sql ='SELECT COUNT(*) as cnt FROM events';
        
        // $params = [':table_name' => $this->table_name];
    
        $record = Messages::retrieveBySql($sql);

        // カウントした数を返す
        return $record->cnt;
    }

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
     * テーブル一覧の取得
     * ページ表示分のみ取得(LIMIT/OFFSET)
     */
    public function indexEvents() {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句:除外する行数)
        $start_record = ($this->page_id - 1) * $display_record;

        //PHP_EOL 実行環境のOSに対応する改行コードを出力する定数
        $sql = 'SELECT event_id, event_name, event_date, event_tag, event_png, status' . PHP_EOL
             . 'FROM events' . PHP_EOL
             . 'ORDER BY event_id DESC' . PHP_EOL 
             . 'LIMIT :display_record OFFSET :start_record'; //OFFSET １件目からの取得は[0]を指定、11件目からの取得は[10]まで除外

        
        $params = [
            ':display_record' => $display_record,
            ':start_record' => $start_record,
        ];
        
        return Messages::findBySql($sql,$params); 
    } 
    
    // insert ------------------------------------------------------------------------
    /**
     * eventsテーブルに新規登録
     */
    public function insertEvent() {

        $sql = 'INSERT INTO events' .PHP_EOL
             . '    (event_name, description, event_date, event_tag, event_svg, event_png,' .PHP_EOL
             . '    img1, img2, img3, img4, img5, img6, img7, img8, img9, img10, status, create_datetime)' .PHP_EOL
             . 'VALUES' .PHP_EOL
             . '    (:event_name, :description, :event_date, :event_tag, :event_svg, :event_png,' .PHP_EOL
             . '    :img1, :img2, :img3, :img4, :img5, :img6, :img7, :img8, :img9, :img10, :status, :create_datetime)';
        
        $params = [
            ':event_name' => $this->event_name,
            ':description' => $this->description,
            ':event_date' => $this->event_date,
            ':event_tag' => $this->event_tag,
            ':event_svg' => $this->event_svg,
            ':event_png' => $this->event_png,
            ':img1' => $this->img1,
            ':img2' => $this->img2,
            ':img3' => $this->img3,
            ':img4' => $this->img4,
            ':img5' => $this->img5,
            ':img6' => $this->img6,
            ':img7' => $this->img7,
            ':img8' => $this->img8,
            ':img9' => $this->img9,
            ':img10' => $this->img10,
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
        $file_dir = './include/images/events/visual/';
        $to = $file_dir . $new_file_name;

        if (empty($files) !== true) {
            Messages::uploadFiles($files, $to);
        }
    }

    /**
     * 複数ファイルのアップロード
     */
    public function uploadImgFiles($re_files, $img_names) {
        $file_dir = './include/images/events/img/';
        
        if (empty($re_files) !== true) {
            $file_count = count($re_files);

            for ($i=0; $i<$file_count; $i++) {
                //
                $to = $file_dir . $img_names[$i];
                $files = $re_files[$i];
                //エラーがあればロールバックを行う  
                Messages::uploadFiles($files, $to);
            }
        }
    }
    
    /**
     * 複数ファイルのプロパティ登録
     */
    public function registerImgFiles($img_names) {
        $file_count = count($img_names); //配列の数をカウント

        for ($i=0; $i<$file_count; $i++) {
            //プロパティ名が1から始まるためi=1でスタート
            $no = $i+1;
            //参照プロパティ
            $property = 'img' . $no;

            //オブジェクトの反復処理
            foreach ($this as $key) {
                if ($key === $property) {
                    $key = $img_names[$i];
                }
            }
        }
    }

    // edit ------------------------------------------------------------------------
    /**
     * 指定レコードの取得
     * 未設定表示あり
     * img1~10を除く
     */
    public function editEvent() {
        $sql = 'SELECT event_id, event_name, description, event_date, event_tag,' . PHP_EOL
             . '       COALESCE(event_svg,:null1) AS event_svg, COALESCE(event_png,:null2) AS event_png,' . PHP_EOL
             . '       status, create_datetime, update_datetime' . PHP_EOL
             . 'FROM events' .PHP_EOL
             . 'WHERE event_id = :event_id';
        
        //NULLを未設定に代替   
        $params = [
            ':event_id' => $this->event_id, 
            ':null1' => '未設定', 
            ':null2' => '未設定'
        ];
        //1レコードのみ
        return Messages::retrieveBySql($sql,$params); 
    }

    /**
     * 指定レコードの画像取得
     * 
     */
    public function editEventImg() {
        $sql = 'SELECT img1, img2, img3, img4, img5, img6, img7, img8, img9, img10' . PHP_EOL
             . 'FROM events' .PHP_EOL
             . 'WHERE event_id = :event_id';
        
          
        $params = [
            ':event_id' => $this->event_id, 
        ];
        
        return Messages::retrieveBySql($sql,$params); 
    }

    // update ------------------------------------------------------------------------
    /**
     * 指定レコードの更新
     */
    public function updateEvent() 
    {
        $sql = 'UPDATE events' . PHP_EOL
             . 'SET event_name = :event_name,' . PHP_EOL
             . '    description = :description,' . PHP_EOL
             . '    event_date = :event_date,' . PHP_EOL
             . '    event_tag = :event_tag,' . PHP_EOL
             . '    event_svg = :event_svg,' . PHP_EOL
             . '    event_png = :event_png,' . PHP_EOL
             . '    status = :status,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE event_id = :event_id' . PHP_EOL;
        
        $params = [
            ':event_name' => $this->event_name,
            ':description' => $this->description,
            ':event_date' => $this->event_date,
            ':event_tag' => $this->event_tag,
            ':event_svg' => $this->event_svg,
            ':event_png' => $this->event_png,
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':event_id' => $this->event_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }

    /**
     * imgの更新
     */
    public function updateEventImgs() 
    {
        $sql = 'UPDATE events' . PHP_EOL
             . 'SET img1 = :img1,' . PHP_EOL
             . '    img2 = :img2' . PHP_EOL
             . '    img3 = :img3' . PHP_EOL
             . '    img4 = :img4' . PHP_EOL
             . '    img5 = :img5' . PHP_EOL
             . '    img6 = :img6' . PHP_EOL
             . '    img7 = :img7' . PHP_EOL
             . '    img8 = :img8' . PHP_EOL
             . '    img9 = :img9' . PHP_EOL
             . '    img10 = :img10' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE event_id = :event_id' . PHP_EOL;
        
        $params = [
            ':img1' => $this->img1,
            ':img2' => $this->img2,
            ':img3' => $this->img3,
            ':img4' => $this->img4,
            ':img5' => $this->img5,
            ':img6' => $this->img6,
            ':img7' => $this->img7,
            ':img8' => $this->img8,
            ':img9' => $this->img9,
            ':img10' => $this->img10,
            ':update_datetime' => $this->update_datetime,
            ':event_id' => $this->event_id,
        ];
    
        Messages::executeBySql($sql, $params);
    }

    /**
     * 指定レコードのステータス更新
     */
    public function updateStatus() {
        $sql = 'UPDATE events' . PHP_EOL
             . 'SET status = :status, update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE event_id = :event_id';
        
        $params = [
            ':status' => $this->status,
            ':update_datetime' => $this->update_datetime,
            ':event_id' => $this->event_id,
            ];
            
        Messages::executeBySql($sql, $params);
    }
    
    // delete ------------------------------------------------------------------------
    /**
     * 指定レコードの削除
     */
    public function deleteEvent() {
        $sql = 'DELETE FROM events' . PHP_EOL
         . 'WHERE event_id = :event_id';
        
        $params = [':event_id' => $this->event_id];
        
        Messages::executeBySql($sql, $params);
    }
    
    // select ------------------------------------------------------------------------
    /**
     * 商品管理に使用 static
     * 
     * select option用　テーブルの取得
     */
    public static function selectOption_Events() {
        $sql = 'SELECT event_id, event_name' . PHP_EOL 
             . 'FROM events';
        
        return Messages::findBySql($sql);
    }

    // ユーザー画面 ------------------------------------------------------------------------
    /**
     * トップ画面
     * イベント情報
     * 
     */
    public function eventIndex() {
        $sql = 'SELECT event_id, event_name, description, event_date, event_tag, event_svg, event_png,' . PHP_EOL
             . '       img1, img2, img3, img4, img5, img6, img7, img8, img9, img10' . PHP_EOL
             . 'FROM events' .PHP_EOL
             . 'WHERE event_id = :event_id';
        
        $params = [
            ':event_id' => $this->event_id, 
        ];
        
        return Messages::retrieveBySql($sql,$params); 
    }

    /**
     * トップ画面下部
     * スケジュール一覧(一部)
     * 
     */
    public function scheduleIndexPart() {
        // 1ページに表示する件数
        $display_record = '5';
        // 配列の何番目から取得するか決定(OFFSET句)
        $start_record = ($this->page_id - 1) * $display_record;

        $sql = 'SELECT event_id, event_name, event_date, event_tag, img1,' . PHP_EOL
             . 'FROM events' . PHP_EOL
             . 'ORDER BY event_id DESC' . PHP_EOL 
             . 'LIMIT :display_record OFFSET :start_record'; 
        
        $params = [
            ':display_record' => $display_record,
            ':start_record' => $start_record,
        ];
        
        return Messages::findBySql($sql, $params);
    }

    /**
     * スケジュール一覧
     * 
     */
    public function scheduleIndex() {
        // 1ページに表示する件数
        $display_record = $this -> display_record;
        // 配列の何番目から取得するか決定(OFFSET句)
        $start_record = ($this->page_id - 1) * $display_record;

        $sql = 'SELECT event_id, event_name, event_date, event_tag, img1,' . PHP_EOL
             . 'FROM events' . PHP_EOL
             . 'ORDER BY event_id DESC' . PHP_EOL // 新しいイベント順
             . 'LIMIT :display_record OFFSET :start_record'; 
        
        $params = [
            ':display_record' => $display_record,
            ':start_record' => $start_record,
        ];

        return Messages::findBySql($sql, $params);
    }

}