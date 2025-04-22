<?php
/**
 *  indexCommon.php
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
include_once(MOD_DIR . "/customermod.php");
class indexCommon extends userProcess
{
    var $error_info;
    var $table_name;
    var $app_name;
    var $check_file;
    var $page_record;
    var $master;

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     object   ロガー
     */
    function indexCommon($logger)
    {
        parent::userProcess($logger);
        $this->app_name    = $this->getMessage("SITE", "site_user_index_title");
        $this->master      = new MasterCommand($this);
        $this->check_file  = "input.check";
        $this->error_info  = array(
                                  "pg_name"   => get_class($this),
                                  "func_name" => "",
                                  "msg"       => "",
                                 );
    }

    /**
     * remindCheck
     *  入力チェック
     *
     * @access    public
     * @param     array   $input
     * @param     array   $param
     * @return    bool
     */
    function remindCheck($input, &$param)
    {
        $errList = parent::checkInput("remind.check", $input);

        if(sizeof($errList) > 0) {
            $success = false;
            foreach ($errList as $key => $value) {
                $param["errmsg"][$key] = $value;
            }
            return false;
        }
        return true;
    }

    /**
     * エラーページ設定
     *
     * @access    public
     * @param     string   $msg メッセージ
     */
    function errorPage($msg)
    {
        // object
        $error = $this->getErrorObject();
        // set
        $error->setContent($this->app_name);
        $error->setMessage($msg);
        $error->setUrl("index.php");
        $error->setProcess("");
        $error->setCmd("");
        $error->setName($this->app_name);
        // 表示
        $error->forwardPage();

        return;
    }
}
?>