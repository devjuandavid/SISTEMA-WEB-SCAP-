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
                <h4 class="card-title text-dark">INSTITUCIÓN </h4>
              </div>
              <div class="col-md-4 my-auto0">
                <button class="btn btn-primary w-100" data-toggle="modal" data-target="#nuevo">NUEVA INSTITUCIÓN</button>
              </div>
            </div>
          </div>
          <div class="card-body px-0 pb-0">
            <div class="table-responsive m-4">
              <table class='table mb-0' id="tabla" style="font-size: 13px;">
                <thead>
                  <tr>
                    <th>Institución</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($institucion as $dato): ?>
                    <tr>
                      <td>
                        <p class="mb-0"><?= $dato['ins_nombre'] ?></p>
                      </td>
                      <td><?php switch($dato['ins_estado']) {
                          case '0':
                            echo '<span class="badge badge-danger bg-danger">Bloqueado</span>';
                          break;
                          case '1':
                            echo '<span class="badge badge-success bg-success">Habilitado</span>';
                          break;
                        } ?>
                      </td>
                      <td class="text-center">
                        <button onclick="editar(<?= $dato['ins_id'] ?>)" class="btn btn-outline-warning px-2"><i class="fa-solid fa-pen-clip"></i></button>
                        <button onclick="eliminar(<?= $dato['ins_id'] ?>)" class="btn btn-outline-danger px-2"><i class="fa-regular fa-trash-can"></i></button>
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
          <form id="frml" action="<?= base_url('new-ins') ?>" method="post">
            <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">NUEVA INSTITUCIÓN</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="h4" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ovf">

              <div class="row">
                <!-- nombre -->
                  <div class="col-md-4">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nombre de Institución</font></font></label>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group has-icon-left">
                      <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Nombre" id="first-name-icon" name="nombre" autocomplete="off" pattern=".{3,500}" title="Datos alfabéticos entre 3 a 500 caracteres" required>
                        <div class="form-control-icon">
                          <i class="fa-solid fa-signature"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                <!-- seleccionar estado -->
                  <div class="col-md-4">
                    <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Estado</font></font></label>
                  </div>
                  <div class="col-md-8">
                    <div class="input-group mb-3">
                      <label class="input-group-text" for="estado"><i class="fa-solid fa-check"></i></label>
                      <select class="form-select" id="estado" name="estado" required>
                        <option selected="">Seleccionar...</option>
                        <option value="1">Habilitado</option>
                        <option value="0">Bloqueado</option>
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
        data:{i:e, act:'get_ins'},
        cache: false,
        dataType:"json",
        success:function(data, status, xhr){
          var hab = '';
          var blo = '';
          if (data[0].ins_estado == 1) { hab = 'selected'; }else{ blo = 'selected'; }
            //llenar modal
          con.innerHTML = `
          <form id="frml" action="<?= base_url('edi-ins?i=') ?>${data[0].ins_id}" method="post">
              <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel">EDITAR INSTITUCIÓN</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span class="h4" aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body ovf">

                <div class="row">
                  <!-- nombre -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nombre de Institución</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="text" class="form-control" placeholder="Nombre" id="first-name-icon" name="nombre" autocomplete="off" pattern=".{3,250}" title="Datos alfabéticos entre 3 a 500 caracteres" value='${data[0].ins_nombre}' required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- seleccionar estado -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Estado</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="input-group mb-3">
                        <label class="input-group-text" for="estado"><i class="fa-solid fa-check"></i></label>
                        <select class="form-select" id="estado" name="estado" required>
                          <option selected="">Seleccionar...</option>
                          <option value="1" ${hab}>Habilitado</option>
                          <option value="0" ${blo}>Bloqueado</option>
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
        data:{i:e, act:'get_ins'},
        cache: false,
        dataType:"json",
        success:function(data, status, xhr){
          var id = data[0].ins_id;
          id = btoa(id);
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
                <p>¿Esta seguro de eliminar esta INSTITUCIÓN?</p>
                <p>${data[0].ins_nombre} </p>
              </div>
          </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
            <a type="submit" class="btn btn-primary" href='<?= base_url('eli-ins?a=') ?>${id}'>ELIMINAR</a>
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