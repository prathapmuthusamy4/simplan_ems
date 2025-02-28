<?php
include_once( 'command_define.php' );
include_once( LIB_DIR.'Smarty/Smarty.class.php' );

class cSmarty extends Smarty{
    function cSmarty(){

        //Smartyコンストラクタ
        parent::Smarty();

        $this->template_dir = SKL_DIR;
        $this->compile_dir = TMP_DIR;
        $this->cache_dir = TMP_DIR;
        $this->compile_id = md5($this->template_dir);
        $this->plugins_dir = array( 'plugins', dirname(__FILE__).'/plugins');
    }
    //--------------------------------------------------------------------------
    
    function putFile( $filename, $disp ){
        file_put_contents( $filename, $this->fetch( $disp ) );
    }
    //--------------------------------------------------------------------------
}
?>
