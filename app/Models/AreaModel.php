<?php
namespace App\Models;

use CodeIgniter\Model;

class AreaModel extends Model{

	protected $table = 'area';
	protected $primaryKey = 'are_id';

	protected $useAutoIncrement = true;

    protected $returnType     = 'array';

	protected $allowedFields = [
		'are_nombre',
		'are_estado'
	];
}