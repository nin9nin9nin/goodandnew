<?php

require_once(MODEL_DIR . '/Messages.php');

//usersテーブル
class Users {
    public $user_id;
    public $user_name;
    public $email;
    public $password;
    public $password_hash;
    public $create_datetime;
    public $update_datetime;
    
    public $old_user_name;
    public $old_password;
    
    public function __construct() {
        $this -> user_id = null;
        $this -> user_name = null;
        $this -> email = null;
        $this -> password = null;
        $this -> password_hash = null;
        $this -> create_datetime = null;
        $this -> update_datetime = null;
        $this -> old_user_name = null;
        $this -> old_password = null;
    }
    
    /**
     * ユーザーネーム　半角英数字　0~128文字
     * 
     * Validatorがfalseの場合メッセージを入れて返す
     * エラーがなければ何も返さない
     * return CommonError::errorAdd
     */
    public function checkUserName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->user_name)) {
            return CommonError::errorAdd('ユーザーネームを入力してください');
        } else if (!Validator::checkAlphanumeric($this->user_name)) {
            return CommonError::errorAdd('ユーザーネームは半角英数字で入力してください');
        } else if (!Validator::checkLength($this->user_name, 6, 128)) {
            return CommonError::errorAdd('ユーザーネームは6文字以上、128文字以内で入力してください');
        }
        
    }
    /**
     * ログイン用
     * 文字数指定なし(adminのため)
     * 
     */
    public function checkloginUserName() {
        Validator::paramClear();
        
        if (!Validator::checkInputempty($this->user_name)) {
            return CommonError::errorAdd('ユーザーネームを入力してください');
        } else if (!Validator::checkAlphanumeric($this->user_name)) {
            return CommonError::errorAdd('ユーザーネームは半角英数字で入力してください');
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
     * ログイン用
     * 文字数指定なし(adminのため)
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
     * user_nameに重複がないか
     * 一致がなければ0 = trueを返す
     * SQLの実行結果は文字列型になるので'0'と比較
     * return CommonError::errorAdd
     */
    public function checkUniqueUserName() {
        Validator::paramClear();
        
        $sql = 'SELECT COUNT(user_id) AS id_count ' .PHP_EOL
              .'FROM users' .PHP_EOL
              .'WHERE user_name = :user_name';
              
        $params = [':user_name' => $this->user_name];
        
        $record = Messages::retrieveBySql($sql, $params);
        
        $count = $record -> id_count;
        
        if ($count > 0) {
            return CommonError::errorAdd('ユーザーネームはすでに使われています');
        }
    }
    
    /**
     * パスワードをハッシュ化させる
     */
    public function passwordHash() {
        $this -> password_hash = password_hash($this->password, PASSWORD_DEFAULT);
    }
    
    /**
     * usersテーブルからpasswordのみ取得(ハッシュ化されたパスワード)
     * password_verify()でパスワードのチェックを行う
     * 
     * return CommonError::errorAdd
     */
    public function checkLogin_PasswordHash() {
        Validator::paramClear();
        
        $sql = 'SELECT password FROM users WHERE user_name = :user_name';
        
        $params = [':user_name' => $this->user_name];
        
        $hash = Messages::retrieveBySql($sql, $params);
        
        if (!password_verify($this->password, $hash->password)) {
            return CommonError::errorAdd('ユーザーネームかパスワードが正しくありません');
        }
    }

    /**
     * 旧パスワードの確認
     * usersテーブルからpasswordのみ取得(ハッシュ化されたパスワード)
     * password_verify()でパスワードのチェックを行う
     * 
     * return CommonError::errorAdd
     */
    public function checkUpdate_PasswordHash() {
        Validator::paramClear();
        
        $sql = 'SELECT password FROM users WHERE user_name = :user_name';
        
        $params = [':user_name' => $this->old_user_name];
        
        $hash = Messages::retrieveBySql($sql, $params);
        
        if (!password_verify($this->old_password, $hash->password)) {
            return CommonError::errorAdd('旧パスワードが正しくありません');
        }
    }
    
    /**
     * テーブル一覧の取得
     */
    public function indexUsers() 
    {
        $sql = 'SELECT * FROM users' . PHP_EOL
             . 'ORDER BY create_datetime DESC';
        
        return Messages::findBySql($sql);
    }
    
    
    /**
     * 新規登録
     */
    public function insertUser() {
        
        $sql = 'INSERT INTO users' .PHP_EOL
             . '    (user_name, email, password, create_datetime)' .PHP_EOL
             . 'VALUES' .PHP_EOL
             . '    (:user_name, :email, :password, :create_datetime)';
        
        $params = [
            ':user_name' => $this->user_name,
            ':email' => $this->email,
            ':password' => $this->password_hash,
            ':create_datetime' => $this->create_datetime,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    /**
     * user_idで指定
     * 指定レコード取得(全カラム)
     */
    public function selectUserId() {
        $sql = 'SELECT * ' .PHP_EOL
             . 'FROM users WHERE user_id = :user_id';
             
        $params = [':user_id' => $this->user_id];
        
        return Messages::retrieveBySql($sql, $params);

    }
    /**
     * user_nameから指定
     * 指定レコード取得(passwordを除く)
     * 
     * $_SESSION['user']用
     */
    public function selectUserName() {
        $sql = 'SELECT user_id, user_name, email, create_datetime, update_datetime' .PHP_EOL
             . 'FROM users WHERE user_name = :user_name';
             
        $params = [':user_name' => $this->user_name];
        
        return Messages::retrieveBySql($sql, $params);

    }
    
    /**
     * 指定レコードの更新
     */
    public function updateUser() {
        $sql = 'UPDATE users' . PHP_EOL
             . 'SET user_name = :user_name,' . PHP_EOL
             . '    email = :email,' . PHP_EOL
             . '    password = :password,' . PHP_EOL
             . '    update_datetime = :update_datetime' . PHP_EOL
             . 'WHERE user_id = :user_id' . PHP_EOL;
        
        $params = [
            ':user_name' => $this->user_name,
            ':email' => $this->email,
            ':password' => $this->password_hash,
            ':update_datetime' => $this->update_datetime,
            ':user_id' => $this->user_id,
        ];
        
        Messages::executeBySql($sql, $params);
    }
    
    
}