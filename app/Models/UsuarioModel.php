<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{

	protected $table = 'usuario';
	protected $primaryKey = 'usu_id';

	protected $useAutoIncrement = true;

    protected $returnType     = 'array';

	protected $allowedFields = [
		'are_id',
		'ins_id',
		'usu_tipo',
		'usu_nombre',
		'usu_ap_paterno',
		'usu_ap_materno',
		'usu_ci',
		'usu_exp',
		'usu_celular',
		'usu_instituto',
		'usu_carrera',
		'usu_estado',
		'usu_tiempo',
		'usu_foto',
		'usu_clave'
	];
}