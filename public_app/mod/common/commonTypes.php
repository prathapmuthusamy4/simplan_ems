<?php
/*_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/*
 * 共通
 *_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/*/

// common session
define("COMMONS_SESSION", "common_session");

// csv file extension
define("CSV_FILE_EXTENSION", "csv");
//excel file extension
define("EXCEl_FILE_EXTENSION", "xls");

// メッセージ
define("STATUS_COMMON", "COMMON");
define("STATUS_ADMIN",  "ADMIN");
define("STATUS_USER",   "USER");
define("STATUS_CLI",    "CLI");

// 管理者権限
define("SUPER_ROLE_SUM", 1023);
define("SUPER_ROLE", "1,2,4,8,16,32,64,128,256,512");

// 会社ID
define("POWER_CIS_COMPANY_ID", 1);

// 銀行マスタ
define("ONLY_POST_BANK", 9900);
define("BANK_HONSHITEN_BRANCK_CODE", '000');

// 通常料金アイテム
define("NORMAL_ITEM_COUNT", 2);

// 季節別時間帯別料金アイテム
define("SEASON_ITEM_COUNT", 5);
// 休日高負荷料金アイテム
define("HOLIDAY_ITEM_COUNT", 4);
// 時間型料金アイテム
define("TIME_ITEM_COUNT", 4);

// 自動処理登録者ID
define("AUTO_REGIST_USER_ID", 0);

// 管理者区分
// ※システム管理者は[ID=1]固定
define("ADMIN_KBN_ID_SUPER_ADMIN", 1);
define("ADMIN_KBN_ID_MANAGER",     2);
define("ADMIN_KBN_LIST",
       serialize(array(ADMIN_KBN_ID_SUPER_ADMIN => "System Admin",
                       ADMIN_KBN_ID_MANAGER     => "Manager"
                       )));

// Leave Type
define("ADMIN_LEAVE_KBN_PERSONAL", 1);
define("ADMIN_LEAVE_KBN_SICK",     2);
define("ADMIN_LEAVE_KBN_BANK",     3);
define("ADMIN_LEAVE_KBN_OTHER",    4);
define("ADMIN_LEAVE_KBN_LIST",
       serialize(array(ADMIN_LEAVE_KBN_PERSONAL => "Personal",
                       ADMIN_LEAVE_KBN_SICK     => "Sick",
                       ADMIN_LEAVE_KBN_BANK     => "Bank",
                       ADMIN_LEAVE_KBN_OTHER    => "Others",
                       )));

// Attendance Type
// Leave Type
define("USER_ATTENDANCE_PRESENT", 1);
define("USER_ATTENDANCE_ABSENT",  2);
define("USER_ATTENDANCE_LIST",
       serialize(array(USER_ATTENDANCE_PRESENT => "Present",
                       USER_ATTENDANCE_ABSENT  => "Absent",
                       )));

// Attendance view Type
// Attendance view status
define("ADMIN_ATTENDANCE_ALL", "");
define("ADMIN_ATTENDANCE_PRESENT", 1);
define("ADMIN_ATTENDANCE_ABSENT",  2);
define("ADMIN_ATTENDANCE_VIEW_LIST",
       serialize(array(ADMIN_ATTENDANCE_ALL     => "All",
                       ADMIN_ATTENDANCE_PRESENT => "Present",
                       ADMIN_ATTENDANCE_ABSENT  => "Absent",
                       )));

// 許可MIMETYPE
define('ALLOW_MIME_FILE_JPG', '0');
define('ALLOW_MIME_FILE_PNG', '1');
define('ALLOW_MIME_FILE_GIF', '2');
define('ALLOW_MIME_FILE_XLS', '3');
define('ALLOW_MIME_FILE_DOC', '4');
define('ALLOW_MIME_FILE_PDF', '5');
define('ALLOW_MIME_FILE_LIST',
       serialize(array(ALLOW_MIME_FILE_JPG => 'JPG',
                       ALLOW_MIME_FILE_PNG => 'PNG',
                       ALLOW_MIME_FILE_GIF => 'GIF',
                       ALLOW_MIME_FILE_XLS => 'XLS',
                       ALLOW_MIME_FILE_DOC => 'DOC',
                       ALLOW_MIME_FILE_PDF => 'PDF',
                       )));

