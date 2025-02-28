<?php
/**
 * OnetimeTicket
 * ワンタイムチケットクラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
class OnetimeTicket
{
    /**
     * コンストラクタ
     *
     * @access    public
     */
    function OnetimeTicket()
    {
        return;
    }

    /**
     * ワンタイムチケットを生成する
     *
     *  @access    public
     *  @return    string    ticket
     */
    public static function make_onetime_ticket()
    {
        // ワンタイムチケットを生成する。
        $ticket = md5(uniqid(rand(), true));
        $_SESSION[ONETIME_TICKET_SESSION] = $ticket;
        return $ticket;
    }

    /**
     * ワンタイムチケットをチェックする
     *
     * @access    public
     * @param     string  $ticket
     * @return    bool
     */
    public static function check_onetime_ticket($ticket)
    {
        $is = false;
        // チケットが空の場合はエラー
        if (is_empty($ticket)) {
            return $is;
        }
        // セッションに保持したチケットが存在しない、または空の場合はエラー
        if (!isset($_SESSION[ONETIME_TICKET_SESSION]) || is_empty($_SESSION[ONETIME_TICKET_SESSION])) {
            return $is;
        }
        // チケットの値が異なる場合はエラー
        if ($ticket != $_SESSION[ONETIME_TICKET_SESSION]) {
            return $is;
        }
        return $is = true;
    }
}