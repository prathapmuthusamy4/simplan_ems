<?php
  /**************************************************
   * 携帯向けUTIL
   **************************************************/
  /**
   *  SimplanMail Class
   *
   */

define('MOBILE_CAREER_DOCOMO',  'docomo');
define('MOBILE_CAREER_AU',      'au');
define('MOBILE_CAREER_SOFTBANK','softbank');

class SimplanMobile
{

    /**
     * 携帯のキャリアを判定する
     *
     * @access    public
     * @return    boolean ok:true, ng:false;
     */
    function getCareer() {
        $ret = "";

        $agent = $_SERVER['HTTP_USER_AGENT']; 
        if(preg_match("(^DoCoMo)", $agent)){
            $ret = MOBILE_CAREER_DOCOMO;
        }else if(preg_match("(^J-PHONE|^Vodafone|^SoftBank)", $agent)){
            $ret = MOBILE_CAREER_SOFTBANK;
        }else if(preg_match("(^UP.Browser|^KDDI)", $agent)){
            $ret = MOBILE_CAREER_AU;
        }

        return $ret;
    }
}
?>