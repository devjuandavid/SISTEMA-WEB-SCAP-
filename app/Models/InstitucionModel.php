<?php
namespace App\Models;

use CodeIgniter\Model;

class InstitucionModel extends Model{

	protected $table = 'institucion';
	protected $primaryKey = 'ins_id';

	protected $useAutoIncrement = true;

    protected $returnType     = 'array';

	protected $allowedFields = [
		'ins_nombre',
		'ins_estado'
	];
}