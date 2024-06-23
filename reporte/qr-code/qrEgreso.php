<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../modelo/conexion.php');
$link = Conexion::conectar();
//traemos la inscripcion
$doc = 10;

//consulta
$consulta = $link->prepare("SELECT * 
    FROM  documentos
    WHERE doc_id = $doc");
    $consulta->execute();

    

    while ($row = $consulta->fetch()) {
        $firma = array('firma' => $row['doc_firma'], 'tipo' => $row['td_id']);
    }

    $firma = json_encode($firma);

//iniciar qr   
require __DIR__ . '/vendor/autoload.php';
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

$writer = new PngWriter();

// Create QR code
$qrCode = QrCode::create($firma)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
    ->setSize(300)
    ->setMargin(2)
    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->setForegroundColor(new Color(0, 0, 0))
    ->setBackgroundColor(new Color(255, 255, 255));

// Create generic logo
$logo = Logo::create(__DIR__.'/vendor/endroid/qr-code/assets/sia.png')
    ->setResizeToWidth(50);

$result = $writer->write($qrCode, $logo);

// Directly output the QR code
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
//$result->getString();


// Save it to a file
$result->saveToFile(__DIR__.'/qrEgreso.png');

//header('Location: ../repCertEgreso.php?ie='.$iest);
?>