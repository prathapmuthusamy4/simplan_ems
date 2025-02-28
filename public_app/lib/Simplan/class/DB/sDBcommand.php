<?php

/*
 * @package	Simplan.DB
 */
class sDBCommander{
    var $logger;

    function sDBCommand( $logger = NULL ){
        if( is_null( $logger ) )  $this->logger = new SystemLog();
        else $this->logger = $logger;
    }
    //--------------------------------------------------------------------------

    function Execute( $module, $command, $param = NULL) {
        $path = MANE_DIR.$module.DIRECTORY_SEPARATOR.$command.'.php';

        //ファイルの存在チェック
        if( file_exists( $path ) == false ) return false;

        require_once( $path );

        $obj = new $command ( $this->logger, $param );
        $ret = $obj->Execute();

        unset( $obj );

        return $ret;
    }
    //--------------------------------------------------------------------------
}
//------------------------------------------------------------------------------

?>
