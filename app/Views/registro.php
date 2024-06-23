<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCAP</title>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/fontawesome/css/all.css">
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
    <!-- fin de mensaje -->
  <div id="auth">
        
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-sm-12 mx-auto">
          <div class="card pt-4">
            <div class="card-body">
              <div class="mb-5">
                <div class="row">
                  <div class="col-md-1 text-center my-auto">
                    <img src="<?= base_url('public/assets/images/ddelpz.png') ?>" height="60" class='mb-4'>
                  </div>
                  <div class="col-md-11 my-auto text-sm-center text-lg-left">
                    <h4 class="">SCAP</h4>
                    <p class="">Sistema de Control de Asistencia de Pasantias</p>
                  </div>
                </div>
                
                
              </div>
              <form id="frml" method="post" action="<?= base_url('reg-for') ?>" class="row">
                  <!-- nombre -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nombre</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Nombre" id="first-name-icon" name="nombre" autocomplete="off" pattern=".{3,100}" title="Datos alfabéticos entre 3 a 100 caracteres" required>
                              <div class="form-control-icon">
                                  <i class="fa-solid fa-signature"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- apellido paterno -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Apellido paterno</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Apellido paterno" id="first-name-icon" name="ap_pat" pattern=".{3,100}" title="Datos alfabéticos entre 3 a 100 caracteres"  autocomplete="off">
                              <div class="form-control-icon">
                                  <i class="fa-solid fa-signature"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- apellido materno -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Apellido materno</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Apellido materno" id="first-name-icon" name="ap_mat" pattern=".{3,100}" title="Datos alfabéticos entre 3 a 100 caracteres"  autocomplete="off">
                              <div class="form-control-icon">
                                  <i class="fa-solid fa-signature"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- ci -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cédula de identidad</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Cédula de identidad" id="first-name-icon" name="ci" autocomplete="off" pattern=".{5,25}" title="Datos alfanuméricos entre 5 a 25 caracteres"  required>
                              <div class="form-control-icon">
                                  <i class="fa-regular fa-id-card"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- celular -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Número celular</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Número celular" id="first-name-icon" name="celular" autocomplete="off" pattern="[0-9]{8}" title="Datos numéricos de 8 dígitos" required>
                              <div class="form-control-icon">
                                  <i class="fa-solid fa-mobile-screen"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- instituto -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Instituto</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Instituto" id="first-name-icon" name="instituto" autocomplete="off" pattern=".{5,250}" title="Datos alfanuméricos entre 5 a 250 caracteres" required>
                              <div class="form-control-icon">
                                  <i class="fa-solid fa-building-columns"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- carrera -->
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Carrera</font></font></label>
                  </div>
                  <div class="col-md-4">
                      <div class="form-group has-icon-left">
                          <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Carrera" id="first-name-icon" name="carrera" autocomplete="off" pattern=".{5,250}" title="Datos alfanuméricos entre 5 a 250 caracteres" required>
                              <div class="form-control-icon">
                                  <i class="fa-solid fa-folder-tree"></i>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tiempo</font></font></label>
                  </div>
                  <div class="col-md-4">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="tiempo"><i class="fa-solid fa-calendar-days"></i></label>
                        <select class="form-select" id="tiempo" name="tiempo">
                            <option selected="">Seleccionar...</option>
                            <option value="1">Medio tiempo</option>
                            <option value="2">Tiempo completo</option>
                        </select>
                    </div>
                  </div>

                <div class="my-4 text-center col-md-12">
                  <button id="btn" type="submit" class="btn btn-primary">REGISTRAR</button>
                </div>
                <div class="mb-4 text-center col-md-12">
                  <a class="btn" href="<?= base_url('/') ?>">VOLVER</a>
                </div>
              </form>
            </div>
            <div class="text-center small">
              <p>
                <?= date('Y') ?> Subdirección de Educación Superior de Formación Profesional
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
    //evitar registros dobles
    document.getElementById("frml").addEventListener('submit', function a(){
      $("btn").prop("disabled", true);
    });    
  </script>
  <script src="<?= base_url('public/assets/js/feather-icons/feather.min.js') ?>"></script>
  <script src="<?= base_url('public/assets/js/app.js') ?>"></script>
  <script src="<?= base_url('public/assets/js/main.js') ?>"></script>
    <script src="<?= base_url() ?>/public/assets/fontawesome/js/all.js"></script>
</body>
</html>