// 許可MIMETYPE
define("ALLOW_MIME_JPG", "0");
define("ALLOW_MIME_PNG", "1");
define("ALLOW_MIME_GIF", "2");
define("ALLOW_MIME_LIST",
       serialize(array(ALLOW_MIME_JPG => "JPG",
                       ALLOW_MIME_PNG => "PNG",
                       ALLOW_MIME_GIF => "GIF",
                       )));

// GENDER
define("ALLOW_GENDER_MALE", "0");
define("ALLOW_GENDER_FEMALE", "1");
define("ALLOW_GENDER_LIST",
       serialize(array(ALLOW_GENDER_MALE => "Male",
                       ALLOW_GENDER_FEMALE => "Female",
                       )));

// MARITAL STATUS
define("ALLOW_STATUS_MARRIED", "0");
define("ALLOW_STATUS_UNMARRIED", "1");
define("ALLOW_STATUS_LIST",
       serialize(array(ALLOW_STATUS_MARRIED => "Married",
                       ALLOW_STATUS_UNMARRIED => "Unmarried",
                       )));

// COUNTRY
define("ALLOW_COUNTRY_INDIA", "0");
define("ALLOW_COUNTRY_JAPAN", "1");
define("ALLOW_COUNTRY_LIST",
       serialize(array(ALLOW_COUNTRY_INDIA => "India",
                       ALLOW_COUNTRY_JAPAN => "Japan",
                       )));

// WORK STATUS
define("ALLOW_STATUS_ACTIVE", "0");
define("ALLOW_STATUS_INACTIVE", "1");
define("ALLOW_EMP_STATUS_LIST",
       serialize(array(ALLOW_STATUS_ACTIVE => "Active",
                       ALLOW_STATUS_INACTIVE => "Inactive",
                       )));

// Blood group
define("STATUS_DISP_BLOOD_AP",  "1");
define("STATUS_DISP_BLOOD_AN",  "2");
define("STATUS_DISP_BLOOD_BP",  "3");
define("STATUS_DISP_BLOOD_BN",  "4");
define("STATUS_DISP_BLOOD_O",   "5");
define("STATUS_DISP_BLOOD_ON",  "6");
define("STATUS_DISP_BLOOD_ABP", "7");
define("STATUS_DISP_BLOOD_ABN", "8");
define("STATUS_DISP_BLOOD_LIST",
       serialize(array(STATUS_DISP_BLOOD_AP => "A+",
                       STATUS_DISP_BLOOD_AN => "A-",
                       STATUS_DISP_BLOOD_BP => "B+",
                       STATUS_DISP_BLOOD_BN => "B-",
                       STATUS_DISP_BLOOD_O  => "O+",
                       STATUS_DISP_BLOOD_ON => "O-",
                       STATUS_DISP_BLOOD_ABP => "AB+",
                       STATUS_DISP_BLOOD_ABN => "AB-"
                       )));

// Education For UG
define("ALLOW_EDUCATION_UG_YES", "0");
define("ALLOW_EDUCATION_UG_NO",  "1");
define("ALLOW_EDUCATION_UG_LIST",
       serialize(array(ALLOW_EDUCATION_UG_YES => "Yes",
                       ALLOW_EDUCATION_UG_NO  => "No"
                       )));



// Education For PG
define("ALLOW_EDUCATION_PG_YES", "0");
define("ALLOW_EDUCATION_PG_NO",  "1");
define("ALLOW_EDUCATION_PG_LIST",
       serialize(array(ALLOW_EDUCATION_PG_YES => "Yes",
                       ALLOW_EDUCATION_PG_NO  => "No"
                       )));

// Language
define("ALLOW_LANGUAGE_TAMIL",    "0");
define("ALLOW_LANGUAGE_ENGLISH",  "1");
define("ALLOW_LANGUAGE_HINDI",    "2");
define("ALLOW_LANGUAGE_JAPANESE", "3");
define("ALLOW_LANGUAGE_OTHERS",   "4");
define("ALLOW_LANGUAGE_LIST",
       serialize(array(ALLOW_LANGUAGE_TAMIL  =>   "Tamil",
                       ALLOW_LANGUAGE_ENGLISH =>  "English",
                       ALLOW_LANGUAGE_HINDI =>    "Hindi",
                       ALLOW_LANGUAGE_JAPANESE => "Japanese",
                       ALLOW_LANGUAGE_OTHERS =>   "Others"
                       )));

