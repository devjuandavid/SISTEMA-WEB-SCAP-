<?php ob_start(); 
	include('../modelo/conexion.php');
	$link = Conexion::conectar();

	$logo = "data:image/jpg;base64," . base64_encode(file_get_contents('logoddelpz.png'));
	$logo2 = "data:image/jpg;base64," . base64_encode(file_get_contents('logo_scap.png'));

	//llamar datos de informe
		$usu = base64_decode($_GET['u']);
	//llamar datos de usuario
		$consulta = $link->prepare("SELECT * 
			FROM  usuario u 
			INNER JOIN institucion i ON i.ins_id = u.ins_id 
			INNER JOIN area a ON a.are_id = u.are_id
			WHERE u.usu_ci = '$usu'");
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
		}
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>REGISTRO DE ASISTENCIAS</title>
	<style>
		/* hoja */
			@page {
	      margin: 95px 40px 70px 40px;
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
	  /* cabecera */
	    header {
	      position: fixed;
	      top: -55px;
	      left: 0px;
	      right: 0px;
	      height: 55px;
	  	}
	  	.logo{
	  		float: left;
	  		height: 50px;
	  	}
	  	.logo2{
	  		float: right;
	  		height: 40px;
	  	}
	  	.logo3{
	  		float: right;
	  		height: 50px;
	  	}
	  /* pie de pagina */
	    footer {
	      position: fixed; 
	      bottom: -30px; 
	      left: 0px; 
	      right: 0px;
	      height: 30px;
	      text-align: center;
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
	    .tab-pri{
	    	width: 100%;
	    	border-collapse : collapse;
	    	border: 1.5px solid #01558c;
	    }
	    .tab-pri tr th{
	    	border: 0.5px solid #dddddd;
	    	padding: 5px;
	    	alignment-baseline: middle;
	    }
	    .tab-pri tr td{
	    	font-size: 10px;
	    	border: 0.5px solid #dddddd;
	    	padding: 5px;
	    }
	    /*tabla titulo*/
	    .tab-tit{
	    	background-color: #01558c;
	    	color: #ffffff;
	    }

			.alt { 
				border-bottom: 1px solid #dddddd; 
			} 
			.alt:nth-of-type(even) { 
				background-color: #D0E8F9; 
			} 
			.alt:last-of-type { 
				border-bottom: 2px solid #B1D6F0; 
			}
			.bgg{
				background-color: #D7E2FF;
			}
	</style>
</head>
<body>
	<header>
		<div>
			<img class="logo" src="<?= $logo ?>">
			<img class="logo2" src="<?= $logo2 ?>">
		</div>
		<div style=" margin-top: 15px;">
			DIRECCIÓN DEPARTAMENTAL DE EDUCACIÓN LA PAZ<br>
			<?php if ($ari != 1): ?>
				<?= $are ?>
			<?php endif ?>
		</div>
	</header>

	<main>
		<!-- datos -->
			<h1 class="txt-c">REGISTRO DE ASISTENCIA</h1>
			<table class="tab-cabe">
				<tr>
					<th class="txt-l">NOMBRE:</th>
					<td><?= $nom ?></td>
					<th class="txt-l">CEDULA DE IDENTIDAD:</th>
					<td><?= $uci ?></td>
				</tr>
				<tr>
					<th class="txt-l">NÚMERO DE CELULAR:</th>
					<td><?= $cel ?></td>
					<th class="txt-l">TIEMPO:</th>
					<td><?= $tie ?></td>
				</tr>
				<tr>
					<th class="txt-l">INSTITUTO:</th>
					<td><?= $ins ?></td>
					<th class="txt-l">CARRERA:</th>
					<td><?= $car ?></td>
				</tr>
			</table>
		<!-- bd upf -->
			<table class="tab-pri">
        <tr class="tab-tit">
          <th>N°</th>
          <th>Fecha ingreso</th>
          <th>Hora ingreso</th>
          <th>Fecha salida</th>
          <th>Hora salida</th>
          <th>Total horas</th>
        </tr>
        <?php 
					$consulta = $link->prepare("SELECT a.asi_fecha, a.asi_hora, a.asi_tipo
						FROM asistencia a 
						INNER JOIN usuario u ON u.usu_id = a.usu_id
						WHERE usu_ci = '$uci'
						ORDER BY a.asi_fecha ASC, a.asi_hora ASC");
					$consulta->execute();

					$ar_dato = array();

					while ($row = $consulta->fetch()) { 
						array_push($ar_dato, array($row['asi_fecha'], $row['asi_hora'], $row['asi_tipo']));
					}
					$k = 0;
					$tti = 0;
					for ($i=0; $i < count($ar_dato); $i=$i+2) {  $k++;
						//echo $val[0].' - '.$val[1].' - '.$val[2].'<br>'; ?>
						<tr class="<?= $k%2 == 0 ? 'bgg' : '' ?> pc">

							<?php $fac = date('Y-m-d', strtotime($ar_dato[$i][0]));
								$con_2 = $link->prepare("SELECT COUNT(*) AS con
									FROM asistencia 
									WHERE asi_fecha = '$fac' AND usu_id = $usu");
								$con_2->execute();
								while ($row_2 = $con_2->fetch()) { 
									$con_fec = $row_2['con'];
								}

								if ($con_fec == 2): ?>
								<th class="txt-c"><?= $k ?></th>
								<td><?= $ar_dato[$i][0] ?></td>
								<td><?= $ar_dato[$i][1] ?></td>
								<td><?= $ar_dato[$i+1][0] ?></td>
								<td><?= $ar_dato[$i+1][1] ?></td>
								<?php 
									$f_emi = date_create(date('Y-m-d H:i:s', strtotime($ar_dato[$i][0].' '.$ar_dato[$i][1])));
						      $f_fin = date_create(date('Y-m-d H:i:s', strtotime($ar_dato[$i+1][0].' '.$ar_dato[$i+1][1])));

						      $diff = date_diff($f_emi, $f_fin);

						      $hor = $diff->format('%H');
						      $min = $diff->format('%i');
									$hor = intval($hor);
									$min = intval($min);						      
						      $tti = $tti + $min + ($hor * 60);
								 ?>
								<td><?= $hor ?>:<?= $min<10 ? '0'.$min : $min ?></td>
							<?php else: ?>
								<th class="txt-c"><?= $k ?></th>
								<td><?= $ar_dato[$i][0] ?></td>
								<td><?= $ar_dato[$i][1] ?></td>
								<td>S/N</td>
								<td>S/N</td>
								<td>0:00</td>
								<?php $i=$i-1; ?>
							<?php endif ?>
						</tr>
					<?php } ?>
					<tr>
						<th colspan="5">TOTAL MINUTOS</th>
						<th class="txt-l"><?= $tti ?> minutos</th>
					</tr>
					<tr>
						<th colspan="5">TOTAL HORAS</th>
						<th class="txt-l"><?= round($tti/60) ?> horas</th>
					</tr>
			</table>
	</main>

	<footer >
		<table style="width: 100%; margin-top: 10px;">
			<tr>
				<td style="font-size: 9px; font-style: italic;"><?= 'Fecha de impresión: '.date('d/m/Y') ?></td>
				<td style="text-align: right; font-size: 9px; font-style: italic;">Página <span class="pagenum"></span></td>
			</tr>
		</table>
	</footer>


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
	$dompdf->stream('Reporte.pdf', array('Attachment' => false));

 ?>