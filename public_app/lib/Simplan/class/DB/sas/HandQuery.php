<?php

/**
 * HandSqlクラス
 *
 * @link
 * @author
 * @license
 * @package    Simplan.HandQuery
 * @version    1.0
 */
class HandQuery{

    /**
     * 配列要素からInsertクエリを作成する
     *
     * @access  public
     * @param   array    $table  テーブル名
     * @param   array    &$obj   フィールド名がキーの配列
     * @return  string
     */
    public static function Insert($table, &$obj)
    {
        if (($def = SasFactor::CreateTableDefine($table)) === false ) {
            return false;
        }

        $filed = '';
        $values = '';
        foreach(array_keys($obj) As $key) {
			if (!array_key_exists($key, $def->field_type)) continue;

			$val = addslashes( $obj[$key] );
			if( strlen( $val ) == 0 ) continue;

			//フィールドセット
			if( strlen( $filed ) == 0 ) {
				$filed .= "{$key}";
			} else {
				$filed .= ", {$key}";
			}

			//文字列対応
			switch( strtolower( $def->field_type[$key] ) ){
				case 'varchar':
				case 'char':
				case 'text':
                case 'date':
				case 'timestamp':
				case 'datetime':
                case 'time':
					$val = "'".$val."'";
					break;
			}

			//Valuesセット
			if( strlen( $values ) == 0 ){
				$values .= "{$val}";
			} else {
				$values .= ", {$val}";
			}
		}

		return "INSERT INTO {$table} ( {$filed} ) VALUES ( {$values} ) ";
    }

    /**
     * 配列要素からInsertクエリを作成する
     *
     * @access  public
     * @param   array    $table  テーブル名
     * @param   array    &$obj   フィールド名がキーの配列
     * @return  string
     */
    public static function InsertDb($db, $table, &$obj)
    {
        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }
        $filed = '';
        $values = '';
        foreach(array_keys($obj) As $key) {
			if (!array_key_exists($key, $def->field_type)) continue;

			$val = addslashes( $obj[$key] );
			if( strlen( $val ) == 0 ) continue;

			//フィールドセット
			if( strlen( $filed ) == 0 ) {
				$filed .= "{$key}";
			} else {
				$filed .= ", {$key}";
			}

			//文字列対応
			switch( strtolower( $def->field_type[$key] ) ){
				case 'varchar':
				case 'char':
				case 'text':
                case 'date':
				case 'timestamp':
				case 'datetime':
				case 'time':
					$val = "'".$val."'";
					break;
			}

			//Valuesセット
			if( strlen( $values ) == 0 ){
				$values .= "{$val}";
			} else {
				$values .= ", {$val}";
			}
		}

