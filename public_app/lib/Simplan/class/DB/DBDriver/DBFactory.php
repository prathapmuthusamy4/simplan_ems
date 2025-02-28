<?php
include_once( DBD_DIR . 'Commander.php');
include_once( DBD_DIR . 'Connector.php');

/**
 * ＤＢクラス生成クラス
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB
 * @version    1.0
 */
class DBFactory
{
    /**
     * @access  protected
     * @var array
     */
    var $db_conf;

    /**
     * コンストラクタ
     * @access  public
     */
    function DBFactory()
    {
        $reader = new SimplanIniReader(ETC_DIR . "system.ini");

        $this->db_conf['DB_TYPE'] = $reader->getValue('DB', 'db_type');
        $this->db_conf['DB_HOST'] = $reader->getValue('DB', 'db_host');
        $this->db_conf['DB_PORT'] = $reader->getValue('DB', 'db_port');
        $this->db_conf['DB_NAME'] = $reader->getValue('DB', 'db_name');
        $this->db_conf['DB_USER'] = $reader->getValue('DB', 'db_user');
        $this->db_conf['DB_PASS'] = $reader->getValue('DB', 'db_pass');
    }

    /**
     * Connectorの生成
     * @access  public
     * @return  Connector
     */
    function CreateConnector()
    {
        return new Connector( $this->db_conf );
    }

    /**
     * Commanderの生成
     * @access  public
     * @return  Commander
     */
    function CreateCommander( $con )
    {
        return new Commander( $this->db_conf, $con );
    }

}

?>
