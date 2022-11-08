<?php
/**
 * バリデーション
 * 
 */
class Validator {
    private static $arg;
    private static $min_value;
    private static $max_value;
    private static $mailAddress;
    private static $img_property;
    
    // sample シングルトンパターン（このクラスには必要ない）------------------
    // //コンストラクタをprivateにすることで外部からアクセスできないようにする
    // private function __construct() { }
    
    // //その上で一度だけ生成し、常に同じインスタンスを使用
    // public static function getInstance()
    // {
    //     static $instance;
        
    //     if ($instance === null) {
    //         $instance = new self();
    //     }
        
    //     return $instance;
    // } ----------------------------------------------------------------------
    
    /**
     * 初期化
     * 使用する際に必ず行う
     * static使用のため（他で使った値が入ったままになる）
     */
    public static function paramClear() {
        self::$arg = null;
        self::$min_value = null;
        self::$max_value = null;
        self::$mailAddress = null;
        self::$img_property = null;
    }
    
    /**
     * 入力値があるかどうかチェック
     * また0は無効とする
     * 
     * @return bool あればtrue、なければfalse
     */
    public static function checkInputempty($arg) {
        if (mb_strlen($arg) > 0 ) {
            return true;
        }
        return false;
    }

    /**
     * 空白文字のチェック
     * 全角半角の空白文字があればfalseを返す
     * @return bool
     */
    //admin_name user_nameの取得時に行う
    public static function checkSpace($arg) {
        if (preg_match('/[　\s]/u', $arg)) {
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * 文字列型チェック<br>
     * 文字列として扱えるかどうかのチェック<br>
     * 数字もOKとするが、arrayやクラスはNGとする
     *
     * @param string $arg チェックする値
     * @return bool 文字列の場合true、そうでなければfalse
     */
    public static function checkString($arg)
    {
        if (is_string($arg) || is_numeric($arg)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 英数字ハイフンアンダースコアのチェック
     * 
     * $param $module,$action チェックする値
     * @return bool 英数字-_のみの場合true、そうでなければfalse
     */
    //$module_name,$action_nameの取得時に行う
    public static function checkAlphaunderscore($arg) {
        if (self::checkString($arg) && preg_match('/^[0-9a-zA-Z\-\_]+$/u', $arg)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 英数字チェック
     *
     * @param string $arg チェックする値
     * @return bool 英数字のみの場合true、そうでなければfalse
     */
    public static function checkAlphanumeric($arg)
    {
        if(self::checkString($arg) && preg_match('/^[a-zA-Z0-9]+$/', $arg)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 数字チェック
     *
     * @param string $arg チェックする値
     * @return bool 数字のみの場合true、そうでなければfalse
     */
    public static function checkNumeric($arg)
    {
        if(self::checkString($arg) && preg_match('/^\d+$/', $arg)){
            return true;
        } else {
            return false;
        }
    }
    
    //メッセージを分けるため少し細かくする --------------
    /**
     * 値の長さチェック<br>
     * 最小と最大を指定、最大を指定しない場合は無制限
     *
     * @param string $arg チェックする値(checkAlphanumeric() =true)
     * @return bool 指定された範囲内の文字列長だった場合true、そうでなければfalse
     */
    public static function checkLength($arg, $min_value, $max_value = null)
    {
        if (self::checkString($arg) && self::checkDigit($min_value) && mb_strlen($arg) >= $min_value && 
        (is_null($max_value) || (self::checkDigit($max_value) && mb_strlen($arg) <= $max_value))){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 数字型チェック<br>
     * 数字だけからできていることをチェックする
     *
     * @param string $arg チェックする値
     * @return bool 数字だけの場合true、そうでなければfalse
     */
    public static function checkDigit($arg)
    {
        if (self::checkString($arg) && ctype_digit((string)$arg)) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * int型文字列のチェック<br>
     *
     * @param string $arg チェックする値
     * @return bool int型文字列の場合true、そうでなければfalse
     */
    public static function checkInt($arg)
    {
        if (self::checkString($arg) && is_numeric((string)$arg)) {
            $arg += 0;
            if (is_int($arg)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    /**
     * シングルバイト文字列型チェック<br>
     * シングルバイト文字列かのチェックを行う
     *
     * @param string $arg チェックする値
     * @return bool シングルバイト文字列の場合true、そうでなければfalse
     */
    public static function checkSingleByte($arg)
    {
        if (self::checkString($arg) && preg_match('/^[!-~]+$/i', $arg)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 文字列の長さチェック<br>
     * string型文字列の長さチェック<br>
     * 最小と最大を指定、最大を指定しない場合は無制限
     *
     * @param string $arg チェックする値(string型の文字列を設定すること)
     * @return bool 指定された範囲内の文字列長だった場合true、そうでなければfalse
     */
    // public static function checkLength($arg, $min_value, $max_value = null)
    // {
    //     if (is_string($arg) && self::checkDigit($min_value) && mb_strlen($arg) >= $min_value
    //     && (is_null($max_value) || (self::checkDigit($max_value) && mb_strlen($arg) <= $max_value))){
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    /**
     * 数値の範囲チェック<br>
     * 整数型数値の範囲チェック<br>
     * 最小と最大を指定、最大を指定しない場合は無制限
     *
     * @param int $arg チェックする値(整数型数値を設定すること)
     * @return bool 指定された範囲内の数値だった場合true、そうでなければfalse
     */
    //price,stock 必須 int(11) 10桁超えると2,147,483,647になる
    //フォームからの受け取りのため最初を変更
    public static function checkRange($arg, $min_value, $max_value = null)
    {
        if (preg_match('/^[1-9]+$/', $arg) && self::checkDigit($min_value) && mb_strlen($arg) >= $min_value
        && (is_null($max_value) || (self::checkDigit($max_value) && mb_strlen($arg) <= $max_value))){
            return true;
        } else {
            return false;
        }
        // if (self::checkDigit($arg) && self::checkDigit($min_value) && $arg >= $min_value
        // && (is_null($max_value) || (self::checkDigit($max_value) && $arg <= $max_value))){
        //     return true;
        // } else {
        //     return false;
        // }
    }

    /**
     * メールアドレス形チェック<br>
     * メールアドレスとして正しいかのチェックを行う
     *
     * @param string $arg チェックする値
     * @return bool メールアドレス形式の文字列だった場合true、そうでなければfalse
     * 
     * pattren ='/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/'
     * pattren = '/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/'
     */
    public static function checkMailAddress($mailAddress)
    {
        if (self::checkString($mailAddress) && preg_match('/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/', $mailAddress) 
        && mb_strlen($mailAddress) <= 128){
            return true;
        } else {
            return false;
        }
    }

    /**
     * URI型のチェック<br>
     * https://mailto: の形をチェックする
     *
     * @param string $arg チェックする値
     * @return bool URI型文字列の場合true、そうでなければfalse
     * 
     * pattern = "/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/"
     * pattern = "/^https?://([\w-]+\.)+[\w-]+(/[\w-./?%&=]*)?$/";
     * pattern = "/^(https?|ftp)(://[-_.!~*'()a-zA-Z0-9;/?:@&amp;amp;=+$,%#]+)$/";
     */
    public static function checkUrl($arg)
    {
        if (self::checkString($arg) && preg_match(';^(https?://).+|(mailto:).+@.+;', $arg)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * phone_numberのチェック
     * 0から始まる9~11桁の半角数字
     * ハイフンはなし
     * 
     * @param int $arg チェックする値
     * @return bool URI型文字列の場合true、そうでなければfalse
     */
    //phone_number 任意
    public static function checkPhonenumber($arg) {
        if (self::checkDigit($arg) && preg_match('/\A0[0-9]{9,10}\z/', $arg)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * アップロード画像
     * 拡張子の確認とファイル名(ユニーク)の作成
     * @param $file_dir ファイルの保存先ディレクトリ
     * @param array $file $_FILES[]
     * 
     */
    public static function checkFileName($files = [], $file_dir) {
        $file_name = $files['name']; //$_FILES['']['name']を代入

        // 画像の拡張子を取得
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        // 小文字に変換
        $extension = strtolower($extension); // あいうえお.JPG => JPG => jpg
        // 指定の拡張子であるかどうかチェック
        if ($extension === 'jpeg' || $extension === 'jpg' || $extension === 'png' || $extension === 'svg') {
            // 保存する新しいファイル名の生成（ユニークな値を設定する）
            $new_file_name = sha1(uniqid(mt_rand(), true)). '.' . $extension;
            // 同名ファイルが存在するかどうかチェック
            if (is_file($file_dir . $new_file_name) !== TRUE) {
                //生成したファイル名を返す
                return $new_file_name;
            } else {
                CommonError::errorAdd('ファイルアップロードに失敗しました。再度お試しください');
            }
        } else {
            CommonError::errorAdd(h($file_name) . 'はファイル形式が異なります。jpeg/jpg/png/svgのみ利用可能です');
        } 
    }

    /**
     * ファイル数の確認
     * 最大8ファイルまで
     */
    public static function checkFileCount($files = []) {
        $file_count = count($files);

        if ($file_count <= 8) {
            return true;
        }else {
            return false;
        }
    }
}