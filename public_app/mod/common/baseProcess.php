<?php 
/**
 *  プロセス共通クラス
 *
 * @link       http://simplan.jp/
 * @author   Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package Simplan
 * @version 1.0
 */
class baseProcess extends SimplanAbstractProcess
{
    var $system_conf;
    var $user_info;
    var $param;
    var $proc;
    var $display;
    var $session_name;
    var $session;
    var $account;

    var $execFuncName;

    /**
     * コンストラクタ
     *
     * @access  public
     */
    function __construct($logger)
    {
        parent::__construct($logger);
        $this->setSmartyPlugins(COM_DIR . "smartyPlugins"); // Smarty プラグインディレクトリ追加
    }

    /**
     * getSmartyCommon
     *
     * @access    public
     */
    function getSmartyCommon()
    {
        $common = parent::getSmartyCommon();
        return $common;
    }

    /**
     * clearSession
     *
     * @access  public
     */
    function clearSession()
    {
        $_SESSION[$this->session_name] = null;
        return;
    }

    /**
     * setSession
     *
     * @access  public
     * @param   array    $input   入力値
     * @param   array    $param   出力値
     */
    function setSession($input, &$param)
    {
        //set
        $_SESSION[$this->session_name] = $param;
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
     * setParamFromSession
     *
     * @access  public
     * @param   array    $param   出力値
     */
    function setParamFromSession(&$param)
    {
        $se = isset($_SESSION[$this->session_name]) ? $_SESSION[$this->session_name] : null;
        if (!is_array($se)) {return;}

        foreach ($param as $key => $value) {
            $param[$key] = array_key_exists($key, $se) ? $se[$key] : $value;
        }
        return;
    }

    /**
     * getErrorObject
     *
     * @access  public
     */
    function getErrorObject()
    {
        $obj = new userErrorPage($this->logger, $this->smarty);
        return $obj;
    }

    /**
     * getDispPass
     *
     * @access  public
     * @param   string   $path
     */
    function getDispPass($path)
    {
        $aryScr = explode("/", $path);
        $name = $aryScr[(count($aryScr) - 1)];
        return $name;
    }

    /**
     * 前処理
     *
     * @access  public
     * @param   array    $input   入力値
     */
    function base_precute($input)
    {
        $this->proc  = $this->initProc();  // プロセスリスト
        $this->param = $this->initParam(); // パラメータ初期化
    }

    /**
     * プロセスリストを初期化する
     *
     * @access  public
     */
    function initProc()
    {
        return array(
                     'delete'         => 'executeDelete',
                     'confirm'        => 'executeConfirm',
                     'regist'         => 'executeRegist',
                     'search'         => 'executeSearch',
                     'update'         => 'executeUpdate',
                     'default'        => 'executeDefault',
                     'back'           => 'executeBack',
                     'reload'         => 'executeReload',
                     'change_page'    => 'executeChangepage',
                     'change_page_ex' => 'executeChangepageEx',
                     'logout'         => 'executeLogout',
                     'login'          => 'executeLogin',
                     'remind'         => 'executeRemind',
                     'remind_conf'    => 'executeRemindConf',
                     'remind_comp'    => 'executeRemindComp',
                     'check'          => 'executeCheck',
                     'sort'           => 'executeSort',
                     'up'             => 'executeSortUpdate',
                     'down'           => 'executeSortUpdate',
                     'mail'           => 'executeMail',
                     'mail_confirm'   => 'executeMailConfirm',
                     'mail_back'      => 'executeMailBack',
                     'next'           => 'executeNext',
                     'upload'         => 'executeUpload',
                    );
    }

    /**
     * 遷移チェック
     *
     * @access  public
     * @param   string    $type
     */
    function RootCheck($type = ROOT_CHECK_NOMAL)
    {
        $ref = $_SERVER['HTTP_REFERER'];
        if (strlen($ref) == 0) {
            return ($type == ROOT_CHECK_HEAD) ? true : false;
        }
        // 同一サーバからのアクセスチェック
        if (strpos($ref, $_SERVER['SERVER_NAME']) === false) {
            return false;
        }
        return true;
    }

    /**
     * システム設定取得関数
     *
     * @access  public
     * @return  array
     */
    function getSystemConfig()
    {
        return parse_ini_file(ETC_DIR . 'system.ini');
    }

    /**
     * セッション文字列取得関数
     *
     * @access  public
     * @return  array
     */
    function getSessionString()
    {
        return $_SESSION[COMMONS_SESSION];
    }

    //--------------------------------------------------------------------------
    // 下記はプロジェクトに依存するコード
    //--------------------------------------------------------------------------
    /**
     * ログインチェック関数
     *
     * @access  public
     * @param   string    $table   テーブル名
     * @param   array     $param
     * @return  bool
     */
    function is_Login($table, $param)
    {
        // print_r($param);exit;
        $res = parent::execCommand($table, 'is_login', $param);
        // check
        if ($res === false) {
            $this->logger->error($table . " is_login ... NG");
            $this->errorPage($this->getMessage(STATUS_COMMON, 'C_0009'));
            return false;
        }
        if (count($res) <= 0) {
            return false;
        }
        return true;
    }

    function makeThumbnailImg($parent, $thumb, $dkey)
    {
        if ($dkey == '1') {
            return;
        }

        if (file_exists($parent)) {

            // 同一ディレクトリにサムネイル用の画像をコピー
            system("cp " . $parent . " " . $thumb);

            // サムネイル画像生成
            $ic = new SimplanImageControl($thumb, $thumb, THUMBNAIL_WIDTH, THUMBNAIL_HEIGHT, 'WIDTH');
            $ic->createImage();
            chmod($thumb, 0777);

            // 画像に再配布不可のコメント追加
            $ex = strtolower(getFileExtention($thumb));
            if ($ex == 'jpg' || $ex == 'jpeg') {
                $comment    = 'kddi_copyright=on,copy="NO"';
                $header     = get_jpeg_header_data($thumb);
                $new_header = put_jpeg_comment($header, $comment);
                put_jpeg_header_data($thumb, $thumb, $new_header);
            }
            //$cmd = "mogrify -comment 'kddi_copyright=on,copy=\"NO\"' " . $thumb;
            //$res = system($cmd);
        }
    }

    /**
     * 後処理
     *
     * @access  public
     * @param   array   $input
     * @param   string  $kbn
     */
    function base_postcute($input, $kbn)
    {
        // アクセスログを出力する
        SimplanLog::writeAnalysisLog($input, $this->param, $kbn);
    }

    /**
     * 一覧画面の表示件数LIMIT句を生成する
     *
     * @access    public
     * @param     array   $param 出力情報
     * @return    array   件数条件
     */
    function makeLimitParam($param)
    {
        $ret = array();

        $ret['offset'] = strval($param['offset'] - 1);
        $ret['limit']  = strval($param['page_limit']);
        return $ret;
    }

    function get_tax()
    {
        $rate = $this->getSiteValue('SITE', 'tax_rate');
        $tax  = 1 + (intval($rate) / 100);
        return $tax;
    }

    /**
     * ファイルをアップロードする
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setUploadImage(&$param)
    {
        // 既存ファイルをセット
        $this->img_obj->setTempFile($param['image_picture']);
        // アップロード
        $this->img_obj->upload($_FILES['tmp_f_image']);

        // set param
        $param['image_picture'] = $this->img_obj->getTempFile();
        $param['f_image']       = $param['image_picture'];
    }

    /**
     * ファイルをアップロードする
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setUploadImageIdx(&$param, $idx)
    {
        // 既存ファイルをセット
        $this->img_obj->setTempFile($param["image_picture{$idx}"]);
        // アップロード
        $this->img_obj->upload($_FILES["tmp_f_image{$idx}"]);

        // set param
        $param["image_picture{$idx}"] = $this->img_obj->getTempFile();
        $param["f_image{$idx}"]       = $param["image_picture{$idx}"];
    }

    /**
     * ファイルをアップロードする（複数）
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setUploadImages(&$param, $idx)
    { 
        for ($i=1; $i<=$idx; $i++) {
            // 既存ファイルをセット
            $this->img_obj->setTempFile($param["image_picture{$i}"]);
            // アップロード
            $this->img_obj->upload($_FILES["tmp_f_image{$i}"]);

            // set param
            $param["image_picture{$i}"] = $this->img_obj->getTempFile(); 
            $param["f_image{$i}"]       = $param["image_picture{$i}"];
        }
    }

    /**
     * テンポラリーファイル情報をセットする（複数）
     *
     * @access    public
     * @param     array   $param
     * @param     string  $idx
     */
    function set_temp_images(&$param, $idx)
    {
        for ($i=1; $i<=$idx; $i++) {
            // 既存ファイルをセット
            $this->img_obj->setTempFile($param["image_picture{$i}"]);
            // set param
            $param["image_picture{$i}"] = $this->img_obj->getTempFile();
            $param["f_image{$i}"]       = $param["image_picture{$i}"];
        }
    }

    /**
     * コピーファイル名を設定する
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setCopyFile(&$param)
    {
        // 既存ファイルをセット
        $this->img_obj->setOriginalFile($param['f_image']); 
        // 既存ファイルをテンポラリにコピー
        $this->img_obj->copyFromOriginalToTemp();

        // set param
        $param['image_picture'] = $this->img_obj->getTempFile();
        $param['copy_image']    = $param['f_image'];
    }

    /**
     * コピーファイル名を設定する（複数）
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setCopyFiles(&$param, $idx)
    {
        for ($i=1; $i<=$idx; $i++) {
            // 既存ファイルをセット
            $this->img_obj->setOriginalFile($param["f_image{$i}"]);
            // 既存ファイルをテンポラリにコピー
            $this->img_obj->copyFromOriginalToTemp();

            // set param
            $param["image_picture{$i}"] = $this->img_obj->getTempFile(); 
            $param["copy_image{$i}"]    = $param["f_image{$i}"];
        }
    }

    /**
     * ファイルを調整する
     *
     * @access    public
     * @param     array   $param
     * @param     string  $key
     */
    function setAdjustImage($param)
    {
        $src = $param['dir_tmp']. $param['f_image'];
        $dst = $src;
        // ファイル調整
        $this->img_obj->adjust($src, $dst);
    }

    /**
     * ファイルを調整する
     *
     * @access    public
     * @param     array   $param
     * @param     string  $key
     */
    function setAdjustImageIdx($param, $idx)
    {
        $src = $param['dir_tmp']. $param["f_image{$idx}"];
        $dst = $src;
        // ファイル調整
        $this->img_obj->adjust($src, $dst);
    }

    /**
     * ファイルを調整する（複数）
     *
     * @access    public
     * @param     array   $param
     * @param     string  $key
     */
    function setAdjustImages($param, $idx)
    { 
        for ($i=1; $i<=$idx; $i++) {
            $src = $param['dir_tmp'] . $param["f_image{$i}"];
            $dst = $src;
            // ファイル調整
            $this->img_obj->adjust($src, $dst);
        }
    }

    /**
     * ファイル名を生成する
     *
     * @access    public
     * @param     string  $pos
     * @param     string  $key
     */
    function makeImageFileName()
    {
        $ret = array();
        $ret['fname'] = "";
        $ret['image'] = "";
        $ret['thumb'] = "";

        if (!is_empty($this->param['f_image']) && $this->param['tmp_f_image_del'] != '1') {
            $ex      =$this->img_obj->getFileExtention($this->param['f_image']);
            $prefix = $this->img_obj->getIniSiteValue("img_prefix");
            $body = date('YmdHis', time()) . rand();

            // set
            $ret['fname'] = "{$prefix}_{$body}";
            $ret['image'] = "{$prefix}_{$body}.{$ex}";
            $ret['thumb'] = "{$prefix}_{$body}_thumb.{$ex}";
        }
        return $ret;
    }

    /**
     * ファイル名を生成する（複数）
     *
     * @access    public
     * @param     string  $pos
     * @param     string  $key
     */
    function makeImageFileNames($idx)
    {
        $ret = array();
        for ($i=1; $i<=$idx; $i++) {
            $ret["fname{$i}"] = "";
            $ret["image{$i}"] = "";
            $ret["thumb{$i}"] = "";

            if (!is_empty($this->param["f_image{$i}"]) && $this->param["tmp_f_image_del{$i}"] != '1') {
                $ex      =$this->img_obj->getFileExtention($this->param["f_image{$i}"]);
                $prefix = $this->img_obj->getIniSiteValue("img_prefix");
                $body = date('YmdHis', time()) .rand();

                // set
                $ret["fname{$i}"] = "{$prefix}_{$body}_{$i}";
                $ret["image{$i}"] = "{$prefix}_{$body}_{$i}.{$ex}";
                $ret["thumb{$i}"] = "{$prefix}_{$body}_{$i}_thumb.{$ex}";
            }
        }
        return $ret;
    }

    /**
     * ファイルの削除、または対象ディレクトリに生成する
     *
     * @access    public
     * @param     string  $dkey
     * @param     string  $key
     */
    function handleImageFile($image)
    {
        $tmp_path = $this->param['dir_tmp'];
        $img_path = $this->param['dir_img'];

        // 元ファイル削除
        if (isset($this->param['copy_image']) &&
            is_file($img_path . $this->param['copy_image'])) {
            $this->img_obj->removeFile($img_path . $this->param['copy_image']);
        }

        // サムネイル削除
        if (isset($this->param['f_thumb']) &&
            is_file($img_path . $this->param['f_thumb'])) {
            $this->img_obj->removeFile($img_path . $this->param['f_thumb']);
        }

        // 正式なファイル
        if ($this->param['tmp_f_image_del'] == '1') {
            $this->img_obj->removeFile($tmp_path . $this->param['f_image']);
        } else {
            // 正式ファイル
            $this->img_obj->copyFromTempToOriginal($this->param['f_image'], $image['fname']);
            // サムネイルファイル
            $this->img_obj->thumbnailImage($img_path.$image['image'], $img_path.$image['thumb']);
            // サムネイルにモバイル用タグ追加
            $this->img_obj->setModifyMobile($img_path.$image['thumb']);
        }

        return;
    }

    /**
     * ファイルの削除、または対象ディレクトリに生成する（複数）
     *
     * @access    public
     * @param     string  $dkey
     * @param     string  $key
     */
    function handleImageFiles($image, $idx, $del = "")
    {
        $tmp_path = $this->param['dir_tmp'];
        $img_path = $this->param['dir_img'];

        for ($i=1; $i<=$idx; $i++) {
            // 元ファイル削除
            if (isset($this->param["copy_image{$i}"]) &&
                is_file($img_path . $this->param["copy_image{$i}"]) && $del != "ng") {
                $this->img_obj->removeFile($img_path . $this->param["copy_image{$i}"]);
            }

            // サムネイル削除
            if (isset($this->param["f_thumb{$i}"]) &&
                is_file($img_path . $this->param["f_thumb{$i}"]) && $del != "ng") {
                $this->img_obj->removeFile($img_path . $this->param["f_thumb{$i}"]);
            }

            // 正式なファイル
            if ($this->param["tmp_f_image_del{$i}"] == '1') {
                $this->img_obj->removeFile($tmp_path . $this->param["f_image{$i}"]);
            } else {
                 // 正式ファイル
                 $this->img_obj->copyFromTempToOriginal($this->param["f_image{$i}"], $image["fname{$i}"]);
                 // サムネイルファイル
                 $this->img_obj->thumbnailImage($img_path . $image["image{$i}"], $img_path . $image["thumb{$i}"]);
                 // サムネイルにモバイル用タグ追加
                 $this->img_obj->setModifyMobile($img_path . $image["thumb{$i}"]);
            }
        }
    }

    /**
     * ファイルのコピー
     *
     * @access    public
     * @param     string  $dkey
     * @param     string  $key
     */
    function fileCopy($image)
    {
        $img_path = $this->param['dir_img'];

        // コピー
        $this->img_obj->copy($img_path . $this->param["f_image"], $img_path . $image["image"]);
        // サムネイルファイル
        $this->img_obj->thumbnailImage($img_path . $image["image"], $img_path . $image["thumb"]);
        // サムネイルにモバイル用タグ追加
        $this->img_obj->setModifyMobile($img_path . $image["thumb"]);
    }

    /**
     * ファイルのコピー（複数）
     *
     * @access    public
     * @param     string  $dkey
     * @param     string  $key
     */
    function fileCopys($image, $idx)
    {
        $img_path = $this->param['dir_img'];

        for ($i=1; $i<=$idx; $i++) {
             // コピー
             $this->img_obj->copy($img_path . $this->param["f_image{$i}"], $img_path . $image["image{$i}"]);
             // サムネイルファイル
             $this->img_obj->thumbnailImage($img_path . $image["image{$i}"], $img_path . $image["thumb{$i}"]);
             // サムネイルにモバイル用タグ追加
             $this->img_obj->setModifyMobile($img_path . $image["thumb{$i}"]);
        }

    }

    /**
     * 画像ファイルをトリミング
     *
     * @access    public
     * @param     array   $param
     * @param     string  $idx
     */
    function trimmings(&$param, $idx)
    {
        $success = false;
        // width, height
        $w = $this->img_obj->getIniSiteValue("img_width");
        $h = $this->img_obj->getIniSiteValue("img_height");

        for ($i=1; $i<=$idx; $i++) {
            // file
            $file = $param["dir_tmp"] . $param["f_image{$i}"];
            if (!is_file($file)) {
                continue;
            }
            $this->img_obj->adjust_trmmings($file, $file, $w, $h);
        }
        return $success = true;
    }

    /**
     * 日付（YYYYmmdd）を分解しparamにセット
     *
     * @access    public
     * @param     array    $param     出力値
     * @param     string   $name      配列の要素名
     * return     boolean
     */
    function setDateToYMD(&$param, $name)
    {
        $success = false;

        $param["{$name}_y"] = "";
        $param["{$name}_m"] = "";
        $param["{$name}_d"] = "";
        if (isset($param[$name]) && !is_empty($param[$name])) {
            $string = $param[$name];
            // 文字を分解
            $y = substr($string, 0, 4);
            $m = substr($string, 4, 2);
            $d = substr($string, 6, 2);
            if (is_empty($d)) {
                $d = "01";
            }

            // 日付チェック
            if (preg_match('/^[0-9]{4}$/u', $y) && preg_match('/^[0-9]{2}$/u', $m) && preg_match('/^[0-9]{2}$/u', $d) && checkdate($m, $d, $y)) {
                $param["{$name}_y"] = date('Y', mktime(0, 0, 0, $m, $d, $y));
                $param["{$name}_m"] = date('n', mktime(0, 0, 0, $m, $d, $y));
                $param["{$name}_d"] = date('j', mktime(0, 0, 0, $m, $d, $y));
            }
            $success = true;
        }

        return $success;
    }

    //--------------------------------------------------------------------------
    // 下記はファイル処理ファンクション
    //--------------------------------------------------------------------------
    /**
     * ファイルをアップロードする
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setUploadFile(&$param)
    { 
        // 既存ファイルをセット
        $this->upl_obj->setTempFile($param['upload_file']); 
        // アップロード
        $this->upl_obj->upload($_FILES['tmp_f_file']); 
        // set param
        $param['upload_file'] = $this->upl_obj->getTempFile();
        $param['f_file'] = $param['upload_file']; 
        $param['delfiles'][] = $param['upload_file']; 
        if ($_FILES['tmp_f_file']['size'] > 0) {
            $param['f_file_size'] = $this->byte_convert($_FILES['tmp_f_file']['size']); 
            $param['f_filename']  = $_FILES['tmp_f_file']['name']; 
            
        }
    }

    /**
     * ファイルをアップロードする（複数）
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setUploadFiles(&$param, $idx)
    {
        for ($i = 1; $i <= $idx; $i++) {
            // 既存ファイルをセット
            $this->upl_obj->setTempFile($param["upload_file{$i}"]);
            // アップロード
            $this->upl_obj->upload($_FILES["upload_file{$i}"]);

            // set param
            $param["upload_file{$i}"] = $this->upl_obj->getTempFile();
            $param["f_file{$i}"] = $param["upload_file{$i}"];
            $param["delfiles"][] = $param["upload_file{$i}"];
        }
    }

    /**
     * コピーファイル名を設定する
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setCopyUploadFile(&$param)
    {
        // 既存ファイルをセット
        $this->upl_obj->setOriginalFile($param['f_file']);
        // 既存ファイルをテンポラリにコピー
        $this->upl_obj->copyFromOriginalToTemp();

        // set param
        $param['upload_file'] = $this->upl_obj->getTempFile();
        $param['copy_file'] = $param['f_file'];
        $param['delfiles'][] = $param['upload_file'];
    }

    /**
     * コピーファイル名を設定する（複数）
     *
     * @access    public
     * @param     array   $param
     * @param     array   $pos
     */
    function setCopyUploadFiles(&$param, $idx)
    {
        for ($i = 1; $i <= $idx; $i++) {
            // 既存ファイルをセット
            $this->upl_obj->setOriginalFile($param["f_file{$i}"]);
            // 既存ファイルをテンポラリにコピー
            $this->upl_obj->copyFromOriginalToTemp();

            // set param
            $param["upload_file{$i}"] = $this->upl_obj->getTempFile();
            $param["copy_file{$i}"] = $param["f_file{$i}"];
            $param['delfiles'][] = $param["upload_file{$i}"];
        }
    }

    /**
     * ファイル名を生成する
     *
     * @access    public
     * @param     string  $pos
     * @param     string  $key
     */
    function makeUploadFileName()
    {
        $ret = array();
        $ret['file'] = "";

        $ex =$this->upl_obj->getFileExtention($this->param['f_file']); 
        $prefix = $this->upl_obj->getIniSiteValue("file_prefix"); 
        $body = $prefix ."_". rand(); 

        // set
        $ret['fname'] = "{$body}";
        $ret['file']  = "{$body}.{$ex}";
        $ret['extention'] = $ex;

        return $ret;
    }

    /**
     * ファイル名を生成する（複数）
     *
     * @access    public
     * @param     string  $pos
     * @param     string  $key
     */
    function makeUploadFileNames($idx)
    {
        $ret = array();
        for ($i=1; $i<=$idx; $i++) {
            $ret["file{$i}"] = "";

            if (!is_empty($this->param["f_file{$i}"])) {
                $ex =$this->upl_obj->getFileExtention($this->param["f_file{$i}"]);
                $body = date('YmdHis', time()) . rand();

                // set
                $ret["fname{$i}"] = "{$body}_{$i}";
                $ret["file{$i}"]  = "{$body}_{$i}.{$ex}";
                $ret["extention{$i}"] = $ex;
            }
        }

        return $ret;
    }

    /**
     * ファイルの削除、または対象ディレクトリに生成する
     *
     * @access    public
     * @param     string  $dkey
     * @param     string  $key
     */
    function handleUploadFile($file, $param, $delflg=false)
    { 
        $temp_path = $param['dir_up_temp']; 
        $real_path = $param['dir_up_real']; 

        // 正式ファイル
        $this->upl_obj->copyFromTempToOriginal($param['f_file'], $file['fname']);

        // 元ファイル削除
        if ($delflg === true) {
            if (isset($param['copy_file']) && is_file($real_path . $param['copy_file'])) {
                $this->upl_obj->removeFile($real_path . $param['copy_file']);
            }
        }

        // 不要テンポラリ画像を削除
        if (is_array($param['delfiles']) && count($param['delfiles']) > 0) {
            foreach ($param['delfiles'] as $val) {
                $tempfile = $temp_path . $val;
                $this->upl_obj->removeFile($tempfile);
            }
        }
        return;
    }

    /**
     * ファイルの削除、または対象ディレクトリに生成する（複数）
     *
     * @access    public
     * @param     string  $dkey
     * @param     string  $key
     */
    function handleUploadFiles($file, $param, $idx, $delflg=false)
    {
        $temp_path = $param['dir_up_temp'];
        $real_path = $param['dir_up_real'];

        for ($i = 1; $i <= $idx; $i++) {
            if(!isset($file["fname{$i}"]) || is_empty($file["fname{$i}"])) {
                continue;
            }
            // 正式ファイル
            $this->upl_obj->copyFromTempToOriginal($param["f_file{$i}"], $file["fname{$i}"]);

            // 元ファイル削除
            if ($delflg === true) {
                if (isset($param["copy_file{$i}"]) && is_file($real_path . $param["copy_file{$i}"])) {
                    $this->upl_obj->removeFile($real_path . $param["copy_file{$i}"]);
                }
            }
        }

        // 不要テンポラリ画像を削除
        if (is_array($param['delfiles']) && count($param['delfiles']) > 0) {
            foreach ($param['delfiles'] as $val) {
                $tempfile = $temp_path . $val;
                $this->upl_obj->removeFile($tempfile);
            }
        }
        return;
    }

    /**
     * 税込金額を取得する
     *
     * @access    public
     * @param     string    金額
     * @param     string    税率
     * @return    string    請求金額税込
     */
    function getTaxPrice($price, $taxRate)
    {
        $taxPrice = 0;
        if (is_empty($price) || is_empty($taxRate)) {
            return $taxPrice;
        }
        $taxPrice = ($price * (1 + $taxRate));
        return $taxPrice;
    }

    /**
     * 消費税相当額を取得する
     *
     * @access    public
     * @param     string    税込金額
     * @param     string    税率
     * @return    string    消費税相当額
     */
    function getTaxEquivalentPrice($price, $taxRate)
    {
        $taxEquivalent = 0;
        if (is_empty($price) || is_empty($taxRate)) {
            return $taxEquivalent;
        }
//        $taxEquivalentPrice = $price / (1 + $taxRate) * $taxRate;
        $taxEquivalentPrice = $price - ($price / (1 + $taxRate));
        return floor(strval($taxEquivalentPrice));
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
            $this->logger->info("メール種別：{$mailType} DON'T SEND");
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
            $this->logger->error("{$tableName} select_one ... NG");
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
     * Byte Convert
     * Convert file size into byte, kb, mb, gb
     * @param int $size
     * @return string
     */
    function byte_convert($size = 0)
    {
        // skip size zero
        if ($size == 0) {
            return;
        }
        // size smaller then 1kb
        if ($size < 1024) {
            return $size . 'Byte';
        } 
        // size smaller then 1mb
        if ($size < 1048576) {
            return sprintf("%4.2fKB", $size/1024);
        }
        // size smaller then 1gb
        if ($size < 1073741824) {
            return sprintf("%4.2fMB", $size/1048576);
        }
        // size smaller then 1tb
        if ($size < 1099511627776) {
            return sprintf("%4.2fGB", $size/1073741824);
        }
        return;
    }
}
?>