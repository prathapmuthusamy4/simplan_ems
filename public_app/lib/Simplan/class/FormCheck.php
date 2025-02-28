<?php
//******************************************************************************
// 機能名   ： 入力データチェック汎用クラス
// 作成日   ： 2005.04.20
//******************************************************************************
class FormCheck {

    //*** 変数宣言 ***//
    var $reader;

    //**************************************************************************
    // 関数名   ：  FormCheck
    // 機能名   ：  コンストラクタ
    // 引　数   ：  $file       (String)プロパティファイル名
    // 戻り値   ：  プロパティデータ
    //**************************************************************************
    function FormCheck ($file) {
        //*** SQLファイルキーよりSQL定義ファイルを取得 ***//
        $file_name = PKG . $file;

        if (!file_exists($file_name)) {
            //*** ERRORレベルログの出力 ***//
            $this->logger->error("FormCheck::FormCheck > check file not found [ {$file_name} ]");
            trigger_error ("FormCheck::FormCheck > check file not found [ {$file_name} ]", E_USER_ERROR);
        }
        $this->reader = new SimplanIniReader($file_name, false);
    }

    //**************************************************************************
    // 関数名   ：  check
    // 機能名   ：  入力チェック
    // 引　数   ：  $input      (hashMap)入力データ
    // 戻り値   ：  なし
    //**************************************************************************
    function check( &$input ) {
        //*** 入力チェック対象プロパティを取得 ***//
        $chk = $this->reader->getIni();

        $errList = array();
        //*** チェック項目についてチェック ***//
        foreach ($chk as $column => $v) {
            //*** 空白があると正常に動作しないため除去します ***//
            $v = str_replace (" ","", $v);

            list($must, $type, $min, $max, $trim, $name) = explode(",", $v);

            if (!array_key_exists($column, $input)) {
                if ($must === '1') {
                    $errList["{$column}"] = "{$name}を入力（選択）してください。";
                }
                continue;
            }

            // チェックボックスの必須チェック
            if ($type === 'CHECKBOX') {
                if ($must === '1' && (!isset($input[$column]) || is_empty($input[$column]))) {
                    $errList["{$column}"] = "{$name}を選択してください。";
                }
                continue;
            }

            if ($type == "HANKAKU" || $type == "HAN_KATAKANA_SP" || $type == "ZENKAKU" || $type == "HANKAKU_KATAKANA" || $type == "HANKAKU_KATAKANA_API" || $type == "ZENKAKU_MOJI" || $type == "HANKAKU_ZENKAKU") {
                $data = $input[$column];
            } else {
                $data = mb_convert_encoding($input[$column], "EUC-JP", "UTF-8,EUC-JP");
            }
            // Trim処理
            if ($trim === '1') {
                $data = ltrim($data);
            }

            // 必須入力チェック
            if ($must === '1' && $data === '') {
                if ($type === 'SELECT') {
                    $errList["{$column}"] = "{$name}を選択してください。";
                } else {
                    $errList["{$column}"] = "{$name}を入力してください。";
                }
                continue;
            }

            // 形式チェック
            if ($must === '0' && $data === '') {
                continue;
            }

            // 形式チェック
            $errMsg = '';

            if ($type === 'TEXT') {                         // テキスト
                $errMsg = $this->isText($data, $min, $max, $name);
            } else if ($type === 'TEXT_EX') {                 // テキスト（半角カナ可）
                $errMsg = $this->isTextEx($data, $min, $max, $name);
            } else if ($type === 'ALPHA') {                 // 半角英字
                $errMsg = $this->isAlpha($data, $min, $max, $name);
            } else if ($type === 'ALPHA_L') {               // 半角英字(大文字)
                $errMsg = $this->isAlphaLarge($data, $min, $max, $name);
            } else if ($type === 'ALPHA_S') {               // 半角英字(小文字)
                $errMsg = $this->isAlphaSmall($data, $min, $max, $name);
            } else if ($type === 'ALPHA_NUM') {             // 半角英数字
                $errMsg = $this->isAlphaNum($data, $min, $max, $name);
            } else if ($type === 'ALPHA_NUM_EX') {          // 半角英数字 + '-' + '.'
                $errMsg = $this->isAlphaNumEx($data, $min, $max, $name);
            } else if ($type == 'NUMBER') {                 // 数字
                $errMsg = $this->isNumber($data, $min, $max, $name);
            } else if ($type == 'DECIMAL') {                // 数字、小数
                $errMsg = $this->isDecimal($data, $min, $max, $name);
            } else if ($type == 'FRACTION') {               // 数字、少数、分数
                $errMsg = $this->isFraction($data, $min, $max, $name);
            } else if ($type == 'NUMERIC') {                // 数値
                $errMsg = $this->isNumeric($data, $min, $max, $name);
            } else if ($type == 'INTEGER') {                // 整数（正の整数（自然数）、負の整数、0）
                $errMsg = $this->isInteger($data, $min, $max, $name);
            } else if ($type == 'DATE') {                   // 日付
                $errMsg = $this->isDate($data, $min, $max, $name);
            } else if ($type == 'DATE_SP') {                   // 日付
                $errMsg = $this->isDateSp($data, $min, $max, $name);
            } else if ($type == 'DATETIME') {               // 日付時刻
                $errMsg = $this->isDateTime($data, $min, $max, $name);
            } else if ($type == 'TIME') {                   // 時刻
                $errMsg = $this->isTime($data, $min, $max, $name);
            } else if ($type == 'TEL') {                    // 電話番号
                $errMsg = $this->isTel($data, $min, $max, $name);
            } else if ($type == 'ZIP') {                    // 郵便番号
                $errMsg = $this->isZip($data, $min, $max, $name);
            } else if ($type == 'MAIL') {                   // メールアドレス
                $errMsg = $this->isMail($data, $min, $max, $name);
            } else if ($type == 'URL') {                    // URL
                $errMsg = $this->isUrl($data, $min, $max, $name);
            } else if ($type == 'DOMAIN') {                    // Domain
                $errMsg = $this->isDomain($data, $min, $max, $name);
            } else if ($type == 'HIRAGANA') {               // 全角ひらがな
                $errMsg = $this->isHiragana($data, $min, $max, $name);
            } else if ($type == 'KATAKANA') {               // 全角カタカナ
                $errMsg = $this->isKatakana($data, $min, $max, $name);
            } else if ($type == 'KATAKANA_EX') {            // 拡張カタカナ（英字含みあり）
                $errMsg = $this->isKatakanaEx($data, $min, $max, $name);
            } else if ($type == 'HAN_KATAKANA_EX') {            // 拡張半角カタカナ（英字含みあり）
                $errMsg = $this->isHanKatakanaEx($data, $min, $max, $name);
            } else if ($type == 'HAN_KATAKANA_SP') {            // 拡張半角カタカナ（英字含みあり）
                $errMsg = $this->isHanKatakanaSp($data, $min, $max, $name);
            } else if ($type === 'MOBILE_TEXT') {           // テキスト（モバイル用）
                $errMsg = $this->isMobileText($data, $min, $max, $name);
            } else if ($type === 'PRICE') {                 // 料金形式
                $errMsg = $this->isPrice($data, $min, $max, $name);
            } else if ($type === 'PERSON') {                // 人数など
                $errMsg = $this->isPerson($data, $min, $max, $name);
            } else if ($type == 'HANKAKU_KATAKANA') {
                $errMsg = $this->isHankakuKatakana($data, $min, $max, $name);
            } else if ($type == 'HANKAKU_KATAKANA_API') {
                $errMsg = $this->isHankakuKatakanaApi($data, $min, $max, $name);
            } else if ($type == 'ZENKAKU_MOJI') {
                $errMsg = $this->isZenkakuMoji($data, $min, $max, $name);
            } else if ($type == 'HANKAKU_ZENKAKU') {
                $errMsg = $this->isHankakuZenkaku($data, $min, $max, $name);
            } else if ($type == 'TEL_LONG') {
                $errMsg = $this->isTelLong($data, $min, $max, $name);
            } else if ($type == 'ZENKAKU') {
                $errMsg = $this->isZenkaku($data, $min, $max, $name);
            } else if ($type === 'ALPHA_NUM_MIX') {
                $errMsg = $this->isAlphaNumMix($data, $min, $max, $name);
            }
            if (strlen($errMsg) > 0) {
                $errList["{$column}"] = $errMsg;
            }
        }
        return $errList;
    }

