<?php

/**
 * Important Information Excel
 * 後重説出力クラス
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */
class vitalInfoExcel
{
    /* reader */
    protected $reader;
    /* excel */
    protected $excel;
    /* sheet */
    protected $sheet;
    /* simplanAbstractオブジェクト */
    protected $obj;
    /* ログオブジェクト */
    protected $logger;
    /* 契約データ */
    protected $agreementData;
    /* パラメータ */
    protected $param;

    /**
     * コンストラクタ
     *
     * @access    public
     * @return    void
     */
    public function vitalInfoExcel($obj)
    {
        $this->obj     = $obj;         // SimplanAbstractオブジェクト
        $this->logger  = $obj->logger; // ログオブジェクト
    }

    /**
     * makeAgreement
     *
     * @access    private
     * @return    void
     */
    public function makeAgreement()
    {
        $success = false;
        // 契約データ
       // $this->agreementData = $agreementData;
        // パラメータ
        //$this->param      = $param;
        // テンプレートエクセルファイルを読み込む

        $loadFileName = DATA_DIR . "invoice/template/vital_info.xlsx";
        $this->book = new ExcelBook(null, null, true); echo "22211saasi"; exit;
        $this->book->setLocale("UTF-8");
        $this->book->loadFile($loadFileName);

        // シート選択
        $this->sheet = $this->book->getSheet(0);

        // 請求先郵便番号
        $this->sheet->write(1, 6, "〒" . "tttttttttt");
        // 請求先住所
//         $address = $this->getAddress($this->agreementData["f_invoice_prefecture_id"], $this->agreementData["f_invoice_address1"], $this->agreementData["f_invoice_address2"], $this->agreementData["f_invoice_address3"]);
//         $this->sheet->write(2, 6, $address);
//         // 名前
//         $name = $this->agreementData["f_surname"] . $this->agreementData["f_firstname"];
//         if ($this->agreementData["f_customer_kbn"] == STATUS_CUSTOMER_KBN_HOJIN) {
//             $name = $this->agreementData["f_company_name"];
//             $name .= ($this->agreementData["f_company_kbn"] == STATUS_BRANCH_KBN_SHITEN) ? $this->agreementData["f_company_branch_name"] : "";
//         }
//         // 　ご契約名
//         $contractorName = !is_empty($name) ? $name : "";
//         $this->sheet->write(4, 6, $contractorName);
//         $titleFlg = t_array_value($this->agreementData["f_invoice_title_flg"], unserialize(TITLE_FLG_LIST));
//         $this->sheet->write(4, 33, $titleFlg);
//         // 供給地点番号
//         $this->sheet->write(9, 15, $this->agreementData["f_supply_point_no"]);
//         // プラン名
//         $this->sheet->write(11, 15, $this->param["f_menu_name"]);
//         // 契約容量・電流
//         if (!is_empty($this->param["f_agreement_capacity"])) {
//             $this->sheet->write(10, 15, $this->param["f_agreement_capacity"] . t_array_value($this->param["f_agreement_capacity_unit"], $this->param["disp_power_unit"]));
//         }
//         // 供給開始日
//         $this->sheet->write(12, 15, $this->agreementData["f_agreement_start_date"]);
//         // 契約期間
//         if (!is_empty($this->agreementData["f_agreement_start_date"])) {
//             $calcEndDateObj = DateTime::createFromFormat("Y/m/d", $this->agreementData["f_agreement_start_date"]);
//             $calcEndDateObj->modify("-1 day");
//             $calcEndDate    = $calcEndDateObj->modify("+1 year")->format("Y/m/d");
//             $this->sheet->write(13, 15, $this->agreementData["f_agreement_start_date"] . "~" . $calcEndDate);
//         }
//         // 電気料金表
//         $basicPriceName = "基本料金";
//         $basicPrice = !is_empty($this->param["f_basic_price"]) ? $this->param["f_basic_price"] . "円" : "";
//         if ($this->param["f_basic_price_unit"] == PRICE_VERSION_BILLING_UNIT_KILOWATS && $this->param["f_agreement_capacity_unit"] == AGREEMENT_POWER_UNIT_kVa) {
//             $basicPrice = bcmul($this->param["f_basic_price"], $this->param["f_agreement_capacity"], 3);
//             $basicPrice .= "円（{$this->param['f_basic_price']}円×{$this->param['f_agreement_capacity']}kVA）";
//         }
//         if ($this->param["f_basic_price_unit"] == PRICE_VERSION_BILLING_UNIT_KILOWATS && $this->param["f_agreement_capacity_unit"] == AGREEMENT_POWER_UNIT_kW) {
//             $basicPrice = bcmul($this->param["f_basic_price"], $this->param["f_agreement_capacity"], 3);
//             $basicPrice .= "円（{$this->param['f_basic_price']}円×{$this->param['f_agreement_capacity']}kW）";
//         }
//         if ($this->param["f_agreement_type"] != STATUS_PRICE_MENU_AGREEMENT_TYPE_JURYO_A) {
//             $this->sheet->write(14, 1, $basicPriceName);
//             $this->sheet->write(14, 15, $basicPrice);
//         }
//         $row = 15;
//         $first = true;
//         if ($this->param["f_menu_kbn"] == PRICE_MENU_KBN_JURYO && $this->param["f_agreement_type"] != STATUS_PRICE_MENU_AGREEMENT_TYPE_JURYO_A) {
//             for ($i=0; $i<$this->param["f_item_count"]; $i++) {
//                 $lastIndex = $this->param["f_item_count"]-1;
//                 if ($lastIndex == 0) {
//                     $stage = "0kWhから";
//                     if (!is_empty($this->param["f_stage"][$i])) {
//                         $stage .= $this->param["f_stage"][$i];
//                         $stage .= "kWhまで";
//                     }
//                 } else {
//                     if ($first) {
//                         $stage = ($i != $lastIndex) ? "0kWhから" . $this->param["f_stage"][$i] . "kWhまで" : "上記超過分";
//                         $first = false;
//                     } elseif (isset($this->param["f_stage"][$i-1]) && !is_empty($this->param["f_stage"][$i-1])) {
//                         $stage = ($i != $lastIndex) ? $this->param["f_stage"][$i-1] . "kWhから" . $this->param["f_stage"][$i] . "kWhまで" : "上記超過分";
//                     } else {
//                         $stage = "上記超過分";
//                     }
//                 }
//                 $this->sheet->write($row, 1, $stage);
//                 $unit = ($this->param["f_stage_kbn"][$i] == STAGE_KBN_TANKA) ? "円/kWｈ" : "円（定額）";
//                 $this->sheet->write($row, 15, $this->param["f_stage_price"][$i] . $unit);
//                 $row++;
//             }
//         }
//         if ($this->param["f_menu_kbn"] == PRICE_MENU_KBN_JURYO && $this->param["f_agreement_type"] == STATUS_PRICE_MENU_AGREEMENT_TYPE_JURYO_A) {
//             $row = 14;
//             for ($i=0; $i<$this->param["f_item_count"]; $i++) {
//                 $lastIndex = $this->param["f_item_count"]-1;
//                 if ($first) {
//                     $stage = ($i != $lastIndex) ? "0kWhから" . $this->param["f_stage"][$i] . "kWhまで" : "上記超過分";
//                     $first = false;
//                 } elseif (isset($this->param["f_stage"][$i-1]) && !is_empty($this->param["f_stage"][$i-1])) {
//                     $stage = ($i != $lastIndex) ? $this->param["f_stage"][$i-1] . "kWhから" . $this->param["f_stage"][$i] . "kWhまで" : "上記超過分";
//                 } else {
//                     $stage = "上記超過分";
//                 }
// /*
//                 $this->sheet->write("B35", "最低料金（" . $this->param["f_stage"][0] . "kWhまで）");
//                 if (!is_empty($this->param["f_basic_price"])) {
//                     $this->sheet->write("F35", $this->param["f_basic_price"] . "円");
//                 }
// */
//                 $this->sheet->write($row, 1, $stage);
//                 $unit = ($this->param["f_stage_kbn"][$i] == STAGE_KBN_TANKA) ? "円/KWｈ" : "円（定額）";
//                 $this->sheet->write($row, 15, $this->param["f_stage_price"][$i] . $unit);
//                 $row++;
//             }
//         }
//         if ($this->param["f_menu_kbn"] == PRICE_MENU_KBN_NORMAL || $this->param["f_menu_kbn"] == PRICE_MENU_KBN_HOLIDAY || $this->param["f_menu_kbn"] == PRICE_MENU_KBN_SEASON) {
//             for ($i=0; $i<$this->param["f_item_count"]; $i++) {
//                 $this->sheet->write($row, 1, $this->param["f_item_name"][$i]);
//                 $this->sheet->write($row, 15, $this->param["f_unit_price"][$i] . "円/kWｈ");
//                 $row++;
//             }
//         }
        // エクセルファイル作成
        $this->makeExcelFile();
        // PDFファイル作成
        $this->makePdfFile();
        return $success = true;
    }

