<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\AsistenciaModel;

class CtAjax extends BaseController
{
    //ajax
    public function AJAX(){
        echo json_encode($this->request->getPost('u'));
        /*$db = \Config\Database::connect();

        if($this->request->getVar('act'))
        {
            $act = $this->request->getVar('act');

            //tipo de intervencion
                if($act == 'get_usu')
                {  
                    $usu = $this->request->getVar('u');
                    $query = $db->query("SELECT *
                        FROM usuario 
                        WHERE usu_id = $usu");
                    $dato = $query->getResultArray();

                    echo json_encode($usu);
                }
        }*/
    }
}