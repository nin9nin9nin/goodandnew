<?php

//データベースにアクセス
//命令実行まで接続を遅らせる
class Database {
    //まずはプロパティを用意（PDOをいれるため）
    private $db;
    
    //つぎにコンストラクトで $db（プロパティ）を初期化
    private function __construct() {
        $this->db = null;
    }
    
    /**
     * 初回:自らクラスを生成 (new Databese();)
     * プロパティ$db
     * コンストラクト　new Databese -> db = null;
     * retutn new Databese()クラスを返す
     */
    public static function getInstance() {
        //new self()を入れるための変数用意
        //static として宣言することで、 クラスのインスタンス化の必要なしにアクセスできる
        //インスタンス変数からクラス変数となる
        static $instance;
        
        //初回アクセス時はnull/２回目以降はnew Databeseが入っている
        if ($instance === null) {
            $instance = new self();
        }
        //new Databese(private $db = null;)
        return $instance;
    }
    
    /**
     * getInstanceを実行しプロパティにPDOを入れる
     * データベース接続するための関数
     * 属性を設定　エラーモードとプリペアドステートメント
     * Databese ->db = PDOクラスと属性設定を代入
     */
    public static function connect() {
        $db = new PDO(DSN, DB_USER, DB_PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        //生成したクラスのプロパティ$dbに$db=new PDO()を代入
        self::getInstance()->db = $db;
    }

    /**
     * 初回のみconnect()を実行
     * connect()が実行されることでPDOの生成とself::getInstance->db=$dbが実行される
     * return $db=new PDO()
     */
    public static function getDatabase() {
        if (self::getInstance()->db === null) {
            //getInstanceを実行
            //Database->dbに$dbを代入実行
            self::connect();
        }
        
        //$dbを返す
        return self::getInstance()->db;
    }
    
    
    
    /**
     * $db ->beginTransaction();
     */
    public static function beginTransaction() {
        self::getDatabase()->beginTransaction();
    }
    
    /**
     * $db ->commit();
     */
    public static function commit() {
        self::getDatabase()->commit();
    }

    /**
     * $db ->rollBack();
     */
    public static function rollBack() {
        self::getDatabase()->rollBack();
    }

    /**
     * return $db ->lastInsertId($name);
     */
    public static function lastInsertId($name = null) {
        return self::getDatabase()->lastInsertId($name);
    }


    /**
     * 必要なレコードのみを参照する
     * $records= $records[]
     * return $records[0][:id]=$id
     * :idでbindValueする
     */
    //detail.php $record = Messages::retrieveBySql($sql, [':id' => $id]);
    //edit.php $record = Messages::retrieveBySql($sql, [':id' => $id]);
    public static function retrieveBySql($sql, $params = [], $class_name = 'stdClass') {
        
        $records = self::findBySql($sql, $params, $class_name);
        //配列の数が１でなければ
        if (count($records) !== 1) {
            return false;
        }
        
        //1レコードのみ返す
        return $records[0];
    }

    /**
     * 参照のみ(SELECT文)
     * $srarement = $db ->prepare($sql);
     * $params bindしないからいらない
     * $class_name = 'stdClass' fetchObjectの作成されるクラス(定数？)
     * $sql = 'SELECT * FROM post' . PHP_EOL . 'ORDER BY create_datetime DESC';
     * return $records 
     */
    //index.php $records = Messages::findBySql($sql);
    public static function findBySql($sql, $params = [], $class_name = 'stdClass') {
        $statement = self::getDatabase()->prepare($sql);
        
        //$statement->execute();
        self::_executeBySql($statement, $sql, $params);
        
        //return用 $records[]配列作成
        $records = [];
        
        //fetch0bject:次の行を取得し、それをオブジェクトとして返す(ORマッピング)
        //一つづつオブジェクトとして取り出し$recordに代入
        //  $record[] = new stdClass{
        //                  public id = 〇〇; 
        //                  public user_name =〇〇;
        //                  ...
        //              }
        while ($record = $statement->fetchObject($class_name)) {
            //オブジェクトごとに$records[]配列に入れていく
            //($records[0]=オブジェクト,$records[1]=オブジェクト...)
            $records[] = $record;
        }

        return $records;
    }

    /**
     * 命令のみ（登録、変更、削除）(INSERT INTO,UPDATE,DELETE文)
     * その後redirectTo()でindex.phpやdetail.phpにリダイレクトされる
     * $srarement = $db ->prepare($sql);
     * _executeBySqlで$paramsをbindしてexecute
     */
    /**
     * create.php Messages::executeBySql($sql, $params);
     * update.php Messages::executeBySql($sql, $params);
     * delete.php Messages::executeBySql($sql, [':id' => $id]);
     */
    public static function executeBySql($sql, $params = []) {
        $statement = self::getDatabase()->prepare($sql);

        return self::_executeBySql($statement, $sql, $params);
    }
    
    /**
     * bindしてexecuteする
     * _がついている/元となる動作
     * $statement = $db->prepare(sql);
     * $sql = SQL文
     * $params = bindValueが必要な場合配列を記入
     * $keyは?を使わないから数字ではなく文字列を使う
     * $valueが数値の場合PDO::PARAM_INTになる
     * return $satement->execute() / $statement=$db->prepare()
     */
    public static function _executeBySql($statement, $sql, $params = []) {
        foreach ($params as $key => $value) {
            if (is_int($value)) {
                $statement->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $statement->bindValue($key, $value, PDO::PARAM_STR);
            }
        }

        return $statement->execute();
        //$statement=$db->prepare()の中にbindValueとexecuteを入れるイメージ？
    }
}