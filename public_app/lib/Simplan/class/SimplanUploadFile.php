<?php
/**
 * Simplan FW - PHP Web Application Framework
 *
 * Copyright(c) 2003-2010 THREET CO.,LTD. All Rights Reserved.
 *
 * http://www.threet.co.jp
 * http://www.simplan.jp
 *
 * PHP versions 4 and 5
 *
 * LICENSE: 
 * 
 * 
 * 
 * 
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @license
 * @package    Simplan
 * @copyright  2003-2010 The Simplan Project by THREET CO.,LTD.
 * @version    $Id: $
 */

/**
 * ファイル処理クラス
 *
 * [note] ファイル処理クラス
 *
 * @author     Toru Yoshikawa <t-yoshikawa@threet.co.jp>
 * @access     public
 * @package    Simplan
 */
class SimplanUploadFile
{
    var $logger;        // ログ
    var $ini;           // 設定ファイル
    var $prefix;        // 接頭語
    var $original;      // 元ファイル
    var $tempfile;      // 一時ファイル
    var $msg;           // メッセージ

    /**
     * Construct
     *
     * @param string $lang
     * @return void
     */
    function __construct($logger, $ini, $prefix)
    {
        // logger初期化
        $this->logger = $logger;
        $this->ini    = $ini;
        $this->prefix = $prefix;
        $this->original = "";
        $this->tempfile = "";
        $this->msg = "";

        return;
    }

