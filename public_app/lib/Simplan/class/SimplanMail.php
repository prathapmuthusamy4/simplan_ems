<?php

// PHPMailer
include_once("PhpMailer" . DIRECTORY_SEPARATOR . "class.phpmailer.php");

/**
 * SimplanMaile
 *
 * [note] 現在、日本語のみ対応
 *
 * @author    Toru Yoshikawa
 * @version   0.1
 * @copyright 2010 THREET
 * @license
 */
class SimplanMail extends PHPMailer
{
    var $to_enc = "";       // メールエンコード
    var $in_enc = "UTF-8";  // 内部エンコード
    var $logger;            // ログ
    var $smarty;            // Smarty

    /**
     * Construct
     *
     * @param string $lang
     * @return void
     */
    function __construct($logger, $lang = "ja")
    {
        // 言語設定
        if ($lang == "ja") {
            $this->Encoding = "7bit";
            $this->CharSet = "iso-2022-jp";
            $this->to_enc = "JIS";
        }

        // SimplanSmarty初期化
        $this->smarty = new SimplanSmarty();
        $this->smarty->compile_dir = TMP_DIR . "mail";
        $this->smarty->cache_dir = $this->smarty->compile_dir;

        // logger初期化
        $this->logger = $logger;

        return;
    }

    /**
     * BODY生成
     *
     * @access public
     * @param string $title
     * @return string
     */
    function makeBody($id, $param, $site_ini)
    {
        $body = "";
        $template = HTML_DIR . "mail/" . $id . ".tpl";
        $this->logger->debug("Send mail ... template is [{$template}].");

        // パラメータセット
        $this->smarty->assign("param", $param);
        $this->smarty->assign("common", $site_ini->getSection("BASE"));

        // making body
        $body = $this->smarty->fetch($template);
        $this->logger->debug("Send mail ... Make body is OK.");

        return $body;
    }

    /**
     * メール送信
     *
     * @access public
     * @return boolean
     */
    function send()
    {
        $success = false;
        $this->logger->debug("Send mail ... Start");

        /*---------------
         * 送信
         *---------------*/
        $success = parent::send();

        // メールログを出力する
        $header = $this->CreateHeader();
        $body = mb_convert_encoding($this->CreateBody(), "UTF-8", "JIS,UTF-8");
        $param = array(t_bool2str($success), $header, $body);
        // write
        $this->logger->writeMailLog($param);
        $this->logger->debug("Send mail ... Mail Contents\n{$header}{$body}\n");

        return $success;
    }

    /**
     * 宛先追加
     *
     * @access public
     * @param string $address
     * @param string $name
     * @return void
     */
    function AddAddress($address, $name = "")
    {
        // check
        if (is_empty($address)) {
            return;
        }
        if (!is_empty($name)){
            $name = $this->encodeMimeHeader($this->_convenc($name));
        }

        parent::AddAddress($address, $name);

        return;
    }

    /**
     * 宛先追加
     *
     * @param string $address
     * @param string $name
     * @return void
     */
    function AddTo($address, $name = "")
    {
        $this->addAddress($address, $name);

        return;
    }

    /**
     * CC追加
     *
     * @access public
     * @param string $address
     * @param string $name
     * @return void
     */
    function AddCC($address, $name = "")
    {
        // check
        if (is_empty($address)) {
            return;
        }
        if (!is_empty($name)){
            $name = $this->encodeMimeHeader($this->_convenc($name));
        }
        parent::AddCC($address, $name);

        return;
    }

    /**
     * BCC追加
     *
     * @access public
     * @param string $address
     * @param string $name
     * @return void
     */
    function AddBCC($address, $name = "")
    {
        // check
        if (is_empty($address)) {
            return;
        }
        if (!is_empty($name)){
            $name = $this->encodeMimeHeader($this->_convenc($name));
        }
        parent::AddBCC($address, $name);

        return;
    }

    /**
     * Reply-To追加
     *
     * @access public
     * @param string $address
     * @param string $name
     * @return void
     */
    function AddReplyTo($address, $name="")
    {
        // check
        if (is_empty($address)) {
            return;
        }
        if (!is_empty($name)){
            $name = $this->encodeMimeHeader($this->_convenc($name));
        }

        parent::AddReplyTo($address,$name);

        return;
    }

