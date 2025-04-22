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
include_once(MOD_DIR . "/usermod.php");
class indexCommon extends userProcess
{
    var $error_info;
    var $table_name;
    var $app_name;
    var $check_file;
    var $page_record;
    var $master;
    var $img_obj;
    var $common;


    /**
     * コンストラクタ
     *
     * @access    public
     * @param     object   ロガー
     */
    function __construct($logger)
    {
        parent::__construct($logger);
        $this->app_name    = $this->getMessage("SITE", "site_user_index_title");
        $this->img_obj    = new SimplanOperateFile($this->logger, $this->getSiteIni(), 'profile_photo');
        $this->master      = new MasterCommand($this);
        $this->common      = new CommonCommand($this);
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
        $err_list = parent::checkInput('remind.check', $input);

        // メールアドレス存在チェック
        if (is_empty(t_array_value('f_mailaddress', $err_list)) && !is_empty($input['f_mailaddress'])) {
            $param['user_info'] = $this->master->getOneData($this->table_name, 'f_mailaddress',$input['f_mailaddress']);
            $admin_info = $param['user_info'];
            $mail = isset($admin_info['f_mailaddress']) ? $admin_info['f_mailaddress'] : '';
            if (!$mail == $input['f_mailaddress']) {
                $err_list['f_mailaddress'] = $this->getMessage(STATUS_COMMON, 'L_0008');
            }
        }

        if (sizeof($err_list) > 0) {
            $success = false;
            foreach ($err_list as $key => $value) {
                $param['errmsg'][$key] = $value;
            }
            return false;
        }
        return true;
    }


    /**
     * キーの生成
     *
     * @access    public
     * @param     string    テーブル名
     * @param     string    桁数
     * @return    string    キー
     */
    function make_key($table_name, $length)
    {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $key = NULL;
        for ($i = 0; $i < $length; $i++) {
            $key .= $str[rand(0, count($str) - 1)];
        }
        if ($this->common->dup_key($table_name, $key)) {
            $key = $this->make_key($table_name, $length);
        }
        return $key;
    }
    /**
     * パスワード再発行メール送信
     *
     * @access    public
     * @param     array     $param
     * @return    void
     */
    function send_password_reissue_mail($param, $enc_id)
    {
        // ベースURL
        $baseurl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $baseurl = str_replace('index', 'passchange', $baseurl);
        // 本登録URL
        $param['f_url'] = $baseurl . '?id=' . $enc_id;
        // ユーザへのメール送信
        $to   = $param['f_mailaddress']; // to
        $name = $param['f_surname'] . $param['f_firstname'].' 先生';
        if (!is_empty($to)) {
            // メール送信
            $this->sendMail('admin_password_reissue', $to, $name, $param);
        }
        return;
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
