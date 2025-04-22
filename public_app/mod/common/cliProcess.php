<?php

/**
 * cliProcess
 * コマンドライン共通プロセス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
define("ERR", 1);
define("NORMAL", 0);
define("DEBUG", 2);
define("CLI_VERSION", "0.9.0");
define("CLI_ID", 90001);

class cliProcess extends SimplanAbstractProcess
{
    var $verbose;           // 冗長化フラグ
    var $count_id;          // カウントID
    var $switching_id;       // スイッチングID

    protected $surveillanceId; // 監視ID

    /**
     * usage (使い方)
     *
     * @access    public
     * @return    array    出力パラメータ
     */
    function usageMessage()
    {
        return "";
    }

    /**
     * 前処理抽象メソッド
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function preExecute($input){
        return true;
    }

    /**
     * 主処理抽象メソッド
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function mainExecute($input){
        return true;
    }


    /**
     * 後処理抽象メソッド
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function postExecute($input){
        return true;
    }

    /**
     * 前処理
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function precute($input)
    {
        // 特殊引数チェック
        if (array_key_exists("help", $input)) {
            return $this->usage(); // exit
        }
        // デバッグ出力チェック
        if (array_key_exists("verbose", $input)) {
            $this->verbose = true;
        }

        // Paramter
        foreach($input as $k => $v) {
            $this->clprint("{$k}: [{$v}]");
        }
        // CLIタイプ
        $type = NULL;
        if (array_key_exists("type", $input)) {
            $type = $input["type"];
        }
        // // CLI監視開始
        // if (!$this->startCliSurveillance($type)) {
        //     return;
        // }
        // preExecute
        if (!$this->preExecute($input)) {
            exit();
        }

        return;
    }

    /**
     * 主処理
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function execute($input)
    {
        // mainExecute
        if (!$this->mainExecute($input)) {
            exit();
        }

        return;
    }

    /**
     * 後処理
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function postcute($input)
    {
        // CLI監視終了
        /*if (!$this->endCliSurveillance()) {
            return;
        }
        // postExecute
        if (!$this->postExecute($input)) {
            return;
        }*/

        return;
    }

    /**
     * setInputData
     *
     * @access  public
     * @param   array    $input   入力値
     * @param   array    $param   出力値
     */
    function setInputData($input, &$param)
    {
        // set
        foreach ($param as $key => $value) {
            $param[$key] = array_key_exists($key, $input) ? $input[$key] : $value;
        }
        return;
    }


    /**
     * usage出力
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function usage()
    {
        $usage = $this->usageMessage();

        echo ($usage);
        exit();
    }

    /**
     * typewriter
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function typewriter($str, $stime)
    {
        for ($i = 0; $i < mb_strlen($str, "UTF-8"); $i++) {
            $one = mb_substr($str, $i, 1, "UTF-8");
            echo($one);
            if ($stime != 0) {
                usleep($stime * 1000000);
            }
        }

        return;
    }

    /**
     * コマンドライン出力
     *
     * @access    public
     * @return    array   $input   入力値
     */
    function clprint($msg, $type = NORMAL, $isbr = true)
    {

        // check
        if (($type == ERR ) ||
            ($type == NORMAL && $this->verbose) ||
            ($type == DEBUG && !$this->verbose)){
            // コマンドライン出力
            $br = $isbr ? "\n": "";
            echo($msg . $br);
        }

        $this->logger->debug($msg);

        return;
    }

    /**
     * 監視テーブル開始処理
     *
     * @access    public
     * @param     string    タイプ
     * @return    bool
     */
    protected function startCliSurveillance($type)
    {
        $success = false;
        // テーブル名
        $tableName = "t_cli_surveillance";
        $curTime   = date("YmdHis", time());
        // コマンドラインの種類
        $cliTypeList = unserialize(CIS_CLI_PROCESS_TYPE_LIST);
        $cliType     = t_array_value($type, $cliTypeList);
        // 監視開始パラメータ
        $setParam = array();
        $setParam["f_cli_type"]    = $cliType;
        $setParam["f_start_time"]  = $curTime;
        $setParam["f_comp_flg"]    = STATUS_COMP_0;
        $setParam["f_del_flg"]     = DEL_FLG_LIST_OFF;
        $setParam["f_reg_account"] = CLI_ID;
        $setParam["f_reg_time"]    = $curTime;
        $setParam["f_upd_account"] = CLI_ID;
        $setParam["f_upd_time"]    = $curTime;
        // 登録処理
        if (!$this->insertTable($tableName, $setParam)) {
            return $success;
        }
        // 監視ID
        $this->surveillanceId = $this->getInsertID();
        return $success = true;
    }

    /**
     * 監視テーブル終了処理
     *
     * @access    public
     * @return    bool
     */
    protected function endCliSurveillance()
    {
        $success = false;
        // テーブル名
        $tableName = "t_cli_surveillance";
        $curTime   = date("YmdHis", time());
        // 監視終了パラメータ
        $setParam = array();
        $setParam["f_end_time"]    = $curTime;
        $setParam["f_comp_flg"]    = STATUS_COMP_1;
        $setParam["f_upd_account"] = CLI_ID;
        $setParam["f_upd_time"]    = $curTime;
        // 更新条件
        $whereParam = array();
        $whereParam["f_surveillance_id"] = $this->surveillanceId;
        // 更新処理
        if (!$this->updateTable($tableName, $setParam, $whereParam)) {
            return $success;
        }
        return $success = true;
    }

    /**
     * テーブルインサート処理
     *
     * @access    public
     * @param     string    テーブル名
     * @param     array     登録パラメータ
     * @param     array
     * @return    bool
     */
    function insertTable($tableName, $param)
    {
        $success = false;
        // insert
        $sql = HandQuery::Insert($tableName, $param);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("INSERT {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("INSERT {$tableName} ... OK");
        return $success = true;
    }

    /**
     * テーブルインサート処理（データベース指定）
     *
     * @access    public
     * @param     string    データベース名
     * @param     string    テーブル名
     * @param     array     登録パラメータ
     * @return    bool
     */
    function insertDbTable($databaseName, $tableName, $param)
    {
        $success = false;
        // insert
        $sql = HandQuery::InsertDb($databaseName, $tableName, $param);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("INSERT {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("INSERT {$tableName} ... OK");
        return $success = true;
    }

    /**
     * テーブルアップデート処理
     *
     * @access    public
     * @param     string    テーブル名
     * @param     array     更新パラメータ
     * @param     array     更新条件
     * @return    bool
     */
    function updateTable($tableName, $param, $where)
    {
        $success = false;
        // update
        $sql = HandQuery::UpdateKey($tableName, $param, $where);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("UPDATE {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("UPDATE {$tableName} ... OK");
        return $success = true;
    }

    /**
     * テーブルアップデート処理（データベース指定）
     *
     * @access    public
     * @param     string    データベース名
     * @param     string    テーブル名
     * @param     array     更新パラメータ
     * @param     array     更新条件
     * @return    bool
     */
    function updateDbTable($databaseName, $tableName, $param, $where)
    {
        $success = false;
        // update
        $sql = HandQuery::UpdateDbKey($databaseName, $tableName, $param, $where);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("UPDATE {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("UPDATE {$tableName} ... OK");
        return $success = true;
    }

    /**
     * テーブルリプレース処理
     *
     * @access    public
     * @param     string
     * @return    bool
     */
    public function replaceTable($tableName, $param)
    {
        $success = false;
        // exec
        $sql = HandQuery::Replace($tableName, $param);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("REPLACE {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("REPLACE {$tableName} ... OK");
        return $success = true;
    }

    /**
     * テーブルデリート処理
     *
     * @access    public
     * @param     string
     * @param     array
     * @return    bool
     */
    function deleteTable($tableName, $where)
    {
        $success = false;
        // exec
        $sql = HandQuery::DeleteKey($tableName, $where);
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("DELETE {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("DELETE {$tableName} ... OK");
        return $success = true;
    }

    /**
     * テーブルトランケート処理
     *
     * @access    public
     * @param     string
     * @return    bool
     */
    public function truncateTable($tableName)
    {
        $success = false;
        // exec
        $sql = "TRUNCATE TABLE `{$tableName}` ";
        $res = parent::execQuery($sql);
        // check
        if ($res === false) {
            $this->clprint("TRUNCATE {$tableName} ... NG", ERR);
            // rollback
            $this->rollback();
            return $success;
        }
        $this->clprint("TRUNCATE {$tableName} ... OK");
        return $success = true;
    }

    /**
     * POWERCISメールを送信する
     *
     * @access    public
     * @param     string    メール種別
     * @param     string    ユーザメールテンプレート
     * @param     string    管理者メールテンプレート
     * @param     string    宛先
     * @param     string    宛名
     * @param     array     パラメータ
     * @return    void
     */
    public function sendCisMail($mailType, $userTemplate, $adminTemplate, $to, $name, $param)
    {
        // POWERCISメール情報を取得する
        $mailData     = $this->getCisMailData($mailType);
        $validFlg     = (isset($mailData["f_valid_flg"]))  ? $mailData["f_valid_flg"]  : STATUS_VALID_1; // 有効無効フラグ
        $userSubject  = (isset($mailData["f_mail_title"])) ? $mailData["f_mail_title"] : NULL;           // ユーザメールタイトル
        $adminSubject = (isset($mailData["f_mail_title"])) ? $mailData["f_mail_title"] : NULL;           // 管理者メールタイトル
        // メール送信が無効の場合は、送信せずに返す
        if ($validFlg == STATUS_VALID_1) {
            $this->clprint("メール種別：{$mailType} DON'T SEND");
            return;
        }
        if (!is_empty($to)) {
            // ユーザメールタイトル
            if (is_empty($userSubject)) {
                $userSubject = $this->getMessage("MAIL", "{$userTemplate}_title");
            }
            // メール送信
            $this->sendMailSubject($userTemplate, $to, $name, $param, $userSubject);
        }
        if (!is_empty($adminTemplate)) {
            // 管理者メールタイトル
            if (is_empty($adminSubject)) {
                $adminSubject = $this->getMessage("MAIL", "{$adminTemplate}_title");
            }
            // 管理者へメール送信
            $this->sendMailSubjectToAdmin($adminTemplate, $param, $adminSubject);
        }
        return;
    }

    /**
     * POWERCISメール情報を取得する
     *
     * @access    public
     * @param     string    メール種別
     * @return    array     メールデータ
     */
    public function getCisMailData($mailType)
    {
        // 検索条件
        $tableName = "m_mail";
        $setParam  = array();
        $setParam["where"] = $this->makeCisMailParam($mailType);
        $mailData = parent::execCommand($tableName, "select_one", $setParam);
        // check
        if ($mailData === false) {
            $this->clprint("{$tableName} select_one ... NG");
            return array();
        }
        return $mailData;
    }

    /**
     * WHERE句を生成する
     *
     * @access    public
     * @param     string    メール種別
     * @return    array     検索条件
     */
    private function makeCisMailParam($mailType)
    {
        $where = array();
        // 削除フラグ
        $where["f_del_flg"] = DEL_FLG_LIST_OFF;
        // メールID
        $where["f_mail_id"] = $mailType;
        return $where;
    }

    /**
     * スイッチング情報を取得する
     *
     * @access    public
     * @param     string    $tableName
     * @param     string    $key
     * @param     string    $val
     * @return    string
     */
    function getSwitchingInfo()
    {
        // 対象テーブル
        $table_name = 't_switching';
        // 検索条件
        $where = array();
        $where['f_switching_id'] = $this->switching_id;
        $where['f_del_flg'] = DEL_FLG_LIST_OFF;
        $res = $this->execCommand($table_name, "one", $where);
        // check
        if ($res === false) {
            $this->clprint("GET SWITCHING INFO {$table_name} ... NG", ERR);
            return;
        }
        $this->clprint("GET SWITCHING INFO {$table_name} ... OK");
        return $res;
    }

    /**
     * バックアップファイルを削除する
     *
     * @access    public
     * @param     $backup_dir       バックアップディレクトリ
     * @param     $backup_expire    バックアップファイルの有効期限
     * @return    void
     */
    public function unlinkBackup($backupDir, $backupExpire)
    {
        // バックアップファイルの有効期限を取得する
        $expire = $this->getBackupExpireDate($backupExpire);
        // バックアップディレクトリのファイル一覧を取得する
        $files  = SimplanUtil::scan_dir($backupDir);
        $this->clprint("BACK UP FILE LIST:" . print_r($files, true));
        for ($i=0; $i<count($files); $i++) {
            $v        = $files[$i];
            $fullname = $v["fullname"]; // ファイル名
            $mod      = $v["mtime"];    // ファイルの更新日時
            if (!is_file($fullname)) {
                continue;
            }
            $this->clprint("BACK UP FILE MOD:" . print_r($mod, true));
            // 有効期限以前のファイルを削除する
            if ($mod < $expire) {
                $file = $v["fullname"];
                chmod($file, 0777);
                unlink($file);
            }
        }
        return;
    }

    /**
     * バックアップファイルの有効期限を取得する
     *
     * @access    public
     * @param     string    $backupExpire    有効期限
     * @return    string    $expire          バックアップファイルの有効期限日時
     */
    public function getBackupExpireDate($backupExpire)
    {
        // 現在日時から有効期限の日時を取得する
        $date   = new DateTime();
        $expire =  $date->modify($backupExpire)->format("YmdHis");
        $this->clprint("BACK UP EXPIRE DATETIME:{$expire}");
        return $expire;
    }

    /**
     * スイッチングの添付ファイルを保存
     *
     * @access    public
     * @param     string    $service_id        サービスID
     * @param     string    $supply_point_no   供給地点特定番号
     * @param     string    $zip               データ
     * @param     string    $filename          ファイル名
     * @param     string    $ex                拡張子
     * @return
     */
    public function makeSwitchingFile($service_id, $supply_point_no, $zip, $filename, $ex)
    {
        $switching_file = '';
        // チェック
        if (($service_id != REQUEST_JIGYOSHA_ICHIRAN_YOKYU && is_empty($supply_point_no)) || is_empty($zip)) {
            return $switching_file;
        }

        // BASE64デコード
        $decode_data = base64_decode($zip);
        // ZIPファイルフルパス
        $target_file = SWITCHING_DATA_DIR . 'zip' . DIRECTORY_SEPARATOR . $filename;
        // 書き出し
        file_put_contents($target_file, $decode_data);
        // CSVファイルを設置
        $zip_archive = new ZipArchive();
        // ZIPファイルをオープン
        $res = $zip_archive->open($target_file);
        // zipファイルのオープンに成功した場合
        if ($res === true) {
            for ($i = 0; $i < $zip_archive->numFiles; $i++) {
                $get_file = $zip_archive->getNameIndex($i);
                $pattern = '/\.' . $ex . '$/';
                if (preg_match($pattern, $get_file)) {
                    $switching_file = $get_file;
                    break;
                }
            }
            // ディレクトリ作成
            if (!is_empty($supply_point_no)) {
                $target_dir = SWITCHING_DATA_DIR . $service_id . DIRECTORY_SEPARATOR . $supply_point_no . DIRECTORY_SEPARATOR;
            } else {
                $target_dir = SWITCHING_DATA_DIR . $service_id . DIRECTORY_SEPARATOR;
            }
            if (!is_dir($target_dir)) {
                mkdir($target_dir, '0777');
                chmod($target_dir, 0777);
            }
            // 圧縮ファイル内の全てのファイルを指定した解凍先に展開する
            $zip_archive->extractTo($target_dir, $switching_file);
            // ZIPファイルをクローズ
            $zip_archive->close();
            // ファイルを削除
            unlink($target_file);
            $this->clprint("CSV MAKE COMPLETE ... OK");
        } else {
            $this->clprint("CSV MAKE COMPLETE ... NG");
        }
        return $switching_file;
    }

    /**
     * スイッチングの添付ファイルを保存
     *
     * @access    public
     * @param     string    $service_id        サービスID
     * @param     string    $supply_point_no   供給地点特定番号
     * @param     string    $filename          ファイル名
     * @param     string    $content_id        コンテンツID
     * @param     string    $data              base64エンコードデータ
     * @return
     */
    public function makeSwitchingImage($service_id, $supply_point_no, $filename, $content_id, $data)
    {
        $switching_file = '';
        // チェック
        if (($service_id != REQUEST_JIGYOSHA_ICHIRAN_YOKYU && is_empty($supply_point_no)) || is_empty($filename) || is_empty($data)) {
            return $switching_file;
        }

        // 拡張子取得
        $extension = '';
        $ary = explode('.', $filename);
        foreach ((array)$ary as $ex) {
            $extension = $ex;
        }
        if (is_empty($extension)) {
            return $switching_file;
        }
        // 保存ファイル名
        $switching_file = $content_id . '.' . $extension;

        // BASE64デコード
        $decode_data = base64_decode($data);
        // 画像設置ディレクトリ作成
        $target_dir = SWITCHING_DATA_DIR . $service_id . DIRECTORY_SEPARATOR . $supply_point_no . DIRECTORY_SEPARATOR;
        if (!is_dir($target_dir)) {
            mkdir($target_dir, '0777');
            chmod($target_dir, 0777);
        }
        // 画像ファイルフルパス
        $target_file = $target_dir . $switching_file;
        // 書き出し
        file_put_contents($target_file, $decode_data);

        return $switching_file;
    }

    /**
     * CSVの読み込みを行う
     *
     * @access    public
     * @param     array    $param   出力値
     */
    function readCsv(&$handle, $len = NULL, $d = ',', $e = '"')
    {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $l = "";
        $eof = false;
        while (($eof != true ) && (!feof($handle))) {
            $l  .= (empty($len) ? fgets($handle) : fgets($handle, $len));
            $cnt = preg_match_all('/' . $e . '/', $l, $dummy);
            if ($cnt % 2 == 0) {
                $eof = true;
            }
        }
        $line    = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($l));
        $pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';

        preg_match_all($pattern, $line, $match);
        $data = $match[1];
        $cnt  = count($data);
        for ($i=0; $i<$cnt; $i++) {
            $data[$i] = preg_replace('/^' . $e . '(.*)' . $e . '$/s', '$1', $data[$i]);
            $data[$i] = str_replace($e . $e, $e, $data[$i]);
            $data[$i] = $this->encCsv($data[$i]);
        }
        return (is_empty($l)) ? false : $data;
    }

    /**
     * 読み込みデータの文字コードを変換する
     *
     * @access    public
     * @param     array    $data   読込データ
     * @return    array    $data   文字コード変換後読込データ
     */
    function encCsv($v)
    {
        $enc = $this->getEncodingType($v);
        $val = mb_convert_encoding(trim($v), 'UTF-8', $enc);
        return $val;
    }

    /**
     * 読み込みデータの文字コードを変換する
     *
     * @access    public
     * @param     array    $data   読込データ
     * @return    array    $data   文字コード変換後読込データ
     */
    function getEncodingType($v)
    {
        $encodingArray = array("ISO-2022-JP","UTF-8","Shift_JIS","EUC","ASCII");
        $n = 0;
        while ($focusEncoding = $encodingArray[$n]) {
            if (mb_check_encoding($v, $focusEncoding)) {
                return $focusEncoding;
            }
            $n++;
        }
        return mb_detect_encoding($v, "SJIS-WIN,SJIS");
    }

    /**
     * SOAPレスポンスを綺麗にする。
     *
     * @access    public
     * @param     string    $response   レスポンスXML
     * @param     string    $request    リクエストサービス名
     * @return    string    $object     XMLオブジェクト
     */
    public function makeCleanXmlObject($response, $request)
    {
        // レスポンス機能名
        $request_service_name = "{$request}Response";
        $xml_object = '';
        if (preg_match('/\<\?xml version\=\'1\.0\' encoding=\'utf-8\'\?\>\<soapenv\:Envelope.+\<\/soapenv\:Envelope\>/', $response, $res)) {
            $xml = simplexml_load_string($res[0]);
            // 使用している名前空間を取得
            $name_spaces = $xml->getNamespaces(true);
            // soapenv
            if (isset($name_spaces['soapenv']) && isset($xml->children($name_spaces['soapenv'])->Body)) {
                $body = $xml->children($name_spaces['soapenv'])->Body;
                // ns
                if (isset($name_spaces['ns']) && isset($body->children($name_spaces['ns'])->$request_service_name->return)) {
                    $return = $body->children($name_spaces['ns'])->$request_service_name->return;
                    // xsdt
                    if (isset($name_spaces['xsdt'])) {
                        $xml_object = $return->children($name_spaces['xsdt']);
                    } elseif (isset($name_spaces['xsdk'])) {
                        $xml_object = $return->children($name_spaces['xsdk']);
                    } elseif (isset($name_spaces['xsdf'])) {
                        $xml_object = $return->children($name_spaces['xsdf']);
                    }
                }
            }
        }
        return $xml_object;
    }

    /**
     * SOAPレスポンスを綺麗にする。
     *
     * @access    public
     * @param     string    $object   XMLオブジェクト
     * @return    string    $object   XMLオブジェクト
     */
    public function makeCleanUketsukeMessageXmlObject($result)
    {
        $xml_object = '';
        if (isset($result->uketsukeMessages)) {
            $xml = $result->uketsukeMessages;
            // 使用している名前空間を取得
            $name_spaces = $xml->getNamespaces(true);
            if (isset($name_spaces['ns']) && isset($xml->children($name_spaces['ns'])->uketsukeMessage)) {
                $xml_object = $xml->children($name_spaces['ns'])->uketsukeMessage;
            }
        }
        return $xml_object;
    }
}
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */

?>