    /**
     * 題名の設定
     *
     * @access public
     * @param string $subject
     * @return void
     */
    function setSubject($subject)
    {
        $this->Subject = $this->encodeMimeHeader($this->_convenc($subject));

        return;
    }

    /**
     * 差出人アドレスのセット
     *
     * @access public
     * @param string $from
     * @param string $fromname
     * @return void
     */
    function setFrom($from, $fromname = "", $auto = 1)
    {
        $this->From = $from;
        if (!is_empty($fromname)){
            $this->setFromName($fromname);
        }

        return;
    }

    /**
     * 差出人名のセット
     *
     * @access public
     * @param string $fromname 差し出し人名
     * @return void
     */
    function setFromName($fromname)
    {
        $this->FromName = $this->encodeMimeHeader($this->_convenc($fromname));

        return;
    }

    /**
     * テキスト本文のセット
     * (text/plain)
     *
     * @access public
     * @param string $body
     * @return void
     */
    function setBody($body)
    {
        $this->Body = $this->_convenc($body);
        $this->AltBody = "";
        $this->IsHtml(false);

        return;
    }

    /**
     * HTML本文のセット
     * (text/html)
     *
     * @access public
     * @param string $htmlbody
     * @return void
     */
    function setHtmlBody($htmlbody)
    {
        $this->Body = $this->_convenc($htmlbody);
        $this->IsHtml(true);

        return;
    }

    /**
     * 代替え本文のセット
     *
     * @access public
     * @param string $altbody
     * @return void
     */
    function setAltBody($altbody)
    {
        $this->AltBody = $this->_convenc($altbody);

        return;
    }

    /**
     * カスタムヘッダー追加
     *
     * @access public
     * @param string $key
     * @param string $value
     * @return void
     */
    function addHeader($key, $value)
    {
        if (is_empty($value)){
            return;
        }
        $this->AddCustomHeader($key.":".$this->encodeMimeHeader($this->_convenc($value)));

        return;
    }

    /**
     * エラーメッセージを取得する
     *
     * @access public
     * @return string エラーメッセージ
     */
    function getErrorMessage()
    {
        return $this->ErrorInfo;
    }

    /**
     * PHPMailerのencodeHeaderをオーバーライドして無効化
     *
     * @access public
     * @return string $str
     */
    function EncodeHeader($str, $position="text")
    {
        return $str;
    }


    /**
     * _convenc
     *
     * @access private
     * @param string $str
     * @return encoded string
     */
    function _convenc($str)
    {
        return mb_convert_encoding($str, $this->to_enc, $this->in_enc);
    }


    /**
     * Mimeエンコード処理
     *
     * @access public
     * @return string $encoded
     */
    function encodeMimeHeader($string, $charset = null, $linefeed = "\r\n")
    {
        if (!strlen($string)){
            return "";
        }

        if (is_empty($charset)) {
            $charset = $this->CharSet;
        }

        $start = "=?$charset?B?";
        $end = "?=";
        $encoded = "";

        /* Each line must have length <= 75, including $start and $end */
        $length = 75 - strlen($start) - strlen($end);
        /* Average multi-byte ratio */
        $ratio = mb_strlen($string, $charset) / strlen($string);
        /* Base64 has a 4:3 ratio */
        $magic = $avglength = floor(3 * $length * $ratio / 4);

        for ($i=0; $i <= mb_strlen($string, $charset); $i+=$magic) {
            $magic = $avglength;
            $offset = 0;
            /* Recalculate magic for each line to be 100% sure */
            do {
                $magic -= $offset;
                $chunk = mb_substr($string, $i, $magic, $charset);
                $chunk = base64_encode($chunk);
                $offset++;
            } while (strlen($chunk) > $length);

            if ($chunk)
                $encoded .= " ".$start.$chunk.$end.$linefeed;
        }
        /* Chomp the first space and the last linefeed */
        $encoded = substr($encoded, 1, -strlen($linefeed));

        return $encoded;
    }
}

?>