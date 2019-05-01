<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//$spreadsheet = new Spreadsheet();
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("asd.xlsx");
$i = 0;
foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
    echo "A<br/>";
    if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
        ob_start();
        call_user_func(
            $drawing->getRenderingFunction(),
            $drawing->getImageResource()
        );
        $imageContents = ob_get_contents();
        ob_end_clean();
        switch ($drawing->getMimeType()) {
            case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_PNG :
                $extension = 'png';
                break;
            case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_GIF:
                $extension = 'gif';
                break;
            case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_JPEG :
                $extension = 'jpg';
                break;
        }
    } else {
        $zipReader = fopen($drawing->getPath(),'r');
        $imageContents = '';
        while (!feof($zipReader)) {
            $imageContents .= fread($zipReader,1024);
        }
        fclose($zipReader);
        $extension = $drawing->getExtension();
    }
    $myFileName = '00_Image_'.++$i.'.'.$extension;
    file_put_contents($myFileName,$imageContents);
    var_dump($myFileName);
}



//$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
//$reader->setReadDataOnly(TRUE);
//$spreadsheet = $reader->load("asd.xlsx");

$worksheet = $spreadsheet->getActiveSheet();

$highestRow = $worksheet->getHighestRow();
/*for($i=1;$i<=$highestRow;$i+=1){
    $srno = $worksheet->getCellByColumnAndRow(1, $i)->getValue();
    $prn = $worksheet->getCellByColumnAndRow(2, $i)->getValue();
    $name = $worksheet->getCellByColumnAndRow(3, $i)->getValue();
    echo $srno."->".$prn."->".$name."<br/>";
}*/
$cellValue =  $spreadsheet->getActiveSheet()->getCell('C2')->getPlainText();
var_dump($cellValue->getFont()->getBold());
if ($cellValue instanceof PhpOffice\PhpSpreadsheet\RichText\RichText) {
    echo "A<br>";
    foreach ($cellValue->getRichTextElements() as $richTextElement) {
        var_dump($richTextElement->getText());
        var_dump($richTextElement->getFont()->getSuperScript());
    }
}

?>