		return "INSERT INTO {$db}.{$table} ( {$filed} ) VALUES ( {$values} ) ";
    }

    //--------------------------------------------------------------------------

    /**
     * InsertSQL作成処理
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @param     Array      $param  登録情報
     * @return    Array      テーブル構造情報
     */
    public static function InsertVal ($table, $param)
    {

        //*** テーブル情報を取得する ***//
        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }

        //*** 登録カラムデータを取得 ***//
        $sqlCol = "";
        $sqlVal = "";

        //*** カラム、値部分のSQLを作成 ***//
        foreach ($param as $n => $v) {
            // 文字列型とそれ以外の判定
            if ($v == null) {
                if (strlen($sqlCol) > 0) {
                    $sqlCol .= ",";
                    $sqlVal .= ",";
                }
                $sqlCol .= "`$n`";
                $sqlVal .= "NULL";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    if (strlen($sqlCol) > 0) {
                        $sqlCol .= ",";
                        $sqlVal .= ",";
                    }
                    $sqlCol .= "`$n`";
                    $sqlVal .= "'" . addslashes($v) . "'";
                } else {
                    if ($v !== '') {        // 数値は空白でないときにセット
                        if (strlen($sqlCol) > 0) {
                            $sqlCol .= ",";
                            $sqlVal .= ",";
                        }
                        $sqlCol .= $n;
                        $sqlVal .= $v;
                    }
                }
            }
        }

        //*** SQLを作成 ***//
        $sqlStr  = "";
        $sqlStr .= "          (";
        $sqlStr .= $sqlVal;
        $sqlStr .= "          )";

        return $sqlStr;
    }

    /**
     * InsertSQL作成処理
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @param     Array      $param  登録情報
     * @return    Array      テーブル構造情報
     */
    public static function InsertCol ($table, $param, $replace = "INSERT")
    {

        //*** テーブル情報を取得する ***//
        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }

        //*** 登録カラムデータを取得 ***//
        $sqlCol = "";

        //*** カラム、値部分のSQLを作成 ***//
        foreach ($param as $n => $v) {
            // 文字列型とそれ以外の判定
            if ($v == null) {
                if (strlen($sqlCol) > 0) {
                    $sqlCol .= ",";
                }
                $sqlCol .= "`$n`";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    if (strlen($sqlCol) > 0) {
                        $sqlCol .= ",";
                    }
                    $sqlCol .= "`$n`";
                } else {
                    if ($v !== '') {        // 数値は空白でないときにセット
                        if (strlen($sqlCol) > 0) {
                            $sqlCol .= ",";
                        }
                        $sqlCol .= $n;
                    }
                }
            }
        }

        //*** SQLを作成 ***//
        $sqlStr  = "";
        $sqlStr .= "{$replace} INTO `{$table}` ";
        $sqlStr .= "          (";
        $sqlStr .= $sqlCol;
        $sqlStr .= "          )";
        $sqlStr .= "     VALUES";

        return $sqlStr;
    }

    /**
     * 配列要素からUpdateクエリを作成する
     *
     * @access  public
     * @param   array    $table  テーブル名
     * @param   array    &$obj   フィールド名がキーの配列
     * @param   array    $wehre  WHERE条件文
     * @return  string
     */
    public static function Update( $table, &$obj, $where = '' ){
		if( ($def = SasFactor::CreateTableDefine($table) ) === false ){
			return false;
		}

		$ret = '';
		foreach( array_keys( $obj ) As $key  ){
			if( !array_key_exists( $key, $def->field_type ) ) continue;

			$val = addslashes( $obj[$key] );
			//文字列対応
			switch( strtolower($def->field_type[$key]) ){
				case 'char':
				case 'varchar':
				case 'text':
				case 'timestamp':
				case 'datetime':
					$val = "'".$val."'";
					break;
			}

			//フィールドセット
			if( strlen( $ret ) > 0 ) { $ret .= ", "; }
			$ret .= "{$key} = {$val}";
		}

		return "UPDATE {$table} SET {$ret} ".$where ;
    }
    //--------------------------------------------------------------------------

    /**
     * UpdateSQL作成処理
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @param     Array      $param  登録情報
     * @return    Array      テーブル構造情報
     */
    public static function UpdateKey ($table, $param, $key)
    {

        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }

        //*** 更新データ部のSQLを作成 ***//
        $sqlUpd = "";
        foreach ($param as $n => $v) {
            if ($v === null) {
                if (strlen($sqlUpd) > 0) {
                    $sqlUpd .= ",";
                }
                $sqlUpd .= "`{$n}` = NULL";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    if (strlen($sqlUpd) > 0) {
                        $sqlUpd .= ",";
                    }
                    $sqlUpd .= "`{$n}` = '" . addslashes($v) . "'";
                } else {
                    if ($v !== '') {
                        if (strlen($sqlUpd) > 0) {
                            $sqlUpd .= ",";
                        }
                        $sqlUpd .= "`{$n}` = {$v}";
                    }
                }
            }
        }

        //*** キー部のSQLを作成 ***//
        $sqlKey = "";
        foreach ($key as $n => $v) {
            if (strlen($sqlKey) > 0) {
                $sqlKey .= ' AND ';
            }
            if ($v === null) {
                $sqlKey .= "`{$n}` IS NULL";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    $sqlKey .= "`$n` = '{$v}'";
                } else {
                    $sqlKey .= "`{$n}` = {$v}";
                }
            }
        }

        //*** SQL文を作成 ***//
        $sqlStr = "";
        $sqlStr .= "UPDATE `{$table}` ";
        $sqlStr .= "   SET ";
        $sqlStr .= $sqlUpd;
        if (!is_empty($key)) {
            $sqlStr .= " WHERE ";
            $sqlStr .= $sqlKey;
        }

        return $sqlStr;
    }

    /**
     * UpdateSQL作成処理
     *
     * @access    public
     * @param     String     $db     データベース名
     * @param     String     $table  テーブル名
     * @param     Array      $param  登録情報
     * @return    Array      テーブル構造情報
     */
    public static function UpdateDbKey ($db, $table, $param, $key)
    {

        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }

        //*** 更新データ部のSQLを作成 ***//
        $sqlUpd = "";
        foreach ($param as $n => $v) {
            if ($v === null) {
                if (strlen($sqlUpd) > 0) {
                    $sqlUpd .= ",";
                }
                $sqlUpd .= "`{$db}`.`{$table}`.`{$n}` = NULL";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    if (strlen($sqlUpd) > 0) {
                        $sqlUpd .= ",";
                    }
                    $sqlUpd .= "`{$db}`.`{$table}`.`{$n}` = '" . addslashes($v) . "'";
                } else {
                    if ($v !== '') {
                        if (strlen($sqlUpd) > 0) {
                            $sqlUpd .= ",";
                        }
                        $sqlUpd .= "`{$db}`.`{$table}`.`{$n}` = {$v}";
                    }
                }
            }
        }

        //*** キー部のSQLを作成 ***//
        $sqlKey = "";
        foreach ($key as $n => $v) {
            if (strlen($sqlKey) > 0) {
                $sqlKey .= ' AND ';
            }
            if ($v === null) {
                $sqlKey .= "`{$db}`.`{$table}`.`{$n}` IS NULL";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    $sqlKey .= "`{$db}`.`{$table}`.`$n` = '{$v}'";
                } else {
                    $sqlKey .= "`{$db}`.`{$table}`.`{$n}` = {$v}";
                }
            }
        }

        //*** SQL文を作成 ***//
        $sqlStr = "";
        $sqlStr .= "UPDATE `{$db}`.`{$table}` ";
        $sqlStr .= "   SET ";
        $sqlStr .= $sqlUpd;
        if (!is_empty($key)) {
            $sqlStr .= " WHERE ";
            $sqlStr .= $sqlKey;
        }

        return $sqlStr;
    }

    /**
     * 配列要素からDeleteクエリを作成する
     *
     * @access  public
     * @param   array    $table  テーブル名
     * @param   array    &$obj   フィールド名がキーの配列
     * @param   array    $wehre  WHERE条件文
     * @return  string
     */
    public static function Delete( $table, &$obj, $where = '' ){
		if( ($def = SasFactor::CreateTableDefine($table) ) === false ){
			return false;
		}

		$ret = array();
		$cnt = 0;
		foreach( array_keys( $obj ) As $key  ){
			if( !array_key_exists( $key, $def->field_type ) ) continue;
			if( $def->field_type_key[$key] !== 'PRI' ) continue;

			$val = addslashes( $obj[$key] );
			//文字列対応
			switch( strtolower($def->field_type[$key]) ){
				case 'char':
				case 'varchar':
				case 'text':
				case 'timestamp':
				case 'datetime':
					$val = "'".$val."'";
					break;
			}

			//フィールドセット
			$ret[$cnt++] = "{$key} = {$val}";
		}

		if( strlen( $where ) == 0 ){
			$where = implode( ' AND ', $ret );
		}

		return "DELETE FROM {$table} WHERE ".$where;
    }
    //--------------------------------------------------------------------------
    /**
     * DeleteSQL作成処理
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @return    Array      テーブル構造情報
     */
    public static function DeleteKey ($table, $key)
    {

        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }

        //*** キー部のSQLを作成 ***//
        $sqlKey = "";
        $sqlUpd = "";
        foreach ($key as $n => $v) {
            if (strlen($sqlKey) > 0) {
                $sqlKey .= ' AND ';
            }
            if ($v === null) {
                $sqlKey .= "`{$n}` IS NULL";
            } else {
                if (preg_match('(^(char|varchar|timestamp|date|datetime|time|text).*)', $def->field_type[$n])) {
                    $sqlKey .= "`$n` = '{$v}'";
                } else {
                    $sqlKey .= "`{$n}` = {$v}";
                }
            }
        }

        //*** SQL文を作成 ***//
        $sqlStr  = "";
        $sqlStr .= "DELETE FROM `{$table}` ";
        if (!is_empty($key)) {
            $sqlStr .= " WHERE ";
            $sqlStr .= $sqlKey;
        }

        return $sqlStr;
    }

    /**
     * 配列要素からReplaceクエリを作成する
     *
     * @access  public
     * @param   array    $table  テーブル名
     * @param   array    &$obj   フィールド名がキーの配列
     * @return  string
     */
    public static function Replace($table, &$obj)
    {
        if (($def = SasFactor::CreateTableDefine($table)) === false) {
            return false;
        }

        $filed = '';
        $values = '';
        foreach (array_keys($obj) As $key) {
            if (!array_key_exists($key, $def->field_type))
                continue;

            $val = addslashes($obj[$key]);
            if (strlen($val) == 0)
                continue;

            //フィールドセット
            if (strlen($filed) == 0) {
                $filed .= "{$key}";
            } else {
                $filed .= ", {$key}";
            }
            //文字列対応
            switch (strtolower($def->field_type[$key])) {
                case 'varchar':
                case 'char':
                case 'text':
                case 'timestamp':
                case 'datetime':
                case 'date':
                case 'time':
                    $val = "'".$val."'";
                    break;
            }

            //Valuesセット
            if (strlen($values) == 0) {
                $values .= "{$val}";
            } else {
                $values .= ", {$val}";
            }
        }

        return "REPLACE INTO {$table} ( {$filed} ) VALUES ( {$values} ) ";
    }

	public static function Where( $table, &$obj, $option = '' ){
		if( ($def = SasFactor::CreateTableDefine($table) ) === false ){
			return false;
		}

		$where = array();
		foreach( array_keys( $obj ) As $key  ){
			if( !array_key_exists( $key, $def->field_type ) ) continue;

			$val = addslashes( $obj[$key] );
			//文字列対応
			switch( strtolower($def->field_type[$key]) ){
				case 'char':
				case 'varchar':
				case 'text':
				case 'timestamp':
				case 'datetime':
					$val = "'".$val."'";
					break;
			}

			//フィールドセット
			$where[] = "{$key} = {$val}";
		}

		if( count( $option ) > 0 ) $where = array_merge( $where, $option );
		$ret = '';
		if( count( $where ) > 0 ){
			$ret = 'WHERE '.implode( ' AND ', $ret );
		}
		return $ret;
	}
    //--------------------------------------------------------------------------
}
?>