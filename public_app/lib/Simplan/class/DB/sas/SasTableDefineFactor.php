<?php
include_once 'SasFunction.php';
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
class   SasTableDefineFactor{
    //--------------------------------------------------------------------------

    /**
     * テーブル定義オブジェクトの生成
     *
     * @access  public
     * @return  sas_TableDefine
     */
    public static function CreateDefObj( $table ){
        $objname = SasFunction::GetSasModName( $table ).'BasicsObject';
        $file = SAS_AUTO_OBJ_DIR.$objname.'.php';
		if( class_exists( $objname ) == false ) {
        	if( file_exists( $file ) == false ) return false; 
        	require_once( $file );
		}
        return new $objname();

    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------
?>