    /**
     * エクセルファイルを生成する
     *
     * @access    private
     * @param     string    請求年月
     * @param     string    請求書管理番号
     * @return    void
     */
    public function makeExcelFile()
    {
        $excelFile = $this->getExcelFileName();
        $this->book->save($excelFile);
        chmod($excelFile, 0777);
    }

    /**
     * エクセルファイル名を取得する
     *
     * @access    private
     * @return    string    エクセルファイル名
     */
    public function getExcelFileName()
    {
        // 現在日付
        $curtime      = date("YmdHis", time());
        $curdate      = date("Ymd", time());
        // エクセルディレクトリ
        $excelDir     = $this->obj->getSiteValue("SITE", "agreement_info_excel_dir");
        // エクセルテンポラリーディレクトリ
        $exceltempDir = $this->obj->getSiteValue("SITE", "agreement_info_excel_temp_dir");
        //$agreementDir = ($this->param["f_download_flg"] == STATUS_IMPORTANT_INFORMATION_FILE_DOWNLOAD_BULK) ? "{$excelDir}/{$curdate}" : "{$exceltempDir}";
        $agreementDir =  "{$exceltempDir}";
        if (!file_exists($agreementDir)) {
            mkdir($agreementDir, 0777);
        }
        $fileName = "{$agreementDir}/agreement_info_xxx.xlsx";
        return $fileName;
    }