    //**************************************************************************
    // 関数名   ：  checkLength
    // 機能名   ：  文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    // 戻り値   ：  true：妥当／false：不当
    //**************************************************************************
    function checkLength ($data, $min, $max) {
        $rslt = true;

        if (!$this->checkLengthMin($data, $min)) {
            $rslt = false;
        }
        if (!$this->checkLengthMax($data, $max)) {
            $rslt = false;
        }
        return $rslt;
    }

    //**************************************************************************
    // 関数名   ：  checkLengthMin
    // 機能名   ：  最小文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    // 戻り値   ：  true：妥当／false：不当
    //**************************************************************************
    function checkLengthMin ($data, $min) {
        $rslt = true;
        if (strlen($data) < $min) {
            $rslt = false;
        }
        return $rslt;
    }

    //**************************************************************************
    // 関数名   ：  checkLengthMax
    // 機能名   ：  最大文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $max        (int)最大文字数
    // 戻り値   ：  true：妥当／false：不当
    //**************************************************************************
    function checkLengthMax ($data, $max) {
        $rslt = true;
        if (strlen($data) > $max) {
            $rslt = false;
        }
        return $rslt;
    }

    //**************************************************************************
    // 関数名   ：  checkLength
    // 機能名   ：  文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    // 戻り値   ：  true：妥当／false：不当
    //**************************************************************************
    function checkMbLength ($data, $min, $max, $enc="UTF-8") {
        $rslt = true;

        if (!$this->checkMbLengthMin($data, $min, $enc)) {
            $rslt = false;
        }
        if (!$this->checkMbLengthMax($data, $max, $enc)) {
            $rslt = false;
        }
        return $rslt;
    }


