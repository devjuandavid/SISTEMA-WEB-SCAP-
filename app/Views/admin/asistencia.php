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
                <h4 class="card-title text-dark">ASISTENCIA </h4>
                <p class="mt-4">
                  <a href="<?= base_url('/reporte/reporte.php?u='.base64_encode($usuario[0]['usu_ci'])) ?>" class="btn btn-outline-danger px-2" target="_blank" title="GENERAR ASISTENCIA PDF"><i class="fa fa-file-pdf"></i> DESCARGAR</a>
                  <a href="<?= base_url('/excel/genReporte.php?u='.base64_encode($usuario[0]['usu_ci'])) ?>" class="btn btn-outline-success px-2" title="GENERAR ASISTENCIA EXCEL"><i class="fa fa-file-excel"></i> DESCARGAR</a>
                </p>
              </div>
              <div class="col-md-4 my-auto">
                <a href="<?= base_url('usuario') ?>" class="btn btn-outline-primary w-100 mb-3">VOLVER</a>
                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#nuevo">NUEVA ASISTENCIA</button>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-0">
            <div class="table-responsive m-4">
              <table class='table mb-0' id="tabla" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>Fecha y Hora Ingreso</th>
                    <th>Hora Ingreso</th>
                    <th>Tipo</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($asistencia as $val => $dato): ?>
                    <tr>
                      <td>
                        <p class="mb-0"><?= $dato['asi_fecha'] ?></p>
                      </td>
                      <td>
                        <p class="text-secondary"><?= $dato['asi_hora'] ?></p>
                      </td>
                      <td><?php switch($dato['asi_tipo']) {
                          case '2':
                            echo '<span class="badge badge-danger bg-danger">Salida</span>';
                          break;
                          case '1':
                            echo '<span class="badge badge-success bg-success">Ingreso</span>';
                          break;
                        } ?>
                      </td>
                      <td class="text-center">
                        <button onclick="editar(<?= $dato['asi_id'] ?>)" class="btn btn-outline-warning px-2"><i class="fa-solid fa-pen-clip"></i></button>
                        <button onclick="eliminar(<?= $dato['asi_id'] ?>)" class="btn btn-outline-danger px-2"><i class="fa-regular fa-trash-can"></i></button>
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
    <div class="modal fade" id="nuevo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form id="frml" action="<?= base_url('new-asi?u='.$_GET['u']) ?>" method="post">
            <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">NUEVO REGISTRO</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="h4" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ovf">

              <div class="row">
                <!-- fecha -->
                  <div class="col-md-4">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha</font></font></label>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group has-icon-left">
                      <div class="position-relative">
                        <input type="date" class="form-control" name="fecha" autocomplete="off" value="<?= date('Y-m-d') ?>" required>
                        <div class="form-control-icon">
                          <i class="fa-solid fa-signature"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- hora -->
                  <div class="col-md-4">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Hora</font></font></label>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group has-icon-left">
                      <div class="position-relative">
                        <input type="time" class="form-control" name="hora" autocomplete="off" value="<?= date('H:i') ?>" required>
                        <div class="form-control-icon">
                          <i class="fa-solid fa-signature"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- seleccionar estado -->
                  <div class="col-md-4">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tipo</font></font></label>
                  </div>
                  <div class="col-md-8">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="tipo"><i class="fa-solid fa-check"></i></label>
                      <select class="form-select" id="tipo" name="tipo" required>
                        <option value="">Seleccionar...</option>
                        <option value="1">Ingreso</option>
                        <option value="2">Salida</option>
                      </select>
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
  <!-- editar -->
    <div class="modal fade" id="editar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
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
  //editar
    function editar(e){
      var con = document.getElementById('cont_editar');

      $.ajax({
        url:"<?= base_url('ajx') ?>",
        method:"POST",
        data:{as:e, act:'get_asi'},
        cache: false,
        dataType:"json",
        success:function(data, status, xhr){
          var ing = '';
          var sal = '';
          if (data[0].asi_tipo == '1') {
            ing = 'selected';
          }else{
            sal = 'selected';
          }

            //llenar modal
          con.innerHTML = `
          <form id="frml" action="<?= base_url('edi-asi?as=') ?>${data[0].asi_id}" method="post">
              <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">EDITAR INSTITUCIÓN</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span class="h4" aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body ovf">

                <div class="row">
                  <!-- fecha -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Fecha</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="date" class="form-control" name="fecha" autocomplete="off" value="${data[0].asi_fecha}" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- hora -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Hora</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="time" class="form-control" name="hora" autocomplete="off" value="${data[0].asi_hora}" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- seleccionar estado -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Tipo</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="tipo"><i class="fa-solid fa-check"></i></label>
                        <select class="form-select" id="tipo" name="tipo" required>
                          <option value="">Seleccionar...</option>
                          <option value="1" ${ing}>Ingreso</option>
                          <option value="2" ${sal}>Salida</option>
                        </select>
                      </div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
                <button id="btn" type="submit" class="btn btn-primary">REGISTRAR</button>
              </div>
            </form>
          `;
        },

        error:function(xhr, status, error){
          con.innerHTML = `<form action="<?= base_url('edi-usu') ?>" method="post" enctype="multipart/form-data">
          <div class="modal-header">
          <h6 class="modal-title" id="staticBackdropLabel">EDITAR DATO</h6>
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
  $('#editar').modal('show');
    }
  //eliminar
    function eliminar(e){
      var con = document.getElementById('cont_eliminar');

      $.ajax({
        url:"<?= base_url('ajx') ?>",
        method:"POST",
        data:{as:e, act:'get_asi'},
        cache: false,
        dataType:"json",
        success:function(data, status, xhr){
          var id = data[0].asi_id;
          id = btoa(id);

          var tip = '';
          if (data[0].asi_tipo == '1') {
            tip = 'Ingreso';
          }else{
            tip = 'Salida';
          }
              //llenar modal
          con.innerHTML = `
          <div class="modal-header">
            <h6 class="modal-title" id="staticBackdropLabel">ELIMINAR INSTITUCIÓN</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="h4" aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body ovf">

          <div class="row">
            <!-- nombre -->
              <div class="col-md-12">
                <p>¿Esta seguro de eliminar este registro?</p>
                <p class="mb-0"><b>Fecha: </b>${data[0].asi_fecha} </p>
                <p class="mb-0"><b>Hora: </b>${data[0].asi_hora} </p>
                <p class="mb-0"><b>Tipo: </b>${tip} </p>
              </div>
          </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
            <a type="submit" class="btn btn-primary" href='<?= base_url('eli-asi?as=') ?>${id}'>ELIMINAR</a>
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
  //table
    $(document).ready(function() {
      $('#tabla').DataTable({
        ordering: false
      });
    });
</script>
<!-- fin de script -->