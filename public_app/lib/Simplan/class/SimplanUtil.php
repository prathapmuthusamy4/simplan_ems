<?php
define('MAX_BEFORE_YEAR', 7);
define('MAX_AFTER_YEAR',  5);

define('MAX_BEFORE_HOUR', 0);
define('MAX_AFTER_HOUR',  24);

define('MAX_FROM_AGE', 1);
define('MAX_TO_AGE'  , 80);

/**
 *  配列から$key, $nameに対応した連想配列を返却する。
 *
 *  @param  array   $ary   配列
 *  @param  string  $key   キーにあたる部分
 *  @param  string  $name  名称にあたる部分
 *  @return array   配列に変換された値
 */
function t_array_change($ary, $key, $name)
{
    $ret = array();
    if (!is_array($ary)) {
        return $ret;
    }

    foreach($ary as $k => $v) {
        $val = $v[$key];
        $str = $v[$name];
        $ret[$val] = $str;
    }
    return $ret;
}

/**
 *  配列からキーに対する値を取得する。無い場合は空を返却
 *
 *  @param  array   $ary   配列１
 *  @return array   配列に変換された値
 */
function t_array_value($key, $list)
{
    $ret = "";
    if (!is_array($list)) {
        return $ret;
    }
    if (is_array($key)) {
        return $key;
    }
    if (array_key_exists($key, $list)) {
        $ret = $list[$key];
    }
    return $ret;
}

function t_array_key_to_num($key, $list)
{
    $ret = 0;
    if (!is_array($list)) {
        return $ret;
    }
    if (is_array($key)) {
        return $key;
    }
    $ret = (isset($list[$key])) ? $list[$key] : 0;
    return $ret;
}

/**
 *  空文字かNULLかどうか判定する
 *
 *  @param  val     value
 *  @return boolean true:empty false: not empty
 */
function is_empty($val)
{
    if ($val == null || $val == "") {
        return true;
    }
    return false;
}

/**
 *  issetかつ空文字でないかどうか判定する
 *
 *  @param  val     value
 *  @return boolean true:empty false: not empty
 */
function is_isset($key, $list)
{
    if (isset($list[$key]) && !is_empty($list[$key])) {
        return true;
    }
    return false;
}

/**
 *  無効な文字の場合は、0を返却
 *
 *  @param  val     value
 *  @return int     value
 */
function to_num($val)
{

    return (is_empty($val) || is_nan($val)) ? 0 : intval($val);
}

/**
 *  現在のURLを表示する
 *
 *  @return $URL
 */
function t_this_url($ssl = false)
{

    $s = ($ssl) ? "s" : "";
    $url = "http{$s}://"
        . htmlspecialchars($_SERVER['HTTP_HOST'],ENT_QUOTES)
        . htmlspecialchars($_SERVER['SCRIPT_NAME'],ENT_QUOTES);

    return $url;
}

/**
 * ランダムな文字列を生成し、返す
 *
 * @param   int
 * @return  string
 */
function t_random_value($len = 12)
{
    $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    mt_srand();
    $val = "";
    for ($i = 0; $i < $len; $i++) {
        $val = substr(str_shuffle($char), 0, $len);
    }

    return $val;
}

/**
 * ログ出力文字列をCSV形式に生成し、返す
 *
 * @param   string
 * @param   bool
 * @return  string
 */
function t_log_format($val, $flg = false)
{
    $str = "\"";
    $top = ($flg == true) ? $str : ",\"";
    return $top . $val . $str;
}

/**
 * 文字コードをEUC-JPに変換し、返す
 *
 * @param   string
 * @return  string
 */
function t_convert_enc_euc($val)
{
    if (is_empty($val)) {
        return $val;
    }
    return mb_convert_encoding($val, "EUC-JP", "UTF-8,EUC-JP");
}

/**
 * Booleanを文字列に変換する
 *
 * @param   string $val
 * @return  string true OR false
 */
function t_bool2str($val)
{
    return var_export($val, TRUE);
}

/**
 * 配列から指定の要素を削除する
 *
 * @param   array $array
 * @return  array $ret
 */
function t_array_delelement($array, $target)
{
    $ret = array();

    foreach($array as $k => $v) {
        if (strcmp($v, $target) != 0) {
            $ret[] = $v;
        }
    }

    return $ret;
}

/**
 * 携帯メールアドレスか判別する
 *
 * @param   string  $mail
 * @return  bool
 */
function is_mobile_email($email)
{
    $domains = array (
                      'docomo.ne.jp',
                      'ezweb.ne.jp',
                      'softbank.ne.jp',
                      't.vodafone.ne.jp',
                      'd.vodafone.ne.jp',
                      'h.vodafone.ne.jp',
                      'c.vodafone.ne.jp',
                      'k.vodafone.ne.jp',
                      'r.vodafone.ne.jp',
                      'n.vodafone.ne.jp',
                      's.vodafone.ne.jp',
                      'q.vodafone.ne.jp',
                      'pdx.ne.jp',
                      'wm.pdx.ne.jp',
                      'di.pdx.ne.jp',
                      'dj.pdx.ne.jp',
                      'dk.pdx.ne.jp',
                     );

    $tar = t_explode($email, '@');
    if (count($tar) != 2) {
        return false;
    }
    return in_array($tar[1], $domains);
}

/**
 * 郵便番号を連結する
 *
 * @param   string  $zip1
 * @param   string  $zip2
 * @return  string
 */
function concat_zip($zip1, $zip2)
{
    $ret = "";
    if (is_empty($zip1) || is_empty($zip2)) {
        return $ret;
    }
    return $zip1 . "-" . $zip2;
}

/**
 * 郵便番号にハイフンを付加する
 *
 * @param   string  $zip
 * @return  string
 */
function add_zip_hyphen($zip)
{
    if (is_empty($zip)) {
        return "";
    }
    return substr($zip, 0, 3).'-'.substr($zip, 3);
}

/**
 * 郵便番号を連結する
 *
 * @param   string  $zip1
 * @param   string  $zip2
 * @return  string
 */
function concat_time($hour, $minute)
{
    $ret = "";
    if (is_empty($hour) || is_empty($minute)) {
        return $ret;
    }
    return $hour . ":" . $minute;
}

/**
 * 電話番号を連結する
 *
 * @param   string  $tel1
 * @param   string  $tel2
 * @param   string  $tel3
 * @return  string
 */
