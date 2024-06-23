<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCAP</title>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/app.css') ?>">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- mensaje de bienvenida -->
      <?php if(session('msg')): ?>
        <?php switch (session('msg.tipo')) {
          case 'warning': $tit = '¡ADVERTENCIA!'; break;
          case 'error': $tit = '¡ERROR!'; break;
          case 'success': $tit = '¡EXITO!'; break;
          case 'info': $tit = '¡INFORMACIÓN!'; break;
          case 'question': $tit = '¡CONSULTA!'; break;
        } ?>
        <script>
          Swal.fire({
            background: '#fff',
            confirmButtonColor: '#456ba4',
            icon: "<?= session('msg.tipo')?>",
            title: "<?= $tit ?>",
            text: "<?= session('msg.mensaje') ?>",
            showConfirmButton: true,
            confirmButtonText: "<b class='px-5'>CERRAR</b>"
          });
        </script>
      <?php endif ?>
      <?php function fecha($e){
        $m = date('m', strtotime($e));
        $d = date('d', strtotime($e));
        $y = date('Y', strtotime($e));
        switch ($d){
          case '01': $d = 1; break;
          case '02': $d = 2; break;
          case '03': $d = 3; break;
          case '04': $d = 4; break;
          case '05': $d = 5; break;
          case '06': $d = 6; break;
          case '07': $d = 7; break;
          case '08': $d = 8; break;
          case '09': $d = 9; break;
        }
        switch ($m) {
            case '01': $m = 'enero'; break;
            case '02': $m = 'febrero'; break;
            case '03': $m = 'marzo'; break;
            case '04': $m = 'abril'; break;
            case '05': $m = 'mayo'; break;
            case '06': $m = 'junio'; break;
            case '07': $m = 'julio'; break;
            case '08': $m = 'agosto'; break;
            case '09': $m = 'septiembre'; break;
            case '10': $m = 'octubre'; break;
            case '11': $m = 'noviembre'; break;
            case '12': $m = 'diciembre'; break;
        }

        return $d.' de '.$m.' de '.$y;
      } ?>
    <!-- fin de mensaje -->
  <div id="auth">
    <div class="container">
      <div class="row">
        <!-- login y usuario --> 
        <div class="col-md-5 col-sm-12 mx-auto">
          <div class="card pt-3">
            <div class="card-body">
              <div class=" mb-3">
                <div class="row">
                  <div class="col-md-12 text-center my-auto">
                    <img src="<?= base_url('public/assets/images/log_scap.jpg') ?>" height="150" class='mb-4'>
                  </div>
                </div>
              </div>
              <form method="post" action="<?= base_url('login') ?>" class="row">
                <?php if (isset($_GET['u'])): ?>
                  <div class="form-group mb-5 col-md-12 text-center">
                    <label for="username">Usuario</label>
                    <div class="position-relative">
                      <input name="ci" type="text" minlength="3" class="form-control" id="ci" autocomplete="off" value="<?= old('ci')?>" required>
                    </div>
                  </div>
                  <div class="form-group mb-5 col-md-12 text-center">
                    <label for="clave">Contraseña</label>
                    <div class="position-relative">
                      <input name="clave" type="password" minlength="3" class="form-control" id="clave" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="mb-3 text-center col-md-12">
                    <button class="btn btn-primary">INICIO DE SESIÓN</button>
                  </div>
                  <div class="mb-3 text-center col-md-12">
                    <a class="btn" href="<?= base_url() ?>">VOLVER</a>
                  </div>
                <?php else: ?>
                  <div class="form-group mb-3 col-md-12 text-center">
                    <label for="username">Cédula de identidad</label>
                    <div class="position-relative">
                      <input name="ci" type="text" class="form-control" id="ci" autocomplete="off" required style="border: 2px solid #C5DDE7;" placeholder="91700000" >
                    </div>
                  </div>
                  <div class="mb-3 text-center col-md-12">
                    <button class="btn btn-primary">ACEPTAR</button>
                  </div>
                  <!--
                  <div class="mb-3 text-center col-md-6">
                    <a class="btn" href="<?= base_url('registro') ?>">REGISTRATE</a>
                  </div>
                  <div class="mb-3 text-center col-md-6">
                    <a class="btn text-dark font-weight-bold" data-toggle="modal" data-target="#reporte">REPORTES</a>
                  </div> -->
                <?php endif ?>
              </form>
            </div>
          </div>
        </div>
        <!-- hitorial de asistencias -->
        <div class="col-md-8 mx-auto">
          <div class="card"> 
            <div class="card-body overflow-auto ovf" style="height: 150px;">
              <table class="w-100">
                <?php foreach ($usuario as $i => $dato): ?>
                  <tr>
                    <td class="text-center small"><?= ucwords(mb_strtolower($dato['usu_nombre'].' '.$dato['usu_ap_paterno'].' '.$dato['usu_ap_materno'])) ?></td>
                    <td class="text-center small"><?= fecha($dato['asi_fecha']) ?></td>
                    <td class="text-center small"><?= $dato['asi_hora'] ?></td>
                    <td class="text-center small">
                      <?php switch ($dato['asi_tipo']) {
                        case '1':
                          echo "<b class='text-info'><i class='fa-solid fa-door-closed'></i> Ingreso registrado</b>";
                          break;
                        case '2':
                          echo "<b class='text-dark'><i class='fa-solid fa-door-open'></i> Salida registrada</b>";
                          break;
                      } ?>
                    </td>
                  </tr>
                <?php endforeach ?>
                <tr>
                  <td></td>
                </tr>
              </table>
            </div>
            <div class="text-center small pt-3">
              <p>
                © 2024 - Dirección Departamental de Educación La Paz 
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- modal -->
    <div class="modal fade" id="reporte" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form id="formulario" action="<?= base_url('rep-hor') ?>" method="post" target="_blank">
            <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">GENERAR REPORTE</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="h4" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ovf">

              <div class="row">
                <div class="col-md-4 mb-3">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cédula de identidad</font></font></label>
                </div>
                <div class="col-md-8 mb-3">
                        <div class="position-relative">
                            <input type="text" class="form-control" id="first-name-icon" name="ci" autocomplete="off" pattern=".{5,25}" title="Datos alfanuméricos entre 5 a 25 caracteres" required>
                        </div>
                </div>
                <div class="col-md-4">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tipo de reporte</font></font></label>
                </div>
                <div class="col-md-8">
                  <div class="input-group mb-3">
                      <select class="form-select" id="file" name="file" required>
                          <option value="1">Archivo PDF</option>
                          <option value="2">Archivo Excel</option>
                      </select>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              <button id="button" type="submit" class="btn btn-primary">GENERAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <!-- fin modal -->

  <script src="<?= base_url('public/assets/js/feather-icons/feather.min.js') ?>"></script>
  <script src="<?= base_url('public/assets/js/app.js') ?>"></script>
  <script src="<?= base_url('public/assets/js/main.js') ?>"></script>
</body>
</html>