    //**************************************************************************
    // 関数名   ：  checkLengthMin
    // 機能名   ：  最小文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    // 戻り値   ：  true：妥当／false：不当
    //**************************************************************************
    function checkMbLengthMin ($data, $min, $enc="UTF-8") {
        $rslt = true;
        if (mb_strlen($data, $enc) < $min) {
            $rslt = false;
        }
        return $rslt;
    }

    //**************************************************************************
    // 関数名   ：  checkLengthMax
    // 機能名   ：  最大文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $max        (int)最大文字数
    // 戻り値   ：  true：妥当／false：不当
    //**************************************************************************
    function checkMbLengthMax ($data, $max, $enc="UTF-8") {
        $rslt = true;
        if (mb_strlen($data, $enc) > $max) {
            $rslt = false;
        }
        return $rslt;
    }

    //**************************************************************************
    // 関数名   ：  isText
    // 機能名   ：  テキストチェック（半角カナが含まれている場合、エラーとする）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isText ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            // 半角カタカナチェック
            if (preg_match("/(?:\x8E[\xA6-\xDF])/", $data)) {
                $errMsg = "{$name}は半角カタカナ以外で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isTextEx
    // 機能名   ：  テキストチェック（半角カナ入力可）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isTextEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        return $errMsg;
    }