function concat_tel($tel1, $tel2, $tel3)
{
    $ret = "";
    if (is_empty($tel1) || is_empty($tel2) || is_empty($tel3)) {
        return $ret;
    }
    return $tel1 . "-" . $tel2 . "-" . $tel3;
}

/**
 * メールアドレスを連結する
 *
 * @param   string  $mail1
 * @param   string  $mail2
 * @return  string
 */
function concat_mail($mail1, $mail2)
{
    $ret = "";
    if (is_empty($mail1) || is_empty($mail2)) {
        return $ret;
    }
    return $mail1 . "@" . $mail2;
}

/**
 * 文字列を区切文字により分割する
 *
 * @param   string  $var  文字列
 * @param   string  $sep  区切文字
 * @return  array
 */
function explode_mail($var, $sep="@")
{
    if (is_empty($var)) {
        return array();
    }
    return explode($sep, $var);
}

/**
 * 置換する
 *
 * @param   string  $mail1
 * @param   string  $mail2
 * @return  string
 */
function t_replace($val, $search, $rep="")
{
    $ret = "";
    if (is_empty($val)) {
        return $ret;
    }

    return str_replace($search, $rep, $val);
}

/**
 * サーバー変数を返却する
 *
 * @param string $ret
 */
function t_server($val)
{
    $ret = "";

    if (isset($_SERVER[$val])) {
        $ret = $_SERVER[$val];
    }

    return $ret;
}

/**
 * サーバー変数を返却する
 *
 * @param string $ret
 */
function t_env($val)
{
    $ret = "";
    $ret = getenv($val);
    return $ret;
}

/**
 * 文字列を区切文字により分割する
 *
 * @param   string  $var  文字列
 * @param   string  $sep  区切文字
 * @return  array
 */
function t_explode($var, $sep)
{
    if (is_empty($var)) {
        return array();
    }
    return explode($sep, $var);
}

/**
 * 配列の要素を区切文字により連結する
 *
 * @param   array   $var  配列
 * @param   string  $sep  区切文字
 * @return  string
 */
function t_implode($var, $sep = "")
{
    if (is_empty($var)) {
        return "";
    }
    return implode($sep, $var);
}

/**
 * Json_encode
 *
 * @param   array   $var  データ配列
 * @return  string        JSON ファイル
 */
function t_json_encode($arr)
{
    return json_encode($arr);
}

/**
 * Json_dencode
 *
 * @param   array   $var  データ配列
 * @return  string        JSON ファイル
 */
function t_json_dencode($arr)
{
    return json_dencode($arr);
}

/**
 * 数値をフォーマットする
 *
 * @param   string  $var  数値
 * @param   string  $d    小数点以下桁数
 * @return  string
 */
function t_number_format($var, $d = 2)
{
    if (is_empty($var)) {
        return "";
    }
    $decimal = (ctype_digit($var)) ? 0 : $d;
    return number_format($var, $decimal);
}

/**
 * 数値をフォーマットする
 *
 * @param   string  $var  数値
 * @param   string  $d    小数点以下桁数
 * @return  string
 */
function t_number_format_ex($var)
{
    if (is_empty($var)) {
        return "";
    }
    $ret = t_bcadd($var, 0, 2);
    return $ret;
}

/**
 * ファイルサイズを取得する
 *
 * @param   string  $var  サイズ
 * @return  string        ファイルサイズ
 */
function t_file_size($var)
{
    if (is_empty($var) || $var <= 0) {
        return "";
    }
    $size = $var / 1024 / 1024;
    return $size;
}

/**
 * SHA1で暗号化した文字列を取得する
 *
 * @param   string  $var  値
 * @return  string
 */
function t_sha1($var)
{
    if (is_empty($var)) {
        return "";
    }
    return sha1($var);
}

function t_kotei_format($var, $num = 1)
{
    if (is_empty($var)) {
        return "";
    }
    $v = sprintf("%.{$num}f", round($var, $num));
    return $v;
}
/*--------------------------------------------------*
 * 特殊関数（シェル起動等）
 * [note] 環境に依存するので推奨しません。
 *--------------------------------------------------*/
/**
 * ファイルの行数・文字数を取得する
 * [note] safe_modeがONの場合は、動作しません
 *        配列 [0] 行数 [1] 単語数 [2] バイト数 [3] ファイル名
 *
 * @param   string $file
 * @return  mixed  $fileinfo
 */
function t_exec_wc($file)
{
    // shell 実行
    $ex = shell_exec("wc {$file}");

    // 配列に格納(空要素は配列から除く)
    $ret = t_array_delelement( explode(" ", $ex), "");

    // wcからの返却値
    if (count($ret) != 4) {
        $ret = array(0, 0, 0, 0);
    }

    return $ret;
}

/**
 * tail コマンド
 * [note] safe_modeがONの場合は、動作しません
 *
 * @param   string $file
 * @param   int    $line
 * @return  string $buf
 */
function t_exec_tail($file, $line = 10)
{
    // shell 実行
    $buf = shell_exec("tail -n {$line} {$file}");

    return $buf;
}

/**
 * head コマンド
 * [note] safe_modeがONの場合は、動作しません
 *
 * @param   string $file
 * @param   int    $line
 * @return  string $buf
 */
function t_exec_head($file, $line)
{
    // shell 実行
    $buf = shell_exec("head -n {$line} {$file}");

    return $buf;
}

function t_wareki($y, $m, $d)
{
    $ret = "";
    if (is_empty($y) || is_empty($m) || is_empty($d)) {
        return $ret;
    }
    $m = str_pad($m, 2, 0, STR_PAD_LEFT);
    $d = str_pad($d, 2, 0, STR_PAD_LEFT);
    $ymd = $y . $m . $d;
    if ($ymd <= "19120729") {
        $gg = "明治";
        $yy = $y - 1867;
    } elseif ($ymd >= "19120730" && $ymd <= "19261224") {
        $gg = "大正";
        $yy = $y - 1911;
    } elseif ($ymd >= "19261225" && $ymd <= "19890107") {
        $gg = "昭和";
        $yy = $y - 1925;
    } elseif ($ymd >= "19890108") {
        $gg = "平成";
        $yy = $y - 1988;
    }
    $ret = "{$gg}{$yy}年{$m}月{$d}日";
    return $ret;
}

