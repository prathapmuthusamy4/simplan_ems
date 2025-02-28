<?php
//***************************************************************//
// ログ生成クラス 
//***************************************************************//

/**
 *  SimplanLog Class
 *
 */
class SimplanLog
{

    /**
     * 分析ログを出力する
     *
     * @access  public
     * @param   array   $input
     * @param   array   $param
     * @param   string  $kbn
     */
    public static function writeAnalysisLog($input, $param, $kbn)
    {
        // ログ出力
        $path = LOG_DIR . 'analysis/analysis_' . date('Ymd') . '.log';
        $fp   = fopen($path, 'a');

        // 出力データの中から対象となるデータを生成する
        $target = array();
        foreach ($param as $k => $v) {
            if (substr($k, 0, 2) == 'f_' ) {
                $target[$k] = $v;
            }
        }
        // 対象データをログ出力用に変換する
        $ret = SimplanLog::make_analysislog_format($target);

        // ログ情報の生成
        $info = SimplanLog::make_log_info($kbn);
        // プロセス
        $prc = t_log_format("[prc]=" . $input['prc']);
        // コマンド
        $cmd = t_log_format("[cmd]=" . ((is_empty($input['cmd'])) ? 'default' : $input['cmd']));
        $log = $info . $prc . $cmd . $ret . "\n";

        fwrite($fp, $log);
        fclose($fp);
    }

    /**
     * メールログを出力する
     *
     * @access  public
     * @param   array   $param
     * @param   string  $kbn 
     */
    public static function writeMailLog($param, $kbn = "-")
    {
        // ログ出力
        $path = LOG_DIR . 'mail/mail_' . date('Ymd') . '.log';
        $fp   = fopen($path, 'a+');

        // ログ情報の生成
        $info = SimplanLog::make_log_info($kbn);

        // ログ出力用にデータを変換
        $ret = SimplanLog::make_maillog_format($param);

        $log = $info . $ret;

        fwrite($fp, $log);
        fclose($fp);

    }

    /**
     * 分析ログデータをフォーマットにあわせて生成する
     *
     * @access  public
     * @param   array   データ
     * @param   string  
     * @return  string  分析ログデータ
     */
    public static function make_analysislog_format($data, $ret = "")
    {
        $ret = '';
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $fmat = "[" . $k . "]=>";
                    $ret .= t_log_format($fmat);
                    $ret .= SimplanLog::make_analysislog_format($v, $ret);
                } else {
                    $fmat = "[" . $k . "]=";
                    $enc  = mb_detect_encoding($v, "utf-8");
                    $ret .= mb_convert_encoding(t_log_format($fmat . str_replace('"', '""', SimplanMakeCsvFile::unhtmlspecialchars($v))), "SJIS", $enc);
                }
            }
        } else {
            $ret .= t_log_format($data);
        }

        return $ret;
    }

    /**
     * メールログデータをフォーマットにあわせて生成する
     *
     * @access  public
     * @param   array   データ
     * @param   string  
     * @return  string  分析ログデータ
     */
    public static function make_maillog_format($param)
    {
        $ret = '';
        foreach ($param as $v) {
            $enc = mb_detect_encoding($v, "utf-8");
            $ret .= mb_convert_encoding(t_log_format(str_replace('"', '""', SimplanMakeCsvFile::unhtmlspecialchars($v))), "SJIS", $enc);
        }
        $ret .= "\n";

        return $ret;
    }

    /**
     * ログ情報を生成する
     *
     * @access  public
     * @param   string  区分
     * @return  string  ログ情報
     */
    public static function make_log_info($kbn)
    {
        $info  = t_log_format("[kbn]="          . $kbn, true);                   // 画面
        $info .= t_log_format("[date]="         . date('Y/m/d H:i:s'));          // 日付
        $info .= t_log_format("[remote_addr]="  . t_server('REMOTE_ADDR'));      // クライアントのIPアドレス
        $info .= t_log_format("[php_self]="     . t_server('PHP_SELF'));         // 実行中のスクリプトパス
        $info .= t_log_format("[user_agent]="   . t_env('HTTP_USER_AGENT'));  // UserAgentヘッダの内容

        return $info;
    }
}
?>