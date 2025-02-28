<?php
include_once 'SasException.php';
include_once 'SasFactor.php';

/**
 * クエリ自動生成クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0
 */
class SasAutoSQL {

    /**
     * コンストラクタ(singleton)
     *
     * @access  protected
     */
    function SasAutoSQL(){
    }
    //--------------------------------------------------------------------------

    /**
     * SasCommandオブジェクトからSQL文を生成する
     *
     * @access  public
     * @return  string
     */
    function Build( &$obj ){
        $type = get_class( $obj );
        $ret = null;
        switch( $type ){
            case 'SasSelect':
                $ret = SasAutoSQL::SelectMake( $obj );
                break;

            case 'SasInsert':
                $ret = SasAutoSQL::InsertMake( $obj );
                break;

            case 'SasUpdate':
                $ret = SasAutoSQL::UpdateMake( $obj );
                break;

            case 'SasDelete':
                $ret = SasAutoSQL::DeleteMake( $obj );
                break;

            default:
                return false;
        }

        return $ret;
    }
    //--------------------------------------------------------------------------

    /**
     * セレクト文の構築
     *
     * @access  protected
     * @return  string
     */
    function SelectMake( &$obj ){
        $str = 'SELECT ';
        $ret = SasAutoSQL::GetSelectFieldsSQL( $obj->def );
        //エラー処理
        if( SasException::is_Except( $ret ) ) return $ret;
        $str.= $ret;

        $str.= 'FROM '.$obj->table.' ';

        if( !is_null( $obj->where ) ) {
            if( !$obj->where->_Empty() ) {
                $ret = SasAutoSQL::GetWhereSQL( $obj->where, $obj->def );
                //エラー処理
                if( SasException::is_Except( $ret ) ) return $ret;
                $str .= $ret;
            }
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * インサート文の構築
     *
     * @access  protected
     * @return  string
     */
    function InsertMake( &$obj ){
        $str = 'INSERT INTO '.$obj->table." (\n";

        $ret = SasAutoSQL::GetInsertValueFieldsSQL( $obj->value, $obj->def );

        //エラー処理
        if( SasException::is_Except( $ret ) ) return $ret;
        $str .= $ret;

        $str.= ') Values ';

        $ret = '';
        switch( get_class( $obj->value ) ) {
            case 'SasFields':
                $ret.= SasAutoSQL::GetInsertValueSQL($obj->value, $obj->def);
                break;

            case 'SasSelect':
                $ret.= SasAutoSQL::GetSelectMake( $obj->value );
                break;
        }

        //エラー処理
        if( SasException::is_Except( $ret ) ) return $ret;

        $str .= $ret;

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * アップデート文の構築
     *
     * @access  protected
     * @return  string
     */
    function UpdateMake( &$obj ){
        $str = 'UPDATE '.$obj->table.' SET ';

        $ret = SasAutoSQL::GetUpdateFielsSQL( $obj->value, $obj->def );
            //エラー処理
            if( SasException::is_Except( $ret ) ) return $ret;
        $str .= $ret;

        if( !is_null( $obj->where ) ){
            if( !$obj->where->_Empty() ){
                $ret = SasAutoSQL::GetWhereSQL( $obj->where, $obj->def );
                //エラー処理
                if( SasException::is_Except( $ret ) ) return $ret;
                $str .= $ret;
            }
        }

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * デリーと文の構築
     *
     * @access  protected
     * @return  string
     */
    function DeleteMake( &$obj ){
        $str = 'DELETE FROM '.$obj->table.' ';

        if( !is_null( $obj->where ) ){
            if( !$obj->where->_Empty() ){
                $ret = SasAutoSQL::GetWhereSQL( $obj->where, $obj->def );
                //エラー処理
                if( SasException::is_Except( $ret ) ) return $ret;
                $str .= $ret;
            }
        }

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * セレクト文抽出フィールド文の作成
     *
     * @access  protected
     * @return  string
     */
    function GetSelectFieldsSQL( &$def ){
        $str = ' ';

        $fields = $def->field_name;
        $len = count( $fields );

		//$str .= implode( ' , ', $fields ).' ';
		$str .= "\n\t".implode( ",\n\t", $fields )."\n";

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * インサート文のフィールド文の作成
     *
     * @access  protected
     * @return  string
     */
    function GetInsertValueFieldsSQL( &$val, &$def ){
        $str = '';
        $keys = array_keys( $val->fields );
        $len = count( $val->fields );
        $tmp = array();
        $line = 0;

        for( $n = 0; $n < $len; $n ++ ) {
            $name = $keys[$n];
            //フィールドに値があるもののみ抽出する
            if( !is_null( $val->fields[$name] )
                    || strlen( $val->fields[$name] ) > 0 ) {
                //フィールドに値がある場合
                $tmp[$line++] = $name;
            } else {
                //フィールドに値が無い場合
                //必須項目チェック
                if( strtoupper($def->field_null[$name]) == 'NO' ){
                    //項目がNULLを許可しない
                    return new SasException( 'SasAutoSQL',
                        "GetInsertValueFieldSQL():: '".$def->table."' ".
                        " has Field '$name' is Not NULL type.".
                        " it did not have value."
                    );
                }
            }
        }

		$str = "\t".implode( ",\n\t" ,$tmp)."\n";

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * インサート文のValue句の作成
     *
     * @access  protected
     * @return  string
    **/
    function GetInsertValueSQL( &$val, &$def ){
        $str = "(\n";
        $keys = array_keys( $val->fields );
        $len = count( $val->fields );
        $tmp = array();
        $line = 0;

        for( $n = 0; $n < $len; $n ++ ) {
            $name = $keys[$n];
            //フィールドに値があるもののみ抽出する
			if( !is_null( $val->fields[$name] ) ||
				strlen( $val->fields[$name] ) > 0
		   	) {
                //シングルクォート処理
				$tmp[$line++] =
					SasAutoSQL::Decorated( $name, $name, $def );
            }
        }

		$str .= "\t".implode( ",\n\t", $tmp )."\n)";
        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * アップデート文のSet句の作成
     *
     * @access  protected
     * @return  string
     */
    function GetUpdateFielsSQL( $val, $def ){
        $str = '';
        $keys = array_keys( $val->fields );
        $len = count( $val->fields );
        $tmp = array();

        //フィールドに値があるもののみ抽出する
        for( $n = 0; $n < $len; $n ++ ) {
            $name = $keys[$n];

            if( !is_null( $val->fields[$name] )
                    || strlen( $val->fields[$name] ) > 0 ) {
                //シングルクォート処理
                $tmp[$name] = SasAutoSQL::Decorated(
                        $val->fields[$name], $name, $def );
            }
        }

        $keys = array_keys( $tmp );
        $len = count( $tmp );
        for( $n = 0; $n < $len; $n ++ ){
            $name = $keys[$n];

            $str .= $name.' = '.$tmp[$name];

            if( $n + 1 < $len ) $str.= ', ';
            else $str .= ' ';
        }

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * 条件文の作成
     *
     * @access  protected
     * @return  string
     */
    function GetWhereSQL( &$where, &$def ){
        $str = "\nWHERE ";
        $ports = array();

        for( $n = 0; $n < $where->object_num; $n ++ ){
            $keys = array_keys( $where->object[$n] );
            $key = $keys[0];
            $ports[$n] = SasAutoSQL::WhereObjectAssemble(
                                $key, $where->object[$n][$key], $def );
        }

        $len = count( $ports );
        if( $len == 0 ) return '';

        for( $n = 0; $n < $len; $n ++ ){
            $str.= $ports[$n].' ';
            if( $n + 1 < $len ) $str.= $where->operator.' ';
        }

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * 条件式の構築
     *
     * @access  protected
     * @return  string
     */
    function WhereObjectAssemble( &$code, &$node, &$def ){
        $str = '( ';
        $keys = array_keys( $node->fields );
        $len = count( $keys );
        $tmp = array();
        $line = 0;

        for( $n = 0; $n < $len; $n ++ ){
            $name = $keys[$n];
            if( !$node->EmptyRow( $name ) ) {
                $ope = $node->fields[$name]['operation'];
                //シングルクォート付加処理
                $val = SasAutoSQL::Decorated(
                        $node->fields[$name]['value'], $name, $def );

                //再帰的処理
				if( is_object( $ope ) ){
	                if( get_class( $ope ) == 'SasWhereFields' ){
						$tmp[$line++] =
							SasAutoSQL::WhereObjectAssemble( $val, $ope, $def );
					} else {
						$tmp[$line++] = "$name ".$ope." $val ";
					}
				}
            }
        }

        $len = count( $tmp );

        if( $len == 0 ) return '';

        if( $len == 1 ) {
            $str.= $tmp[0] . ' )'; 
            return $str;
        }

        for( $n = 0; $n < $len; $n ++ ){
            $str .= $tmp[$n].' ';
            if( $n + 1 < $len ) $str .= $code.' ';
        }

        $str.= ') ';

        return $str;
    }
    //--------------------------------------------------------------------------

    /**
     * シングルコート付加
     *
     * @access  protected
     * @return  string
     */
    function Decorated( $value, &$key, &$def ){
        switch( strtoupper($def->field_type[$key]) ){
            case 'CHAR' :
            case 'VARCHAR' :
            case 'TIME' :
            case 'DATE' :
            case 'TIMESTAMP' :
                return '{'.$value.':NVL_STRING}';

            case 'INT':
            case 'SMALLINT':
            case 'DOUBLE':
            case 'FLOAT':
                //英字チェック?
                break;
        }
        return '{'.$value.':NVL}';
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
