<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

include('../modelo/conexion.php');
$link = Conexion::conectar();

date_default_timezone_set('America/La_Paz');
$fac = date('Y-m-d H:i:s');
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

$ss = new SpreadSheet();

	//metadatos
	$ss->getProperties()->setCreator('SIA - Kernel Bolivia - MAQV')->setTitle('Institutos');
	$ss->setActiveSheetIndex(0);
	$hojaAct = $ss->getActiveSheet();

	$hojaAct->setCellValue('A1', 'REGISTRO DE ASISTENCIAS');

	//combinar celdas
	$ss->getActiveSheet()->mergeCells('A1:F1');
	//centrar y cambiar estilo de texto
	$ss->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
	$ss->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(20);
	//definir cabecera
	$hojaAct->setCellValue('A2', 'NOMBRE: ');
	$hojaAct->setCellValue('A3', 'CED. IDENTIDAD: ');
	$hojaAct->setCellValue('A4', 'NÚMERO CELULAR: ');
	$hojaAct->setCellValue('A5', 'INSTITUTO: ');
	$hojaAct->setCellValue('A6', 'CARRERA: ');
	$hojaAct->setCellValue('A7', 'TIEMPO: ');

	$ss->getActiveSheet()->mergeCells('A2:B2');
	$ss->getActiveSheet()->mergeCells('A3:B3');
	$ss->getActiveSheet()->mergeCells('A4:B4');
	$ss->getActiveSheet()->mergeCells('A5:B5');
	$ss->getActiveSheet()->mergeCells('A6:B6');
	$ss->getActiveSheet()->mergeCells('A7:B7');

	$hojaAct->setCellValue('C2', $nom);
	$hojaAct->setCellValue('C3', $uci);
	$hojaAct->setCellValue('C4', $cel);
	$hojaAct->setCellValue('C5', $ins);
	$hojaAct->setCellValue('C6', $car);
	$hojaAct->setCellValue('C7', $tie);

	$ss->getActiveSheet()->mergeCells('C2:F2');
	$ss->getActiveSheet()->mergeCells('C3:F3');
	$ss->getActiveSheet()->mergeCells('C4:F4');
	$ss->getActiveSheet()->mergeCells('C5:F5');
	$ss->getActiveSheet()->mergeCells('C6:F6');
	$ss->getActiveSheet()->mergeCells('C7:F7');

	//$ss->getActiveSheet()->getStyle('C'.$l.':E'.$l)->getAlignment()->setHorizontal('left');

	$ss->getActiveSheet()->getStyle('C2:F2')->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('C3:F3')->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('C4:F4')->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('C5:F5')->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('C6:F6')->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('C7:F7')->getAlignment()->setHorizontal('left');

	$hojaAct
	->setCellValue('A8', 'Nº')
	->setCellValue('B8', 'Fecha ingreso')
	->setCellValue('C8', 'Hora ingreso')
	->setCellValue('D8', 'Fecha salida')
	->setCellValue('E8', 'Hora salida')
	->setCellValue('F8', 'Total minutos');
	//DEFINIR BOLD
	$ss->getActiveSheet()->getStyle('A8:F8')->getFont()->setBold(true);

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
	$l = 8;
	$tti = 0;
	for ($i=0; $i < count($ar_dato); $i=$i+2) {  $k++; $l++;

		$fac = date('Y-m-d', strtotime($ar_dato[$i][0]));
		$con_2 = $link->prepare("SELECT COUNT(*) AS con
			FROM asistencia 
			WHERE asi_fecha = '$fac' AND usu_id = $usu");
		$con_2->execute();
		while ($row_2 = $con_2->fetch()) { 
			$con_fec = $row_2['con'];
		}

		if ($con_fec == 2){
			$hojaAct->setCellValue('A'.$l, $k);
			$hojaAct->setCellValue('B'.$l, $ar_dato[$i][0]);
			$hojaAct->setCellValue('C'.$l, $ar_dato[$i][1]);
			$hojaAct->setCellValue('D'.$l, $ar_dato[$i+1][0]);
			$hojaAct->setCellValue('E'.$l, $ar_dato[$i+1][1]);
			$f_emi = date_create(date('Y-m-d H:i:s', strtotime($ar_dato[$i][0].' '.$ar_dato[$i][1])));
		    $f_fin = date_create(date('Y-m-d H:i:s', strtotime($ar_dato[$i+1][0].' '.$ar_dato[$i+1][1])));

		    $diff = date_diff($f_emi, $f_fin);

		    $hor = $diff->format('%H');
		    $min = $diff->format('%i');
		    $kkk = $min;
			$hor = intval($hor);
			$min = intval($min);	
			$tot = $min + ($hor * 60);			      
		    $tti = $tti + $tot;
			$hojaAct->setCellValue('F'.$l, $tot);
		}else{
			$hojaAct->setCellValue('A'.$l, $k);
			$hojaAct->setCellValue('B'.$l, $ar_dato[$i][0]);
			$hojaAct->setCellValue('C'.$l, $ar_dato[$i][1]);
			$hojaAct->setCellValue('D'.$l, 'S/N');
			$hojaAct->setCellValue('E'.$l, 'S/N');
			$hojaAct->setCellValue('F'.$l, 0);
			$i = $i -1;
		}
	}

	$l++;
	$hojaAct->setCellValue('A'.$l, 'TOTAL MINUTOS');
	$tti = intval($tti);
	$hojaAct->setCellValue('F'.$l, $tti);
	$ss->getActiveSheet()->mergeCells('A'.$l.':E'.$l);
	$ss->getActiveSheet()->getStyle('A'.$l.':E'.$l)->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('A'.$l.':F'.$l)->getFont()->setBold(true);
	$l++;
	$hojaAct->setCellValue('A'.$l, 'TOTAL HORAS');
	$tti = round($tti/60);
	$hojaAct->setCellValue('F'.$l, $tti);
	$ss->getActiveSheet()->mergeCells('A'.$l.':E'.$l);
	$ss->getActiveSheet()->getStyle('A'.$l.':E'.$l)->getAlignment()->setHorizontal('left');
	$ss->getActiveSheet()->getStyle('A'.$l.':F'.$l)->getFont()->setBold(true);

	$ss->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
//para descargar
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="Registro de asistencia.xlsx"');
	header('Cache-Control: max-age=0');

	$writer = IOFactory::createWriter($ss, 'Xlsx');
	$writer->save('php://output');
?>