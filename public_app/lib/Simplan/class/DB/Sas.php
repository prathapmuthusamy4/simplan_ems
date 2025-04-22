<?php

/*
 * Sasクラスディレクトリのパス
 */
define( 'SAS_CLASS_DIR', dirname(__FILE__). '/sas/' );

/*
 * Sas自動生成ファイルのパス
 */
define( 'SAS_AUTO_OBJ_DIR', SAS_DIR.'basics'.'/' );
/*
 * Sas Basicsクラスのパス
 */
define( 'SAS_BAS_DIR', SAS_DIR.'basics'.'/' );
/*
 * Sas コマンドクラスのパス
 */
define( 'SAS_COMMAND_DIR', SAS_DIR.'manager'.'/' );
/*
 * Sas のmanagerディレクトリのパス
 */
define( 'SAS_MANA_DIR', SAS_DIR.'manager'.'/' );
/*
 * Sas オペレーターディレクトリのパス
 */
define( 'SAS_OPE_DIR', SAS_DIR.'operator'.'/' );

/*
 * 
 */
include_once SAS_CLASS_DIR.'SasFunction.php';
/*
 *
 */
include_once SAS_CLASS_DIR.'SasFactor.php';
/*
 *
 */
include_once SAS_CLASS_DIR.'SasAutoSQL.php';
/*
 *
 */
include_once SAS_CLASS_DIR.'SasException.php';

/*
 *
 */
include_once SAS_CLASS_DIR.'HandQuery.php';
/**
 * Sasクラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class Sas extends SasFactor{
    /*
     * loggerハンドル
     * @var SystemLog
     */
    var $logger;
   /*
    * エラーハンドル
    * @var  resource
    */  
    var $err_handle;

    /**
     * コンストラクタ
     *
     * @access  public
     */
    function Sas( &$logger ){
        if( is_null( $logger ) ) $this->logger = new SystemLog();
        else $this->logger = $logger;

        $this->err_handle = NULL;
    }
    //--------------------------------------------------------------------------

    /**
     * SasSelect/SasInsert/SasDelete/SasUpdate オブジェクトからSQLを生成する
     *
     * @access  public
     * @return  string
     */
    function AutoSQL( &$object ){
        return SasAutoSQL::Build( $object );
    }
    //--------------------------------------------------------------------------

    /**
     * 例外処理クラスを登録する
     * @access  public
     * @param   resource    &$obj   例外処理クラスオブジェクト
     * @param   string      $func   $objのメンバ関数名
     * @return  void
     */
    function SetErrHandle( &$obj, $func ){
        $this->err_handle = array( get_class( $obj ), $func );
    }
    //--------------------------------------------------------------------------

    /**
     * 例外処理クラスを登録する
     * @access  protected
     * @param   mixed   $val    例外判定オブジェクト
     * @return  mixed
     */
    function Except( $val ){
        //例外オブジェクで出なければ処理をしない
        $name = get_class( $val );
        if( $name != 'SasException' ) return $val;

        //例外クラスがセットされていれば例外処理を任せる
        if( !is_null( $this->err_handle ) ){

            //例外処理関数がfalseを返したらログを出力する
            call_user_func( $this->err_handle );

            if( $ret == false ){
                $this->logger->errlog( $val->GetMsg() );
            }
            return $ret;
        } else {
            //Sasの例外処理を実行
            $this->logger->errlog( $val->GetMsg() );
            echo $val->GetMsg();
        }
        return $val;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------
//
?>
