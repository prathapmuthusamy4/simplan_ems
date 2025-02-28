<?php
/**
 * StretchedPassword
 * パスワード生成クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
// ストレッチング件数
define("STRETCH_COUNT", 10000);
class StretchedPassword
{
    /**
     * コンストラクタ
     *
     * @access    public
     */
    function StretchedPassword()
    {
        $this->logger = new SystemLog();
        return;
    }

    /**
     *  文字列からSHA256のハッシュ値を取得
     *
     *  @access    public
     *  @param     string    $value
     *  @return    string    hash
     */
    public static function get_sha256($value)
    {
        return hash("sha256", $value);
    }

    /**
     *  ストレッチハッシュ値を取得
     *
     *  @access    public
     *  @param     string    $user_id
     *  @param     string    $password
     *  @return    string    hash
     */
    public static function get_stretched_password($user_id, $password)
    {
        $salt = StretchedPassword::get_sha256($user_id);
        $hash = "";
        for ($i=0; $i<STRETCH_COUNT; $i++) {
            $hash = StretchedPassword::get_sha256($hash . $salt . $password);
        }
        return $hash;
    }
}