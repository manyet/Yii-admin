<?php
/**
 * Created by PhpStorm.
 * User: xiaoguo0426
 * Date: 2016/11/23
 * Time: 14:16
 */
require 'PHPExcel.php';

Class Excel extends PHPExcel
{
    public $activeSheet;
    public $index;

    public function __construct()
    {
        parent::__construct();
        $this->index = 0;
    }

    public function renderData($header = [], $data = [])
    {
        $sheet = $this->getSheet($this->index);
        $row = 1;
        $column = 1;
        //处理表头
        foreach ($header as $key => $value) {
            $sheet->setCellValue($this->getCellIndex($column) . $row, $value);
            $column++;
        }

        $row = 2;//表头占一行，所以从第二行开始
        $header_keys = array_keys($header);

        foreach ($data as $key => $value) {
            $column = 1;
            foreach ($header_keys as $k => $v) {
                if (strpos($v,'|') === false){
                    $cell = $value[$header_keys[$k]];
                }else{
                    list($header,$method) = explode('|',$v);
                    if (strpos($method,',') !== false){
                        list($action,$param) = explode(',',$method);
                        $cell = $action($value[$header],$param,$value);
                    }else{
                        $cell = $method($value[$header],$value);
                    }

                }
                $sheet->setCellValueExplicit($this->getCellIndex($column) . $row, $cell,PHPExcel_Cell_DataType::TYPE_STRING);//去掉格式
                $column++;
            }
            $row++;
        }

        return $this;
    }

    public function addNewSheet()
    {
        $tmp = $this->index;
        if ($tmp !== 0) {
            $this->index = $tmp + 1;
        }

        $this->setActiveSheetIndex($this->getIndex($this->createSheet($this->index)));
        return $this;
    }

    public function setSheetTitle($title = 'Worksheet')
    {
        $this->getActiveSheet()->setTitle($title);
        return $this;
    }

    /**
     *
     */
    public function download($fileName = '', $type = '2007')
    {
        $this->setActiveSheetIndex(0);  //将sheet索引重置为第一个

        if ($fileName === '') {
            $fileName = time();
        }
        if ($type === '2003') {
            $type = 'Excel5';
            header('Content-Type: application/vnd.ms-excel');
            $extension = '.xls';
        } else {
            $type = 'Excel2007';
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $extension = '.xlsx';
        }
        $fileName = iconv('utf-8', 'gb2312', $fileName);
        header('Content-Disposition: attachment;filename="' . $fileName . $extension . '"');

        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($this, $type);
        $objWriter->save('php://output');
        exit;
    }

    /**
     *
     * @param $index
     * @param int $start
     * @return string
     */
    public function getCellIndex($index, $start = 65)
    {
        return chr(intval($index) + $start - 1);
    }

}