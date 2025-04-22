<?php
define('EXECUTE_TYPE_NORMAL', 0x00 );
define('EXECUTE_TYPE_TRAN',   0x01 );
define('RECODE_TYPE_NORMAL',  0x00 );
define('RECODE_TYPE_LIST',    0x02 );
/**
 *  WideDB
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    
 */
class WideDB
{
    var $conf;
    var $connect;
    var $command;
    var $except;
    var $sql;

    /**
     * コンストラクタ
     *
     * @access    public
     */
    function __construct()
    {
        /* コネクション */
        $this->connect = NULL;
        /* コマンド */
        $this->command = NULL;
        // default
        // $this->conf['TYPE'] = 'mysql';
        $this->conf['TYPE'] = 'mysql';

        $this->conf['HOST'] = 'localhost';
        $this->conf['PORT'] = '3360';
        // $this->conf['PORT'] = '';

        $this->conf['NAME'] = 'mysql';
        $this->conf['USER'] = 'mysql';
        $this->conf['PASS'] = 'mysql';
    }

    function setConf($conf)
    {
        // db_type
        $this->conf['TYPE'] = $conf->getValue('DB', 'db_type');
        // db_host
        $this->conf['HOST'] = $conf->getValue('DB', 'db_host');
        // db_port
        $this->conf['PORT'] = $conf->getValue('DB', 'db_port');
        // db_name
        $this->conf['NAME'] = $conf->getValue('DB', 'db_name');
        // db_user
        $this->conf['USER'] = $conf->getValue('DB', 'db_user');
        // db_pass
        $this->conf['PASS'] = $conf->getValue('DB', 'db_pass');

    }

    function Connect()
    {
        $path = dirname(__FILE__) . '/driver/' . strtolower($this->conf['TYPE']) .'/';
//         echo 'ma';
// print_r($this->conf['TYPE']);exit;
        // connect
        $name = $this->getName($this->conf['TYPE'], 'connector');
        if ($name === false) return false;
        include_once($path . $name. '.php');
        $this->connect = new $name($this->conf);
        $this->connect->Connect();

        // command
        $name = $this->getName($this->conf['TYPE'], 'commander');
        if ($name === false) {
            $this->connect = NULL;
            return false;
        }
        include_once($path . $name. '.php');
        $con = $this->connect->Get();
        $this->command = new $name($this->conf, $con);

        return true;
    }

    function DisConnect()
    {
        // check
        if (is_null($this->connect)) return true;
        if (!$this->connect->DisConnect()) return false;

        // disconnect
        $this->command = NULL;
        $this->connect = NULL;

        return true;
    }

    function TableLock($table)
    {
        return $this->command->TableLock($table);
    }

    function TableUnLock()
    {
        return $this->command->TableUnLock();
    }

    function Begin()
    {
        return $this->command->Begin();
    }

    function Commit()
    {
        return $this->command->Commit();
    }

    function RollBack()
    {
        return $this->command->RollBack();
    }

    function getCommander()
    {
        return $this->command;
    }

    function isReady()
    {
        // check
        if (is_null($this->connect)) return -1;
        if (is_null($this->command)) return -10;
        return true;
    }

    function Ready()
    {
        if($this->isReady() < 0) {
            $this->Connect();
        }
        return true;
    }

    function WideException($exp)
    {
        if (is_object($exp)) {
            if (get_class($exp) == 'WideDbException') {
                $this->except = $exp;
                return false;
            }
        }
        return $exp;
    }

    function getName($type, $name)
    {
        $ini  = parse_ini_file('WideDB.ini', true);
        $type = strtolower($this->conf['TYPE']);
        // check
        if (!array_key_exists($type, $ini))        return false;
        if (!array_key_exists($name, $ini[$type])) return false;

        return $ini[$type][$name];
    }

    function QueryExecute($query, $type = 0)
    {
        $sql = '';
        $this->except = NULL;
        if (is_object($query)) {
            switch (get_class($query)) {
                case 'Query':
                case 'WideQuery':
                    $sql = $query->GetSQL();
                    break;
                default:
                    $sql = $query;
                    break;
            }
        } else {
            $sql = $query;
        }

        $this->sql = $sql;
        if (($type & EXECUTE_TYPE_TRAN)) $this->command->Begin();

        $res = $this->command->QueryExecute($sql);

        //例外処理
        if (!$this->WideException($res)) {
            $this->except = $res;
            if($type & EXECUTE_TYPE_TRAN) $this->command->Rollback();
            return false;
        }

        //トランザクションの処理
        if ($res === false) {
            if ($type & EXECUTE_TYPE_TRAN) {
                $this->command->Rollback();
            }
        } else if ($res === true) {
            if ($type & EXECUTE_TYPE_TRAN) $this->command->Commit();
            return true;
        }

        if($res->GetRowNum() == 0) return array();

        $res->RecResult((($type & RECODE_TYPE_LIST) >> 1));
        return $res->GetResult();
    }

}
?>