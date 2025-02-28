<?php

define( 'REC_TYPE_ONE',     0 );
define( 'REC_TYPE_ROWS',    1 );
define( 'EXEC_TYPE_NOMAL',  0 );
define( 'EXEC_TYPE_TRAN',   1 );

/**
 *  コマンド基底クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */
class AbstractCommand extends Smarty
{

    //*** 変数 ***//
    var $logger;            // システムロガー
    var $sdb;               // DBコネクション
    var $param = array();   // SQLパラメータ
    var $dbRes;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     Object   $logger   (SystemLog)システムロガー
     * @param     Object   $sdb      (sDB)DB
     */
    function __construct(&$logger, &$sdb)
    {
        $this->logger = $logger;
        $this->sdb = $sdb;

        //Smartyコンストラクタ
        parent::__construct();

        $this->template_dir = SQL_DISP_DIR;
        $this->compile_dir = SQL_TMP_DIR.'/';
        $this->cache_dir = SQL_TMP_DIR;
        $this->compile_id = md5($this->template_dir);

        $this->plugins_dir = array(
                                'plugins',
                                SIMPLAN_BASE.'/class/SmartyPlugins'
                            );

        $this->assign('common', $this->getSmartyCommon());
    }

    /**
     * Smarty取得 抽象メソッド
     *
     * @access    abstract
     */
    function getSmartyCommon()
    {
        return array();
    }

    /**
    * Smartyプラグイン処理
    *
    * @access    abstract
    * @param     String     $path  プラグインパス
    */
    function setSmartyPlugins( $path )
    {
        $this->plugins_dir[] = $path;
    }

    /**
     * SQL取得
     *
     * @access    public
     * @param     String   $key   キー
     * @return    String   取得SQL文
     */
    function getSql( $sql )
    {
        if( count( $this->param ) > 0 ) {
            $this->assign('param', $this->param);
        }
        $this->load_filter('output', 'strip');
        return $this->fetch( $sql );
    }

    /**
     * テーブル情報取得
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @return    Array      テーブル構造情報
     */
    function getTableInfo ( $table )
    {
        //*** テーブル情報取得SQL作成 ***//
        $sqlStr = "SHOW COLUMNS FROM $table";

        //*** SQL実行 ***//
        $rsltSet = $this->executeSql($sqlStr);

        //*** テーブル情報の設定 ***//
        for ($idx = 0; $idx < mysql_num_rows($rsltSet); $idx++) {
            $data = mysql_fetch_array($rsltSet);
            // set
            foreach($data as $k => $v) {
                $tbl[$data['Field']] = $data['Type'];
            }
        }
        return $tbl;
    }

    /**
     * InsertSQL作成処理
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @param     Array      $param  登録情報
     * @return    Array      テーブル構造情報
     */
    function makeInsertSql ($table, $param)
    {
        return HandQuery::Insert( $table, $param);
    }

    /**
     * UpdateSQL作成処理
     *
     * @access    public
     * @param     String     $table  テーブル名
     * @param     Array      $param  登録情報
     * @return    Array      テーブル構造情報
     */
    function makeUpdateSql ($table, $param )
    {
        return HandQuery::Update( $table, $param );
    }

    /**
     * SQLパラメータ設定処理
     *
     * @access    public
     * @param     String     $idx  SQLプロパティファイルキー
     * @param     String     $val  SQLキー
     */
    function setSqlParam ($idx, $val)
    {
        $this->param[$idx] = $val;
    }

    /**
     * SQLパラメータのクリア処理
     *
     * @access    public
     */
    function clearParam() {
        $this->param = array();
    }

    /**
     * バインドエンジンを使用して実行する場合
     * @access    public
     * @param     String     $param SQL文
     * @return    ResultSet  実行結果
     */
    function executeSql($sql, $type = REC_TYPE_ONE )
    {
        $sql .= '.sql';
        $path = $this->template_dir.$sql ;
        if( !file_exists( $path ) ){
            $msg = "SimplanAbstractProcess::execCommand -> AbstractCommand::execSql".
                " > {$path} is not found.";
            $this->logger->error( $msg );
            trigger_error( $msg, E_USER_ERROR );
            return false;
        }

        $this->logger->info(
            "SimplanAbstractProcess::execCommand -> ".
            "AbstractCommand::executeProcess > [ {$sql} ]"
        );

        $ret = NULL;
        if( ($ret = $this->execQuery($this->getSql($sql), $type, true) ) === false){
            $msg = "SimplanAbstractProcess::execCommand -> ".
                "AbstractCommand::executeProcess ".
                "{$sql}.sql is  error.\n".$this->sdb->except->GetMsg();
            $this->logger->error( $msg );
            trigger_error( $msg, E_USER_ERROR );
            return false;
        }
        return $ret;
    }

    /**
     * SQL単独で実行する場合
     * @access    public
     * @param     String     $query SQL文
     * @return    ResultSet  実行結果
     */
    function execQuery( $query, $type, $flg = false )
    {
        $time_start = microtime(true);
        // print_r($this->sdb);exit;

        $ret = $this->sdb->QueryExecute( $query, $type );
        $time_end = microtime(true);
        $this->logger->info("execQuery TIME : " . number_format($time_end - $time_start, 5) . " second");
        if( $ret === false ){
            if( $flg ) return false;

            $msg = "execQuery > Query is  error.\n".
                $this->sdb->except->GetMsg();
            $this->logger->error( $msg );
            trigger_error( $msg, E_USER_ERROR );
            return false;
        }
        return $ret;
    }

}
?>