<?php
//***************************************************************//
// ファイル出力クラス
//***************************************************************//

    // ファイルエンコード
    define('FILE_ENC',  'SJIS-win');

/**
 *  SimplanMakeFile Class
 *
 */
class SimplanMakeFile
{
    /**
     *  ファイルを出力する。
     *
     *  @access public
     *  @param  string  $filename ファイル名
     *  @param  string  $prename  保存ファイル名
     *  @return boolean OK:true , NG:false
     */
    public static function outputFile($filename, $prename)
    {
        // 文字コード
        $kanji_code = mb_internal_encoding();
        $success = false;
        // 出力
        header("Content-Disposition: attachment; filename=\"{$prename}\"");
        header("Content-type: application/octet-stream; name=\"{$prename}\"");
        header("Cache-Control: public");
        header("Pragma: public");
        // 文字コードを指定
        mb_http_output(FILE_ENC);
        // 出力
        if (readfile($filename)) {
            $success = true;
        }
        // 内部文字コードを元に戻す
        mb_internal_encoding($kanji_code);
        return $success;
    }

    /**
     *  ファイル名のエンコーディングを変換。
     *
     *  @access public
     *  @param  string  $prename ファイル名
     *  @return string  $prename エンコーディング後ファイル名
     */
    public static function makeFileName($prename)
    {
        $browser = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strstr($browser , 'edge') || strstr($browser , 'trident') || strstr($browser , 'msie')) {
            /* ～IEまたはEdgeの場合の処理～ */
            $prename = mb_convert_encoding($prename, FILE_ENC, 'UTF-8');
        }
        return $prename;
    }
}
?>