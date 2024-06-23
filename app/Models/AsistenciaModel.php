<?php
namespace App\Models;

use CodeIgniter\Model;

class AsistenciaModel extends Model{

	protected $table = 'asistencia';
	protected $primaryKey = 'asi_id';

	protected $useAutoIncrement = true;

    protected $returnType     = 'array';

	protected $allowedFields = [
		'usu_id',
		'asi_fecha',
		'asi_hora',
		'asi_tipo'
	];
}