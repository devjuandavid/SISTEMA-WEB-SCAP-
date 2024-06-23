            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>© 2023 DIRECCIÓN DEPARTAMENTAL DE EDUCACIÓN LA PAZ</p>
                    </div>
                    <div class="float-right">
                        <p>Desarrollado <span class='text-danger'><i data-feather="heart"></i></span> por <a href="https://www.facebook.com/miguelangel.quispevila.98/" target="_blank"> M.A.Q.V.</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

  
    <div class="modal fade" id="contra" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <form id="frml" action="<?= base_url('cam-cla') ?>" method="post">
            <div class="modal-header">
              <h6 class="modal-title" id="staticBackdropLabel">MODIFICAR CONTRASEÑA</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="h4" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body ovf">

              <div class="row">
                <!-- nombre -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Contraseña actual</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="password" class="form-control" id="first-name-icon" name="cla_act" autocomplete="off" placeholder="**********" minlength="3" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                <!-- clave nueva -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Contraseña nueva</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="password" class="form-control" id="first-name-icon" name="cla_nue" autocomplete="off" placeholder="**********" minlength="3" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                <!-- clave nueva repetir -->
                    <div class="col-md-4">
                      <label><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Repite la contraseña nueva</font></font></label>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group has-icon-left">
                        <div class="position-relative">
                          <input type="password" class="form-control" id="first-name-icon" name="cla_rep" autocomplete="off" placeholder="**********" minlength="3" required>
                          <div class="form-control-icon">
                            <i class="fa-solid fa-signature"></i>
                          </div>
                        </div>
                      </div>
                    </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCELAR</button>
              <button id="btn" type="submit" class="btn btn-primary">MODIFICAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="<?= base_url() ?>/public/assets/js/feather-icons/feather.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= base_url() ?>/public/assets/js/app.js"></script>
    <script src="<?= base_url() ?>/public/assets/fontawesome/js/all.js"></script>
    
    <script src="<?= base_url() ?>/public/assets/vendors/apexcharts/apexcharts.min.js"></script>
    <!--<script src="<?= base_url() ?>/public/assets/js/pages/dashboard.js"></script>-->

    <script src="<?= base_url() ?>/public/assets/js/main.js"></script>
    <!-- Datatable -->
    <script src="<?= base_url() ?>/public/assets/datatable/datatables.js"></script>
</body>
</html>