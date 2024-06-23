<!-- main -->
<div class="main-content container-fluid">
  <section class="section">
    <!-- tabla -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card p-3">
          <div class="card-header">
            <div class="row">
              <div class="col-md-8 my-auto0">
                <h4 class="card-title text-dark">LISTA DE USUARIOS</h4>
              </div>
              <div class="col-md-4 my-auto0">
                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#nuevo">NUEVO USUARIO</button>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-0">
            <div class="table-responsive m-4">
              <table class='table mb-0' id="tabla" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th class="text-center">Img.</th>
                    <th>Nombre y CI</th>
                    <th>Celular y Tiempo</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Asistencia</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($usuario as $dato): ?>
                    <tr>
                      <td class="text-center">
                        <img src="<?= base_url('public/foto/'.$dato['usu_foto']) ?>" width="40" class="border rounded border-dark">
                      </td>
                      <td>
                        <p class="mb-0"><?= $dato['usu_nombre'].' '.$dato['usu_ap_paterno'].' '.$dato['usu_ap_materno'] ?></p>
                        <p class="text-secondary mb-0"><?= $dato['usu_ci'].' '.$dato['usu_exp'] ?></p>
                      </td>
                      <td>
                        <p class="mb-0"><?= $dato['usu_celular'] ?></p>
                        <p class="text-secondary mb-0"><?php switch($dato['usu_tiempo']) {
                          case '1':
                          echo 'MEDIO TIEMPO';
                          break;
                          case '2':
                          echo 'TIEMPO COMPLETO';
                          break;
                        } ?></p>
                      </td>
                      <td class="text-center">
                        <?php if ($dato['usu_estado'] == '1'): ?>
                          <a href="<?= base_url('acc-usu?u='.base64_encode($dato['usu_id']).'&e='.$dato['usu_estado']) ?>" title="ACCESO"><span class="badge bg-success text-white" style="font-size: 70%;">HABILITADO</span></a>
                        <?php else: ?>
                          <a href="<?= base_url('acc-usu?u='.base64_encode($dato['usu_id']).'&e='.$dato['usu_estado']) ?>" title="ACCESO"><span class="badge bg-danger text-white" style="font-size: 70%;">BLOQUEADO</span></a>
                        <?php endif ?>
                      </td>
                      <td class="text-center">
                        <a href="<?= base_url('asi-usu?u='.base64_encode($dato['usu_id'])) ?>" class="btn btn-primary px-2 py-1">ASISTENCIA</a>
                      </td>
                      <td class="text-center">
                        <a href="<?= base_url() ?>/reporte/credencial.php?u=<?= base64_encode($dato['usu_id']) ?>" class="btn btn-outline-dark px-2" target="_blank"><i class="fa-solid fa-id-card"></i></a>
                        <button onclick="informacion(<?= $dato['usu_id'] ?>)" class="btn btn-outline-primary px-2"><i class="fa-solid fa-circle-info"></i></button>
                        <button onclick="editar(<?= $dato['usu_id'] ?>)" class="btn btn-outline-warning px-2"><i class="fa-solid fa-pen-clip"></i></button>
                        <button onclick="eliminar(<?= $dato['usu_id'] ?>)" class="btn btn-outline-danger px-2"><i class="fa-regular fa-trash-can"></i></button>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- fin main -->

