<?php
include_once(dirname(dirname(__FILE__)) . '/WideConnector.php');
/**
 * MySQLConnect
 *
 * @link
 * @author
 * @license
 * @package    Simplan.DB
 * @version    1.0
 */

class MySQLConnect extends WideConnector
{
    /**
     * コンストラクタ
     *
     * @access  public
     * @param   array    $db_info
     */
    function __construct($db_info)
    {
        parent::__construct($db_info);
        $this->adapte_type = 'mysql';
    }

    /**
     * Connect
     *
     * @access  public
     * @return  bool
     */
    function Connect()
    {
        // exist
        if (!is_NULL($this->con)) {
            return true;
            //return new DbException($this,'Connect()::it was done two times.');
        }
        // connetct
        // echo 'nanba';
        // print_r($this->conf);exit;
        $this->con = mysqli_connect($this->conf["HOST"], $this->conf["USER"], $this->conf["PASS"], $this->conf["NAME"]);
        if (mysqli_connect_errno() > 0) {
            return new WideDbException($this, 'Connect()::Connecting done');
        }
        mysqli_set_charset($this->con, "utf8");
        return true;
    }

    /**
     * DisConnect
     *
     * @access  public
     * @return  void
     */
    function DisConnect()
    {
        // disconnect
        mysqli_close($this->con);
        $this->con = NULL;
    }

    /**
     * Get
     *
     * @access  public
     * @return  resource
     */
    function Get()
    {
        // get resource
        return $this->con;
    }
}
?>