// Language
define("ALLOW_JLPT_N5", "0");
define("ALLOW_JLPT_N4", "1");
define("ALLOW_JLPT_N3", "2");
define("ALLOW_JLPT_N2", "3");
define("ALLOW_JLPT_N1", "4");
define("ALLOW_JLPT_LIST",
       serialize(array(ALLOW_JLPT_N5 => "N5",
                       ALLOW_JLPT_N4 => "N4",
                       ALLOW_JLPT_N3 => "N3",
                       ALLOW_JLPT_N2 => "N2",
                       ALLOW_JLPT_N1 => "N1"
                       )));

// バッチ結果ステータス
define("STATUS_CLI_RESULT_OK",     "1");
define("STATUS_CLI_RESULT_NG",     "2");
define("STATUS_CLI_RESULT_RUNING", "3");
define("STATUS_CLI_RESULT_LIST",
       serialize(array(STATUS_CLI_RESULT_OK     => "正常終了",
                       STATUS_CLI_RESULT_NG     => "異常終了",
                       STATUS_CLI_RESULT_RUNING => "処理中",
                       )));
define("STATUS_CLI_CSV_INPUT_RESULT_LIST",
       serialize(array(STATUS_CLI_RESULT_OK     => "完了",
                       STATUS_CLI_RESULT_NG     => "異常終了",
                       STATUS_CLI_RESULT_RUNING => "処理中",
                       )));

// バッチ処理区分
define("CLI_KBN_MANUAL", "0");
define("CLI_KBN_WEB",    "1");
define("CLI_KBN_LIST",
       serialize(array(CLI_KBN_MANUAL => "手動",
                       CLI_KBN_WEB    => "WEB",
                       )));

// バッチ結果ステータス
define("STATUS_RESULT_OK",  "1");
define("STATUS_RESULT_NG",  "2");
define("STATUS_RESULT_UN",  "3");
define("STATUS_RESULT_ING", "4");
define("STATUS_RESULT_LIST",
       serialize(array(STATUS_RESULT_OK  => "OK",
                       STATUS_RESULT_NG  => "NG",
                       STATUS_RESULT_UN  => "未処理",
                       STATUS_RESULT_ING => "処理中",
                       )));

// 削除フラグ
define("DEL_FLG_LIST_OFF", "0");
define("DEL_FLG_LIST_ON",  "1");
define("DEL_FLG_LIST",
       serialize(array(DEL_FLG_LIST_OFF => "非削除",
                       DEL_FLG_LIST_ON  => "削除"
                       )));

// 表示ステータス
define("STATUS_DISP_OFF", "0");
define("STATUS_DISP_ON",  "1");
define("STATUS_DISP_LIST",
       serialize(array(STATUS_DISP_OFF => "表示",
                       STATUS_DISP_ON  => "非表示"
                       )));

// 表示ステータス（検索用）
define("STATUS_DISP_SEARCH_ALL", "");
define("STATUS_DISP_SEARCH_OFF", "0");
define("STATUS_DISP_SEARCH_ON",  "1");
define("STATUS_DISP_SEARCH_LIST",
       serialize(array(STATUS_DISP_SEARCH_ALL => "すべて",
                       STATUS_DISP_SEARCH_OFF => "表示",
                       STATUS_DISP_SEARCH_ON  => "非表示"
                       )));

// 表示ステータス
define("STATUS_DISP_GENDER_MALE",   "1");
define("STATUS_DISP_GENDER_FEMALE", "2");
define("STATUS_DISP_GENDER_LIST",
       serialize(array(STATUS_DISP_GENDER_MALE   => "MALE",
                       STATUS_DISP_GENDER_FEMALE => "FEMALE"
                       )));

// Graduate
define("STATUS_DISP_GRADUATE_YES",   "1");
define("STATUS_DISP_GRADUATE_NO",    "2");
define("STATUS_DISP_GRADUATE_LIST",
       serialize(array(STATUS_DISP_GRADUATE_YES   => "YES",
                       STATUS_DISP_GRADUATE_NO    => "NO"
         )));

// Hobbies
define("STATUS_DISP_HOBBIES_SPORTS",  "1");
define("STATUS_DISP_HOBBIES_MUSIC",   "2");
define("STATUS_DISP_HOBBIES_READING", "3");
define("STATUS_DISP_HOBBIES_YOGA",    "4");
define("STATUS_DISP_HOBBIES_LIST",
       serialize(array(STATUS_DISP_HOBBIES_SPORTS  => "Sports",
                       STATUS_DISP_HOBBIES_MUSIC   => "Music",
                       STATUS_DISP_HOBBIES_READING => "Reading",
                       STATUS_DISP_HOBBIES_YOGA    => "Yoga"
                       )));