<!-- modal -->
  <!-- nuevo -->
    <div class="modal fade" id="nuevo" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <form id="frml" action="<?= base_url('new-usu') ?>" method="post" enctype="multipart/form-data">
            <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">NUEVO USUARIO</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="h4" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ovf">

              <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <!-- foto -->
                    <div class="col-md-12 mb-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fotografía del usuario</font></font></label>
                    </div>
                    <div class="col-md-12">
                      <div class="w-100 text-center mb-5">
                        <input id="imgInp" name="foto" class="fichero" type="file" accept=".jpg, .png, .jpeg">
                        <label for="imgInp" class="circle">
                          <img id="blah" src="<?= base_url('public/foto/subiImg.png') ?>" />
                        </label>  
                      </div>
                    </div>
                    <!-- ci -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cédula de identidad</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Cédula de identidad" id="first-name-icon" name="ci" autocomplete="off" pattern=".{5,25}" title="Datos alfanuméricos entre 5 a 25 caracteres"  required>
                          <div class="form-control-icon">
                            <i class="fa-regular fa-id-card"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Expedido:</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="exp">EX.</label>
                        <select class="form-select" id="exp" name="exp" required>
                          <option value="0">QR</option>
                          <option value="LP">La Paz</option>
                          <option value="SC">Santa Cruz</option>
                          <option value="CB">Cochabamba</option>
                          <option value="CH">Chuquisaca</option>
                          <option value="BE">Beni</option>
                          <option value="PT">Pototsí</option>
                          <option value="OR">Oruro</option>
                          <option value="TJ">Tarija</option>
                          <option value="PD">Pando</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    <!-- nombre -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nombre</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Nombre" id="first-name-icon" name="nombre" autocomplete="off" pattern=".{3,300}" title="Datos alfabéticos entre 3 a 300 caracteres" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- apellido paterno -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Apellido paterno</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Apellido paterno" id="first-name-icon" name="ap_pat" pattern=".{3,150}" title="Datos alfabéticos entre 3 a 100 caracteres"  autocomplete="off">
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- apellido materno -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Apellido materno</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Apellido materno" id="first-name-icon" name="ap_mat" pattern=".{3,150}" title="Datos alfabéticos entre 3 a 100 caracteres"  autocomplete="off">
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- celular -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Número celular</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Número celular" id="first-name-icon" name="celular" autocomplete="off" pattern="[0-9]{8}" title="Datos numéricos de 8 dígitos" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-mobile-screen"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                   <!-- institución -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Institución</font></font></label>
                    </div>
                   <div class="col-md-8">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="institucion"><i class="fa-solid fa-university"></i></label>
                        <select class='mi-selector form-select ovf' name='institucion' style="width: 88%;">
                          <option value='0'>Otros...</option>
                          <?php foreach ($institucion as $key => $val): ?>
                            <?php if ($val['ins_id'] != 0): ?>
                              <option value="<?= $val['ins_id'] ?>"><?= ($val['ins_nombre']) ?></option>
                            <?php endif ?>
                          <?php endforeach ?>
                        </select>
                      </div> 
                   </div> 
                    <!-- carrera -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Carrera</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Carrera" id="first-name-icon" name="carrera" autocomplete="off" pattern=".{5,250}" title="Datos alfanuméricos entre 5 a 250 caracteres" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-folder-tree"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- tiempo -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tiempo</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="tiempo"><i class="fa-solid fa-calendar-days"></i></label>
                        <select class="form-select" id="tiempo" name="tiempo" required>
                          <option selected="">Seleccionar...</option>
                          <option value="1">Medio tiempo</option>
                          <option value="2">Tiempo completo</option>
                        </select>
                      </div>
                    </div>
                    <!-- area -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Área</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="area"><i class="fa-solid fa-layer-group"></i></label>
                        <select class="form-select" id="area" name="area" required>
                          <?php if (session('are')!=1): ?>
                            <option selected value="<?= session('are') ?>">.....................</option>
                          <?php else: ?>
                            <?php foreach ($area as $key => $val): ?>
                              <option value="<?= $val['are_id'] ?>"><?= $val['are_nombre'] ?></option>
                            <?php endforeach ?>
                          <?php endif ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              <button id="btn" type="submit" class="btn btn-primary">REGISTRAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <!-- informacion -->
    <div class="modal fade" id="info" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="cont_info">

        </div>
      </div>
    </div>
  <!-- editar -->
    <div class="modal fade" id="editar" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" id="cont_editar">

        </div>
      </div>
    </div>
  <!-- eliminar -->
    <div class="modal fade" id="eliminar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="cont_eliminar">

        </div>
      </div>
    </div>
<!-- fin modal -->

