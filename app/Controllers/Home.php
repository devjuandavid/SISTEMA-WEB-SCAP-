<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\AsistenciaModel;
use App\Models\AreaModel;
use App\Models\InstitucionModel;

class Home extends BaseController
{
    public function index()
    {
        $tab_usuario = new UsuarioModel();
        $tab_area = new AreaModel();

        $fa = date('Y-m-d');

        $are = $this->request->getGet('a');
        $query = $this->db->query("SELECT *
            FROM asistencia a 
            INNER JOIN usuario u ON u.usu_id = a.usu_id
            WHERE a.asi_fecha = '$fa'
            ORDER BY a.asi_id DESC ");
        $dato_usuario = $query->getResultArray();

        $dato_area = $tab_area->findAll();

        $datos = array(
            'area' => $dato_area,
            'usuario' => $dato_usuario
        );

        return view('index', $datos);
    }
    //modificar clave
    public function camClave(){
        $tab_usuario = new UsuarioModel();

        $cla = $this->request->getPost('cla_act');
        $cln = $this->request->getPost('cla_nue');
        $clr = $this->request->getPost('cla_rep');
        $uid = session('id');

        $dat_usu = $tab_usuario->where('usu_id', $uid)->findAll();

        if (password_verify($cla, $dat_usu[0]['usu_clave'])) {
            if ($cln === $clr) {
                $data = [
                    'usu_clave' => password_hash($cln, PASSWORD_DEFAULT)
                ];

                $tab_usuario->update($uid, $data);

                return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'La contraseña se actualizo correctamente']);   
            }else{
                return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'La nueva contraseña no coincide']);
            }
        }else{
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Contraseña incorrecta']);
        }
    }
