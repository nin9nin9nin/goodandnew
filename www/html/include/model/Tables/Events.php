<?php

require_once(MODEL_DIR . '/Messages.php');

//events テーブル
class Events {
    
    public $table_name = 'events'; //count(*)するテーブル
    public $diplay_record = '20'; //1ページの表示件数
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
     * svg画像
     * 拡張子の確認とファイル名(ユニーク)の確認
     * プロパティに登録
     * 
     * 保存先フォルダ指定
     */
    public function checkEvntSvg() {
        $img_dir = './assets/imges/event/svg/';
        
        if (isset($_FILES['event_svg'])) {
            // 内部で正しくアップロードされたか確認
            Validator::checkImg($_FILES['event_svg'], $img_dir, $this->event_svg);
        }
        //アップロード自体なければ何も返さない
    }

    /**
     * pmg画像
     * 拡張子の確認とファイル名(ユニーク)の確認
     * プロパティに登録
     * 
     * 保存先フォルダ指定
     */
    public function checkEvntPng() {
        $img_dir = './assets/imges/event/png/';
        
        if (isset($_FILES['event_png'])) {
            Validator::checkImg($_FILES['event_png'], $img_dir, $this->event_png);
        }
    }

    /**
     * 
     */
    public function checkEventImg() {
        $img_dir = './assets/imges/event/img/';

        if (isset($_FILES['img1'])) {
            Validator::checkImg($_FILES['img1'], $img_dir, $this->img1);
        }
        if (isset($_FILES['img2'])) {
            Validator::checkImg($_FILES['img2'], $img_dir, $this->img2);
        }
        if (isset($_FILES['img3'])) {
            Validator::checkImg($_FILES['img3'], $img_dir, $this->img3);
        }
        if (isset($_FILES['img4'])) {
            Validator::checkImg($_FILES['img4'], $img_dir, $this->img4);
        }
        if (isset($_FILES['img5'])) {
            Validator::checkImg($_FILES['img5'], $img_dir, $this->img5);
        }
        if (isset($_FILES['img6'])) {
            Validator::checkImg($_FILES['img6'], $img_dir, $this->img6);
        }
        if (isset($_FILES['img7'])) {
            Validator::checkImg($_FILES['img7'], $img_dir, $this->img7);
        }
        if (isset($_FILES['img8'])) {
            Validator::checkImg($_FILES['img8'], $img_dir, $this->img8);
        }
        if (isset($_FILES['img9'])) {
            Validator::checkImg($_FILES['img9'], $img_dir, $this->img9);
        }

    }

    // index ------------------------------------------------------------------------
    /**
     * トータルレコードを取得し、ページネーションの値をセットして返す
     * return array
     */
    public function getPaginations() {
        //$table_nameからトータルレコードの取得
        $total_record = Messages::getTotalRecord();

        //page_idを取得してページネーションを取得してくる
        return Messages::setPaginations($total_record);
    }

    /**
     * テーブル一覧の取得
     * ページ表示分のみ取得(LIMIT/OFFSET)
     */
    public function indexEvents() {
        // 配列の何番目から取得するか決定(OFFSET句)
        $start_record = ($this->page_id - 1) * $this->display_record;

        //PHP_EOL 実行環境のOSに対応する改行コードを出力する定数
        $sql = 'SELECT event_id, event_name, event_date, event_tag, status' . PHP_EOL
             . 'FROM events' . PHP_EOL
             . 'LIMIT :display_record OFFSET :start_record'; //OFFSET １件目からの取得は[0]を指定、11件目からの取得は[10]まで除外

        
        $params = [
            ':start_record' => $start_record,
            ':display_record' => $this->display_record,
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
    public function uploadEvntSvg() {
        $img_dir = './assets/imges/event/svg/';

        if (isset($_FILES['event_svg'])) {
            Messages::uploadImg($_FILES['event_svg'], $img_dir, $this -> event_svg);
        }
    }

    /**
     * 画像のファイルアップロード
     * アップロードできなければロールバック(コミットさせない)
     */
    public function uploadEvntPng() {
        $img_dir = './assets/imges/event/png/';

        if (isset($_FILES['event_png'])) {
            Messages::uploadImg($_FILES['event_png'], $img_dir, $this -> event_png);
        }
    }

    /**
     * 
     */
    public function uploadEventImg() {
        $img_dir = './assets/imges/event/img/';

        if (isset($_FILES['img1'])) {
            Messages::uploadImg($_FILES['img1'], $img_dir, $this -> img1);
        }
        if (isset($_FILES['img2'])) {
            Messages::uploadImg($_FILES['img2'], $img_dir, $this -> img2);
        }
        if (isset($_FILES['img3'])) {
            Messages::uploadImg($_FILES['img3'], $img_dir, $this -> img3);
        }
        if (isset($_FILES['img4'])) {
            Messages::uploadImg($_FILES['img4'], $img_dir, $this -> img4);
        }
        if (isset($_FILES['img5'])) {
            Messages::uploadImg($_FILES['img5'], $img_dir, $this -> img5);
        }
        if (isset($_FILES['img6'])) {
            Messages::uploadImg($_FILES['img6'], $img_dir, $this -> img6);
        }
        if (isset($_FILES['img7'])) {
            Messages::uploadImg($_FILES['img7'], $img_dir, $this -> img7);
        }
        if (isset($_FILES['img8'])) {
            Messages::uploadImg($_FILES['img8'], $img_dir, $this -> img8);
        }
        if (isset($_FILES['img9'])) {
            Messages::uploadImg($_FILES['img9'], $img_dir, $this -> img9);
        }
        if (isset($_FILES['img10'])) {
            Messages::uploadImg($_FILES['img10'], $img_dir, $this -> img10);
        }
        if (isset($_FILES['img10'])) {
            Messages::checkImg($_FILES['img10'], $img_dir, $this->img10);
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
     * スケジュール一覧
     * 
     */
    public function scheduleIndex() {

        $sql = 'SELECT event_id, event_name, event_date, event_tag, img1,' . PHP_EOL
             . 'FROM events';
        
        return Messages::findBySql($sql);
    }
}