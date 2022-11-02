<?php
/**
 * Databese機能の拡張
 * static::classでModelsをfetchObject()のクラス名にする
 * ページネーションに関する機能の追加
 * 検索・絞り込み機能の追加
 * 
 */
class Models {

    //Databeseの基本機能
    public static function retrieveBySql($sql, $params = []) {
        return Database::retrieveBySql($sql, $params, static::class);
    }

    public static function findBySql($sql, $params = []) {
        return Database::findBySql($sql, $params, static::class);
    }

    public static function executeBySql($sql, $params = []) {
        return Database::executeBySql($sql, $params);
    }


    // ファイルのアップデート機能の追加 -----------------------------------------------
    /**
     * ファイルのアップロード
     * アップロードできなければロールバック(コミットさせない)
     * 
     */
    public static function uploadFiles($files = [], $to) {
        $tmp_name = $files['tmp_name'];

        if (move_uploaded_file($tmp_name, $to) !== TRUE) {
            $e = new Exception('ファイルアップロードに失敗しました', 0, $e);
            throw $e;

            Database::rollback();
        }
    }
    
    // ページネーション機能の追加 -----------------------------------------------
    /**
     * ページネーション作成
     * 配列で格納
     * ['total_record'] トータルアイテム数
     * ['page_total'] トータルページ数
     * ['prev_page'] 戻るページ値
     * ['next_page'] 進むページ値
     * ['page_range'] ページレンジ(リンク表示数)
     * ['from_record'] ◯件目-
     * ['to_record'] -◯件目
     * 
     * return array
     */
    public static function setPaginations($total_record, $display_record, $page_id) {
        $paginations = [];

        //トータルレコード数の取得
        $paginations['total_record'] = $total_record;
        //１ページに表示する件数の取得
        $paginations['display_record'] = $display_record;
        //現在のページ番号の取得
        $paginations['page_id'] = $page_id;

        //トータルページ数の決定(ceilで端数の切り上げ/return float)
        $paginations['page_total'] = ceil($total_record / $display_record);

        //戻る・進む
        $paginations['prev_page'] = max($page_id - 1, 1); // 前のページ番号
        $paginations['next_page'] = min($page_id + 1, $paginations['page_total']); // 次のページ番号

        //表示するページのレンジ決定
        $paginations['page_range'] = self::setPageRange($paginations['page_total'], $page_id);

        //◯ - ◯件目
        $paginations['from_record'] = self::fromRecord($display_record, $page_id);
        $paginations['to_record'] = self::toRecord($paginations['page_total'], $total_record, $display_record, $page_id);

        return $paginations;
    }


    /**
     * ページネーションのレンジ決定
     * ページ番号を作る
     * 前後５ページまでを表示
     * 途中から前後2ページづつのレンジとなる
     * 
     */
    public static function setPageRange($page_total, $page_id) {

        //rangeの決定
        if($page_id === 1 || $page_id === $page_total) { // 1ページ目と最後のページ
            $range = 4;
        } elseif ($page_id === 2 || $page_id === $page_total - 1) { // 2ページ目と最後の前のページ
            $range = 3;
        } else {
            $range = 2;
        }
        
        $start_page = max($page_id - $range, 1); // ページ番号始点
        $end_page = min($page_id + $range, $page_total); // ページ番号終点
        //1-2=-1,1 =1 //1+4=5,7 =5
        //2-2=0,1 =1 //2+3=5,7 =5
        //3-2=1,1 =1 //3+2=5,7 =5
        //4-2=2,1 =2 //4+2=6,7 =6
        //5-2=3,1 =3 //5+2=7,7 =7
        //6-3=3,1 =3 //6+3=9,7 =7
        //7-4=3,1 =3 //7+4=11,7 =7

        
        $nums = []; // ページ番号格納用
        // ページ番号格納
        for ($i = $start_page; $i <= $end_page; $i++) {
            $nums[] = $i;
        }

        return $nums;
    }

    /**
     * ◯件目 -
     * 現在のページ*display_recordに1を足した数字
     * ページ1 =　(1-1)*10+1 = 1~
     * ページ2 = (2-1)*10+1 = 11~
     */
    public static function fromRecord($display_record, $page_id) {

        return ($page_id - 1) * $display_record + 1;
    }
    
    /**
     * - ◯件目
     * 現在のページから１引いてdisplay_recordをかけた数に
     * 全件数をdisplay_recordで割ったあまりの数を足す
     * 最大件数48 
     * ページ5 (5-1)*10=40 + 48%10=8　~48
     * ページ2 2*10= ~20
     * 
     * floatを使うため厳密に等しいを使用しない
     */
    public static function toRecord($page_total, $total_record, $display_record, $page_id) {

        if($page_id == $page_total && $total_record % $display_record !== 0) {
            return $to_record = ($page_id - 1) * $display_record + $total_record % $display_record;
        } else {
            return $to_record = $page_id * $display_record;
        }
    }

    // 検索機能の追加 -----------------------------------------------
    /**
     * 追加するSQL文の作成
     * $search 入力された値
     * $keyword,$filter,$sortingは各テーブルの値
     * 
     */
    //入力された検索条件からSQl文を生成
    public static function setSearchSql($searchs = []) {
        // keyの検索
        if (!empty($searchs['keyword'])) {
            $searchSql = 'WHERE :search_key LIKE :search_value ';
        } else if (!empty($searchs['filter'])) {
            $searchSql = 'WHERE :search_key = :search_value ';
        } else if (!empty($searchs['sorting'])) {
            $searchSql = self::setSortingSql($search, $sorting);
        }

        return $searchSql;
    }


    /**
     * 追加する$search(bindValue)の作成
     * $search 入力された値
     * $keyword,$filter,$sortingは各テーブルの値
     * 
     */
    //入力された検索条件からSQl文を生成
    public static function setSearchParams($searchs = []) {

        if (!empty($searchs['keyword'])) {
            foreach ($searchs['keyword'] as $key => $value) {
                $value = "%{$value}%"; //前後0文字以上検索
                $searchParams = [':search_key' => $key, ':search_value' => $value,];
            } 
        } else if (!empty($searchs['filter'])) {
            foreach ($searchs['filter'] as $key => $value) {
                $value = (int)$value; //intに変換
                $searchParams = [':search_key' => $key, ':search_value' => $value,];
            }
        } else if (!empty($searchs['sorting'])) {
            $searchParams = self::setSortingParams($search, $search);
        }

        return $searchParams;
    }

    /**
     * 全レコード削除
     */
    public function deleteAll() {
        $sql = 'TRUNCATE TABLE :table_name';
    
        $params = [':table_name' => $this ->table_name];
        
        Database::executeBySql($sql, $params);
    }   
}