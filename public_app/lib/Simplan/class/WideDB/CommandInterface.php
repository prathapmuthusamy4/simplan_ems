<?php
include_once( 'WideDB.php' );
include_once( 'WideDBLogger.php' );

if( !defined( 'ETC_DIR' ) )
    define( 'ETC_DIR', dirname(__FILE__).'/../../../../etc/' );

class WideDB_CommandInterface extends WideDB
{
    var $logger;
    function WideDB_CommandInterface()
    {
        parent::WideDB();

        $conf = new SimplanIniReader(ETC_DIR . 'system.ini');
        parent::setConf( $conf );
        if( !parent::Connect() ) $this->ErrProc();
        parent::Ready();
    }

    function ErrProc()
    {
        echo "err no : ".$this->commander->GetError()."\n";
        echo "err msg: ".$this->commander->GetErrorMsg()."\n";
        exit;
    }

    function QueryExecute( $query, $type = 0 )
    {
        $ret = parent::QueryExecute( $query, $type );
        if( $ret === false ){
            $msg = get_class( $this)."::QueryExecute >>".$this->sql."\n";
            if( isset( $this->except ) ) $msg .= $this->except->GetMsg();
            echo $msg;
        }
        return $ret;
    }
}

?>