// はい／いいえフラグ
define('YES_NO_FLG_LIST_ALL', '');
define('YES_NO_FLG_LIST_NO',  '0');
define('YES_NO_FLG_LIST_YES', '1');
define("YES_NO_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO  => "いいえ",
                       YES_NO_FLG_LIST_YES => "はい"
                       )));
// API連携使用フラグ
define("API_USE_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO  => "使用しない",
                       YES_NO_FLG_LIST_YES => "使用する"
                       )));
// 月次確定値との不一致フラグ
define("DEMAND_POWER_MISMATCH_FLG_LIST_SEARCH",
       serialize(array(YES_NO_FLG_LIST_ALL => "すべて",
                       YES_NO_FLG_LIST_NO  => "一致",
                       YES_NO_FLG_LIST_YES => "不一致"
                       )));
// 自動処理フラグ
define("AUTO_NUMBERING_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO  => "手動",
                       YES_NO_FLG_LIST_YES => "自動"
                       )));
// 検針日の前月フラグ
define("METER_READING_DATE_LAST_MONTH_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_YES => "検針日の前月とする",
                       YES_NO_FLG_LIST_NO  => "しない"
                       )));
// 需要家同意事項プライバシーポリシー同意
define("PRIVACY_FLG_LIST_NO", "0");
define("PRIVACY_FLG_LIST_YES", "1");
define("PRIVACY_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO => "同意しない",
                       YES_NO_FLG_LIST_YES => "同意する",
                       )));
// 需要家同意事項契約申込同意
define("APPLICATION_FLG_LIST_NO", "0");
define("APPLICATION_FLG_LIST_YES", "1");
define("APPLICATION_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO => "同意しない",
                       YES_NO_FLG_LIST_YES => "同意する",
                       )));
// 需要家同意事項個人情報取扱同意
define("PERSONAL_FLG_LIST_NO", "0");
define("PERSONAL_FLG_LIST_YES", "1");
define("PERSONAL_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO => "同意しない",
                       YES_NO_FLG_LIST_YES => "同意する",
                       )));
// 需要家同意事項契約更新規約同意
define("RENEWAL_FLG_LIST_NO", "0");
define("RENEWAL_FLG_LIST_YES", "1");
define("RENEWAL_FLG_LIST",
       serialize(array(YES_NO_FLG_LIST_NO => "同意しない",
                       YES_NO_FLG_LIST_YES => "同意する",
                       )));

// 確認ステータス
define("STATUS_CONF_OFF", "1");
define("STATUS_CONF_ON",  "2");
define("STATUS_CONF_LIST",
       serialize(array(STATUS_CONF_OFF => "未確認",
                       STATUS_CONF_ON  => "確認済"
                       )));

// 確認ステータス（検索用）
define("STATUS_CONF_SEARCH_ALL", "");
define("STATUS_CONF_SEARCH_OFF", "1");
define("STATUS_CONF_SEARCH_ON",  "2");
define("STATUS_CONF_SEARCH_LIST",
       serialize(array(STATUS_CONF_SEARCH_ALL => "すべて",
                       STATUS_CONF_SEARCH_OFF => "未確認",
                       STATUS_CONF_SEARCH_ON  => "確認済"
                       )));

// 完了ステータス
// ※受付情報に使用しています。
define("STATUS_COMP_0", "0");
define("STATUS_COMP_1", "1");
define("STATUS_COMP_LIST",
       serialize(array(STATUS_COMP_0 => "未",
                       STATUS_COMP_1 => "済"
                       )));

// 完了検索ステータス
define("STATUS_COMP_SEARCH_ALL", "");
define("STATUS_COMP_SEARCH_0"  , "0");
define("STATUS_COMP_SEARCH_1"  , "1");
define("STATUS_COMP_SEARCH_LIST",
       serialize(array(STATUS_COMP_SEARCH_ALL => "すべて",
                       STATUS_COMP_SEARCH_0   => "未",
                       STATUS_COMP_SEARCH_1   => "済",
                       )));

// 有効ステータス
define("STATUS_VALID_1", "1");
define("STATUS_VALID_2", "2");
define("STATUS_VALID_LIST",
       serialize(array(STATUS_VALID_1 => "無効",
                       STATUS_VALID_2 => "有効"
                       )));

// 有効ステータス
define("STATUS_VALID_SEARCH_ALL", "");
define("STATUS_VALID_SEARCH_1"  , "1");
define("STATUS_VALID_SEARCH_2"  , "2");
define("STATUS_VALID_SEARCH_LIST",
       serialize(array(
                       STATUS_VALID_SEARCH_ALL => "すべて",
                       STATUS_VALID_SEARCH_1   => "無効",
                       STATUS_VALID_SEARCH_2   => "有効"
                       )));