function t_wareki_cap($y)
{
    $ret = "";
    if (is_empty($y)) {
        return $ret;
    }
    $m = "01";
    $d = "01";
    $ymd = $y . $m . $d;
    if ($ymd <= "19120729") {
        $gg = "明治";
        $yy = $y - 1867;
    } elseif ($ymd >= "19120730" && $ymd <= "19251231") {
        $gg = "大正";
        $yy = $y - 1911;
    } elseif ($ymd >= "19260101" && $ymd <= "19881231") {
        $gg = "昭和";
        $yy = $y - 1925;
    } elseif ($ymd >= "19890101") {
        $gg = "平成";
        $yy = $y - 1988;
    }
    $ret = "{$gg}{$yy}";
    return $ret;
}

function t_wareki_y($y, $m = "01", $d = "01")
{
    $ret = "";
    if (is_empty($y)) {
        return $ret;
    }
    $ymd = $y . $m . $d;
    if ($ymd <= "19120729") {
        $yy = $y - 1867;
    } elseif ($ymd >= "19120730" && $ymd <= "19251231") {
        $yy = $y - 1911;
    } elseif ($ymd >= "19260101" && $ymd <= "19881231") {
        $yy = $y - 1925;
    } elseif ($ymd >= "19890101") {
        $yy = $y - 1988;
    }
    $ret = "{$yy}";
    return $ret;
}

function t_seireki($y, $era)
{
    $year = "";
    if (is_empty($y) || is_empty($era)) {
        return $year;
    }
    switch($era){
        case STATUS_ERA_KBN_0:
            $year = 1868 + $y;
            break;
        case STATUS_ERA_KBN_1:
            $year = 1911 + $y;
            break;
        case STATUS_ERA_KBN_2:
            $year = 1925 + $y;
            break;
        case STATUS_ERA_KBN_3:
            $year = 1988 + $y;
            break;
    }
    return $year;
}

function t_date_format($format, $y, $m, $d = 1)
{
    $ret = "";
    if (is_empty($format) || is_empty($y) || is_empty($m) || is_empty($d)) {
        return $ret;
    }
    $ret = date($format, mktime(0, 0, 0, $m, $d, $y));
    return $ret;
}

function t_datetime($y, $m, $d = 1)
{
    $ret = "";
    if (is_empty($y) || is_empty($m) || is_empty($d)) {
        return $ret;
    }
    $ret = mktime(0, 0, 0, $m, $d, $y);
    return $ret;
}

function is_leap_year($y)
{
    $is = false;
    if (checkdate(2, 29, $y)) {
        $is = true;
    }
    return $is;
}

/**
 * 四捨五入する
 *
 * @param    string    数値
 * @param    string    桁
 * @return   array
 */
function t_round($value, $digit)
{
    if (is_empty($value)) {
        return "";
    }
    return round($value, ($digit - 1));
}

/**
 * 切り捨てする
 *
 * @param    string    数値
 * @param    string    桁
 * @return   array
 */
function t_floor($value, $digit)
{
    if (is_empty($value)) {
        return "";
    }
    $num = str_pad(1, $digit, 0, STR_PAD_RIGHT);
    $d   = ($digit - 1 > 0) ? $digit - 1 : 0;
    return bcdiv(bcmul($value, $num, $d), $num, $d);
}

/**
 * 切り上げする
 *
 * @param    string    数値
 * @param    string    桁
 * @return   array
 */
function t_ceil($value, $digit)
{
    if (is_empty($value)) {
        return "";
    }
    $num = str_pad(1, $digit, 0, STR_PAD_RIGHT);
    $d   = ($digit - 1 > 0) ? $digit - 1 : 0;
    return bcdiv(ceil(bcmul($value, $num, $d)), $num, $d);
}

/**
 * 文字列を固定長の他の文字列で埋める
 *
 * @param    string    値
 * @param    string    埋める桁数
 * @param    string    埋める文字
 * @param    string    タイプ
 * @return   string
 */
function t_str_pad($input, $length, $string = " ", $type = STR_PAD_RIGHT)
{
    $value = "";
    if (is_empty($length)) {
        return $value;
    }
    $value = str_pad($input, $length, $string, $type);
    return $value;
}

/**
 * 2つの任意精度の数値を加算する
 *
 * @param    string    左オペランド
 * @param    string    右オペランド
 * @param    string    小数点以下の桁数
 * @return   string    二つの数の和を文字列で返します
 */
function t_bcadd($left, $right, $scale = 3)
{
    $value = bcadd($left, $right, $scale);
    return $value;
}

/**
 * 2つの任意精度数値の減算を行う
 *
 * @param    string    左オペランド
 * @param    string    右オペランド
 * @param    string    小数点以下の桁数
 * @return   string    減算の結果を文字列で返します
 */
function t_bcsub($left, $right, $scale = 3)
{
    $value = bcsub($left, $right, $scale);
    return $value;
}

/**
 * 2つの任意精度数値の乗算を行う
 *
 * @param    string    左オペランド
 * @param    string    右オペランド
 * @param    string    小数点以下の桁数
 * @return   string    乗算の結果を文字列で返します
 */
function t_bcmul($left, $right, $scale = 3)
{
    $value = bcmul($left, $right, $scale);
    return $value;
}

/**
 * 2つの任意精度数値で除算を行う
 *
 * @param    string    左オペランド
 * @param    string    右オペランド
 * @param    string    小数点以下の桁数
 * @return   string    除算の結果を文字列で返します
 */
function t_bcdiv($left, $right, $scale = 3)
{
    $value = bcdiv($left, $right, $scale);
    return $value;
}

/**
 *  SimplanUtil Class
 *
 */
class SimplanUtil
{

    /**
     *  年齢リストを取得する。
     *
     *  @access public
     *  @param  string  $from   開始年齢(デフォルト MAX_FROM_AGE)
     *  @param  string  $to     終了年齢(デフォルト MAX_TO_AGE)
     *  @return array   day list
     */
    public static function getAgeList($from = null, $to = null)
    {
        $ret = array();

        if (is_empty($from) || is_nan($from)) {
            $from = MAX_FROM_AGE;
        }

        if (is_empty($to) || is_nan($to)) {
            $to = MAX_TO_AGE;
        }

        for ($i = $from; $i <= $to; $i++) {
            $ret["$i"] = $i;
        }
        return $ret;
    }

