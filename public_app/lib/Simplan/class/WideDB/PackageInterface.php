<?php
include_once( 'WideDB.php' );

if( !defined( 'ETC_DIR' ) )
    define( 'ETC_DIR', dirname(__FILE__).'/../../../../etc/' );

class WideDB_PackageInterface extends WideDB
{
    function WideDB_PackageInterface(){
        parent::WideDB();

        $conf = new SimplanIniReader(ETC_DIR . 'system.ini');
        parent::setConf( $conf );
        if( !parent::Connect() ) $this->ErrProc();
        parent::Ready();
    }

    function ErrProc(){
        echo "err no : ".$this->commander->GetError()."\n";
        echo "err msg: ".$this->commander->GetErrorMsg()."\n";
        exit;
    }


}
?>