// 出力ステータス
define("STATUS_OUTPUT_ALL", "");
define("STATUS_OUTPUT_OFF", "1");
define("STATUS_OUTPUT_ON",  "2");
define("STATUS_OUTPUT_LIST",
       serialize(array(STATUS_OUTPUT_OFF => "未出力",
                       STATUS_OUTPUT_ON  => "出力済"
                       )));
define("STATUS_OUTPUT_SEARCH_LIST",
       serialize(array(STATUS_OUTPUT_ALL => "すべて",
                       STATUS_OUTPUT_OFF => "未出力",
                       STATUS_OUTPUT_ON  => "出力済",
                       )));

// 入力ステータス
define("STATUS_INPUT_OFF", "1");
define("STATUS_INPUT_ON",  "2");
define("STATUS_INPUT_LIST",
       serialize(array(STATUS_INPUT_OFF => "未入力",
                       STATUS_INPUT_ON  => "入力済"
                       )));

// 必須フラグリスト
define("MUST_FLG_OFF", "1");
define("MUST_FLG_ON",  "2");
define("MUST_FLG_LIST",
       serialize(array(MUST_FLG_OFF => "必須ではない",
                       MUST_FLG_ON  => "必須"
                       )));

// 取消フラグ
define("CANCEL_FLG_OFF", "0");
define("CANCEL_FLG_ON",  "1");
define("CANCEL_FLG_LIST",
       serialize(array(CANCEL_FLG_OFF => "未取消",
                       CANCEL_FLG_ON  => "取消"
                       )));

// 曜日
define("STATUS_WEEK_SUN",  "0");
define("STATUS_WEEK_MON",  "1");
define("STATUS_WEEK_TUE",  "2");
define("STATUS_WEEK_WED",  "3");
define("STATUS_WEEK_THU",  "4");
define("STATUS_WEEK_FRI",  "5");
define("STATUS_WEEK_SAT",  "6");
define("STATUS_WEEK_LIST",
       serialize(array(STATUS_WEEK_SUN  => "日",
                       STATUS_WEEK_MON  => "月",
                       STATUS_WEEK_TUE  => "火",
                       STATUS_WEEK_WED  => "水",
                       STATUS_WEEK_THU  => "木",
                       STATUS_WEEK_FRI  => "金",
                       STATUS_WEEK_SAT  => "土",
                       )));

// 端数処理区分
define("ROUND_KBN_ROUDN", "1");
define("ROUND_KBN_FLOOR", "2");
define("ROUND_KBN_CEIL",  "3");
define("ROUND_KBN_LIST",
       serialize(array(ROUND_KBN_ROUDN => "四捨五入",
                       ROUND_KBN_FLOOR => "切り捨て",
                       ROUND_KBN_CEIL  => "切り上げ",
                       )));

// 所属部署
define("STATUS_DEPART_SOMU",   "1");
define("STATUS_DEPART_GYOMU",  "2");
define("STATUS_DEPART_EIGYO",  "3");
define("STATUS_DEPART_SHINKI", "4");
define("STATUS_DEPART_LIST",
       serialize(array(STATUS_DEPART_SOMU   => "総務部",
                       STATUS_DEPART_GYOMU  => "業務部",
                       STATUS_DEPART_EIGYO  => "営業部",
                       STATUS_DEPART_SHINKI => "新規事業部",
                       )));

// 電力会社エリア
define("STATUS_AREA_HOKKAIDO", "1");
define("STATUS_AREA_TOHOKU",   "2");
define("STATUS_AREA_TOKYO",    "3");
define("STATUS_AREA_CHUBU",    "4");
define("STATUS_AREA_HOKURIKU", "5");
define("STATUS_AREA_KANSAI",   "6");
define("STATUS_AREA_CHUGOKU",  "7");
define("STATUS_AREA_SHIKOKU",  "8");
define("STATUS_AREA_KYUSHU",   "9");
define("STATUS_AREA_OKINAWA",  "10");
define("STATUS_AREA_ID_LIST",
       serialize(array(STATUS_AREA_HOKKAIDO => "北海道エリア",
                       STATUS_AREA_TOHOKU   => "東北エリア",
                       STATUS_AREA_TOKYO    => "東京エリア",
                       STATUS_AREA_CHUBU    => "中部エリア",
                       STATUS_AREA_HOKURIKU => "北陸エリア",
                       STATUS_AREA_KANSAI   => "関西エリア",
                       STATUS_AREA_CHUGOKU  => "中国エリア",
                       STATUS_AREA_SHIKOKU  => "四国エリア",
                       STATUS_AREA_KYUSHU   => "九州エリア",
                       STATUS_AREA_OKINAWA  => "沖縄エリア",
                       )));
