<?php
include_once( 'WideDB.php' );

if( !defined( 'ETC_DIR' ) )
    define( 'ETC_DIR', dirname(__FILE__).'/../../../../etc/' );

class WideDB_SimplanInterface extends WideDB
{
    var $logger;
    function __construct( $logger ){
        parent::__construct();
        $this->logger = $logger;

        $conf = new SimplanIniReader(ETC_DIR . 'system.ini');
        parent::setConf( $conf );
        if( !parent::Connect() ) $this->ErrProc();
        parent::Ready();
    }

    function ErrProc(){
        echo 'bbb';exit;
        // echo "err no : ".$this->commander->GetError()."\n";
        // echo "err msg: ".$this->commander->GetErrorMsg()."\n";
        exit;
    }

    function QueryExecute( $query, $type = 0 ){
        $ret = parent::QueryExecute( $query, $type );
        $this->logger->debug(
            get_class( $this)."::QueryExecute >>".$this->sql
        );
        if( $ret === false ){
            $msg = get_class( $this)."::QueryExecute >>".$this->sql."\n";
            if( isset( $this->except ) ) $msg .= $this->except->GetMsg();
            $this->logger->error( $msg );
        }
        return $ret;
    }

    function GetInsertID(){
        if( !$this->command ) return false;
        return $this->command->GetID();
    }

    function GetAutoIncrement($table)
    {
        if (!$this->command) return false;
        return $this->command->GetAutoIncrement($table);
    }

    function AlterAutoIncrement($table, $id)
    {
        if (!$this->command) return false;
        return $this->command->AlterAutoIncrement($table, $id);
    }

    function get_mysql_version()
    {
        if (!$this->command) return false;
        return $this->command->get_mysql_version();
    }

}
?>
