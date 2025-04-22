<?php
/**
 * Sas共通関数
 * 　このクラスは静的なクラスです
 *
 * @link       
 * @author     
 * @license    
 * @package    Simplan.DB.SAS
 * @version    1.0
 */
class SasFunction
{
    /*
     * テーブル名をSas名に変換する
     *
     * @access  public
     * @return  string
     */
    public static function GetSasModName($table)
    {
        if (preg_match('(\_)', $table) === false ) {
            return ucfirst($table);
        } else {
            $tmp = explode('_', $table);
            $ret = '';
            foreach($tmp as $val) $ret .= ucfirst($val);
            return $ret;
        }
    }
}
?>