define("STATUS_AREA_COMPANY_LIST",
       serialize(array(STATUS_AREA_HOKKAIDO => "北海道電力",
                       STATUS_AREA_TOHOKU   => "東北電力",
                       STATUS_AREA_TOKYO    => "東京電力",
                       STATUS_AREA_CHUBU    => "中部電力",
                       STATUS_AREA_HOKURIKU => "北陸電力",
                       STATUS_AREA_KANSAI   => "関西電力",
                       STATUS_AREA_CHUGOKU  => "中国電力",
                       STATUS_AREA_SHIKOKU  => "四国電力",
                       STATUS_AREA_KYUSHU   => "九州電力",
                       STATUS_AREA_OKINAWA  => "沖縄電力",
                       )));

// TODOフラグ
define("TO_DO_SETTING_OFF", "1");
define("TO_DO_SETTING_ON",  "2");
define("TO_DO_SETTING_LIST",
       serialize(array(TO_DO_SETTING_OFF => "行わない",
                       TO_DO_SETTING_ON  => "行う"
                       )));
define("PEAK_TIME_NAME_LIST",
       serialize(array(TO_DO_SETTING_OFF => "",
                       TO_DO_SETTING_ON  => "ピーク時間"
                       )));
define("HOLIDAY_KBN_NAME_LIST",
       serialize(array(TO_DO_SETTING_OFF => "",
                       TO_DO_SETTING_ON  => "休日"
                       )));
define("POWER_FACTOR_SETTING_LIST",
       serialize(array(TO_DO_SETTING_OFF => "しない",
                       TO_DO_SETTING_ON  => "する"
                       )));
// アンペア変更フラグ
define("AMPERE_HENKO_FLG_LIST",
       serialize(array(TO_DO_SETTING_OFF => "変更されていない",
                       TO_DO_SETTING_ON  => "変更された"
                       )));
// 相対契約区分
define("RELATIVE_AGREEMENT_KBN_LIST",
       serialize(array(TO_DO_SETTING_OFF => "はい",
                       TO_DO_SETTING_ON  => "いいえ"
                       )));

// 課金単位
define("BILLING_UNIT_KWH", "1");
define("BILLING_UNIT_LIST",
       serialize(array(BILLING_UNIT_KWH => "KWh",
                       )));

// しきい値区分
define("STAGE_UNIT_KWH", "1");
define("STAGE_UNIT_LIST",
       serialize(array(STAGE_UNIT_KWH  => "総従量(KWh)",
                       )));

// 土曜日休日設定区分
define("SATURDAY_HOLIDAY_KBN_ON",  "1");
define("SATURDAY_HOLIDAY_KBN_OFF", "2");
define("SATURDAY_HOLIDAY_KBN_LIST",
       serialize(array(SATURDAY_HOLIDAY_KBN_ON  => "土曜日を平日として扱う",
                       SATURDAY_HOLIDAY_KBN_OFF => "土曜日を休日として扱う",
                       )));

// 検針日タイプ
define("METER_READING_TYPE_KIJYUN", "1");
define("METER_READING_TYPE_KEIRYO", "2");
define("METER_READING_TYPE_LIST",
    serialize(array(
        METER_READING_TYPE_KIJYUN => "基準検針日",
        METER_READING_TYPE_KEIRYO => "計量日"
    )));

// アクション
define("STATUS_ACTION_LOGIN",   "1");
define("STATUS_ACTION_SEND",    "2");
define("STATUS_ACTION_RECEIVE", "3");
define("STATUS_ACTION_LIST",
       serialize(array(STATUS_ACTION_LOGIN   => "ログイン",
                       STATUS_ACTION_SEND    => "ファイル送信",
                       STATUS_ACTION_RECEIVE => "ファイル受信"
                       )));


// CLIENT OPTION
define("LIST_OPTION",  "1");
define("CHECK_OPTION", "2");
define("OPTION_LIST",
       serialize(array(LIST_OPTION  => "LIST",
                       CHECK_OPTION => "CHECK"
                       )));


?>
