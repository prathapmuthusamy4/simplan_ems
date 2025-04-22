<?php
//***************************************************************//
// エラーチェック関数 
//***************************************************************//

/**
 *  SimplanErrorCheck Class
 *
 */
class SimplanErrorCheck
{

    /**
    * 関数名   ：  checkLength
    * 機能名   ：  文字列長チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    * 戻り値   ：  true：妥当／false：不当
    */
    function checkLength ($data, $min, $max)
    {
        $rslt = true;

        if (!SimplanErrorCheck::checkLengthMin($data, $min)) {
            $rslt = false;
        }
        if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
            $rslt = false;
        }
        return $rslt;
    }

    /**
    * 関数名   ：  checkLengthMin
    * 機能名   ：  最小文字列長チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    * 戻り値   ：  true：妥当／false：不当
    */
    function checkLengthMin ($data, $min)
    {
        $rslt = true;
        if (strlen($data) < $min) {
            $rslt = false;
        }
        return $rslt;
    }

    /**
    * 関数名   ：  checkLengthMax
    * 機能名   ：  最大文字列長チェック
    * 引　数   ：  $data       (String)検証データ
    *              $max        (int)最大文字数
    * 戻り値   ：  true：妥当／false：不当
    */
    function checkLengthMax ($data, $max) {
        $rslt = true;
        if (strlen($data) > $max) {
            $rslt = false;
        }
        return $rslt;
    }

    /**
    * 関数名   ：  isText
    * 機能名   ：  テキストチェック（半角カナが含まれている場合、エラーとする）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isText ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }
        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            // 半角カタカナチェック
            if (preg_match("/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])/", $data)) {
                $errMsg = "{$name}は半角カタカナ以外で入力してください。";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isTextEx
    * 機能名   ：  テキストチェック（半角カナ入力可）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isTextEx ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        return $errMsg;
    }


    /**
    * 関数名   ：  isAlpha
    * 機能名   ：  半角英字チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isAlpha ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isAlphaLarge
    * 機能名   ：  半角英字（大文字）チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isAlphaLarge ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isAlphaSmall
    * 機能名   ：  半角英字（小文字）チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isAlphaSmall ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isAlphaNum
    * 機能名   ：  半角英数チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isAlphaNum ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isAlphaNumEx
    * 機能名   ：  半角英数拡張チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isAlphaNumEx ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は半角{$max}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([a-zA-Z0-9]|\\-|\\.)+$/", $data)) {
                $errMsg = "{$name}は半角英数字と'.'、'-'で入力してください。";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isNumber
    * 機能名   ：  数字チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小値
    *              $max        (int)最大値
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isNumber ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角数字{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角数字{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isNumeric
    * 機能名   ：  数値チェック（数字ではなく数値）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小値
    *              $max        (int)最大値
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
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

    /**
    * 関数名   ：  isDate
    * 機能名   ：  日付チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小値
    *              $max        (int)最大値
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isDate ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^[1-9][0-9][0-9][0-9]\/(1[0-2]|0[1-9])\/(3[01]|[12][0-9]|0[0-9])$/", $data)) {
            $errMsg = "{$name}を正しく入力してください(YYYY/MM/DD形式)。";
        } else {
            $date_ary = explode("/", $data);
            if (!checkdate(intval($date_ary[1]), intval($date_ary[2]), intval($date_ary[0]))) {
                $errMsg = "{$name}を正しく入力してください。b";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isDateTime
    * 機能名   ：  日付時刻チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小値
    *              $max        (int)最大値
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
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


    /**
    * 関数名   ：  isTime
    * 機能名   ：  時刻チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小値
    *              $max        (int)最大値
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isTime ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^(2[0-3]|1[0-9]|0[0-9]):([0-5][0-9])$/", $data)) {
            $errMsg = "{$name}を正しく入力してください(HH:MM形式)。";
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isTel
    * 機能名   ：  電話番号チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isTel ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^0\d{1,4}?-\d{1,4}?-\d{3,4}$/", $data)
                && !preg_match("/^0\d{4}?-\d{3,4}?$/", $data)
                && !preg_match("/^0120-\d{1,5}?-\d{1,5}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isZip
    * 機能名   ：  郵便番号チェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isZip ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^\d{3}-\d{4}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isMail
    * 機能名   ：  メールアドレスチェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isMail ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^([a-zA-Z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$/", $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        } else {
            // ありえないと思うが長さチェック
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "申し訳ありませんが、その{$name}はご使用できません。";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isUrl
    * 機能名   ：  URLチェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isUrl ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $data)) {
            $errMsg = "{$name}を正しく入力してください。";
        } else {
            // ありえないと思うが長さチェック
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "申し訳ありませんが、その{$name}はご使用できません。";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isHiragana
    * 機能名   ：  全角ひらがなチェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isHiragana ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^(?:\xE3\x81[\x81-\xBF]|\xE3\x82[\x80-\x93])+$/", $data)) {
                $errMsg = "{$name}は全角ひらがなで入力してください。";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isKatakana
    * 機能名   ：  全角カタカナチェック
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isKatakana ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6])+$/", $data)) {
                $errMsg = "{$name}は全角カタカナで入力してください。";
            }
        }
        return $errMsg;
    }

    /**
    * 関数名   ：  isKatakanaEx
    * 機能名   ：  拡張カタカナチェック（全角カタカナ、英数字、「-」、「.」）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isKatakanaEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([A-Za-z0-9]|\\-|\\.|(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6]))+$/", $data)) {
                $errMsg = "{$name}は全角カタカナ、半角英数字、「-」、「.」で入力してください。";
            }
        }
        return $errMsg;
    }


    /**
    * 関数名   ：  isHanKatakanaEx
    * 機能名   ：  拡張半角カタカナチェック（半角カタカナ、英数字、「-」、「.」）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isHanKatakanaEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([0-9A-Za-z]|\\-|\\.|(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F]))+$/", $data)) {
                $errMsg = "{$name}は半角カタカナ、半角英数字、「-」、「.」で入力してください。";
            }
        }
        return $errMsg;
    }



    /**
    * 関数名   ：  isMobileText
    * 機能名   ：  テキストチェック（モバイル用、半角カナが含まれている場合、エラーとしない）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isMobileText ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isPrice
    * 機能名   ：  料金チェック（長さ、形式チェック）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isPrice ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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

    /**
    * 関数名   ：  isPerson
    * 機能名   ：  人数チェック（長さ、形式チェック）
    * 引　数   ：  $data       (String)検証データ
    *              $min        (int)最小文字数
    *              $max        (int)最大文字数
    *              $name       (String)項目名
    * 戻り値   ：  (String)エラーメッセージ
    */
    function isPerson ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!SimplanErrorCheck::checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!SimplanErrorCheck::checkLengthMax($data, $max)) {
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
}
?>