    //**************************************************************************
    // 関数名   ：  isAlpha
    // 機能名   ：  半角英字チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isAlpha ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[a-zA-Z]+$/", $data)) {
                $errMsg = "{$name}は半角英字で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isAlphaLarge
    // 機能名   ：  半角英字（大文字）チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isAlphaLarge ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[A-Z]+$/", $data)) {
                $errMsg = "{$name}は半角英字(大文字)で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isAlphaSmall
    // 機能名   ：  半角英字（小文字）チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isAlphaSmall ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[a-z]+$/", $data)) {
                $errMsg = "{$name}は半角英字(小文字)で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isAlphaNum
    // 機能名   ：  半角英数チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isAlphaNum ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[a-zA-Z0-9]+$/", $data)) {
                $errMsg = "{$name}は半角英数字で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isAlphaNumEx
    // 機能名   ：  半角英数拡張チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isAlphaNumEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([a-zA-Z0-9]|\\-|\\.|\\@|\\_|\\|)+$/", $data)) {
                $errMsg = "{$name}は半角英数字と'.'、'-'、'@'、'_'、'|'で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isNumber
    // 機能名   ：  数字チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isNumber ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角数字{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角数字{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角数字{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^\d+$/", $data)) {
                $errMsg = "{$name}は半角数字で入力してください。";
            }
            /*if (preg_match("/^0/", $data)) {
                $errMsg = "{$name}は正しい数字で入力してください。";
            }*/
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isNumeric
    // 機能名   ：  数値チェック（数字ではなく数値）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isNumeric ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に形式チェック
        if (!preg_match("/^\d+$/", $data)) {
            $errMsg = "{$name}は半角数字で入力してください。";
        }
        if (! (($min == 0 && $max == 0) ||($min == "" && $max == "")) ) {
            if (strlen($errMsg) === 0) {
                if ($data < $min || $data > $max) {
                    $errMsg = "{$name}は${min}以上、${max}以内で入力してください。";
                }
            }
        }
        if ($max != 0 && $max != "") {
            if (strlen($errMsg) === 0) {
                if ($data > $max){
                    $errMsg = "{$name}は{$max}以内で入力してください。";
                }
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isDecimal
    // 機能名   ：  数字、小数チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isDecimal ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角数字、半角ドット「.」{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角数字、半角ドット「.」{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角数字、半角ドット「.」{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if(!preg_match("/^\d$|^-+\d$|^-+\d+\.?\d+$|^\d+\.?\d+$/", $data)){
                $errMsg = "{$name}は半角数字、半角ドット「.」で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isFraction
    // 機能名   ：  数字、小数、分数チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isFraction ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角数字、半角ドット「.」、半角「/」{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角数字、半角ドット「.」、半角「/」{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角数字、半角ドット「.」、半角「/」{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if(!preg_match("/^\d$|^\d+\.?\d+$|^\d+\/?\d+$/", $data)){
                $errMsg = "{$name}は半角数字、半角ドット「.」、半角「/」で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isInteger
    // 機能名   ：  正の整数、負の整数、0チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isInteger ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック（絶対値）
        $absolute_value = abs($data);
        if ($min > 0) {
            if (!$this->checkLength($absolute_value, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は整数{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は整数{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {
            if (!$this->checkLengthMax($absolute_value, $max)) {
                $errMsg = "{$name}は整数{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {
            if(!preg_match("/^-?\d+$/", $data)){
                $errMsg = "{$name}は整数で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isDate
    // 機能名   ：  日付チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isDate ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^[1-9][0-9][0-9][0-9]\/(1[0-2]|0[1-9])\/(3[01]|[12][0-9]|0[0-9])$/", $data)) {
            $errMsg = "{$name}を正しく入力してください(YYYY/MM/DD形式)。";
        } else {
            $date_ary = explode("/", $data);
            if (!checkdate(intval($date_ary[1]), intval($date_ary[2]), intval($date_ary[0]))) {
                $errMsg = "{$name}を正しく入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isDateSp
    // 機能名   ：  日付チェック（YYYYmmdd or YYYY/mm/dd 以外はエラー）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isDateSp ($data, $min, $max, $name) {
        $errMsg = '';
        // 数値チェック
        if (preg_match("/^\d{4}\/\d{1,2}\/\d{1,2}$/", $data)) {
            list($y, $m, $d) = explode('/', $data);
            // 妥当性チェック
            if (!checkdate($m, $d, $y)) {
                $errMsg = "{$name}を正しく入力してください。";
            }
        } elseif (preg_match("/^\d{8}$/", $data)) {
            $y = substr($data, 0, 4);
            $m = substr($data, 4, 2);
            $d = substr($data, 6, 2);
            // 妥当性チェック
            if (!checkdate($m, $d, $y)) {
                $errMsg = "{$name}を正しく入力してください。";
            }
        } else {
            $errMsg = "{$name}を正しく入力してください。(YYYY/MM/DD形式またはYYYYMMDD)";
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isDateTime
    // 機能名   ：  日付時刻チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isDateTime ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^\d+$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        } else {
            if (strlen($data) != 12) {
                $errMsg = "{$name}を正しく入力してください。";
            } else {
                // 入力された日付をシリアル秒に変換
                $date_serial = mktime (substr($data, 8, 2), substr($data, 10, 2), 0, substr($data, 4, 2), substr($data, 6, 2), substr($data, 0, 4));
                // さらに日付形式に変換
                $comp = date('YmdHi', $date_serial);
                // 異なればエラー
                if ($data != $comp) {
                    $errMsg = "{$name}を正しく入力してください。";
                }
            }
        }
        return $errMsg;
    }


    //**************************************************************************
    // 関数名   ：  isTime
    // 機能名   ：  時刻チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isTime ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^(2[0-3]|1[0-9]|0[0-9]):([0-5][0-9])$/", $data)) {
            $errMsg = "{$name}を正しく入力してください(HH:MM形式)。";
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isTel
    // 機能名   ：  電話番号チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isTel ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^0\d{1,4}?-\d{1,4}?-\d{3,4}$/", $data)
                && !preg_match("/^0\d{4}?-\d{3,4}?$/", $data)
                && !preg_match("/^0120-\d{1,5}?-\d{1,5}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isZip
    // 機能名   ：  郵便番号チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isZip ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^\d{3}-\d{4}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isMail
    // 機能名   ：  メールアドレスチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isMail ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^([a-zA-Z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        } else {
            // ありえないと思うが長さチェック
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "申し訳ありませんが、その{$name}はご使用できません。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isUrl
    // 機能名   ：  URLチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isUrl ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        } else {
            // ありえないと思うが長さチェック
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "申し訳ありませんが、その{$name}はご使用できません。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isDomain
    // 機能名   ：  URLチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isDomain ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match('/^([-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        } else {
            // ありえないと思うが長さチェック
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "申し訳ありませんが、その{$name}はご使用できません。";
            }
        }
        return $errMsg;
    }
    //**************************************************************************
    // 関数名   ：  isHiragana
    // 機能名   ：  全角ひらがなチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isHiragana ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^((\xA4[\xA0-\xF3])||\xA1[\xA1\xBC])*$/", $data)) {
                $errMsg = "{$name}は全角ひらがなで入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isKatakana
    // 機能名   ：  全角カタカナチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isKatakana ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^((\xA5[\xA0-\xF6])||\xA1[\xA1\xBC])*$/", $data)) {
                $errMsg = "{$name}は全角カタカナで入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isKatakanaEx
    // 機能名   ：  拡張カタカナチェック（全角カタカナ、英数字、「-」、「.」）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isKatakanaEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([A-Za-z0-9]|\\-|\\.|((\xA5[\xA0-\xF6])||\xA1[\xA1\xBC]))*$/", $data)) {
                $errMsg = "{$name}は全角カタカナ、半角英数字、「-」、「.」で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isHanKatakanaEx
    // 機能名   ：  拡張半角カタカナチェック（半角カタカナ、英数字、「-」、「.」）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isHanKatakanaEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([A-Za-z0-9]|\\-|\\.|(?:\x8E[\xA6-\xDF]))*$/", $data)) {
                $errMsg = "{$name}は半角カタカナ、半角英数字、「-」、「.」で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isHanKatakanaSp
    // 機能名   ：  拡張半角カタカナチェック（半角カタカナ、英（大文字）数字、「 」、「(」、「)」、「-」）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isHanKatakanaSp ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[ \.\(\)\-0-9A-Zｦ-ﾟ]+$/u", $data)) {
                $errMsg = "{$name}は半角カタカナ、半角英（大文字）数字、半角スペース、「.」「(」、「)」、「-」で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isMobileText
    // 機能名   ：  テキストチェック（モバイル用、半角カナが含まれている場合、エラーとしない）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isMobileText ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }
        /*if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            // 半角カタカナチェック
            if (preg_match("/(?:\x8E[\xA6-\xDF])/", $data)) {
                $errMsg = "{$name}は半角カタカナ以外で入力してください。";
            }
        }*/
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isPrice
    // 機能名   ：  料金チェック（長さ、形式チェック）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isPrice ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[1-9][0-9]{0,4}$/", $data)) {
                $errMsg = "{$name}に料金を正しく入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isPerson
    // 機能名   ：  人数チェック（長さ、形式チェック）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isPerson ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[1-9][0-9]{0,4}$/", $data)) {
                $errMsg = "{$name}に人数を正しく入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isHankakuKatakana
    // 機能名   ：  半角のみ
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isHankakuKatakana ($data, $min, $max, $name)
    {
        $errMsg = '';
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match('/^[ｦ-ﾟ｡｢｣､･ \-]+$/u', $data)) {
                $errMsg = "{$name}は半角カタカナで入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isHankakuKatakanaApi
    // 機能名   ：  API連携で可能なカナ文字
    // 対象文字 ：  ｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝ
    //          ：  ｧｨｩｪｫｯｬｭｮ
    //          ：  0123456789
    //          ：  - ﾞﾟ()
    //          ：  ABCDEFGHIJKLMNOPQRSTUVWXYZ
    //          ：  abcdefghijklmnopqrstuvwxyz
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isHankakuKatakanaApi ($data, $min, $max, $name)
    {
        $errMsg = '';
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match('/^[0-9a-zA-Zｦ-ﾟ \-\(\)]+$/u', $data)) {
                $errMsg = "{$name}は半角カタカナで入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isZenkakuMoji
    // 機能名   ：  全角のみ
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isZenkakuMoji ($data, $min, $max, $name)
    {
        $errMsg = '';
        if ($min > 0) {
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {
            $target = $this->makeZenkakuCharacter();
            if (!preg_match("/^[" . $target . "]+$/u", $data)) {
                $errMsg = "{$name}は全角文字で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isHankakuZenkaku
    // 機能名   ：  全半角混在
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isHankakuZenkaku ($data, $min, $max, $name)
    {
        $errMsg = '';
        if ($min > 0) {
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {
            $target1 = $this->makeHankakuCharacter();
            $target2 = $this->makeZenkakuCharacter();
            if (!preg_match("/^[" . $target1 . $target2 . "]+$/u", $data)) {
                $errMsg = "{$name}は全角文字で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isTelLong
    // 機能名   ：  電話番号チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isTelLong ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^[0-9]\d{1,5}-\d{1,4}-\d{1,4}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isZenkaku
    // 機能名   ：  全角のみ
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isZenkaku ($data, $min, $max, $name)
    {
        $errMsg = '';
        if ($min > 0) {
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {
            $length = mb_strlen($data, 'UTF-8');
            $ret_flg = true;
            for ($i=0; $i<$length; $i++) {
                $char        = mb_substr($data, $i, 1, 'UTF-8');
                $char_length = strlen(mb_convert_encoding($char, 'SJIS-win', 'UTF-8'));
                $byte_array  = unpack('C*', (mb_convert_encoding($char, 'SJIS-win', 'UTF-8')));
                $first_byte  = $byte_array[1];
                if ($char_length === 2 && ((0x81 <= $first_byte && $first_byte <= 0x9F) || (0xE0 <= $first_byte && $first_byte <= 0xFC))) {
                    continue;
                }
                $errMsg = "{$name}は全角文字で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  isAlphaNumMix
    // 機能名   ：  半角英数と全角英数のみ
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //**************************************************************************
    function isAlphaNumMix ($data, $min, $max, $name)
    {
        $errMsg = '';
        if ($min > 0) {
            if (!$this->checkMbLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {
            if (!$this->checkMbLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {
            if (!preg_match('/^[0-9A-Za-z０-９Ａ-Ｚａ-ｚ]+$/u', $data)) {
                $errMsg = "{$name}は英数字で入力してください。";
            }
        }
        return $errMsg;
    }

    //**************************************************************************
    // 関数名   ：  makeHankakuCharacter
    // 機能名   ：  利用可能半角文字
    // 引　数   ：
    // 戻り値   ：  (String)半角文字列
    //**************************************************************************
    function makeHankakuCharacter () {
        // [0x20] [0x2F]
        $string1 = " !\"#\$%&'()\*\+,\-\.\/";
        // [0x3A] [0x40]
        $string2 = "\:\;\<=\>\?@";
        // [0x5B] [0x60]
        $string3 = "\\\[\]\^\_\`";
        // [0x7B] [0x7E]
        $string4 = "\{\|\}\~";
        // [0x30] [0x39]
        $string5 = "0-9";
        // [0x41] [0x5A]
        $string6 = "A-Z";
        // [0x61] [0x7A]
        $string7 = "a-z";
        // [0xA1] [0xA5]
        $string8 = "｡｢｣､･";
        // [0xA6] [0xDF]
        $string9 = "ｦ-ﾟ";

        $string = $string1 . $string2 . $string3 . $string4 . $string5 . $string6 . $string7 . $string8 . $string9;
        return $string;
    }

    //**************************************************************************
    // 関数名   ：  makeZenkakuCharacter
    // 機能名   ：  利用可能全角文字
    // 引　数   ：
    // 戻り値   ：  (String)全角文字列
    //**************************************************************************
    function makeZenkakuCharacter () {
        // [0x8140] [0x819E]
        $string1 = "　、。，．・：；？！゛゜´`¨^‾_ヽヾゝゞ〃仝々〆〇ー—‐／￥〜‖｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃＄￠￡％＃＆＊＠§☆★○●◎◇";
        // [0x819F] [0x81AC]
        $string2 = "◆□■△▲▽▼※〒→←↑↓〓";
        // [0x81B8] [0x81BF]
        $string3 = "∈∋⊆⊇⊂⊃∪∩";
        // [0x81C8] [0x81CE]
        $string4 = "∧∨￢⇒⇔∀∃";
        // [0x81DA] [0x81E8]
        $string5 = "∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬";
        // [0x81F0] [0x81F7]
        $string6 = "Å‰♯♭♪†‡¶";
        // [0x81FC]
        $string7 = "◯";
        // [0x8260] [0x8279]
        $string8 = "Ａ-Ｚ";
        // [0x8281] [0x829A]
        $string9 = "ａ-ｚ";
        // [0x824F] [0x8258]
        $string10 = "０-９";
        // [0x829F] [0x82F1]
        $string11 = "ぁ-ん";
        // [0x8340] [0x8396]
        $string12 = "ァ-ヶ";
        // [0x839F] [0x83B6]
        $string13 = "ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩ";
        // [0x83BF] [0x83D6]
        $string14 = "αβγδεζηθικλμνξοπρστυφχψω";
        // [0x8440] [0x8460]
        $string15 = "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ";
        // [0x8470] [0x847E]
        $string16 = "абвгдеёжзийклмн";
        // [0x8480] [0x8491]
        $string17 = "опрстуфхцчшщъыьэюя";
        // [0x849F] [0x84BE]
        $string18 = "─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂";
        // [0x889F] [0x9872] [0x989F] [0xEAA4]
        $string19 = "一-龠";

        $string = $string1 . $string2 . $string3 . $string4 . $string5 . $string6 . $string7 . $string8 . $string9 . $string10 . $string11 . $string12 . $string13 . $string14 . $string15 . $string16 . $string17 . $string18 . $string19;
        return $string;
    }
}
?>