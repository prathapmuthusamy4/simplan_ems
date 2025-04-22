<?php
// define
define("POWER_CIS_AUTH_1",   1);
define("POWER_CIS_AUTH_2",   2);
define("POWER_CIS_AUTH_4",   4);
define("POWER_CIS_AUTH_8",   8);
define("POWER_CIS_AUTH_16",  16);
define("POWER_CIS_AUTH_32",  32);
define("POWER_CIS_AUTH_64",  64);
define("POWER_CIS_AUTH_128", 128);
define("POWER_CIS_AUTH_256", 256);
define("POWER_CIS_AUTH_512", 512);
define("POWER_CIS_AUTH_KBN_LIST",
       serialize(array(POWER_CIS_AUTH_1   => "受付",
                       POWER_CIS_AUTH_2   => "契約",
                       POWER_CIS_AUTH_4   => "顧客",
                       POWER_CIS_AUTH_8   => "料金メニュー",
                       POWER_CIS_AUTH_16  => "請求書",
                       POWER_CIS_AUTH_32  => "マスタメンテナンス",
                       POWER_CIS_AUTH_64  => "各種設定"
                       )));

class AuthCheck
{
    var $logger;

    /**
     * コンストラクタ
     *
     * @access    public
     */
    function AuthCheck()
    {
        $this->logger = new SystemLog();
        return;
    }

    /**
     *  権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    public static function is_auth($value, $target)
    {
        $ret = false;
        // check
        if (!is_numeric($value) && !is_numeric($target)) {
            return $ret;
        }
        // judge
        $ret = (((int)$value & (int)$target) == $target);
        return $ret;
    }

    /**
     *  受付の権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_1($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_1);
    }

    /**
     *  契約の権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_2($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_2);
    }

    /**
     *  顧客の権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_4($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_4);
    }

    /**
     *  料金メニューの権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_8($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_8);
    }

    /**
     *  請求書の権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_16($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_16);
    }

    /**
     *  マスタメンテナンスの権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_32($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_32);
    }

    /**
     *  各種設定の権限があるかどうか
     *
     *  @access public
     *  @param  string  $value
     *  @return bool
     */
    function is_auth_64($value)
    {
        return AuthCheck::is_auth($value, POWER_CIS_AUTH_64);
    }

