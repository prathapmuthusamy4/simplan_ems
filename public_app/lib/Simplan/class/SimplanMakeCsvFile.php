<?php
//***************************************************************//
// CSVファイル生成クラス 
//***************************************************************//

// CSVエンコード
define('CSV_ENC',  'sjis-win');
// ファイルディレクトリ
define('CSV_TMP_DIR',  './app/lib/Simplan/test/');

/**
 *  SimplanMakeCsvFile Class
 *
 */
class SimplanMakeCsvFile
{

    /**
     *  CSVファイルを作成する。
     *
     *  @access public
     *  @param  string  $list     データ
     *  @param  string  $filename 生成するCSVファイル名
     *  @param  string  $inhead   ヘッダ
     *  @param  string  $infoot   フッタ
     *  @return array   OK:true , NG:false
     */
    public static function makeCsvFile($list, $filename, $inhead, $infoot = '')
    {
        // set
        $success = false;
        $file = fopen($filename, "w");
        if (!$file) {
            return $success;
        }
        // 排他ロック
        if(flock($file, LOCK_EX)) {
            // head
            if (is_array($inhead)) {
                fputs($file, SimplanMakeCsvFile::makeCsvString($inhead) );
            }
            // data
            foreach($list as $datas) {
                fputs($file, SimplanMakeCsvFile::makeCsvString($datas) );
            }
            //
            if (is_array($infoot)) {
                fputs($file, SimplanMakeCsvFile::makeCsvString($infoot) );
            }
            // ファイルクローズ
            fclose($file);
            $success = true;
        }

        return $success;
    }

    /**
     *  datas(配列)よりCSV出力文字列を生成する。
     *
     *  @access public
     *  @param  string  $datas データ
     *  @return array   string
     */
    public static function makeCsvString($datas) {

        $record = "";
        $i = 0;
        foreach($datas as $v) {
            $code = mb_detect_encoding($v);
            $record .= ($i == 0) ? "" : ",";
            $record .= mb_convert_encoding("\"" . str_replace('"', '""', SimplanMakeCsvFile::unhtmlspecialchars($v)) . "\"", CSV_ENC, $code);
            $i++;
        }
        $record .= "\r\n";

        return $record;
    }

    /**
     *  CSVファイルを出力する。
     *
     *  @access public
     *  @param  string  $filename CSVファイル名
     *  @return array   OK:true , NG:false
     */
    public static function outputCsvFile($filename)
    {

        // 文字コード
        $kanji_code = mb_internal_encoding();
        $success = false;

        header("Content-disposition: attachment; filename=" . basename($filename));
        header("Content-type: application/octet-stream; name=". basename($filename));
        header("Cache-Control: public");
        header("Pragma: public");

        // 文字コードを指定
        mb_http_output(CSV_ENC);

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
     *  @param  string  $pre CSVファイル名
     *  @return array   file name
     */
    public static function makeCsvFileName($pre)
    {
        $enc = mb_detect_encoding($pre);
        $pre = mb_convert_encoding($pre, CSV_ENC, $enc);
        $filename = TMP_DIR . $pre . '.csv';
        return $filename;
    }

    /**
     *  HTMLエンティティに変換した特殊文字の逆変換。
     *
     *  @access public
     *  @param  string  $string 文字
     *  @return array   string
     */
    public static function unhtmlspecialchars($string)
    {
        $string = str_replace('&amp;', '&', $string);
        $string = str_replace('&quot;', '"', $string);
        $string = str_replace('&#039;', '\'', $string);
        $string = str_replace('&lt;', '<', $string);
        $string = str_replace('&gt;', '>', $string);

        return $string;
    }
}
?>