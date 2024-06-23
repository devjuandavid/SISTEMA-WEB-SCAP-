<?php ob_start(); 
	include('../modelo/conexion.php');
	$link = Conexion::conectar();

	$logo = "data:image/jpg;base64," . base64_encode(file_get_contents('logoddelpz2.png'));
	$logo2 = "data:image/jpg;base64," . base64_encode(file_get_contents('logo_scap.png'));
	$logo3 = "data:image/jpg;base64," . base64_encode(file_get_contents('minedu.png'));

	//llamar datos de informe
		$usu = base64_decode($_GET['u']);
	//llamar datos de usuario
		$consulta = $link->prepare("SELECT * 
			FROM  usuario u 
			INNER JOIN institucion i ON i.ins_id = u.ins_id 
			INNER JOIN area a ON a.are_id = u.are_id
			WHERE u.usu_id = $usu");
		$consulta->execute();

		while ($row = $consulta->fetch()) {
			$usu = $row['usu_id'];
			$nom = $row['usu_nombre'].' '.$row['usu_ap_paterno'].' '.$row['usu_ap_materno'];
			$uci = $row['usu_ci'].' '.$row['usu_exp'];
			$cel = $row['usu_celular'];
			$ins = $row['ins_nombre'];
			$ari = $row['are_id'];
			$are = $row['are_nombre'];
			$car = $row['usu_carrera'];
			switch($row['usu_tiempo']){
				case '1': $tie = 'MEDIO TIEMPO'; break;
				case '2': $tie = 'TIEMPO COMPLETO'; break;
			}
			$logo4 = "data:image/jpg;base64," . base64_encode(file_get_contents('../public/foto/'.$row['usu_foto']));
		}

	/* crear codigo QR */
		require __DIR__ . '/qr-code/vendor/autoload.php';
		use Endroid\QrCode\Color\Color;
		use Endroid\QrCode\Encoding\Encoding;
		use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
		use Endroid\QrCode\QrCode;
		use Endroid\QrCode\Label\Label;
		use Endroid\QrCode\Logo\Logo;
		use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
		use Endroid\QrCode\Writer\PngWriter;

		// Create QR code
			$writer = new PngWriter();
			//consulta 
			  $firma = array(
			  	'Nombre:' => $nom, 
			  	'CI:' => $uci,
			  	'Area:' => $are,
			  	'Instituto:' => $ins,
			  	'Celular:' => $cel
			  );

			  $firma = json_encode($firma);

				$qrCode = QrCode::create($firma)
				->setEncoding(new Encoding('UTF-8'))
				->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
				->setSize(300)
				->setMargin(2)
				->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
				->setForegroundColor(new Color(0, 0, 0))
				->setBackgroundColor(new Color(255, 255, 255));
			// Create generic logo
			$logoqr = Logo::create(__DIR__.'/qr-code/vendor/endroid/qr-code/assets/sia.png')
				->setResizeToWidth(120);

			$result = $writer->write($qrCode, $logoqr);
			$qr = 'data:image/jpg;base64,'.base64_encode($result->getString());
	/* Fin de crear codigo QR */
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>REGISTRO DE ASISTENCIAS</title>
	<style>
		/* hoja */
			@page {
	      margin: 50px 50px 50px 50px;
	    }
	    body{
	    	font-family: Arial, Helvetica, sans-serif;
	    	font-size: 11px;
	    }
	    /* salto de pagina */
	    .pagenum:before {
        content: counter(page);
    	}
	    .page-break {
		    page-break-after: always;
			}

	  /* tabla */
	    .tab-cabe{
	    	width: 100%;
	    	margin: 10px;
	    }
	    .txt-l{
	    	text-align: left;
	    }
	    .txt-c{
	    	text-align: center;
	    }
	    .txt-gri{
	    	color: #616161;
	    }
	</style>
</head>
<body>

	<main>
		<div style="border: 1px solid black; width: 6cm; height: 9.5cm; float: left; margin: 6px; padding-left: 0.2cm; padding-right: 0.2cm; border: 5px solid #009d71; outline: 5px solid #d32d27; background: url('<?= $logo ?>'); background-size: 100%; background-repeat: no-repeat;background-position: 10% 70%;" class="txt-c">
			<img src="<?= $logo3 ?>" style="width: 5.5cm; margin-top: 0.5cm;">
			<h6 style="font-size: 11px; margin-top: 10px; margin-bottom: 0px;">DIRECCIÓN DEPARTAMENTAL DE<br>EDUCACIÓN LA PAZ</h6>
			<img src="<?= $logo4 ?>" style="width: 3cm; margin-top: 0.5cm; border: 2px solid black;">
			<h6 style="font-size: 11px;margin-bottom: 10px; margin-top: 0.5cm;"><?= $nom ?><br><b class="txt-gri">C.I.: <?= $uci ?></b></h6>
			<hr style="background-color: #EAD91A;color: #EAD91A; border-color: #EAD91A; height: 2px;">
			<p style="font-size: 12px;margin-top: 0px; margin-bottom: 0px;"><b>PASANTE</b></p>
			<h6 style="font-size: 8px;margin-top: 5px; margin-bottom: 5px;"><?= $are ?></h6>
			<p style="font-size: 6px; font-style: italic;">"LÍDER EN CALIDAD EDUCATIVA Y CALIDEZ HUMANA"</p>
		</div>
		<div style="padding: 0.5cm; border: 1px solid black; width: 5cm; height: 8.5cm; float: left; margin: 6px;border: 5px solid #009d71; outline: 5px solid #d32d27;">
			<p style="font-size: 14px; font-style: italic; text-aling: justify;">Este credencial sirve como identificación del Pasante, el portador de la misma no esta autorizado a realizar ningun cobro trámite u otro tipo de gestión en representación de la institución.</p>
			<p class="txt-c">
				<img src="<?= $qr ?>" width="100">
			</p>
			<p style="font-size: 10px; font-style: italic; margin-top: 40px;" class="txt-c">"LÍDER EN CALIDAD EDUCATIVA Y CALIDEZ HUMANA"</p>
		</div>
	</main>

	<script type="text/php">
    if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("italic");
        $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
    }
	</script>

</body>
</html>
<?php 
	
	$html = ob_get_clean();
	/*echo $html;*/

	require_once 'dompdf/autoload.inc.php';

	use Dompdf\Dompdf;
	$dompdf = new Dompdf();

	ini_set("memory_limit", "800M"); ini_set("max_execution_time", "800");

	$options = $dompdf->getOptions();
	$options->set(array(
		'isRemoteEnabled' => true
	));
	$dompdf->setOptions($options);

	$dompdf->loadHtml($html);
	$dompdf->setPaper('letter');

	$dompdf->render();
	$dompdf->stream('Credencial.pdf', array('Attachment' => false));

 ?>