    /**
     * 年齢を取得する
     *
     * @param  $year, $month, $day
     * @return 年齢
     */
    public static function getAge($year, $month, $day)
    {
        $ret = '';
        if (is_empty($year) || is_empty($month) || is_empty($day)) {
            return $ret;
        }

        $ret = (int)((date('Ymd') - date('Ymd', mktime(0, 0, 0, $month, $day, $year))) / 10000);

        return $ret;
    }

    /**
     *  年リストを取得する。
     *
     *  @access public
     *  @param  string  $to   開始年(デフォルト MAX_BEFORE_YEAR)
     *  @param  string  $from 終了年(デフォルト MAX_AFTER_YEAR)
     *  @return array   day list
     */
    public static function getYearList($from = null, $to = null)
    {
        $cur = date("Y");
        $from_year = $cur;
        $to_year = $cur;
        $ret = array();

        if (is_empty($from) || is_nan($from)) {
            $from_year = $cur - MAX_BEFORE_YEAR;
        } else {
            $from_year = $cur - $from;
        }

        if (is_empty($to) || is_nan($to)) {
            $to_year = $cur + MAX_AFTER_YEAR;
        } else {
            $to_year = $cur + $to;
        }

        for ($i = $from_year; $i < ($to_year + 1); $i++) {
            $ret["$i"] = $i;
        }
        return $ret;
    }

    /**
     *  和暦リストを取得する。
     *
     *  @access public
     *  @param  string  $to   開始年(デフォルト MAX_BEFORE_YEAR)
     *  @param  string  $from 終了年(デフォルト MAX_AFTER_YEAR)
     *  @return array   day list
     */
    public static function getWarekiList($from = null, $to = null)
    {
        $cur = date("Y");
        $from_year = $cur;
        $to_year = $cur;
        $ret = array();

        if (is_empty($from) || is_nan($from)) {
            $from_year = $cur - MAX_BEFORE_YEAR;
        } else {
            $from_year = $cur - $from;
        }

        if (is_empty($to) || is_nan($to)) {
            $to_year = $cur + MAX_AFTER_YEAR;
        } else {
            $to_year = $cur + $to;
        }

        for ($i = $from_year; $i < ($to_year + 1); $i++) {
            $ret["$i"] = t_wareki_cap($i);
        }
        return $ret;
    }

    /**
     *  月リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getMonthList()
    {
        $ret = array();
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $ret["$month"] = $month;
        }

        return $ret;
    }

    /**
     *  月リストを取得する（%02d）。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getMonthListEx()
    {
        $ret = array();
        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $ret[sprintf('%02d',$month)] = $month;
        }

        return $ret;
    }

    /**
     *  月リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getMonthListExx()
    {
        $ret = array();
        for ($i = 1; $i <= 12; $i++) {
            $ret[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }

        return $ret;
    }

    /**
     *  日付リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getDayList()
    {
        $ret = array();
        for ($i = 0; $i < 31; $i++) {
            $day = $i + 1;
            $ret["$day"] = $day;
        }

        return $ret;
    }

    /**
     *  日付リストを取得する（%02d）。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getDayListEx()
    {
        $ret = array();
        for ($i = 0; $i < 31; $i++) {
            $day = $i + 1;
            $ret["$day"] = sprintf('%02d',$day);
        }

        return $ret;
    }

    /**
     *  日付リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getDayListExx()
    {
        $ret = array();
        for ($i = 1; $i <= 31; $i++) {
            $ret[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }

        return $ret;
    }

    /**
     *  時間リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getHourList()
    {
        $ret = array();
        for ($i = MAX_BEFORE_HOUR; $i < MAX_AFTER_HOUR; $i++) {
            $ret["$i"] = $i;
        }

        return $ret;
    }

    /**
     *  時間リストを取得する（%02d）。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getHourListEx()
    {
        $ret = array();
        for ($i = MAX_BEFORE_HOUR; $i < MAX_AFTER_HOUR; $i++) {
            $ret["$i"] = sprintf('%02d',$i);
        }

        return $ret;
    }

    /**
     *  時間リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getTimeList()
    {
        $ret = array();
        for ($i = 1; $i < 11; $i++) {
            $ret["$i"] = $i;
        }

        return $ret;
    }

    public static function getMinuteList()
    {
        $ret = array();
        for ($i = 0; $i < 60; $i++) {
            $ret[sprintf('%02d',$i)] = sprintf('%02d',$i);
        }

        return $ret;
    }

    /**
     *  数値リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getNumList($start = 0, $end = 10, $term = 1)
    {
        $ret = array();
        for ($i = $start; $i < ($end+1); ) {
            $ret["$i"] = $i;
            $i += $term;
        }

        return $ret;
    }

    /**
     *  数値リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getBiuldNumList($start = 0, $end = 10, $term = 1)
    {
        $ret = array();
        for ($i = $start; $i < ($end+1); ) {
            $ret["$i"] = ($i == 0) ? "新築" : $i;
            $i += $term;
        }

        return $ret;
    }

    /**
     *  数値リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getScheNumList($start = -50, $end = 50, $term = 1)
    {
        $ret = array();
        for ($i = $start; $i < ($end+1); ) {
            $m = "";
            if ($i < 0) {
                $m = "－";
            }
            $ret["$i"] = $m . abs($i) . "日";
            $i += $term;
        }

        return $ret;
    }

    /**
     *  数値リストを取得する。
     *
     *  @access public
     *  @return array   day list
     */
    public static function getNumTermList($start = 0, $end = 10, $term = 1)
    {
        $ret = array();
        if (is_numeric($start)) {
            $ret[$start] = $start;
        }

        for($i = 1; $i <= ($end / $term); $i++) {
           $var = $i * $term;
           $ret[$var] = $var;
        }

        return $ret;
    }

    /**
     * 日付を作成する
     *
     * @param  $year, $month, $data
     * @return 日付のタイムスタンプ型
     */
    public static function makeDate($year, $month, $date, $hour = '0', $minute = '0')
    {
        $ret = null;

        if ($year != "" && $month != "" && $date != "" &&
            checkdate($month, $date, $year)) {
            $ret = mktime($hour, $minute, 0, $month, $date, $year);
        }
        return $ret;
    }

