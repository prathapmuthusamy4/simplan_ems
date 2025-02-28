<?php
/**
 *  Zipメソッドクラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */
class SimplanZip
{

    /**
     * freezeZip
     *
     * @access    public
     * @param     String   $srcFileName    圧縮対象ファイル
     * @param     String   $freezeFileName 圧縮時のファイル名
     * @return    String   $rslt           コマンド実行結果
     */
    function freezeZip( $srcFileName, $freezeFileName )
    {
        $rslt = exec(
            sprintf( "zip -r %s %s", $destFileName, $freezeFileName )
        );
        return $rslt;
    }

    /**
     * extractZip
     *
     * @access    public
     * @param     String   $srcFileName    解凍対象ファイル
     * @return    String                   実行結果
     */
    function extractZip( $srcFileName )
    {
        $rslt = exec( sprintf( "unzip %s", $srcFileName ) );

        return $rslt;
    }
}
?>