    /**
     * mimetypes
     * 許可するMIME種別
     * [note] 許可したい種別を列挙すること
     *
     * @access public
     * @return array
     */
    function mimetypes()
    {
        // MIME許可種別
        $allowed = array( 'JPG' => array('image/jpeg',
                                         'image/jpg',
                                         'image/pjpeg'),
                          'PNG' => array('image/png',
                                         'image/x-png'),
                          'BMP' => array('image/bmp'),
                          'TIFF'=> array('image/tiff'),
                          'GIF' => array('image/gif'),
                          'TXT' => array('text/plain'),
                          'CSV' => array('text/comma-separated-values'),
                          'PDF' => array('application/pdf',
                                         'application/x-pdf'),
                          'XLS' => array('application/vnd.ms-excel',
                                         'application/excel',
                                         'application/msexcel',
                                         'application/x-excel',
                                         'application/x-msexcel',
                                         'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
                          'DOC' => array('application/msword',
                                         'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
                          );
        return $allowed;
    }

    /**
     * extentiontypes
     * 許可する拡張子種別
     * [note] 許可したい種別を列挙すること
     *
     * @access public
     * @return array
     */
    function extentiontypes()
    {
        // MIME許可種別
        $allowed = array(
                         'PDF' => array('pdf'),
                         'XLS' => array('xlsx',
                                        'xlsm',
                                        'xlsb',
                                        'xltx',
                                        'xltm',
                                        'xls',
                                        'xlt',
                                        'xml',
                                        'xlam',
                                        'xla',
                                        'xlw'),
                         'DOC' => array('doc',
                                        'docx',
                                        'docm',
                                        'dotx',
                                        'dotm'),
                        );
        return $allowed;
    }

    /**
     * getFileDir
     * 保存ディレクトリを取得
     *
     * @access public
     * @param  string $dir  実ファイル保存ディレクトリ
     * @return string $temp_directory
     */
    function getFileDir()
    {
        // 実ファイルディレクトリ
        $filedir = DATA_DIR . $this->getIniSiteValue('file_dir');
        $this->logger->debug("File dir is [{$filedir}]");

        // ディレクトリ作成
        if (!is_dir($filedir)) {
            mkdir($filedir, '0777');
            chmod($filedir, 0777);
        }

        return $filedir;
    }

    /**
     * getTempDir
     * 一時保存ディレクトリを取得
     *
     * @access public
     * @return string $temp_directory
     */
    function getTempDir()
    {
        // 添付ファイルディレクトリ
        $tmpdir = DATA_DIR . $this->getIniSiteValue('file_temp_dir');
        $this->logger->debug("Temp dir is [{$tmpdir}]");

        // ディレクトリ作成
        if (!is_dir($tmpdir)) {
            mkdir($tmpdir, '0777');
            chmod($tmpdir, 0777);
        }

        return $tmpdir;
    }

    /**
     * getIniSiteValue
     * $keyに対応する値を取得する。ない場合は規定値を取得
     *
     * @access public
     * @param string $key
     * @return string $value name
     */
    function getIniSiteValue($key)
    {
        $value = $this->ini->getValue('SITE', "{$key}_" . $this->prefix);
        // 無い場合は、既定値の取得を試みる。
        if (is_empty($value)) {
            $value = $this->ini->getValue('SITE', $key);
        }

        return $value;
    }

    /**
     * setOriginalFile
     * 既存のファイルを設定
     *
     * @access public
     * @param string $target
     * @return void
     */
    function setOriginalFile($target)
    {
        $this->original = $target;
    }

    /**
     * getOriginalFile
     * 既存ファイル名を取得する
     *
     * @access public
     * @return string
     */
    function getOriginalFile()
    {
        return $this->original;
    }

    /**
     * setTempFile
     * テンポラリのファイルを設定
     *
     * @access public
     * @param string $target
     * @return void
     */
    function setTempFile($target)
    {
        $this->tempfile = $target;
    }

    /**
     * geTempFile
     * テンポラリファイル名を取得する
     *
     * @access public
     * @return string
     */
    function getTempFile()
    {
        return $this->tempfile;
    }

    /**
     * makeTempFileName
     * テンポラリファイル名を命名する
     *
     * @access public
     * @return string $name
     */
    function makeTempFileName()
    {
        $name = "";

        // オリジナルファイル
        $original = $this->getOriginalFile();
        // オリジナルファイルの拡張子を取得
        $extension = $this->getFileExtention($original);
        // 一意
        $body = session_id() . rand();

        /********************
         * 名前
         ********************/
        $name = "{$body}.{$extension}";

        return $name;
    }

    //_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
    //  通常処理
    //_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/

    /**
     * copyFromOriginalToTemp
     * 既存ファイルをテンポラリにコピーする。
     *
     * @access public
     * @param string  $target
     * @return boolean OK:true , NG:false
     */
    function copyFromOriginalToTemp()
    {
        $success = false;

        // 既存ファイル
        $original = $this->getOriginalFile();
        $original_full = $this->getFileDir() . $original;
        // テンポファイル
        $tmpfile = $this->makeTempFileName();
        $tmpfile_full = $this->getTempDir() . $tmpfile;

        /********************
         * ファイルコピー
         ********************/
        if ($this->copy($original_full, $tmpfile_full)) {
            $success = true;
            // set temp file
            $this->setTempFile($tmpfile);
        } else {
            $success = false;
            // set temp file
            $this->setTempFile("");
        }

        return $success;
    }

    /**
     * copyFromTempToOriginal
     * テンポラリのファイルを本番ファイルにコピーする。
     *
     * @access public
     * @param string  $src
     * @param string  $desc
     * @return boolean OK:true , NG:false
     */
    function copyFromTempToOriginal($src, $dest)
    {
        $success = false;

        // 一時保存ファイル名
        $tmpfile = $src;
        $tmpfile_full = $this->getTempDir() . $tmpfile;
        $extension = $this->getFileExtention($tmpfile);
        // 新規ファイル
        $original = "{$dest}.{$extension}";
        $original_full = $this->getFileDir() . $original;

        /********************
         * ファイルコピー
         ********************/
        if ($this->copy($tmpfile_full, $original_full)) {
            $success = true;
            // remove
            $this->removeFile($tmpfile_full);
        } else {
            $success = false;
        }

        return $success;
    }

    /**
     * copy
     * ファイルをコピーする
     *
     * @access public
     * @param string $src コピー元
     * @param string $dest コピー先
     * @return boolean OK:true, NG:false
     */
    function copy($src, $dest)
    {
        // ファイルチェック
        if (!is_file($src)) {
            $this->logger->debug("File is NONE . [{$src}]");
            $this->setTempFile("");
            return $success = false;
        }

        /********************
         * ファイルコピー
         ********************/
        $this->logger->debug("Copy from: {$src} to {$dest}");
        // check
        if (strcmp($src, $dest) == 0) {
            $this->logger->debug("DO NOT COPY because File name is same .");
            return $success = true;
        }

        // copy
        if(copy($src, $dest)) {
            $this->logger->debug("COPY OK");
            chmod($dest, 0777);
            $success = true;
        } else {
            $this->logger->debug("COPY NG");
            $success = false;
        }

        return $success;
    }

    /**
     * upload
     * ファイルをアップロードする。
     * [note]
     * アップロードされたファイルを取得し、
     * ファイルが存在する場合は、テンポラリにコピーしセット
     * ただし、アップロードされたファイルがなく既にテンポラリに
     * ある場合は、テンポラリを優先する。
     *
     * @param string $target
     * @return boolean OK:true , NG:false
     */
    function upload($upfile)
    {
        $success = false;

        // ファイルチェック
        if ($upfile['size'] == 0 || !is_uploaded_file($upfile['tmp_name'])) {
            $this->logger->debug("File is NONE.");
            return $success = true;
        }

        $tmpfile = "";
        // propeties
        $tmpdir = $this->getTempDir();
        $body   = session_id() . rand();
        $extension = $this->getFileExtention($upfile['name']);  // 拡張子
        // ファイル名
        $tmpfile = "{$this->prefix}_{$body}.{$extension}";
        $tmpfile_full = $tmpdir . $tmpfile;

        /********************
         * UPLOAD
         ********************/
        if(move_uploaded_file($upfile['tmp_name'], $tmpfile_full)) {
            $this->logger->debug("UPLOAD OK: $tmpfile_full");
            chmod($tmpfile_full, 0777);
            $this->setTempFile($tmpfile);
            $success = true;
        } else {
            $this->logger->debug("UPLOAD NG: $tmpfile_full");
            $success = false;
        }

        return $success;
    }

    /**
     * isMimeType
     * MIMEタイプのチェックを行う。
     * [note] types には、mimetypesにある判定したい種別を指定すること
     *
     * @access public
     * @param  $_FILES $files
     * @param  array   $types
     * @return boolean OK:true , NG:false
     *
     */
    function isMimeType($files, $types = array())
    {
        $success = false;
        $mimes = $this->mimetypes();
        $allowed = array();

        // 許可するMIMEの設定
        if (is_array($types)) {
            foreach($types as $k => $v) {
                if (array_key_exists(strtoupper($v), $mimes)) {
                    $allowed[$v] = $mimes[$v];
                }
            }
        }

        $cur_type = $files['type'];
        $this->logger->debug("Current File MIME TYPE:".  $cur_type);
        /********************
         * チェック
         ********************/
        foreach($allowed as $k => $v) {
            if (in_array($cur_type, $v)) {
                $this->logger->debug("Current File MIME TYPE: OK");
                $success = true;
                break;
            }
        }

        if (!$success) {
            $this->logger->debug("Current File MIME TYPE: NG");
        }

        return $success;
    }

    /**
     * isExtentionType
     * 拡張子のチェックを行う。
     * [note] types には、extentiontypesにある判定したい種別を指定すること
     *
     * @access public
     * @param  $_FILES $files
     * @param  array   $types
     * @return boolean OK:true , NG:false
     *
     */
    function isExtentionType($files, $types = array())
    {
        $success = false;
        $extention = $this->extentiontypes();
        $allowed = array();

        // 許可する拡張子の設定
        if (is_array($types)) {
            foreach($types as $k => $v) {
                if (array_key_exists(strtoupper($v), $extention)) {
                    $allowed[$v] = $extention[$v];
                }
            }
        }

        $cur_type = $this->getFileExtention($files['name']);
        $this->logger->debug("Current File EXTENTION:".  $cur_type);
        /********************
         * チェック
         ********************/
        foreach($allowed as $k => $v) {
            if (in_array($cur_type, $v)) {
                $this->logger->debug("Current File EXTENTION: OK");
                $success = true;
                break;
            }
        }

        if (!$success) {
            $this->logger->debug("Current File EXTENTION: NG");
        }

        return $success;
    }

    /**
     * removeFile
     * ファイルを削除する
     *
     * @access public
     * @param string  $target
     * @return boolean OK:true , NG:false
     */
    function removeFile($target)
    {
        // ファイルチェック
        if (!file_exists($target)) {
            $this->logger->debug("File is NONE. [$target]");
            return true;
        }

        if (!is_file($target)) {
            $this->logger->debug("File is NONE. [$target]");
            return true;
        }

        // テンポラリファイル削除
        unlink($target);
        $this->logger->debug("File remove OK: $target");

        return true;
    }

    /**
     * removeFileExt
     * 該当のファイル名から始まるファイルを削除
     *
     * @param string $targetdir
     * @param string $postname
     * @return void
     */
    function removeFileExt($targetdir, $prefix)
    {
        if (!($dir = opendir($targetdir))) {
            $this->logger->debug("Dir do not open . [{$targetdir}]");
            return;
        }

        // 取得
        while ($fnm = readdir($dir)) {
            if (preg_match("(^$prefix\.)", $fnm)) {
                removeFile($targetdir . $fnm);
            }
        }
        closedir($dir);

        return;
    }

    /**
     * getFileExtention
     * 拡張子を取得する。
     *
     * @access public
     * @param string  $target
     * @return boolean OK:true , NG:false
     */
    function getFileExtention($target)
    {
        $extension = "";

        if (!is_empty($target)) {
            $ary = explode('.', $target);
            if (is_array($ary) && count($ary) > 0) {
                foreach ($ary as $val) {
                    $extension = $val;
                }
            }
        }

        return $extension;
    }

    /**
     * downloadFile
     *
     * @access public
     * @param string  $file
     * @param string  $name
     * @return boolean OK:true , NG:false
     */
    function downloadFile($file, $name, $textmode = true)
    {

        // 文字コード
        $kanji_code = mb_internal_encoding();

        $name = mb_convert_encoding($name, "SJIS", "EUC-JP, SJIS,UTF-8");
        header("Content-Disposition: attachment; filename=$name");
        header("Content-type: application/octet-stream; name=$name");
        header("Content-Length: " . filesize($file) );
        header("Cache-Control: public");
        header("Pragma: public");
        readfile($file);

        mb_http_output('SJIS');
        // 内部文字コードを元に戻す
        mb_internal_encoding($kanji_code);

        return;
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>