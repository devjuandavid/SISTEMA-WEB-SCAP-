<?php ob_start(); 
	include('../modelo/conexion.php');
	$link = Conexion::conectar();

	$logo = "data:image/jpg;base64," . base64_encode(file_get_contents('logoddelpz.png'));

	//llamar datos de usuario
		$consulta = $link->prepare("SELECT * 
			FROM  usuario
			WHERE usu_tipo = 2");
		$consulta->execute();
?>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>LISTA DE USUARIOS</title>
	<style>
		/* hoja */
			@page {
	      margin: 95px 40px 70px 40px;
	    }
	    body{
	    	font-family: Arial, Helvetica, sans-serif;
	    	font-size: 10px;
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
	  		height: 50px;
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
			.txt-sup{
				margin-bottom: 0px;
				margin-top: 0px;
			}
			.txt-inf{
				margin-bottom: 0px;
				margin-top: 0px;
				color: #414141;
			}
	</style>
</head>
<body>
	<header>
		<div>
			<img class="logo" src="<?= $logo ?>">
		</div>
		<div style=" margin-top: 15px;">
			DIRECCIÓN DEPARTAMENTAL DE EDUCACIÓN LA PAZ<br>
			SUBDIRECCIÓN DE EDUCACIÓN SUPERIOR DE FORMACIÓN PROFESIONAL
		</div>

	</header>

	<main>
		<!-- datos -->
			<h1 class="txt-c">LISTA DE USUARIOS</h1>
			<p style="text-align: right; margin-bottom: 2px; font-size: 6px;"><?= 'Fecha de impresión: '.date('d/m/Y') ?></p>
		<!-- bd upf -->
			<table class="tab-pri">
        <tr class="tab-tit">
          <th class="txt-c">N°</th>
          <th>Nombre completo y C.I.</th>
          <th>Instituto y Carrera</th>
          <th>Celular y Tiempo</th>
        </tr>
        <?php $i = 0; while ($row = $consulta->fetch()) { $i++; ?>
        	<tr class="<?= $i%2==0?'bgg':'' ?>">
        		<td class="txt-c"><?= $i ?></td>
        		<td>
        			<p class="txt-sup"><?= $row['usu_nombre'].' '.$row['usu_ap_paterno'].' '.$row['usu_ap_materno'] ?></p>
        			<p class="txt-inf"><?= $row['usu_ci'] ?></p>
        		</td>
        		<td>
        			<p class="txt-sup"><?= $row['usu_instituto'] ?></p>
							<p class="txt-inf"><?= $row['usu_carrera'] ?></p>
        		</td>
        		<td>
        			<p class="txt-sup"><?= $row['usu_celular'] ?></p>
							<p class="txt-inf"><?= $row['usu_tiempo'] == 1 ? 'MEDIO TIEMPO' : 'TIEMPO COMPLETO' ?></p>
        		</td>
        	</tr>
        <?php } ?>
			</table>
	</main>

	<footer>
  	<p style="font-style: italic;">
  		Página <span class="pagenum"></span>
  	</p>	
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
	$dompdf->setPaper('letter', 'landscape');

	$dompdf->render();
	$dompdf->stream('Lista.pdf', array('Attachment' => false));

 ?>