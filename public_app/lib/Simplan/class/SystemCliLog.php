<?php
/**
 * SystemCliLog Class
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan.mod.common
 * @version    1.0
 */
class SystemCliLog extends SystemLog
{

    /**
     * コンストラクタ
     *
     * @access    public
     * @param     none
     * @return    none
     */
    function SystemCliLog()
    {
        //*** システムプロパティよりログ設定取得 ***//
        $reader = new SimplanIniReader(ETC_DIR . "system.ini");

        $this->level = $reader->getValue('LOG',  'cli_log_level');
        $this->fSize = $reader->getValue('LOG',  'cli_log_file_size');
        $this->fName = $reader->getValue('LOG',  'cli_log_file_name');
        $this->backup = $reader->getValue('LOG', 'cli_log_backup');
        $this->format = $reader->getValue('LOG', 'cli_log_format');

    }

    /**
     * メールログを出力する
     *
     * @access  public
     * @param   array   $param
     * @param   string  $kbn 
     */
    function writeMailLog($param, $kbn = "-")
    {
        // ログ出力
        $path = LOG_DIR . 'mail/cli_mail_' . date('Ymd') . '.log';
        $fp   = fopen($path, 'a+');

        // ログ情報の生成
        $info = $this->make_log_info($kbn);

        // ログ出力用にデータを変換
        $ret = $this->make_maillog_format($param);

        $log = $info . $ret;

        fwrite($fp, $log);
        fclose($fp);

    }

}
?>