    /**
     * PDFファイルを生成する
     *
     * @access    protected
     * @param     string    請求書ID
     * @return    void
     */
    protected function makePdfFile()
    {
        $is = false;
        // 現在日付
        $curdate = date("Ymd", time());
        // エクセルディレクトリ
        $excelDir  = $this->obj->getSiteValue("SITE", "agreement_info_excel_dir");
        // エクセルテンポラリーディレクトリ
        $exceltempDir = $this->obj->getSiteValue("SITE", "agreement_info_excel_temp_dir");
        // 全体作成
        // if ($this->param["f_download_flg"] == STATUS_IMPORTANT_INFORMATION_FILE_DOWNLOAD_BULK) {
        //     $excelDir  .= "/{$curdate}";
        // }
        // // 個別作成
        // if ($this->param["f_download_flg"] == STATUS_IMPORTANT_INFORMATION_FILE_DOWNLOAD_SINGLE) {
        //     $excelDir = "{$exceltempDir}";
        // }
         $excelDir = "{$exceltempDir}";
        $excelFile = "{$excelDir}/agreement_info_xxx.xlsx";

        if (!file_exists($excelFile)) {
            return $is;
        }
        $tmpDir = $this->obj->getSiteValue("SITE", "libreoffice_tmp_dir");
        // PDFファイル
        $pdfDir = $this->obj->getSiteValue("SITE", "agreement_info_pdf_dir");
        // PDFテンポラリーファイル
        $pdfTempDir = $this->obj->getSiteValue("SITE", "agreement_info_pdf_temp_dir");
        // 全体作成
        // if ($this->param["f_download_flg"] == STATUS_IMPORTANT_INFORMATION_FILE_DOWNLOAD_BULK) {
        //     $pdfDir .= "/{$curdate}";
        // }
        // // 個別作成
        // if ($this->param["f_download_flg"] == STATUS_IMPORTANT_INFORMATION_FILE_DOWNLOAD_SINGLE) {
        //     $pdfDir = "{$pdfTempDir}";
        // }
        $pdfDir = "{$pdfTempDir}";
        // PDFファイル作成
        $execCmd = "export HOME={$tmpDir};/usr/lib/libreoffice/program/soffice.bin --headless --convert-to pdf --outdir {$pdfDir} {$excelFile}";
        $this->logger->debug("MAKE PDF FILE [{$execCmd}]");
        exec($execCmd);
        $this->logger->debug("EXEC COMMAND");
        return $is = true;
    }

    /**
     * 住所作成する
     *
     * @access    private
     * @param     string    都道府県ID
     * @param     string    住所1
     * @param     string    住所2
     * @param     string    住所3
     * @return    string    住所
     */
    private function getAddress($prefId, $addr1, $addr2, $addr3 = "")
    {
        $prefName = t_array_value($prefId, $this->param["disp_prefecture"]);
        $address = "{$prefName}{$addr1}{$addr2}{$addr3}";
        return $address;
    }

    /**
     * destroy
     *
     * @access    private
     * @return    void
     */
    public function destroy($excelFile)
    {
        $this->excel->disconnectWorksheets();
        unset($this->excel);
    }
}
?>