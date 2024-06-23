<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SCAP</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico'); ?>">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendors/chartjs/Chart.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url() ?>/public/assets/fontawesome/css/all.css">
    <!-- Datatable -->
    <link href="<?= base_url() ?>/public/assets/datatable/datatables.min.css" rel="stylesheet" />
    <!-- JQuery -->
    <script src="<?= base_url() ?>/public/assets/js/jquery-3.6.0.js"></script>
    <!-- mensaje -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script src="<?= base_url() ?>/public/assets/vendors/chartjs/Chart.min.js"></script>
    <!-- select -->
    <link href="<?= base_url() ?>/public/assets/css/select2.css" rel="stylesheet"/>
    <script src="<?= base_url() ?>/public/assets/js/select2.min.js"></script>
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
    <div id="app">
        <div id="sidebar" class='active'>
          <div class="sidebar-wrapper active">
            <div class="sidebar-header pb-0 text-center">
                <img src="<?= base_url() ?>/public/assets/images/logo_scap.png" >
            </div>
            <div class="sidebar-menu ">
              <ul class="menu">
                <li class='sidebar-title'>Menú</li>
                <li class="sidebar-item <?= $pag == 'pri' ? 'active' : '' ?>">
                  <a href="<?= base_url('panel') ?>" class='sidebar-link'>
                    <i data-feather="home" width="20"></i> 
                    <span>Panel principal</span>
                  </a>
                </li>
                <li class="sidebar-item <?= $pag == 'usu' ? 'active' : '' ?>">
                  <a href="<?= base_url('usuario') ?>" class='sidebar-link'>
                    <i data-feather="user" width="20"></i> 
                    <span>Usuarios</span>
                  </a>
                </li>
                <?php if (session('tipo') == '1'): ?>
                  <li class="sidebar-item <?= $pag == 'are' ? 'active' : '' ?>">
                    <a href="<?= base_url('area') ?>" class='sidebar-link'>
                      <i data-feather="book" width="20"></i> 
                      <span>Áreas</span>
                    </a>
                  </li>
                  <!-- Institución -->
                  <li class="sidebar-item <?= $pag == 'ins' ? 'active' : '' ?>">
                    <a href="<?= base_url('institucion') ?>" class='sidebar-link'>
                      <i data-feather="book-open" width="20"></i> 
                      <span>Institución</span>
                    </a>
                  </li>  
                <?php endif ?>
              </ul>
            </div>
            <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
          </div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <img src="<?= base_url() ?>/public/assets/images/ddelpz.png" alt="" srcset="">
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block"><?= session('nombre') ?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" data-toggle="modal" data-target="#contra"><i class="fa-regular fa-user"></i> Cambiar contraseña</button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('salir') ?>"><i data-feather="log-out"></i> Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>