    /**
     * 申込受付のアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_accept($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/accept\.php/", $page) > 0
         || preg_match("/\/accept_import\.php/", $page) > 0) {
            // 受付
            if ($this->is_auth_1($authval)) {
                $this->logger->info("Auth [RECEPTION] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [RECEPTION] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     * 契約のアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_agreement($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/reception\.php/", $page) > 0
         || preg_match("/\/agreement\.php/", $page) > 0
         || preg_match("/\/agreement_renewal\.php/", $page) > 0
         || preg_match("/\/agreement_notice\.php/", $page) > 0
         || preg_match("/\/invoice_group\.php/", $page) > 0
         || preg_match("/\/business_type_supply\.php/", $page) > 0
         || preg_match("/\/max_demand_power_csv\.php/", $page) > 0
         || preg_match("/\/reception_import\.php/", $page) > 0) {
            // 契約
            if ($this->is_auth_2($authval)) {
                $this->logger->info("Auth [AGREEMENT] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [AGREEMENT] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     * 顧客のアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_client($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/client\.php/", $page) > 0
         || preg_match("/\/contact\.php/", $page) > 0
         || preg_match("/\/fix_value_download\.php/", $page) > 0
         || preg_match("/\/news\.php/", $page) > 0) {
            // 契約
            if ($this->is_auth_4($authval)) {
                $this->logger->info("Auth [AGREEMENT] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [AGREEMENT] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     *  料金メニューのアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_price_plan($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/price_plan\.php/", $page) > 0
         || preg_match("/\/price_rule\.php/", $page) > 0
         || preg_match("/\/juryo_plan\.php/", $page) > 0
         || preg_match("/\/teigaku_plan\.php/", $page) > 0
         || preg_match("/\/season_plan\.php/", $page) > 0
         || preg_match("/\/jikaho_plan\.php/", $page) > 0
         || preg_match("/\/free_plan\.php/", $page) > 0) {
            // 料金メニュー
            if ($this->is_auth_8($authval)) {
                $this->logger->info("Auth [PRICE_MENU] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [PRICE_MENU] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     *  請求書のアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_invoice($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/invoice\.php/", $page) > 0
         || preg_match("/\/payment\.php/", $page) > 0
         || preg_match("/\/account_transfer_create\.php/", $page) > 0
         || preg_match("/\/account_transfer\.php/", $page) > 0
         || preg_match("/\/zengin_create\.php/", $page) > 0
         || preg_match("/\/zengin_update\.php/", $page) > 0
         || preg_match("/\/power_usage_csv_download\.php/", $page) > 0
         || preg_match("/\/torihikiho\.php/", $page) > 0
         || preg_match("/\/fit_payment_download\.php/", $page) > 0
         || preg_match("/\/fare_calculation_err\.php/", $page) > 0) {
            // 請求書
            if ($this->is_auth_16($authval)) {
                $this->logger->info("Auth [INVOICE] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [INVOICE] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     *  マスタメンテナンスのアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_master_maintenance($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/account\.php/", $page) > 0
         || preg_match("/\/auth\.php/", $page) > 0
         || preg_match("/\/department\.php/", $page) > 0
         || preg_match("/\/admin_kbn\.php/", $page) > 0
         || preg_match("/\/holiday\.php/", $page) > 0
         || preg_match("/\/area\.php/", $page) > 0
         || preg_match("/\/area_config\.php/", $page) > 0
         || preg_match("/\/area_holiday\.php/", $page) > 0
         || preg_match("/\/fuelcost_adjustment\.php/", $page) > 0
         || preg_match("/\/consignment_price\.php/", $page) > 0
         || preg_match("/\/business_type\.php/", $page) > 0
         || preg_match("/\/agent\.php/", $page) > 0
         || preg_match("/\/bank\.php/", $page) > 0
         || preg_match("/\/bank_branch\.php/", $page) > 0
         || preg_match("/\/tax\.php/", $page) > 0
         || preg_match("/\/era\.php/", $page) > 0
         || preg_match("/\/direct_debit\.php/", $page) > 0
         || preg_match("/\/renewable_energy\.php/", $page) > 0) {
            // ポータル
            if ($this->is_auth_32($authval)) {
                $this->logger->info("Auth [PORTAL] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [PORTAL] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     *  各種設定のアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_setting($page, $prc, $authval)
    {
        $success = false;
        // check
        if (preg_match("/\/company\.php/", $page) > 0
         || preg_match("/\/company_payee\.php/", $page) > 0
         || preg_match("/\/round\.php/", $page) > 0
         || preg_match("/\/mail\.php/", $page) > 0) {
            // マスタメンテナンス
            if ($this->is_auth_64($authval)) {
                $this->logger->info("Auth [ACCOUNT] CHECK ... OK");
                return $success = true;
            }
            $this->logger->info("Auth [ACCOUNT] CHECK ... NG");
        } else {
            $success = true;
        }
        return $success;
    }

    /**
     *  ページのアクセスチェック
     *
     *  @access public
     *  @param  string  $page
     *  @param  string  $prc
     *  @param  string  $authval
     *  @return bool
     */
    function page_check($page, $prc, $authval)
    {
        $success = false;
        /*------------------------------*
         * ACCESS CHECK
         * [note] 許可したものしか通過しない厳しいチェック
         *------------------------------*/
        if (!$this->page_accept($page, $prc, $authval) ||
            !$this->page_agreement($page, $prc, $authval) ||
            !$this->page_client($page, $prc, $authval) ||
            !$this->page_price_plan($page, $prc, $authval) ||
            !$this->page_invoice($page, $prc, $authval) ||
            !$this->page_master_maintenance($page, $prc, $authval) ||
            !$this->page_setting($page, $prc, $authval)) {
            return $success;
        }
        $this->logger->info("Auth CHECK is ... OK");
        return $success = true;
    }
}
