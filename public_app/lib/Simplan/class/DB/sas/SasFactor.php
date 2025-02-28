<?php

include_once    'SasTableDefineFactor.php';
include_once    'SasDelete.php';
include_once    'SasFields.php';
include_once    'SasInsert.php';
include_once    'SasSelect.php';
include_once    'SasUpdate.php';
include_once    'SasWhere.php';
include_once    'SasWhereFields.php';


/**
 * 定義情報関連生成クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0.1
 * @create date 2009/3/2
 */
class   SasFactor extends SasTableDefineFactor{

    /**
     * テーブルフィールド名の連想配列の生成
     *
     * @access  public
     * @return  array
     */
    public static function CreateTableDefine( $tablename ){
        return parent::CreateDefObj( $tablename );
    }
    //--------------------------------------------------------------------------

    /**
     * テーブルフィールド名の連想配列の生成
     *
     * @access  public
     * @return  array
     */
    public static function CreateFieldsArray( $tablename ){
        if( !($obj = parent::CreateDefObj($tablename) ) ) return false;
        return $obj->fields;
    }
    //--------------------------------------------------------------------------

    /**
     * フィールドオブジェクトの生成
     *
     * @access  public
     * @return  SasFields
     */
    public static function CreateFields( $tablename ){

        if( ($obj = parent::CreateDefObj($tablename) ) == false ) return false;
        return new SasFields( $obj );
    }
    //--------------------------------------------------------------------------

    /**
     * 条件オブジェクトの生成
     *
     * @access  public
     * @return  SasWhere
     */
    public static function CreateWhere(){
        return new SasWhere();
    }
    //--------------------------------------------------------------------------

    /**
     * 条件フィールドオブジェクトの生成
     *
     * @access  public
     * @return  SasWhere
     */
    public static function CreateWhereFields( $tablename ){
        if( !($obj = parent::CreateDefObj($tablename) ) ) return false;
        return new SasWhereFields( $tablename, $obj );
    }
    //--------------------------------------------------------------------------


    /**
     * セレクトオブジェクトの生成
     *
     * @access  public
     * @return  SasSelect
     */
    public static function CreateSelect( $tablename ){
        if( !($obj = parent::CreateDefObj($tablename) ) ) return false;
        return new SasSelect( $tablename, $obj );
    }
    //--------------------------------------------------------------------------

	/**
     * セレクトオブジェクトの生成
     *
     * @access  public
     * @return  SasSelect
     */
	public static function CreateSelectOne( $tablename ){
		$sobj = SasFactor::CreateSelect( $tablename );
	}
    //--------------------------------------------------------------------------

    /**
     * インサートオブジェクトの生成
     *
     * @access  public
     * @return  SasInsert
     */
    public static function CreateInsert( $tablename ){
        if( !($obj = parent::CreateDefObj($tablename) ) ) return false;
        return new SasInsert( $tablename, $obj );
    }
    //--------------------------------------------------------------------------

    /**
     * アップデートオブジェクトとの生成
     *
     * @access  public
     * @return  SasUpdate
     */
    public static function CreateUpdate( $tablename ){
        if( !($obj = parent::CreateDefObj($tablename) ) ) return false;
        return new SasUpdate( $tablename, $obj,
                        SasFactor::CreateFields( $tablename ),
                        SasFactor::CreateWhere()
                    );
    }
    //--------------------------------------------------------------------------

    /**
     * デリートオブジェクトの生成
     *
     * @access  public
     * @return  SasDelete
     */
    public static function CreateDelete( $tablename ){
        if( !($obj = parent::CreateDefObj($tablename) ) ) return false;
        return new SasDelete( $tablename, $obj,
                                SasFactor::CreateWhere() );
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------
?>