    /**
     * 関数名   ： makeDateByKey
     * 機能名   ： KEYに従い日付を作成する
     * 引　数   ： $key
     * 戻り値   ： 日付のタイムスタンプ型
     */
    public static function makeDateByKey($key, $list)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";

        return SimplanUtil::makeDate($year, $month, $day);
    }

    /**
     * 関数名   ： makeDateByKeyArray
     * 機能名   ： KEYに従い日付を作成する
     * 引　数   ： $key
     * 戻り値   ： 日付のタイムスタンプ型
     */
    public static function makeDateByKeyArray($key, $list, $idx)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'][$idx] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'][$idx] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'][$idx] : "";

        return SimplanUtil::makeDate($year, $month, $day);
    }

    /**
     * 関数名   ： makeDateTimeByKey
     * 機能名   ： KEYに従い日時を作成する
     * 引　数   ： $key
     * 戻り値   ： 日付のタイムスタンプ型
     */
    public static function makeDateTimeByKey($key, $list)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";
        $hour  = array_key_exists($key . '_h', $list) ? $list[$key . '_h'] : "";

        return SimplanUtil::makeDate($year, $month, $day, $hour);
    }

    /**
     * 関数名   ： makeDateHIByKey
     * 機能名   ： KEYに従い日時を作成する
     * 引　数   ： $key
     * 戻り値   ： 日付のタイムスタンプ型
     */
    public static function makeDateHIByKey($key, $list)
    {
        $year   = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month  = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day    = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";
        $hour   = array_key_exists($key . '_h', $list) ? $list[$key . '_h'] : "";
        $minute = array_key_exists($key . '_i', $list) ? $list[$key . '_i'] : "";

        return SimplanUtil::makeDate($year, $month, $day, $hour, $minute);
    }

    /**
     * 関数名   ： makeDiffDateByKey
     * 機能名   ： 日付の差を作成する
     * 引　数   ： $key
     * 戻り値   ： 日付の差
     */
    public static function makeDiffDateByKey($fromkey, $tokey, $list)
    {
        $from_year  = array_key_exists($fromkey . '_y', $list) ? $list[$fromkey . '_y'] : "";
        $from_month = array_key_exists($fromkey . '_m', $list) ? $list[$fromkey . '_m'] : "";
        $from_day   = array_key_exists($fromkey . '_d', $list) ? $list[$fromkey . '_d'] : "";

        $to_year  = array_key_exists($tokey . '_y', $list) ? $list[$tokey . '_y'] : "";
        $to_month = array_key_exists($tokey . '_m', $list) ? $list[$tokey . '_m'] : "";
        $to_day   = array_key_exists($tokey . '_d', $list) ? $list[$tokey . '_d'] : "";

        $from = SimplanUtil::makeDate($from_year, $from_month, $from_day);
        $to   = SimplanUtil::makeDate($to_year, $to_month, $to_day);

        $diff = 0;
        $diff = ($to - $from) / 86400;

        return $diff;

    }

    /**
     * 関数名   ： makeDiffDateByKeyArray
     * 機能名   ： 日付の差を作成する
     * 引　数   ： $key
     * 戻り値   ： 日付の差
     */
    public static function makeDiffDateByKeyArray($fromkey, $tokey, $list, $idx)
    {
        $from_year  = array_key_exists($fromkey . '_y', $list) ? $list[$fromkey . '_y'][$idx] : "";
        $from_month = array_key_exists($fromkey . '_m', $list) ? $list[$fromkey . '_m'][$idx] : "";
        $from_day   = array_key_exists($fromkey . '_d', $list) ? $list[$fromkey . '_d'][$idx] : "";

        $to_year  = array_key_exists($tokey . '_y', $list) ? $list[$tokey . '_y'][$idx] : "";
        $to_month = array_key_exists($tokey . '_m', $list) ? $list[$tokey . '_m'][$idx] : "";
        $to_day   = array_key_exists($tokey . '_d', $list) ? $list[$tokey . '_d'][$idx] : "";

        $from = SimplanUtil::makeDate($from_year, $from_month, $from_day);
        $to   = SimplanUtil::makeDate($to_year, $to_month, $to_day);

        $diff = 0;
        $diff = ($to - $from) / 86400;

        return $diff;

    }

    /**
     * 関数名   ： checkedSelectDate
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkedSelectDate($year, $month, $date)
    {
        if ( (!is_empty($year) && !is_empty($month) && !is_empty($date)) ) {
            return true;
        }
        return false;
    }

    /**
     * 関数名   ： checkedSelectDateTime
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkedSelectDateTime($year, $month, $date, $hour)
    {
        if ( (!is_empty($year) && !is_empty($month) && !is_empty($date) && !is_empty($hour)) ) {
            return true;
        }
        return false;
    }

    /**
     * 関数名   ： checkSelectDateByKey
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されているもしくは全て選択されていないとき, False:ng
     */
    public static function checkSelectDateByKey($key, $list)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";

        return SimplanUtil::checkedSelectDate($year, $month, $day);
    }

    /**
     * 関数名   ： checkSelectDateByKeyArray
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されているもしくは全て選択されていないとき, False:ng
     */
    public static function checkSelectDateByKeyArray($key, $list, $idx)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'][$idx] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'][$idx] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'][$idx] : "";

        return SimplanUtil::checkedSelectDate($year, $month, $day);
    }

    /**
     * 関数名   ： checkSelectDateTimeByKey
     * 機能名   ： 日時のチェックを行う
     * 引　数   ： $year, $month, $data, $hour
     * 戻り値   ： True:全て選択されているもしくは全て選択されていないとき, False:ng
     */
    public static function checkSelectDateTimeByKey($key, $list)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";
        $hour  = array_key_exists($key . '_h', $list) ? $list[$key . '_h'] : "";

        return SimplanUtil::checkSelectDateTime($year, $month, $day, $hour);
    }

    /**
     * 関数名   ： checkSelectDate
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されているもしくは全て選択されていないとき, False:ng
     */
    public static function checkSelectDate($year, $month, $date)
    {

        if ( (is_empty($year) && is_empty($month) && is_empty($date)) ) {
            return true;
        }
        if (!is_empty($year) && !is_empty($month) && !is_empty($date))  {
            if (checkdate($month, $date, $year)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 関数名   ： checkSelectDateTime
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されているもしくは全て選択されていないとき, False:ng
     */
    public static function checkSelectDateTime($year, $month, $date, $hour)
    {

        if ( (is_empty($year) && is_empty($month) && is_empty($date) && is_empty($hour)) ) {
            return true;
        }
        if (!is_empty($year) && !is_empty($month) && !is_empty($date) && !is_empty($hour))  {
            if (checkdate($month, $date, $year)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 関数名   ： checkedSelectDateByKey
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkedSelectDateByKey($key, $list)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";

        return SimplanUtil::checkSelectDate($year, $month, $day);
    }

    /**
     * 関数名   ： checkedSelectDateByKeySeq
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkedSelectDateByKeySeq($key, $idx, $list)
    {
        $year  = array_key_exists($key . '_y' . $idx, $list) ? $list[$key . '_y' . $idx] : "";
        $month = array_key_exists($key . '_m' . $idx, $list) ? $list[$key . '_m' . $idx] : "";
        $day   = array_key_exists($key . '_d' . $idx, $list) ? $list[$key . '_d' . $idx] : "";

        return SimplanUtil::checkSelectDate($year, $month, $day);
    }

    /**
     * 関数名   ： checkedSelectDateTimeByKey
     * 機能名   ： 日時のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkedSelectDateTimeByKey($key, $list)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'] : "";
        $hour  = array_key_exists($key . '_h', $list) ? $list[$key . '_h'] : "";

        return SimplanUtil::checkedSelectDateTime($year, $month, $day, $hour);
    }

    /**
     * 関数名   ： checkedSelectDateByKey
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkedSelectDateByKeyArray($key, $list, $idx)
    {
        $year  = array_key_exists($key . '_y', $list) ? $list[$key . '_y'][$idx] : "";
        $month = array_key_exists($key . '_m', $list) ? $list[$key . '_m'][$idx] : "";
        $day   = array_key_exists($key . '_d', $list) ? $list[$key . '_d'][$idx] : "";

        return SimplanUtil::checkSelectDate($year, $month, $day);
    }

    /**
     * 関数名   ： checkDateTermByKey
     * 機能名   ： 日付の期間チェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkDateTermByKey($fromkey, $tokey, $list)
    {
        if ( !(SimplanUtil::checkedSelectDateByKey($fromkey, $list) &&
               SimplanUtil::checkedSelectDateByKey($tokey, $list))) {
            return true;
        }
        $from = SimplanUtil::makeDateByKey($fromkey, $list);
        $to = SimplanUtil::makeDateByKey($tokey, $list);
        if ( !is_nan($from) && !is_nan($to) && $from > $to) {
            return false;
        }
        return true;
    }

    /**
     * 関数名   ： checkDateTermByKeyArray
     * 機能名   ： 日付の期間チェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkDateTermByKeyArray($fromkey, $tokey, $list, $idx)
    {
        if (!(SimplanUtil::checkedSelectDateByKeyArray($fromkey, $list, $idx) &&
               SimplanUtil::checkedSelectDateByKeyArray($tokey, $list, $idx))) {
            return true;
        }
        $from = SimplanUtil::makeDateByKeyArray($fromkey, $list, $idx);
        $to = SimplanUtil::makeDateByKeyArray($tokey, $list, $idx);
        if (!is_nan($from) && !is_nan($to) && $from > $to) {
            return false;
        }
        return true;
    }

    /**
     * 関数名   ： checkDateTimeTermByKey
     * 機能名   ： 日時の期間チェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されている, False:ng
     */
    public static function checkDateTimeTermByKey($fromkey, $tokey, $list)
    {
        if ( !(SimplanUtil::checkedSelectDateTimeByKey($fromkey, $list) &&
               SimplanUtil::checkedSelectDateTimeByKey($tokey, $list))) {
            return true;
        }
        $from = SimplanUtil::makeDateTimeByKey($fromkey, $list);
        $to = SimplanUtil::makeDateTimeByKey($tokey, $list);
        if ( !is_nan($from) && !is_nan($to) && $from > $to) {
            return false;
        }
        return true;
    }

    /**
     * 関数名   ： checkSelectDateEx
     * 機能名   ： 日付のチェックを行う
     * 引　数   ： $year, $month, $data
     * 戻り値   ： True:全て選択されているもしくは全て選択されていないとき, False:ng
     */
    public static function checkSelectDateEx($year, $month, $date, $hour, $minute)
    {
        if ( (is_empty($year) && is_empty($month) && is_empty($date) &&
              is_empty($hour) && is_empty($minute)) ) {
            return true;
        }
        if (!is_empty($year) && !is_empty($month) && !is_empty($date) &&
            !is_empty($hour) && !is_empty($minute))  {
            if (checkdate($month, $date, $year)) {
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * 関数名   ：  makePageCalc
     * 機能名   ：  ページタグ計算処理用メソッド
     * 引　数   ：  $allCount   ：  データ全件数
     *              $nowPage    ：  現在のページ番号
     *              $pageLimit  ：  １ページに表示できる件数
     * 戻り値   ：  処理結果を格納した配列
     *              $arr_result['page']         現在のページ
     *              $arr_result['offset']       取得データの開始位置
     *              $arr_result['limit']        取得データの終了位置
     *              $arr_result['max_page']     ページ数の最終ページ
     * 備　考   ：  「$arr_result['offset'] - 1」(0以下の時は0にする)と「$change」で
     *              DBの OFFSET と LIMIT の値がとれます
     */
    public static function makePageCalc($allCount, $nowPage, $pageLimit)
    {
        //*** データ終了ページ ***//
        $page_num = ceil($allCount / $pageLimit);

        // 現在のページが終了ページより大きい時現在のページを最後のページにする
        if ($nowPage >= $page_num) {
            $nowPage = $page_num ;
        }

        //*** データ開始位置 ***//
        // ページが指定されていない時もしくはページ数が０以下になった時
        if (strlen( $nowPage ) == 0 || $nowPage < 1) {
            // データがある時、現在のページとデータ開始位置を1にする
            if ($allCount > 0) {
                $offset = 1;
                $nowPage   = 1;
            } else {
            // データがない時、現在のページとデータ開始位置を0にする
                $offset = 0;
                $nowPage   = 0;
            }
        } else {
            // 通常データの時、開始位置の計算
            $offset = ($nowPage - 1) * $pageLimit + 1;
        }
        if ($offset > $allCount) {
            $offset = $allCount;
        }

        //*** データ終了位置 ***//
        $limit = $nowPage * $pageLimit;
        if ($limit > $allCount) {
            $limit = $allCount;
        }
        $offset = ($offset < 1) ? 1 : $offset;

        $result = array();
        $result['page']      = $nowPage;    // 現在のページ
        $result['offset']    = $offset;     // 取得データの開始位置
        $result['limit']     = $limit;      // 取得データの終了位置
        $result['max_page']  = $page_num;   // ページ数の最終ページ

        return $result;
    }

    /**
     * 関数名   ： replaceStringArray
     * 機能名   ： 置換処理
     * 引　数   ： $v
     * 戻り値   ： 置換後の値
     */
    public static function replaceStringArray($value, $target)
    {

        $ret = $target;

        // check
        if (!is_array($value)) {
            return $ret;
        }

        // 置換
        foreach ($value as $key => $val) {
            $ret = str_replace($key, SimplanUtil::htmlspecialcharsDecode($val), $ret);
        }

        return $ret;
    }

    /**
     * 関数名   ： htmlspecialchars
     * 機能名   ： 置換処理
     * 引　数   ： $v
     * 戻り値   ： 置換後の値
     */
    public static function htmlspecialcharsDecode($target)
    {

        $ret = $target;

        // target
        $value = array( "&amp;" => '&',
                        "&lt;" => '<',
                        "&gt;" => '>',
                        "&quot;" => '"',
                        "&#039;" => "'",
                        );

        // 置換
        foreach ($value as $key => $val) {
            $ret = str_replace($key, $val, $ret);
        }

        return $ret;
    }

    /**
     * 関数名   ： antiProhibitionDecode
     * 機能名   ： 置換処理
     * 引　数   ： $v
     * 戻り値   ： 置換後の値
     */
    public static function antiProhibitionDecode($target, $htmlde = false)
    {

        $ret = $target;

        if ($htmlde) {
            $ret = SimplanUtil::htmlspecialcharsDecode($ret);
        }

        // target
        $value = array( "，" => ",",
                        "”" => "\"",
                        "’" => "'",
                        "＜" => "<",
                        "＞" => ">",
                        "￥" => "\\\\",
                        "＄" => "\$",
                        );

        // 置換
        foreach ($value as $key => $val) {
            $ret = str_replace($key, $val, $ret);
        }

        return $ret;
    }

    /**
     * ファイルを読み込む
     *  $reverse にTrueを指定した場合は、ファイルの内容を逆から読む.
     *
     * @param  string  $filename
     * @param  boolean $reverse
     * @param  int     $maxline
     * @return 記録内容
     */
    public static function read_file($filename, $reverse = false)
    {
        $success = false;
        $record = "";     // 読み込みデータ

        // check
        if (!file_exists($filename)) {
            return $record;
        }

        // オープン
        $fp = fopen($filename, "rb");
        if (!$fp) {
            return $record;
        }

        // 排他ロック
        if (flock($fp, LOCK_EX)) {
            while (!feof($fp)) {
                $buf = fgets($fp);
                if ($reverse) {
                    $record = $buf . $record;
                } else {
                    $record .= $buf;
                }
            }

            // ファイルクローズ
            fclose($fp);
        }

        $record = mb_convert_encoding($record, "UTF-8", "UTF-8,SJIS");
        return $record;
    }

    /**
     * ファイルを書き込む
     *
     * @param  $filename, $buf
     * @return 記録内容
     */
    public static function write_file($filename, $buf, $mode = "wb+")
    {
        $success = false;

        // オープン
        $fp = fopen( $filename, $mode);
        if (!$fp) {
            return $success;
        }

        // 排他ロック
        $data = mb_convert_encoding($buf, "UTF-8", "UTF-8,SJIS");
        if (flock($fp, LOCK_EX)) {

            if (fwrite($fp, $data) === FALSE) {
                // ng
            } else {
                $success = true;
                // ok
            }
            // ファイルクローズ
            fclose($fp);
        }

        return $success;
    }

    /**
     * ディレクトリを読む
     *
     * @access public
     * @param  string $dir
     * @param  string $extension 拡張子
     * @return array ファイルリスト
     */
    public static function scan_dir($dir, $extension = "", $nameprefix = '')
    {
        $files = array();

        // check
        if (!is_dir($dir)) {
            return $files;
        }

        /*--------------------*
         * scan dir
         *--------------------*/
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                $cur = $dir . $file;
                if (($file == '.') || ($file == '..') || ($file == '.svn')) {
                    continue;
                }
                if ($nameprefix != "" &&
                    preg_match("/^{$nameprefix}/", $file ) == false) {
                    continue;
                }

                if (is_file($cur)) {
                    $cur_info = pathinfo($cur);

                    // 拡張子が指定されていればその拡張子のみを取得
                    if ($extension != "" &&
                        strtolower($cur_info['extension']) != strtolower($extension)) {
                        continue;
                    }

                    // file info set
                    $files[] = SimplanUtil::fileinfo($cur);
                }
            }
            closedir($handle);
        }

        return $files;
    }

    /**
     * 再帰的にディレクトリを読む
     *
     * @access public
     * @param  string $dir
     * @param  string $nameprefix 対象ファイル接頭語
     * @param  string $extension 拡張子
     * @return array ファイルリスト
     */
    public static function scan_dir_recursive($dir, $extension = "", $nameprefix = '')
    {
        $files = array();

        // check
        if (!is_dir($dir)) {
            return $files;
        }

        /*--------------------*
         * scan dir
         *--------------------*/
        if ($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                $cur = $dir . $file;

                // 対象チェック
                if (($file == '.') || ($file == '..') || ($file == '.svn')) {
                    continue;
                }

                if ($nameprefix != "" &&
                    preg_match("/^{$nameprefix}/", $file ) == false) {
                    continue;
                }

                // ファイルの場合
                if (is_file($cur)) {
                    $cur_info = pathinfo($cur);

                    // 拡張子が指定されていればその拡張子のみを取得
                    if ($extension != "" &&
                        strtolower($cur_info['extension']) != strtolower($extension)) {
                        continue;
                    }

                    // file info set
                    $files[] = SimplanUtil::fileinfo($cur);
                }

                // ディレクトリの場合
                if (is_dir($cur)) {
                    $cur .= "/";
                    // file info set
                    $files[] = SimplanUtil::fileinfo($cur);
                    $scan = SimplanUtil::scan_dir_recursive($cur, $extension); // 下層スキャン
                    $files = array_merge($files, $scan);
                }
            }
            closedir($handle);
        }

        return $files;
    }

    /**
     * ファイル情報
     *
     * @param  string $file    ファイルパス
     * @return array  $info    ファイル情報
     */
    public static function fileinfo($file)
    {
        $cur = pathinfo($file);

        // ファイル情報
        $info = array();
//        $info['name'] =  $cur['basename'];
        $info['name'] =  substr(strrchr($file,'/'), 1);
        $info['fullname'] = $file;
        $info['group'] = filegroup($file);
        $info['owner'] = fileowner($file);
        $info['size']  = filesize($file);
        $info['type']  = filetype($file);
        $info['perms'] = fileperms($file);
        $info['mtime'] = filemtime($file);
        $info['extension'] = "";
        $info['basename'] = "";
        $info['line'] = "";

        // ファイルの場合は下記の情報
        if (!is_dir($file)) {
            $info['extension'] = (isset($cur['extension'])) ? $cur['extension'] : "";
            $info['basename'] = basename($file, ".{$info['extension']}");
        }

        return $info;
    }

    /**
     * $listを元にビットが立ってるかどうかの判定を行い配列を返却する
     *
     * @param  $sum    合計値
     * @param  $list   対象配列
     * @param  $keyflg true: キーを元, false: 値を元に判定
     * @return 配列
     */
    public static function bit_array($sum, $list, $keyflg = true)
    {
        $ret = array();

        foreach($list as $k => $v) {
            $target = $keyflg ? $k : $v;
            if ( ($target & $sum) == $target) {
                $ret[] = $target;
            }
        }

        return $ret;
    }

    /**
     * プロパティがあるか判断し値を返却する
     *
     * @param  $input, $name, $default = ''
     * @return 判定結果
     */
    public static function getIssetParam($input, $name, $default = '')
    {

        $ret = '';

        // check
        if (!is_array($input)) {
            return $ret;
        }

        // judge
        if (array_key_exists($name, $input)) {
            $ret = $input[$name];
        } else {
            $ret = $default;
        }
        return $ret;
    }

    /**
     * 指定した基準に最適化した画像サイズを返す
     *
     *
     * @param  $input, $name, $default = ''
     * @return 判定結果
     */
    public static function optimizedImageInfo($image, $new_width, $new_height, $mode="AUTO")
    {
        $info = array('', '');

        // チェック
        if(!file_exists($image)) {
            return $info;
        }

        // 既存の画像ファイル情報
        $cur = getimagesize($image);
        if (!$cur) {
            return $info;
        }
        $cur_width  = $cur[0];  // 現在の幅
        $cur_height = $cur[1];  // 現在の高さ

        // 縮小率算出
        switch ($mode) {
            case 'WIDTH':   //横幅を基準に調整
                $percent_x = (float)($new_width / $cur_width) * 100;
                $percent_y = $percent_x;
                break;
            case 'HEIGHT':  //高さを基準に調整
                $percent_y = (float)($new_height / $cur_height) * 100;
                $percent_x = $percent_y;
                break;
            case 'CERTAIN': //絶対指定調整
                $percent_x = (float)($new_width / $cur_width) * 100;
                $percent_y = (float)($new_height / $cur_height) * 100;
                 break;
/*
            case 'AUTO':    //自動調整
                if ($cur_width > $cur_height) { //横幅で調整
                    $percent_x = (float)($new_width / $cur_width) * 100;
                    $percent_y = $percent_x;
                } else {                            //高さで調整
                    $percent_y = (float)($new_height / $cur_height) * 100;
                    $percent_x = $percent_y;
                }
                break;
*/
            case 'AUTO':         //自動調整
                if ($new_width < $cur_width || $new_height < $cur_height) {
                    if (($new_width / $cur_width) < ($new_height / $cur_height)) {
                        $percent_x = (float)($new_width / $cur_width) * 100;
                        $percent_y = $percent_x;
                    } else {
                        $percent_y = (float)($new_height / $cur_height) * 100;
                        $percent_x = $percent_y;
                    }
                } else {
                    $percent_x = 100;
                    $percent_y = 100;
                }
                break;
            default:
                return $info;
        }

        // 最終サイズ
        $correct_width   = floor($cur_width  * $percent_x / 100); // 幅
        $correct_height  = floor($cur_height * $percent_y / 100); // 高さ
        $info[0] = $correct_width;
        $info[1] = $correct_height;

        return $info;
    }

    /**
     * 指定した基準に最適化した画像サイズを返す
     *
     *
     * @param  $input, $name, $default = ''
     * @return 判定結果
     * @author Mahesvaran
     */
    public static function optimizedImageInfo2($image, $w, $h, $mode="AUTO"){
	    $info = array('', '');
	    // チェック
	    if(!file_exists($image)) {
		    return $info;
	    }
	    // get image size of img
	    $x = getimagesize($image);
	    // image width
	    $sw = $x[0];
	    // image height
	    $sh = $x[1];
	    switch ($mode) {
		    case 'WIDTH':
			    // autocompute height if only width is set
			    $h = (100 / ($sw / $w)) * .01;
			    $h = @round ($sh * $h);
			    break;
		    case 'HEIGHT':
			    // autocompute width if only height is set
			    $w = (100 / ($sh / $h)) * .01;
			    $w = @round ($sw * $w);
			    break;
		    case 'CERTAIN':
			    break;
		    case 'AUTO':
			    // get the smaller resulting image dimension if both height
			    // and width are set and $constrain is also set
			    $hx = (100 / ($sw / $w)) * .01;
			    $hx = @round ($sh * $hx);

			    $wx = (100 / ($sh / $h)) * .01;
			    $wx = @round ($sw * $wx);

			    if ($hx < $h) {
				    $h = (100 / ($sw / $w)) * .01;
				    $h = @round ($sh * $h);
			    } else {
				    $w = (100 / ($sh / $h)) * .01;
				    $w = @round ($sw * $w);
			    }
			    break;
	    }

	    $info[0] = $w;
	    $info[1] = $h;

	    return $info;
    }
}
?>