//session
    public function login(){
        $tab_usuario = new UsuarioModel();
        $tab_asistencia = new AsistenciaModel();

        $usu = $this->request->getPost('ci');

        $dat_usu = $tab_usuario->where('usu_ci', $usu)->findAll();

        if (!$dat_usu) {
            return redirect()->to(base_url('/'))->with('msg', ['tipo'=>'error', 'mensaje'=>'Usuario no registrado']);
        }


        if ($dat_usu[0]['usu_estado'] != 1) {
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Usuario bloqueado'])->withInput();
        }

        if ($dat_usu) {
            switch ($dat_usu[0]['usu_tipo']) {
                case '1':
                    if ($this->request->getPost('clave')) {
                        if (password_verify($this->request->getPost('clave'), $dat_usu[0]['usu_clave'])) {
                            $data = [
                                "tipo" => $dat_usu[0]['usu_tipo'],
                                "are" => $dat_usu[0]['are_id'],
                                "id" => $dat_usu[0]['usu_id'],
                                "nombre" => $dat_usu[0]['usu_nombre'].'  '.$dat_usu[0]['usu_ap_paterno'].' '.$dat_usu[0]['usu_ap_materno']
                            ];
                            $session = session();

                            $session->set($data);
                            return redirect()->to(base_url('panel'))->with('msg', ['tipo'=>'success', 'mensaje'=>'BIENVENIDO '.$dat_usu[0]['usu_nombre'].'  '.$dat_usu[0]['usu_ap_paterno'].' '.$dat_usu[0]['usu_ap_materno']]);
                            break;    
                        }else{
                            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Contraseña incorrecta'])->withInput();
                        }
                    }else{
                        return redirect()->to(base_url().'?u=1')->withInput();
                        break;
                    }
                    
                case '2':
                    $nom = $dat_usu[0]['usu_nombre'];
                    $u = $dat_usu[0]['usu_id'];
                    $fa = date('Y-m-d');
                    $ha = date(' H:i:s');

                    $query = $this->db->query("SELECT *
                        FROM asistencia
                        WHERE usu_id = $u AND asi_fecha = '$fa'");
                    $dat_asi = $query->getResultArray();

                    if($dat_asi){
                        $can = count($dat_asi);
                        if ($can == 1) {
                            $f_emi = date_create(date('Y-m-d H:i:s', strtotime($dat_asi[0]['asi_fecha'].' '.$dat_asi[0]['asi_hora'])));
                            $f_fin = date_create(date('Y-m-d H:i:s', strtotime($fa.' '.$ha)));

                            $diff = date_diff($f_emi, $f_fin);

                            $hor = $diff->format('%H');
                            $min = $diff->format('%i');
                                $hor = intval($hor);
                                $min = intval($min);                              
                            $tti = $min + ($hor * 60);
                            if ($tti < 30) {
                                return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Debe pasar por lo menos 30 minutos para que se registre su asistencia']);
                            }
                            $data = [
                                'usu_id' => $u,
                                'asi_fecha' => $fa,
                                'asi_hora' => $ha,
                                'asi_tipo' => 2
                            ];
                            $tab_asistencia->insert($data);
                            return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'REGISTRO DE SALIDA EXITOSA']);
                        }else{
                            return redirect()->back()->with('msg', ['tipo'=>'info', 'mensaje'=>'El usuario ya registro su entrada y salida']);
                        }
                    }else{
                        $data = [
                            'usu_id' => $u,
                            'asi_fecha' => $fa,
                            'asi_hora' => $ha,
                            'asi_tipo' => 1
                        ]; 
                        $tab_asistencia->insert($data);
                        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'REGISTRO DE INGRESO EXITOSO']);
                    }
                break;

                case '3':
                    if ($this->request->getPost('clave')) {
                        if (password_verify($this->request->getPost('clave'), $dat_usu[0]['usu_clave'])) {
                            $data = [
                                "tipo" => $dat_usu[0]['usu_tipo'],
                                "id" => $dat_usu[0]['usu_id'],
                                "are" => $dat_usu[0]['are_id'],
                                "nombre" => $dat_usu[0]['usu_nombre'].'  '.$dat_usu[0]['usu_ap_paterno'].' '.$dat_usu[0]['usu_ap_materno']
                            ];
                            $session = session();

                            $session->set($data);
                            return redirect()->to(base_url('panel'))->with('msg', ['tipo'=>'success', 'mensaje'=>'BIENVENIDO '.$dat_usu[0]['usu_nombre'].'  '.$dat_usu[0]['usu_ap_paterno'].' '.$dat_usu[0]['usu_ap_materno']]);
                            break;
                        }else{
                            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Contraseña incorrecta'])->withInput();
                        }
                    }else{
                        return redirect()->to(base_url().'?u=1')->withInput();
                        break;
                    }
            }
            
        }else{
            return redirect()->to(base_url('/'))->with('msg', ['tipo'=>'error', 'mensaje'=>'Usuario no registrado']);
        }
        return redirect()->to(base_url('/'));
    }
    //registro de usuario
    public function registro(){
        echo view('registro');
    }
    public function nuevoRegistro(){
        $tab_usuario = new UsuarioModel();

        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $app = mb_strtoupper($this->request->getPost('ap_pat'));
        $apm = mb_strtoupper($this->request->getPost('ap_mat'));
        $ced = $this->request->getPost('ci');
        $cel = mb_strtoupper($this->request->getPost('celular'));
        $ins = mb_strtoupper($this->request->getPost('instituto'));
        $car = mb_strtoupper($this->request->getPost('carrera'));
        $tie = $this->request->getPost('tiempo');

        $data = [
            'usu_nombre' => $nom,
            'usu_ap_paterno' => $app,
            'usu_ap_materno' => $apm,
            'usu_ci' => $ced,
            'usu_celular' => $cel,
            'usu_instituto' => $ins,
            'usu_carrera' => $car,
            'usu_tiempo' => $tie
        ];
        $tab_usuario->insert($data);

        return redirect()->to(base_url('/'))->with('msg', ['tipo'=>'success', 'mensaje'=>'Usuario registrado exitosamente']);
    }
    //generar reporte
    public function reporteHorario(){
        $uci = $this->request->getPost('ci');
        $tip = $this->request->getPost('file');

        $query = $this->db->query("SELECT *
            FROM usuario 
            WHERE usu_ci = '$uci'");
        $dat_usu = $query->getResultArray();

        if ($dat_usu) {
            switch($tip){
                case '1':
                    return redirect()->to(base_url('/reporte/reporte.php?u='.base64_encode($uci)));
                break;
                case '2':
                    return redirect()->to(base_url('/excel/genReporte.php?u='.base64_encode($uci)));
                break;
            }
        }else{
            return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Usuario no registrado']);
        }
    }
    //cerrar sesion
    public function salir(){
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }
//panel
    public function panel(){
        $tab_usuario = new UsuarioModel();
        $tab_asistencia = new AsistenciaModel();
        $pag = ['pag' => 'pri'];

        $are = session('are');

        //llamar usuarios
            $dato_usuario = $tab_usuario->where('usu_tipo', 2)->orderBy('usu_id', 'desc')->findAll();

            $query = $this->db->query("SELECT a.are_id, a.are_nombre, COUNT(u.usu_id) AS can
                FROM area a 
                Left JOIN usuario u ON u.are_id = a.are_id
                WHERE u.usu_estado = 1 
                GROUP BY a.are_id");
            $dato_area = $query->getResultArray();

        //area individual
            $query = $this->db->query("SELECT a.are_id, a.are_nombre, COUNT(u.usu_id)-1  AS can
                FROM area a 
                inner JOIN usuario u ON u.are_id = a.are_id
                WHERE u.are_id = $are AND u.usu_estado = 1 
                GROUP BY a.are_id");
            $dat_are = $query->getResultArray();

        //instituciones
            $query = $this->db->query("SELECT i.ins_id, i.ins_nombre, COUNT(u.usu_id) AS can
                FROM institucion i 
                INNER JOIN usuario u ON u.ins_id = i.ins_id
                WHERE u.usu_estado = 1 AND u.usu_tipo = 2
                GROUP BY i.ins_id");
            $dato_institucion = $query->getResultArray();

        //llamar podio
            $query = $this->db->query("SELECT u.usu_id, ar.are_nombre, u.usu_foto, u.usu_nombre, u.usu_ap_paterno, u.usu_ap_materno, COUNT(*) as can_hor
                FROM `asistencia` a 
                INNER JOIN usuario u ON u.usu_id = a.usu_id
                INNER JOIN area ar ON ar.are_id = u.are_id
                WHERE a.asi_hora < '08:30:00' AND u.usu_estado = 1 AND a.asi_tipo = 1
                GROUP BY u.usu_id 
                ORDER BY can_hor DESC");
            $dato_podio_man = $query->getResultArray();

            $query = $this->db->query("SELECT u.usu_id, ar.are_nombre, u.usu_foto, u.usu_nombre, u.usu_ap_paterno, u.usu_ap_materno, COUNT(*) as can_hor
                FROM `asistencia` a 
                INNER JOIN usuario u ON u.usu_id = a.usu_id
                INNER JOIN area ar ON ar.are_id = u.are_id
                WHERE a.asi_hora < '14:30:00' AND a.asi_hora > '13:00:00' AND u.usu_estado = 1 AND a.asi_tipo = 1
                GROUP BY u.usu_id 
                ORDER BY can_hor DESC");
            $dato_podio_tar = $query->getResultArray();

        $datos = array(
            'area' => $dato_area,
            'dat_are' => $dat_are,
            'institucion' => $dato_institucion,
            'pod_man' => $dato_podio_man,
            'pod_tar' => $dato_podio_tar,
            'usuario' => $dato_usuario
        );

        echo view('admin/header', $pag);
        echo view('admin/panel', $datos);
        echo view('admin/footer');
    }
//usuarios
    public function usuario(){
        $tab_area = new AreaModel();
        $tab_usuario = new UsuarioModel();
        $tab_institucion = new InstitucionModel();
        $pag = ['pag' => 'usu'];

        if (session('are') != '1') {
            $are = session('are');
            $query = $this->db->query("SELECT u.*, a.are_nombre, i.ins_nombre 
                FROM usuario u 
                INNER JOIN area a ON a.are_id = u.are_id
                INNER JOIN institucion i ON i.ins_id = u.ins_id
                WHERE u.usu_tipo != 1 AND u.usu_tipo != 3 AND u.are_id = $are
                ORDER BY u.usu_id desc"
            );
        }else{
            $query = $this->db->query("SELECT u.*, a.are_nombre, i.ins_nombre
                FROM usuario u 
                INNER JOIN area a ON a.are_id = u.are_id
                INNER JOIN institucion i ON i.ins_id = u.ins_id
                WHERE usu_tipo != 1 AND usu_tipo != 3
                ORDER BY u.usu_id desc"
            );
        }
        
        $dato_usuario = $query->getResultArray();

        $dato_area = $tab_area->where('are_estado', 1)->orderBy('are_id', 'asc')->findAll();
        $dato_institucion = $tab_institucion->where('ins_estado', 1)->orderBy('ins_nombre', 'asc')->findAll();

        $datos = array(
            'area' => $dato_area,
            'institucion' => $dato_institucion,
            'usuario' => $dato_usuario
        );

        echo view('admin/header', $pag);
        echo view('admin/usuario', $datos);
        echo view('admin/footer');
    }
    //nuevo usuario
    public function nuevoUsuario(){
        $tab_usuario = new UsuarioModel();

        $fot = $this->request->getFile('foto');
        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $app = mb_strtoupper($this->request->getPost('ap_pat'));
        $apm = mb_strtoupper($this->request->getPost('ap_mat'));
        $ced = $this->request->getPost('ci');
        $exp = $this->request->getPost('exp');
        $cel = mb_strtoupper($this->request->getPost('celular'));
        $ins = $this->request->getPost('institucion');
        $ind = $this->request->getPost('desc_inst');
        $car = mb_strtoupper($this->request->getPost('carrera'));
        $tie = $this->request->getPost('tiempo');
        $are = $this->request->getPost('area');

        $dat_usu = $tab_usuario->where('usu_ci', $ced)->findAll();

        if ($dat_usu) {
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'El usuario ya ha sido registrado']);
        }

        if ($ind == '') {
            $ind = '';
        }

        if ($exp == '0') {
            $exp = NULL;
        }
        //verificar datos
        if ($app == '') { $app = NULL; }
        if ($apm == '') { $apm = NULL; }

        //guardar foto
        if ($fot->getName() != '') {
            $fot->move('public/foto/', 'foto.jpg');
            $fot = $fot->getName();
        }else{
            $fot = 'foto_def.jpg';
        }

        $data = [
            'are_id' => $are,
            'ins_id' => $ins,
            'usu_nombre' => $nom,
            'usu_ap_paterno' => $app,
            'usu_ap_materno' => $apm,
            'usu_ci' => $ced,
            'usu_exp' => $exp,
            'usu_celular' => $cel,
            'usu_instituto' => $ind,
            'usu_carrera' => $car,
            'usu_foto' => $fot,
            'usu_tiempo' => $tie
        ];
        $tab_usuario->insert($data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Usuario registrado exitosamente']);
    }
    //editar usuario
    public function editarUsuario(){
        $tab_usuario = new UsuarioModel();

        $usu = $this->request->getGet('u');

        $fot = $this->request->getFile('foto');
        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $app = mb_strtoupper($this->request->getPost('ap_pat'));
        $apm = mb_strtoupper($this->request->getPost('ap_mat'));
        $ced = $this->request->getPost('ci');
        $exp = $this->request->getPost('exp');
        $cel = mb_strtoupper($this->request->getPost('celular'));
        $ins = $this->request->getPost('institucion');
        $car = mb_strtoupper($this->request->getPost('carrera'));
        $tie = $this->request->getPost('tiempo');
        $are = $this->request->getPost('area');

        $query = $this->db->query("SELECT * 
            FROM usuario 
            WHERE usu_ci = '$ced' AND usu_id != $usu");
        $dat_usu = $query->getResultArray();

        if ($dat_usu) {
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'El usuario ya ha sido registrado']);
        }

        $dat_usu = $tab_usuario->where('usu_id', $usu)->findAll();
        //guardar foto
        if ($fot->getName() != '') {
            $img_act = $dat_usu[0]['usu_foto'];
            if($img_act != 'foto_def.jpg'){
                unlink(FCPATH.'public/foto/'.$img_act);
            }
            $fot->move('public/foto', 'foto.jpg');
            $fot = $fot->getName();

            $data = [
                'usu_foto' => $fot
            ];
            $tab_usuario->update($usu, $data);
        }

        if ($exp == '0') {
            $exp = NULL;
        }

        $data = [
            'are_id' => $are,
            'ins_id' => $ins,
            'usu_nombre' => $nom,
            'usu_ap_paterno' => $app,
            'usu_ap_materno' => $apm,
            'usu_ci' => $ced,
            'usu_exp' => $exp,
            'usu_celular' => $cel,
            'usu_carrera' => $car,
            'usu_tiempo' => $tie
        ];
        $tab_usuario->update($usu, $data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Usuario editado exitosamente']);
    }
    //eliminar usuario
    public function eliminarUsuario(){
        $tab_usuario = new UsuarioModel();
        $tab_asistencia = new AsistenciaModel();

        $usu = base64_decode($this->request->getGet('u'));

        $dat_usu = $tab_asistencia->where('usu_id', $usu)->findAll();

        if ($dat_usu) {
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Existen datos registrados con este usuario, elimine la información referenciada primero']);
        }else{
            $tab_usuario->delete($usu);
            return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Usuario eliminado exitosamente']);
        }
    }
    //acceso usuario
    public function accesoUsuario(){
        $tab_usuario = new UsuarioModel();

        $acc = $this->request->getGet('e');
        $usu = base64_decode($this->request->getGet('u'));

        if ($acc == 1) { $est = 2; $men = 'Usuario bloqueado correctamente'; }else{ $est = 1; $men = 'Usuario habilitado correctamente'; }

        $data = [
            'usu_estado' => $est
        ];
        $tab_usuario->update($usu, $data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>$men]);
    }
//asistencia
    public function asistencia(){
        $tab_usuario = new UsuarioModel();
        $tab_asistencia = new AsistenciaModel();
        $usu = base64_decode($this->request->getGet('u'));

        $pag = ['pag' => 'usu'];

        $dato_usuario = $tab_usuario->where('usu_id', $usu)->findAll();
        $query = $this->db->query("SELECT *
            FROM asistencia
            WHERE usu_id = $usu
            ORDER BY asi_fecha desc, asi_hora desc
            ");
        $dato_asistencia = $query->getResultArray();

        $datos = array(
            'asistencia' => $dato_asistencia,
            'usuario' => $dato_usuario
        );

        echo view('admin/header', $pag);
        echo view('admin/asistencia', $datos);
        echo view('admin/footer');
    }
    // insertar asistencia
    public function nuevoAsistencia(){
        $tab_asistencia = new AsistenciaModel();

        $usu = base64_decode($this->request->getGet('u'));
        $fec = $this->request->getPost('fecha');
        $hor = $this->request->getPost('hora');
        $tip = $this->request->getPost('tipo');

        $data = [
            'usu_id' => $usu,
            'asi_fecha' => $fec,
            'asi_hora' => $hor,
            'asi_tipo' => $tip
        ];
        $tab_asistencia->insert($data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Registro adicionado exitosamente']);
    }
    // editar asistencia
    public function editarAsistencia(){
        $tab_asistencia = new AsistenciaModel();
        $asi = $this->request->getGet('as');

        $fec = $this->request->getPost('fecha');
        $hor = $this->request->getPost('hora');
        $tip = $this->request->getPost('tipo');

        $data = [
            'asi_fecha' => $fec,
            'asi_hora' => $hor,
            'asi_tipo' => $tip
        ];
        $tab_asistencia->update($asi, $data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Registro editado exitosamente']);
    }
    // eliminar asistencia
    public function eliminarAsistencia(){
        $tab_asistencia = new AsistenciaModel();
        $asi = base64_decode($this->request->getGet('as'));

        $tab_asistencia->delete($asi);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Registro eliminado exitosamente']);
    }
//area
    public function areas(){
        $tab_area = new AreaModel();
        $pag = ['pag' => 'are'];

        //llamar areas 
        $query = $this->db->query("SELECT * 
            FROM area a 
            INNER JOIN usuario u ON u.are_id = a.are_id
            WHERE usu_tipo = 3");
        $dato_area = $query->getResultArray();


        $datos = array(
            'area' => $dato_area
        );

        echo view('admin/header', $pag);
        echo view('admin/area', $datos);
        echo view('admin/footer');
    }
    //nueva area
    public function nuevaArea(){
        $tab_area = new AreaModel();
        $tab_usuario = new UsuarioModel();
        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $est = $this->request->getPost('estado');
        $usu = $this->request->getPost('usuario');

        $data = [
            'are_nombre' => $nom,
            'are_estado' => $est
        ];
        $tab_area->insert($data);

        $query = $this->db->query("SELECT are_id FROM area ORDER BY are_creacion DESC LIMIT 1;");
        $dat_are = $query->getResultArray();

        $data = [
            'are_id' => $dat_are[0]['are_id'],
            'ins_id' => 0,
            'usu_tipo' => 3,
            'usu_nombre' => $nom,
            'usu_ap_paterno' => '',
            'usu_ap_materno' => '',
            'usu_ci' => $usu,
            'usu_celular' => '',
            'usu_instituto' => '',
            'usu_carrera' => '',
            'usu_tiempo' => '',
            'usu_clave' => password_hash($usu, PASSWORD_DEFAULT)
        ];
        $tab_usuario->insert($data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Área registrada exitosamente']);
    }
    //editar area
    public function editarArea(){
        $tab_area = new AreaModel();
        $tab_usuario = new UsuarioModel();
        $are = $this->request->getGet('a');
        $isu = $this->request->getGet('u');
        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $est = $this->request->getPost('estado');
        $usu = $this->request->getPost('usuario');

        $data = [
            'are_nombre' => $nom,
            'are_estado' => $est
        ];
        $tab_area->update($are, $data);

        if ($isu != '') {
            $data = [
                'usu_nombre' => $nom,
                'usu_ci' => $usu,
                'usu_clave' => password_hash($usu, PASSWORD_DEFAULT)
            ];
            $tab_usuario->update($isu, $data);
        }

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Área editada exitosamente']);
    }
    //eliminar area
    public function eliminarArea(){
        $tab_usuario = new UsuarioModel();
        $tab_area = new AreaModel();
        $isu = base64_decode($this->request->getGet('u'));
        $are = base64_decode($this->request->getGet('a'));

        $query = $this->db->query("SELECT * FROM usuario WHERE are_id = $are AND usu_tipo != 3");
        $dat_usu = $query->getResultArray();

        if ($dat_usu) {
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Existen datos registrados con esta área, elimine la información referenciada primero']);
        }else{
            $tab_usuario->delete($isu);
            $tab_area->delete($are);
            return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Área eliminada exitosamente']);
        }
    }
//institucion
    public function institucion(){
        $tab_institucion = new InstitucionModel();
        $pag = ['pag' => 'ins'];

        //llamar usuarios
        $dato_institucion = $tab_institucion->orderBy('ins_id', 'desc')->findAll();


        $datos = array(
            'institucion' => $dato_institucion
        );

        echo view('admin/header', $pag);
        echo view('admin/institucion', $datos);
        echo view('admin/footer');
    }
    //nueva institucion
    public function nuevaInstitucion(){
        $tab_institucion = new InstitucionModel();
        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $est = $this->request->getPost('estado');

        $data = [
            'ins_nombre' => $nom,
            'ins_estado' => $est
        ];
        $tab_institucion->insert($data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Institución registrada exitosamente']);
    }
    //editar area
    public function editarInstitucion(){
        $tab_institucion = new InstitucionModel();

        $ins = $this->request->getGet('i');
        $nom = mb_strtoupper($this->request->getPost('nombre'));
        $est = $this->request->getPost('estado');

        $data = [
            'ins_nombre' => $nom,
            'ins_estado' => $est
        ];
        $tab_institucion->update($ins, $data);

        return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Institución editada exitosamente']);
    }
    //eliminar area
    public function eliminarInstitucion(){
        $tab_usuario = new UsuarioModel();
        $tab_institucion = new InstitucionModel();
        $are = base64_decode($this->request->getGet('a'));

        $dat_usu = $tab_usuario->where('ins_id', $are)->findAll();

        if ($dat_usu) {
            return redirect()->back()->with('msg', ['tipo'=>'error', 'mensaje'=>'Existen datos registrados con esta área, elimine la información referenciada primero']);
        }else{
            $tab_institucion->delete($are);
            return redirect()->back()->with('msg', ['tipo'=>'success', 'mensaje'=>'Institución eliminada exitosamente']);
        }
    }
//ajax
    public function AJAX(){
        $db = \Config\Database::connect();

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

                    echo json_encode($dato);
                }
            //area
                if($act == 'get_are')
                {  
                    $are = $this->request->getVar('a');
                    $query = $db->query("SELECT a.*, u.usu_id, u.usu_ci
                        FROM area a 
                        left JOIN usuario u ON u.are_id = a.are_id
                        WHERE a.are_id = $are");
                    $dato = $query->getResultArray();

                    echo json_encode($dato);
                }
            //institucion
                if($act == 'get_ins')
                {  
                    $ins = $this->request->getVar('i');
                    $query = $db->query("SELECT *
                        FROM institucion 
                        WHERE ins_id = $ins");
                    $dato = $query->getResultArray();

                    echo json_encode($dato);
                }
            //asistencia
                if($act == 'get_asi')
                {  
                    $asi = $this->request->getVar('as');
                    $query = $db->query("SELECT *
                        FROM asistencia 
                        WHERE asi_id = $asi");
                    $dato = $query->getResultArray();

                    echo json_encode($dato);
                }
            //podioi
                if($act == 'get_pod')
                {  
                    $usu = $this->request->getVar('u');
                    $query = $db->query("SELECT count(*)/2 as can_dia
                        FROM asistencia 
                        WHERE usu_id = $usu");
                    $dato = $query->getResultArray();

                    echo json_encode($dato);
                }
        }
    }
}
