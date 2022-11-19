<?php

require_once(MODEL_DIR . '/Messages.php');

//admin テーブル
class Admin {
    //クラスの外側から呼び出し値を入れる(public)
    public $admin_id;
    public $admin_name;
    public $email;
    public $password;
    public $password_hash;
    public $create_datetime;
    public $update_datetime;
    
    public $old_admin_name;
    public $old_password;
    
    /**
     * 生成時に自動的に初期化
     * 共通のプロパティではないので必要ない？(複数のインスタンスがa存在する)
     */
    public function __construct() {
        $this -> admin_id = null;
        $this -> admin_name = null;
        $this -> email = null;
        $this -> password = null;
        $this -> password_hash = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
        $this -> old_admin_name = null;
        $this -> old_password = null;
    }
    
    public function set() {
        
    }
    
    /**
     * 管理者ネーム　半角英数字　0~128文字
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkAdminName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->admin_name)) {
            return CommonError::errorAdd('管理者ネームを入力してください');
        } else if (!Validator::checkSpace($this->admin_name)) {
            return CommonError::errorAdd('管理者ネームは空白文字を使用しないでください');
        } else if (!Validator::checkAlphanumeric($this->admin_name)) {
            return CommonError::errorAdd('管理者ネームは半角英数字で入力してください');
        } else if (!Validator::checkLength($this->admin_name, 6, 128)) {
            return CommonError::errorAdd('管理者ネームは6文字以上、128文字以内で入力してください');
        }
    }

    /**
     * メールアドレス　'/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/'
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkEmail() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->email)) {
            return CommonError::errorAdd('メールアドレスを入力してください');
        } else if (!Validator::checkMailAddress($this->email)) {
            return CommonError::errorAdd('メールアドレスが正しくありません');
        }
    }
    
    /**
     * パスワード 半角英数字　6~255文字(ハッシュ化するため)
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkPassword() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->password)) {
            return CommonError::errorAdd('パスワードを入力してください');
        } else if (!Validator::checkAlphanumeric($this->password)) {
            return CommonError::errorAdd('パスワードは半角英数字で入力してください');
        } else if (!Validator::checkLength($this->password, 6, 255)) {
            return CommonError::errorAdd('パスワードは6文字以上、255文字以内で入力してください');
        }
    }
    
    /**
     * 新規登録用
     * admin_nameに重複がないか
     * 一致がなければ0 = trueを返す
     * SQLの実行結果は文字列型になるので'0'と比較
     * return CommonError::errorAdd
     */
    public function checkUniqueAdminName() {
        $sql = 'SELECT COUNT(admin_id) AS id_count ' .PHP_EOL
        .'FROM admin' .PHP_EOL
        .'WHERE admin_name = :admin_name';
        
        $params = [':admin_name' => $this->admin_name];
        
        $record = Messages::retrieveBySql($sql, $params);
        
        $count = $record -> id_count;
        
        if ($count > 0) {
            return CommonError::errorAdd('管理者ネームはすでに使われています');
        }
    }
    
    /**
     * 新規登録用
     * パスワードをハッシュ化させる
     * 
     */
    public function passwordHash() {
        $this -> password_hash = password_hash($this->password, PASSWORD_DEFAULT);
    }
    
    /**
     * ログイン用
     * 文字数指定なし(adminのため)
     * 
     */
    public function checkloginAdminName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->admin_name)) {
            return CommonError::errorAdd('管理者ネームを入力してください');
        } else if (!Validator::checkAlphanumeric($this->admin_name)) {
            return CommonError::errorAdd('管理者ネームは半角英数字で入力してください');
        }
        
    }

    /**
     * ログイン用
     * 文字数指定なし(adminのため)
     * 
     */
    public function checkloginPassword() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->password)) {
            return CommonError::errorAdd('パスワードを入力してください');
        } else if (!Validator::checkAlphanumeric($this->password)) {
            return CommonError::errorAdd('パスワードは半角英数字で入力してください');
        } else {
            $this -> checkLogin_PasswordHash();
        }
    }

    /**
     * ログイン用
     * adminテーブルからpasswordのみ取得(ハッシュ化されたパスワード)
     * password_verify()でパスワードのチェックを行う
     * 
     * return CommonError::errorAdd
     */
    public function checkLogin_PasswordHash() {
        $sql = 'SELECT password FROM admin WHERE admin_name = :admin_name';
        
        $params = [':admin_name' => $this->admin_name];
        
        $hash = Messages::retrieveBySql($sql, $params);
        
        if (!password_verify($this->password, $hash->password)) {
            return CommonError::errorAdd('管理者ネームかパスワードが正しくありません');
        }
    }

    /**
     * 更新用
     * 旧パスワードの確認
     * adminテーブルからpasswordのみ取得(ハッシュ化されたパスワード)
     * password_verify()でパスワードのチェックを行う
     * 
     * return CommonError::errorAdd
     */
    public function checkUpdate_PasswordHash() {
        $sql = 'SELECT password FROM admin WHERE admin_name = :admin_name';
        
        $params = [':admin_name' => $this->old_admin_name];
        
        $hash = Messages::retrieveBySql($sql, $params);
        
        if (!password_verify($this->old_password, $hash->password)) {
            return CommonError::errorAdd('旧パスワードが正しくありません');
        }
    }
    
    
    /**
     * 新規登録
     */
    public function insertAdmin() {
        
        $sql = 'INSERT INTO admin' .PHP_EOL
             . '    (admin_name, email, password, create_datetime)' .PHP_EOL
             . 'VALUES' .PHP_EOL
             . '    (:admin_name, :email, :password, :create_datetime)';
        
        $params = [
            ':admin_name' => $this->admin_name,
            ':email' => $this->email,
            ':password' => $this->password_hash,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * インデックス
     * admin_idで指定
     * 指定レコード取得(全カラム)
     */
    public function selectAdminId() {
        $sql = 'SELECT * ' .PHP_EOL
             . 'FROM admin WHERE admin_id = :admin_id';
             
        $params = [':admin_id' => $this->admin_id];
        
        return Messages::retrieveBySql($sql, $params);

    }
    /**
     * admin_nameから指定
     * 指定レコード取得(passwordを除く)
     * 
     * $_SESSION['admin']用
     */
    public function selectAdminName() {
        $sql = 'SELECT admin_id, admin_name, email, create_datetime, update_datetime' .PHP_EOL
             . 'FROM admin WHERE admin_name = :admin_name';
             
        $params = [':admin_name' => $this->admin_name];
        
        return Messages::retrieveBySql($sql, $params);

    }
    
    
    /**
     * 指定レコードの更新
     */
    public function updateAdmin() {
        $sql = 'UPDATE admin' . PHP_EOL
             . 'SET admin_name = :admin_name,' . PHP_EOL
             . '    email = :email,' . PHP_EOL
             . '    password = :new_password,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE admin_id = :admin_id' . PHP_EOL;
        
        $params = [
            ':admin_name' => $this->admin_name,
            ':email' => $this->email,
            ':new_password' => $this->password_hash,
            ':update_datetime' => $this->update_datetime,
            ':admin_id' => $this->admin_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
}