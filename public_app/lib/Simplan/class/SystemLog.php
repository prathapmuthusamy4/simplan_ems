<?php
//******************************************************************************
// 機能名   ： システムロガークラス
// 作成日   ： 2005.04.26
//******************************************************************************
class SystemLog
{

    //*** 変数宣言 ***//
    var $level;     // レベル
    var $fSize;     // ファイルサイズ
    var $fName;     // ファイル名
    var $backup;    // バックアップ数
    var $format;    // 日付のフォーマット

    //******************************************************************************
    // 関数名   ：  SystemLog
    // 機能名   ：  コンストラクタ
    // 引　数   ：  なし
    // 戻り値   ：  なし
    //******************************************************************************
    function __construct()
    {
        //*** システムプロパティよりログ設定取得 ***//
        $reader = new SimplanIniReader(ETC_DIR . "system.ini");

        $this->level = $reader->getValue('LOG', 'log_level');
        $this->fSize = $reader->getValue('LOG', 'log_file_size');
        $this->fName = $reader->getValue('LOG', 'log_file_name');
        $this->backup = $reader->getValue('LOG', 'log_backup');
        $this->format = $reader->getValue('LOG', 'log_format');

    }

    //******************************************************************************
    // 関数名   ：  writeLog
    // 機能名   ：  ログ書き込み処理
    // 引　数   ：  $lv         ：  ログレベル
    //              $msg        ：  ログメッセージ
    // 戻り値   ：  なし
    //******************************************************************************
    function writeLog ($lv, $msg) {

        //*** ログファイルチェック ***//
        $is_cli = false;
        $file_path = LOG_DIR . $this->fName;
        if (file_exists($file_path)) {
            if (filesize($file_path) > $this->fSize) {
                // バックアップファイル名の設定
                $fhead = $this->fName;
                $fext = "";
                $pos = strpos($fhead, '.');
                // 拡張子有りならファイル名のみを取得
                if ($pos) {
                    $fext = substr($fhead, $pos + 1);
                    $fhead = substr($fhead, 0, $pos);
                }
                for ($idx = $this->backup; $idx > 1; $idx--) {
                    $num = $idx - 1;
                    $checkFile = LOG_DIR . $fhead . $num . '.' . $fext;
                    if (file_exists($checkFile)) {
                        $renameFile = LOG_DIR . $fhead . $idx . '.' . $fext;
                        if (file_exists($renameFile)) {
                            unlink($renameFile);
                        }
                        rename($checkFile, $renameFile);
                    }
                }
                $renameFile = LOG_DIR . $fhead . '1.' . $fext;
                rename($file_path, $renameFile);
                // ファイル新規作成
                $is_cli = false;
            } else {
                // ファイル存在
                $is_cli = true;
            }
        } else {
            // ファイル無し
            $is_cli = false;
        }

        //*** ログファイルオープン ***//
        $fp = fopen($file_path, 'a');
        $logStr = date($this->format) . " >> {$lv} : {$msg}\n";
        fwrite($fp, $logStr);
        fclose($fp);
        if ($is_cli === false) {
            chmod($file_path, 0664);
        }
    }

    //******************************************************************************
    // 関数名   ：  debug
    // 機能名   ：  デバッグレベルログ
    // 引　数   ：  $msg        (String)ログメッセージ
    // 戻り値   ：  なし
    //******************************************************************************
    function debug ($msg) {
        if ($this->level == 'debug') {
            $this->writeLog('debug', $msg);
        }
    }

    //******************************************************************************
    // 関数名   ：  info
    // 機能名   ：  情報レベルログ
    // 引　数   ：  $msg        (String)ログメッセージ
    // 戻り値   ：  なし
    //******************************************************************************
    function info ($msg) {
        if ($this->level == 'debug'
                || $this->level == 'info') {
            $this->writeLog('info', $msg);
        }
    }

    //******************************************************************************
    // 関数名   ：  warning
    // 機能名   ：  警告レベルログ
    // 引　数   ：  $msg        (String)ログメッセージ
    // 戻り値   ：  なし
    //******************************************************************************
    function warning ($msg) {
        if ($this->level == 'debug'
                || $this->level == 'info'
                || $this->level == 'warning') {
            $this->writeLog('warning', $msg);
        }
    }

    //******************************************************************************
    // 関数名   ：  error
    // 機能名   ：  エラーレベルログ
    // 引　数   ：  $msg        (String)ログメッセージ
    // 戻り値   ：  なし
    //******************************************************************************
    function error ($msg) {
        $this->writeLog('error', $msg);
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
        $path = LOG_DIR . 'mail/mail_' . date('Ymd') . '.log';
        $fp   = fopen($path, 'a+');

        // ログ情報の生成
        $info = $this->make_log_info($kbn);

        // ログ出力用にデータを変換
        $ret = $this->make_maillog_format($param);

        $log = $info . $ret;

        fwrite($fp, $log);
        fclose($fp);

    }

    /**
     * メールログデータをフォーマットにあわせて生成する
     *
     * @access  public
     * @param   array   データ
     * @param   string  
     * @return  string  分析ログデータ
     */
    function make_maillog_format($param)
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
    function make_log_info($kbn)
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