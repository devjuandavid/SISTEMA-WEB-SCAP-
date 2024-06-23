<?php 
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

include('../../modelo/conexion.php');
$link = Conexion::conectar();

date_default_timezone_set('America/La_Paz');
$fac = date('Y-m-d H:i:s');

$tok = base64_decode($_GET['t']);

$consulta = $link->prepare("SELECT *
	FROM token 
	WHERE tok_codigo = '$tok'");
$consulta->execute();

while ($row = $consulta->fetch()) {
	$fin = $row['tok_hora_inicio'];
	$ffi = $row['tok_hora_fin'];
	$tip = $row['tok_tipo'];
}
if($fac >= $fin && $fac <= $ffi){

	$ss = new SpreadSheet();

	//metadatos
	$ss->getProperties()->setCreator('SIA - Kernel Bolivia - MAQV')->setTitle('Institutos');
	$ss->setActiveSheetIndex(0);
	$hojaAct = $ss->getActiveSheet();

	//agregar logo
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
		$drawing->setName('Logo');
		$drawing->setDescription('Logo');
		$drawing->setPath('../../public/assets/img/membrete.png');
		$drawing->setHeight(50);

		$drawing->setWorksheet($ss->getActiveSheet());
		$drawing->setCoordinates('A1');
	//titulo
	$hojaAct->setCellValue('A1', 'LISTA DE CARRERAS DE INSTITUTOS');
	//combinar celdas
	$ss->getActiveSheet()->mergeCells('A1:H1');
	//centrar y cambiar estilo de texto
	$ss->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
	$ss->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(20);
	//definir cabecera
	$hojaAct
	->setCellValue('A2', 'Nº')
	->setCellValue('B2', 'COD-UE')
	->setCellValue('C2', 'INSTITUTOS')
	->setCellValue('D2', 'CARRERAS')
	->setCellValue('E2', 'MENCIÓN')
	->setCellValue('F2', 'NIVEL DE FORMACIÓN')
	->setCellValue('G2', 'RÉGIMEN ACADÉMICO')
	->setCellValue('H2', 'CANTIDAD DE DOCENTES');
	//DEFINIR BOLD
	$ss->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(true);

	//LLENAR CONTENIDO DE DOCUMENTO
	$consulta = $link->prepare("SELECT * 
		FROM institutos");
	$consulta->execute();
	
	$k = 2;
	$i = 2;
	$c = 0;
	$tot_doc = 0;
	while ($row = $consulta->fetch()) { 
		$uea = $row['inst_codigo_ue'];
		$b = 0;
		$c++;
		//Definir agrupacion de institutos
		$con1 = $link->prepare("SELECT COUNT(cs.carsel_id) AS can_car 
			FROM carreras_seleccionadas cs 
			WHERE cs.inst_codigo_ue = '$uea' ");
		$con1->execute();

		while ($row1 = $con1->fetch()) {
			$cnc = $row1['can_car'];
		}
		//carreraas por instituto
		$con2 = $link->prepare("SELECT cs.*, c.*, nv.niv_nombre,  COUNT(u.usu_id) AS can_doc 
			FROM carreras_seleccionadas cs 
			INNER JOIN carreras c ON c.carr_id = cs.carr_id
			INNER JOIN nivel_formacion nv ON nv.niv_id = c.niv_id
			LEFT JOIN usuarios u ON u.carsel_id = cs.carsel_id
			WHERE cs.inst_codigo_ue = '$uea'
			GROUP BY cs.carsel_id
			ORDER BY cs.inst_codigo_ue ASC");
		$con2->execute();

		while ($row2 = $con2->fetch()) {
			$i++;
			if ($b == 0) {
				$ic = $i+$cnc;
				$ic = $ic -1;
				$hojaAct->setCellValue('A'.$i, $c);
				$hojaAct->setCellValue('B'.$i, $row['inst_codigo_ue']);
				$hojaAct->setCellValue('C'.$i, $row['inst_nombre']);
				$hojaAct->setCellValue('D'.$i, $row2['carr_nombre']);
				$men = '';
				switch($row2['carr_mension']){
					case '0': $men = 'SIN MENCIÓN'; break;
					case '1': $men = $row2['carr_nom_mension']; break;
					case '2': $men = 'MENCIÓN MULTIPLE'; break;
				}
				$hojaAct->setCellValue('E'.$i, $men);
				$hojaAct->setCellValue('F'.$i, $row2['niv_nombre']);
				if ($row2['carr_regimen'] == 1) {
					$reg = 'SEMESTRAL';
				}else{
					$reg = 'ANUAL';
				}
				$hojaAct->setCellValue('G'.$i, $reg);
				$hojaAct->setCellValue('H'.$i, $row2['can_doc']);
				$tot_doc = $tot_doc + $row2['can_doc'];
				$ss->getActiveSheet()->mergeCells('A'.$i.':A'.$ic);
				$ss->getActiveSheet()->mergeCells('B'.$i.':B'.$ic);
				$ss->getActiveSheet()->mergeCells('C'.$i.':C'.$ic);
				$ss->getActiveSheet()->getStyle('A'.$i.':A'.$ic)->getAlignment()->setVertical('center');
				$ss->getActiveSheet()->getStyle('B'.$i.':B'.$ic)->getAlignment()->setVertical('center');
				$ss->getActiveSheet()->getStyle('B'.$i.':B'.$ic)->getAlignment()->setHorizontal('center');
				$ss->getActiveSheet()->getStyle('C'.$i.':C'.$ic)->getAlignment()->setVertical('center');
				$b = 1;
			}else{
				$hojaAct->setCellValue('D'.$i, $row2['carr_nombre']);
				$men = '';
				switch($row2['carr_mension']){
					case '0': $men = 'SIN MENCIÓN'; break;
					case '1': $men = $row2['carr_nom_mension']; break;
					case '2': $men = 'MENCIÓN MULTIPLE'; break;
				}
				$hojaAct->setCellValue('E'.$i, $men);
				$hojaAct->setCellValue('F'.$i, $row2['niv_nombre']);
				if ($row2['carr_regimen'] == 1) {
					$reg = 'SEMESTRAL';
				}else{
					$reg = 'ANUAL';
				}
				$hojaAct->setCellValue('G'.$i, $reg);
				$hojaAct->setCellValue('H'.$i, $row2['can_doc']);
				$tot_doc = $tot_doc + $row2['can_doc'];
			}
		}
	}
	
	$i = $i + 1;

	$hojaAct->setCellValue('A'.$i, 'TOTAL');
	$ss->getActiveSheet()->mergeCells('A'.$i.':'.'G'.$i,);
	$hojaAct->setCellValue('H'.$i, $tot_doc);

	$ss->getActiveSheet()->getStyle('A'.$i.':H'.$i)->getFont()->setBold(true);

	//definir altura de una fila
		$ss->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
	//ancho de columna automatico
	$ss->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$ss->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	//para descargar
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="LISTA DE INSTITUTOS POR DEPARTAMENTO.xlsx"');
	header('Cache-Control: max-age=0');

	$writer = IOFactory::createWriter($ss, 'Xlsx');
	$writer->save('php://output');


}else{ $url = $_SERVER["HTTP_HOST"].'/salir';?>
	<script>
		window.location.href = "http://<?= $url ?>";
	</script>
<?php } ?>