<!-- script -->
  <script>
      //evitar registros dobles
        document.getElementById("frml").addEventListener('submit', function a(){
          $("btn").prop("disabled", true);
        });
      //informacion
        function informacion(e){
          var con = document.getElementById('cont_info');

          $.ajax({
            url:"<?= base_url('ajx') ?>",
            method:"POST",
            data:{u:e, act:'get_usu'},
            cache: false,
            dataType:"json",
            success:function(data, status, xhr){
              var app = '';
              if (data[0].usu_ap_paterno != null) { app = data[0].usu_ap_paterno; }
              var apm = '';
              if (data[0].usu_ap_materno != null) { apm = data[0].usu_ap_materno; }
              var tie = '';
              if (data[0].usu_tiempo == 1) { tie = 'MEDIO TIEMPO'; }else{ tie = 'TIEMPO COMPLETO'; }

              var ar = '';
              <?php foreach ($area as $key => $val): ?>
                if (<?= $val['are_id'] ?> == data[0].are_id) {
                  ar = '<?= $val['are_nombre'] ?>';
                }
              <?php endforeach ?>
              var ins = 'OTROS';
              <?php foreach ($institucion as $key => $val): ?>
                if (<?= $val['ins_id'] ?> != 0) {
                  if (<?= $val['ins_id'] ?> == data[0].ins_id) {
                    ins = '<?= $val['ins_nombre'] ?>';
                  }
                }
              <?php endforeach ?>


                
              var exp = '';

              switch(data[0].usu_exp){
                case 'LP': lp = exp = 'LP'; break;
                case 'SC': sc = exp = 'SC'; break;
                case 'CB': cb = exp = 'CB'; break;
                case 'CH': ch = exp = 'CH'; break;
                case 'BE': be = exp = 'BE'; break;
                case 'PT': pt = exp = 'PT'; break;
                case 'OR': or = exp = 'OR'; break;
                case 'TJ': tj = exp = 'TJ'; break;
                case 'PD': pd = exp = 'PD'; break;
              }
                
                //llenar modal
              con.innerHTML = `
                <div class="modal-header">
                  <h6 class="modal-title" id="staticBackdropLabel">INFORMACIÓN DEL USUARIO</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="h4" aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ovf">

                  <div class="row">
                    <div class="col-md-3"><b>Nombre:</b></div>
                    <div class="col-md-9">${data[0].usu_nombre} ${app} ${apm}</div>
                    <div class="col-md-3"><b>Ced. Identidad:</b></div>
                    <div class="col-md-9">${data[0].usu_ci} ${exp}</div>
                    <div class="col-md-3"><b>Celular:</b></div>
                    <div class="col-md-9">${data[0].usu_celular}</div>
                    <div class="col-md-3"><b>Área:</b></div>
                    <div class="col-md-9">${ar}</div>
                    <div class="col-md-3"><b>Institución:</b></div>
                    <div class="col-md-9">${ins}</div>
                    <div class="col-md-3"><b>Carrera:</b></div>
                    <div class="col-md-9">${data[0].usu_carrera}</div>
                    <div class="col-md-3"><b>Tiempo:</b></div>
                    <div class="col-md-9">${tie}</div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">ACEPTAR</button>
                </div>
              </form>
              `;
            },

            error:function(xhr, status, error){
              con.innerHTML = `<form action="<?= base_url('edi-usu') ?>" method="post" enctype="multipart/form-data">
              <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">INFORMACIÓN DEL USUARIO</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="h4" aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body ovf">
              <p>${status}</p>
              ${error}
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              </div>
              </form>`; 
            }
          });
          $('#info').modal('show');
        }
      //editar
        function editar(e){
          var con = document.getElementById('cont_editar');

          $.ajax({
            url:"<?= base_url('ajx') ?>",
            method:"POST",
            data:{u:e, act:'get_usu'},
            cache: false,
            dataType:"json",
            success:function(data, status, xhr){
              var app = '';
              if (data[0].usu_ap_paterno != null) { app = data[0].usu_ap_paterno; }
              var apm = '';
              if (data[0].usu_ap_materno != null) { apm = data[0].usu_ap_materno; }
              var med = '';
              var com = '';
              if (data[0].usu_tiempo == 1) { med = 'selected'; }else{ com = 'selected'; }

              var ar = '';
              <?php foreach ($area as $key => $val): ?>
                if (<?= $val['are_id'] ?> == data[0].are_id) {
                  ar = ar + `
                    <option selected value="<?= $val['are_id'] ?>"><?= $val['are_nombre'] ?></option>
                  `;
                }else{
                  ar = ar + `<option value="<?= $val['are_id'] ?>"><?= $val['are_nombre'] ?></option>`;
                }
                
              <?php endforeach ?>
              var ins = '';
              <?php foreach ($institucion as $key => $val): ?>
                if (<?= $val['ins_id'] ?> != 0) {
                  if (<?= $val['ins_id'] ?> == data[0].ins_id) {
                    ins = ins + `
                      <option selected value="<?= $val['ins_id'] ?>"><?= ($val['ins_nombre']) ?></option>
                    `;
                  }else{
                    ins = ins + `
                      <option value="<?= $val['ins_id'] ?>"><?= ($val['ins_nombre']) ?></option>
                    `;
                  }
                }
              <?php endforeach ?>


                
              var lp = '';
              var sc = '';
              var cb = '';
              var ch = '';
              var be = '';
              var pt = '';
              var or = '';
              var tj = '';
              var pd = '';

              switch(data[0].usu_exp){
                case 'LP': lp = 'selected'; break;
                case 'SC': sc = 'selected'; break;
                case 'CB': cb = 'selected'; break;
                case 'CH': ch = 'selected'; break;
                case 'BE': be = 'selected'; break;
                case 'PT': pt = 'selected'; break;
                case 'OR': or = 'selected'; break;
                case 'TJ': tj = 'selected'; break;
                case 'PD': pd = 'selected'; break;
              }
                
                //llenar modal
              con.innerHTML = `
              <form action="<?= base_url('edi-usu?u=') ?>${data[0].usu_id}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                  <h6 class="modal-title" id="staticBackdropLabel">EDITAR USUARIO</h6>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="h4" aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body ovf">

                  <div class="row">
                    <div class="col-md-6">
                      <div class="row">
                        <!-- foto -->
                        <div class="col-md-12 mb-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fotografía del usuario</font></font></label>
                        </div>
                        <div class="col-md-12">
                          <div class="w-100 text-center mb-5">
                            <input id="imgInp1" name="foto" onchange="fileChoose(event,this)" class="fichero" type="file" accept=".jpg, .png, .jpeg">
                            <label for="imgInp1" class="circle1">
                              <img id="blah1" src="<?= base_url('public/foto') ?>/${data[0].usu_foto}" />
                            </label>  
                          </div>
                        </div>
                        <!-- ci -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cédula de identidad</font></font></label>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group has-icon-left">
                            <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Cédula de identidad" id="first-name-icon" name="ci" autocomplete="off" pattern=".{5,25}" title="Datos alfanuméricos entre 5 a 25 caracteres"  value="${data[0].usu_ci}" required>
                              <div class="form-control-icon">
                                <i class="fa-regular fa-id-card"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Expedido:</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group mb-3">
                            <label class="input-group-text" for="exp">EX.</label>
                            <select class="form-select" id="exp" name="exp" required>
                              <option value="0">QR</option>
                              <option ${lp} value="LP">LP</option>
                              <option ${sc} value="SC">SC</option>
                              <option ${cb} value="CB">CB</option>
                              <option ${ch} value="CH">CH</option>
                              <option ${be} value="BE">BE</option>
                              <option ${pt} value="PT">PT</option>
                              <option ${or} value="OR">OR</option>
                              <option ${tj} value="TJ">TJ</option>
                              <option ${pd} value="PD">PD</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="row">
                        <!-- nombre -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nombre</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group has-icon-left">
                            <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Nombre" id="first-name-icon" name="nombre" autocomplete="off" pattern=".{3,100}" title="Datos alfabéticos entre 3 a 100 caracteres" value="${data[0].usu_nombre}" required>
                              <div class="form-control-icon">
                                <i class="fa-solid fa-signature"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- apellido paterno -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Apellido paterno</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group has-icon-left">
                            <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Apellido paterno" id="first-name-icon" name="ap_pat" pattern=".{3,100}" title="Datos alfabéticos entre 3 a 100 caracteres"  autocomplete="off" value="${app}">
                              <div class="form-control-icon">
                                <i class="fa-solid fa-signature"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- apellido materno -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Apellido materno</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group has-icon-left">
                            <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Apellido materno" id="first-name-icon" name="ap_mat" pattern=".{3,100}" title="Datos alfabéticos entre 3 a 100 caracteres"  autocomplete="off" value="${apm}">
                              <div class="form-control-icon">
                                <i class="fa-solid fa-signature"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- celular -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Número celular</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group has-icon-left">
                            <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Número celular" id="first-name-icon" name="celular" autocomplete="off" pattern="[0-9]{8}" title="Datos numéricos de 8 dígitos" value="${data[0].usu_celular}" required>
                              <div class="form-control-icon">
                                <i class="fa-solid fa-mobile-screen"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- institución -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Institución</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group mb-3">
                            <label class="input-group-text" for="institucion"><i class="fa-solid fa-university"></i></label>
                            <select class='mi-selector form-select ' name='institucion' style="width: 88%;">
                              <option value='0'>Otros...</option>
                              ${ins}
                            </select>
                          </div> 
                        </div> 
                        <!-- carrera -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Carrera</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group has-icon-left">
                            <div class="position-relative">
                              <input type="text" class="form-control" placeholder="Carrera" id="first-name-icon" name="carrera" autocomplete="off" pattern=".{5,250}" title="Datos alfanuméricos entre 5 a 250 caracteres" value="${data[0].usu_carrera}" required>
                              <div class="form-control-icon">
                                <i class="fa-solid fa-folder-tree"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tiempo</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group mb-3">
                            <label class="input-group-text" for="tiempo"><i class="fa-solid fa-calendar-days"></i></label>
                            <select class="form-select" id="tiempo" name="tiempo">
                              <option selected="">Seleccionar...</option>
                              <option value="1" ${med}>Medio tiempo</option>
                              <option value="2" ${com}>Tiempo completo</option>
                            </select>
                          </div>
                        </div>

                        <!-- area -->
                        <div class="col-md-4">
                          <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Área</font></font></label>
                        </div>
                        <div class="col-md-8">
                          <div class="input-group mb-3">
                            <label class="input-group-text" for="area"><i class="fa-solid fa-layer-group"></i></label>
                            <select class="form-select" id="area" name="area" required>
                              <?php if (session('are')!=1): ?>
                                <option selected value="<?= session('are') ?>">.....................</option>
                              <?php else: ?>
                                ${ar}
                              <?php endif ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                  <button type="submit" class="btn btn-primary">EDITAR</button>
                </div>
              </form>
              `;
            },

            error:function(xhr, status, error){
              con.innerHTML = `<form action="<?= base_url('edi-usu') ?>" method="post" enctype="multipart/form-data">
              <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">EDITAR USUARIO</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="h4" aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body ovf">
              <p>${status}</p>
              ${error}
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              </div>
              </form>`; 
            }
          });

            //mostrar modal
            $('.mi-selector').select2();
          $('#editar').modal('show');
        }
      //eliminar
        function eliminar(e){
          var con = document.getElementById('cont_eliminar');

          $.ajax({
            url:"<?= base_url('ajx') ?>",
            method:"POST",
            data:{u:e, act:'get_usu'},
            cache: false,
            dataType:"json",
            success:function(data, status, xhr){
              var id = data[0].usu_id;
              id = btoa(id);
              var app = '';
              if (data[0].usu_ap_paterno != null) { app = data[0].usu_ap_paterno; }
              var apm = '';
              if (data[0].usu_ap_materno != null) { apm = data[0].usu_ap_materno; }
                  //llenar modal
              con.innerHTML = `
              <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">ELIMINAR USUARIO</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="h4" aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body ovf">

              <div class="row">
              <!-- nombre -->
              <div class="col-md-12">
              <p>¿Esta seguro de eliminar este usuario?</p>
              <p>${data[0].usu_nombre} ${app} ${apm}</p>
              </div>
              </div>

              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              <a type="submit" class="btn btn-primary" href="<?= base_url('eli-usu?u=') ?>${id}">ELIMINAR</a>
              </div>
              `;
            },

            error:function(xhr, status, error){
              con.innerHTML = `
              <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">EDITAR USUARIO</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="h4" aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body ovf">
              <p>${status}</p>
              ${error}
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              </div>`; 
            }
          });

            //mostrar modal
          $('#eliminar').modal('show');
        }
      //filtro select
        jQuery(document).ready(function($){
          $(document).ready(function() {
            $('.mi-selector').select2();
          });
        });
      //foto
        function readImage (input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result); // Renderizamos la imagen
            }
            reader.readAsDataURL(input.files[0]);
          }
        }

        $("#imgInp").change(function () {
          // Código a ejecutar cuando se detecta un cambio de archivO
          readImage(this);
        });
        //editar img
        function fileChoose(event, element) {
          var img = document.getElementById('blah1');
          if (event.target.files.length > 0) {
            var ruta = URL.createObjectURL(event.target.files[0]);
            img.setAttribute('src', ruta);
          }
        }
      //table
        $(document).ready(function() {
          $('#tabla').DataTable({
            ordering: false
          });
        });
  </script>
<!-- fin de script -->