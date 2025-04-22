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
class SimplanOperateFile
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
                          );
        return $allowed;
    }

    /**
     * getFileDir
     * 保存ディレクトリを取得
     *
     * @access public
     * @return string $temp_directory
     */
    function getFileDir()
    {
        // 添付ファイルディレクトリ
        $filedir = WWW_DIR . $this->getIniSiteValue('img_dir');
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
        $tmpdir = WWW_DIR . $this->getIniSiteValue('img_temp_dir');
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
     * getFullOriginalFile
     * パス付既存ファイルを取得する
     *
     * @access public
     * @return string
     */
    function getFullOriginalFile()
    {
        return $this->getFileDir() . $this->getOriginalFile();
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
     * getFullTempFile
     * パス付きテンポラリファイルを取得する
     *
     * @access public
     * @return string
     */
    function getFullTempFile()
    {
        return $this->getTempDir() . $this->getTempFile();
    }

    /**
     * setMessage
     * メッセージを設定
     *
     * @access public
     * @param string $target
     * @return void
     */
    function setMessage($val)
    {
        $this->msg = $val;
    }

    /**
     * getMessage
     * メッセージを取得
     *
     * @access public
     * @return string
     */
    function getMessage()
    {
        $val = "";

        // check
        if (!is_empty($val)) {
            $val = $this->msg;
        }
        return $msg;
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
        // ファイル接頭語
        $prefix   = $this->getIniSiteValue("img_prefix");
        // 一意
        $body = session_id() . rand();

        /********************
         * 名前
         ********************/
        $name = "{$prefix}_{$body}.{$extension}";

        return $name;
    }

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

        // テンポファイル
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
        $prefix = $this->getIniSiteValue("img_prefix");
        $body   = session_id() . rand();
        $extension = $this->getFileExtention($upfile['name']);  // 拡張子
        // ファイル名
        $tmpfile = "{$prefix}_{$body}.{$extension}";
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
     * adjust
     * 画像ファイルの調整
     *
     * @param string $src
     * @param string $dest
     * @return void
     */
    function adjust($src, $dest)
    {
        $this->logger->debug("adjust ...");

        // 幅
        $width = $this->getIniSiteValue("img_width");
        // 高さ
        $height = $this->getIniSiteValue("img_height");
        // モード
        $mode = $this->getIniSiteValue("img_createmode");
        // 拡張
        $expansion = $this->getIniSiteValue("img_expansion");

        return $this->imageControl($src, $dest, $width, $height, $mode, $expansion);
    }

    /**
     * thumbnailImage
     * サムネイルイメージの生成
     *
     * @access public
     * @param string $src
     * @param string $dest
     * @return boolean OK:true , NG:false
     */
    function thumbnailImage($src, $dest)
    {
        $this->logger->debug("thumbnailImage ...");

        // 幅
        $width = $this->getIniSiteValue("img_thumb_width");
        // 高さ
        $height = $this->getIniSiteValue("img_thumb_height");
        // モード
        $mode = $this->getIniSiteValue("img_thumb_createmode");
        // 拡張
        $expansion = $this->getIniSiteValue("img_thumb_expansion");

        return $this->imageControl($src, $dest, $width, $height, $mode, $expansion);
    }

    /**
     * setModifyMobile
     * モバイル用のサムネイルに再配布不可のコメントヘッダを追加
     *
     * @access public
     * @param string $src
     * @return void
     */
    function setModifyMobile($src)
    {
        $this->logger->debug("setModifyMobile ...");
        // ファイルチェック
        if (!is_file($src)) {
            $this->logger->debug("File is NONE. [$src]");
            return $success = true;
        }

        // 画像に再配布不可のコメント追加
        $ex = strtolower($this->getFileExtention($src));
        if ($ex == 'jpg' || $ex == 'jpeg') {
            $comment    = 'kddi_copyright=on,copy="NO"';
            $header     = get_jpeg_header_data($src);
            $new_header = put_jpeg_comment($header, $comment);
            put_jpeg_header_data($src, $src, $new_header);
        }

        return;
    }

    /**
     * imageControl
     * 画像を操作する
     *
     * @access public
     * @param string $src
     * @param string $dest
     * @return boolean OK:true , NG:false
     */
    function imageControl($src, $dest, $width, $height, $mode, $expansion)
    {
        $success = false;

        // ファイルチェック
        if (!is_file($src)) {
            $this->logger->debug("File is NONE. [$src]");
            return $success = true;
        }

        /********************
         * 調整
         ********************/
        $this->logger->debug("Image Control SRC: [{$src}]");
        $this->logger->debug("Image Control DST: [{$dest}]");
        $this->logger->debug("Image Control WIDTH:{$width}, HEIGHT:{$height}, MODE:{$mode}, EXPANSION:{$expansion}");
        $ic = new SimplanImageControl($src, $dest, $width, $height, $mode, $expansion);
        $ic->createImage();
        chmod($dest, 0777);

        return $success = true;
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
        // 画像チェック
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

        // 拡張子取得
        if(preg_match( "/^(.*)\.(.*)$/i", $target, $match)) {
            $extension = $match[2];
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
    public static function downloadFile($file, $name, $textmode = true)
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

    /**
     * カレンダートリミング
     * [note] GDとImagemagickを使用しているのでライブラリに注意
     *
     * @access    public
     * @param     string    $input    入力元
     * @param     string    $output   出力先
     * @param     string    $width    幅
     * @param     string    $height   縦
     */
    function adjust_trmmings($input, $output, $width, $height)
    {
        // check
        $this->logger->debug("Input file is [{$input}]");
        if (!is_file($input)) {
            $this->logger->error("input file is none.");
            return;
        }
        // get size
        list($cur_width, $cur_height) = getimagesize($input);

        // instance
        $thumb = PhpThumbFactory::create($input);

        // 横長の場合
        if ($cur_width >= $cur_height) {
            if ($cur_width < $width) {
                $thumb->resizePercent(($width / $cur_width * 100 ));
            }
            $thumb->resize($width, 0);                // 横に合わせる
            $thumb->cropFromCenter($width, $height);  // センターに合わせて切り取り
            $thumb->save($output);
            // 余白の追加
            $im = new Imagick($output);
            $add_height = ($height - $im->getImageHeight()) / 2 ;
            $im->setImageBackgroundColor('#FAFAF9');
            $im->spliceImage(0, $add_height, 0, 0);
            $im->spliceImage(0, ($height - $im->getImageHeight()), 0, $im->getImageHeight());
            $im->writeImage($output);
            $im->destroy();
        } else {
            if ($cur_height < $height) {
                $thumb->resizePercent(($height / $cur_height * 100 ));
            }
            $thumb->resize(0, $height);               // 縦に合わせる
            $thumb->cropFromCenter($width, $height);  // センターに合わせて切り取り
            $thumb->save($output);
            // 余白の追加
            $im = new Imagick($output);
            $add_width = ($width - $im->getImageWidth()) / 2 ;
            $im->setImageBackgroundColor('#FAFAF9');
            $im->spliceImage($add_width, 0, 0, 0);
            $im->spliceImage(($width - $im->getImageWidth()), 0, $im->getImageWidth(), 0);
            $im->writeImage($output);
            $im->destroy();
        }
    }

    function draw_ellipse($file, $x, $y, $w, $h, $name)
    {
        $image = new imagick($file);
        $draw  = new ImagickDraw;
        $draw->setfillcolor("none");
        $draw->setstrokecolor("#FF0000");
        $draw->setstrokewidth(1);
        $draw->ellipse($x, $y, $w, $h, 0, 360);
        $image->drawimage($draw);
        $image->writeImage($name);
        $draw->destroy();
        $image->destroy();
    }
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>