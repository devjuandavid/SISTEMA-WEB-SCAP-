<?php $col = ["#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464"]; ?>
<!-- main -->
<div class="main-content container-fluid">
  <div class="page-title">
    <h4 class="mb-4">PANEL PRINCIPAL</h4>
  </div>
  <section class="section">
    <!-- tabla -->
    <div class="row mb-4">
      <!-- podio tarde -->
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_man[0]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_man[0]['usu_nombre'].' '.$pod_man[0]['usu_ap_paterno'].' '.$pod_man[0]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_man[0]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_man[0]['can_hor'] ?> de <span id="p0"></span> días<br>
                      <b>Turno: </b>Mañana
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b0">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p0 = document.getElementById('p0');
                      var b0 = document.getElementById('b0');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_man[0]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p0.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_man[0]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b0.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_man[1]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_man[1]['usu_nombre'].' '.$pod_man[1]['usu_ap_paterno'].' '.$pod_man[1]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_man[1]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_man[1]['can_hor'] ?> de <span id="p1"></span> días<br>
                      <b>Turno: </b>Mañana
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b1">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p1 = document.getElementById('p1');
                      var b1 = document.getElementById('b1');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_man[1]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p1.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_man[1]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b1.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_man[2]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_man[2]['usu_nombre'].' '.$pod_man[2]['usu_ap_paterno'].' '.$pod_man[2]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_man[2]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_man[2]['can_hor'] ?> de <span id="p2"></span> días<br>
                      <b>Turno: </b>Mañana
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b2">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p2 = document.getElementById('p2');
                      var b2 = document.getElementById('b2');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_man[2]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p2.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_man[2]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b2.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_man[3]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_man[3]['usu_nombre'].' '.$pod_man[3]['usu_ap_paterno'].' '.$pod_man[3]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_man[3]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_man[3]['can_hor'] ?> de <span id="p3"></span> días<br>
                      <b>Turno: </b>Mañana
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b3">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p3 = document.getElementById('p3');
                      var b3 = document.getElementById('b3');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_man[3]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p3.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_man[3]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b3.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- podio tarde -->
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_tar[0]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_tar[0]['usu_nombre'].' '.$pod_tar[0]['usu_ap_paterno'].' '.$pod_tar[0]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_tar[0]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_tar[0]['can_hor'] ?> de <span id="p5"></span> días<br>
                      <b>Turno: </b>Tarde
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b5">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p5 = document.getElementById('p5');
                      var b5 = document.getElementById('b5');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_tar[0]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p5.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_tar[0]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b5.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_tar[1]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_tar[1]['usu_nombre'].' '.$pod_tar[1]['usu_ap_paterno'].' '.$pod_tar[1]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_tar[1]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_tar[1]['can_hor'] ?> de <span id="p6"></span> días<br>
                      <b>Turno: </b>Tarde
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b6">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p6 = document.getElementById('p6');
                      var b6 = document.getElementById('b6');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_tar[1]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p6.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_tar[1]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b6.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_tar[2]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_tar[2]['usu_nombre'].' '.$pod_tar[2]['usu_ap_paterno'].' '.$pod_tar[2]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_tar[2]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_tar[2]['can_hor'] ?> de <span id="p7"></span> días<br>
                      <b>Turno: </b>Tarde
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b7">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p7 = document.getElementById('p7');
                      var b7 = document.getElementById('b7');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_tar[2]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p7.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_tar[2]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b7.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 col-12">
          <div class="card">
            <div class="card-content">
              <div class="row no-gutters">
                <div class="col-md-12 col-lg-3" style="background-size: cover;">
                  <img src="<?= base_url() ?>/public//foto/<?= $pod_tar[3]['usu_foto'] ?>" alt="element 01" class="h-100 w-100 rounded-left">
                </div>
                <div class="col-md-12 col-lg-9">
                  <div class="card-body p-1">
                    <p class="card-text text-ellipsis small">
                      <b>Nombre: </b><?= ucwords(mb_strtolower($pod_tar[3]['usu_nombre'].' '.$pod_tar[3]['usu_ap_paterno'].' '.$pod_tar[3]['usu_ap_materno'])) ?><br>
                      <b>Área: </b><?= ucwords(mb_strtolower($pod_tar[3]['are_nombre'])) ?><br>
                      <b>Asistencias puntuales: </b><?= $pod_tar[3]['can_hor'] ?> de <span id="p8"></span> días<br>
                      <b>Turno: </b>Tarde
                    </p>
                    <p class="pb-0">
                      <div class="progress progress-dark" id="b8">
                      </div>
                    </p>
                    <!-- script -->
                    <script>
                      var p8 = document.getElementById('p8');
                      var b8 = document.getElementById('b8');
                      $.ajax({
                        url:"<?= base_url('ajx') ?>",
                        method:"POST",
                        data:{u:<?= $pod_tar[3]['usu_id'] ?>, act:'get_pod'},
                        cache: false,
                        dataType:"json",
                        success:function(data, status, xhr){
                              //llenar modal
                          p8.innerHTML = `${Math.round(data[0].can_dia)}`;
                          var dt = (<?= $pod_tar[3]['can_hor'] ?> * 100) / Math.round(data[0].can_dia);
                          b8.innerHTML = `<div class="progress-bar" role="progressbar" style="width: ${dt}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>`;
                        },

                        error:function(xhr, status, error){
                          con.innerHTML = ``; 
                        }
                      });
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- por areas -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-heading p-1 pl-3">Distribución por Áreas</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4 col-12">
                  <div class="pl-3">
                    <h2 class="mt-5"><?= $dat_are[0]['can'] ?> Pasantias</h2>
                    <p class="text-xs">
                      <span class="text-green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                          <line x1="12" y1="20" x2="12" y2="10"></line>
                          <line x1="18" y1="20" x2="18" y2="4"></line>
                          <line x1="6" y1="20" x2="6" y2="16"></line>
                        </svg> 
                      </span> <?= $dat_are[0]['are_nombre'] ?>
                    </p>
                    <div class="legends">
                      <?php foreach ($area as $key => $val): ?>
                        <div class="legend d-flex flex-row align-items-center">
                          <div class="w-3 h-3 rounded-full  mr-2" style="background-color: <?= $col[$key] ?>;"></div><span class="text-xs"><?= ucwords(mb_strtolower($val['are_nombre'])) ?></span>
                        </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                </div>
                <div class="col-md-8 col-12">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                      <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                      <div class=""></div>
                    </div>
                  </div>
                  <canvas id="gra_are" style="display: block; height: 128px; width: 257px;" width="321" height="160" class="chartjs-render-monitor"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      <!-- por institucion -->
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-heading p-1 pl-3">Distribución por Institución</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-10">
                  <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                      <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                      <div class=""></div>
                    </div>
                  </div>
                  <canvas id="gra_ins" style="display: block; max-width: 100%;" class="chartjs-render-monitor"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</section>
</div>
<!-- fin main -->

<!-- script -->
  <script>
    //grafico area
      var ctxBarAre = document.getElementById("gra_are").getContext("2d");
      var myBarAre = new Chart(ctxBarAre, {
          type: 'bar',
          data: {
              labels: [
                <?php foreach ($area as $key => $val): ?>
                  '.',
                <?php endforeach ?>
                ],
              datasets: [{
                  label: 'Students',
                  backgroundColor: ["#1f5f8f",
                    "#9f463e",
                    "#daf7a6",
                    "#fcce3a",
                    "#6d6cc2",
                    "#fe6b4c",
                    "#d13a65",
                    "#479b79",
                    "#5fc755",
                    "#937764",
                    "#b96b36",
                    "#6dcacb",
                    "#cdb363",
                    "#b6e464",],
                  data: [
                <?php foreach ($area as $key => $val): ?>
                  <?= $val['can']-1 ?>,
                <?php endforeach ?>
                  ]
              }]
          },
          options: {
              responsive: true,
              barRoundness: 1,
              title: {
                  display: true,
                  text: "Pasantes registrados"
              },
              legend: {
                  display: false
              },
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero: true,
                          padding: 10,
                      },
                      gridLines: {
                          drawBorder: false,
                      }
                  }],
                  xAxes: [{
                      gridLines: {
                          display: false,
                          drawBorder: false
                      }
                  }]
              }
          }
      });
    //grafico dona
      var ctxBarIns = document.getElementById("gra_ins").getContext("2d");
      var colo = ["#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464","#1f5f8f","#9f463e","#daf7a6","#fcce3a","#6d6cc2","#fe6b4c","#d13a65","#479b79","#5fc755","#937764","#b96b36","#6dcacb","#cdb363","#b6e464"];
      var myBarIns = new Chart(ctxBarIns, {
          type: 'doughnut',
          data: {
              labels: [
                <?php foreach ($institucion as $key => $val): ?>
                  '<?= $val['ins_nombre'] ?>',
                <?php endforeach ?>
                ],
              datasets: [{
                  label: 'Students',
                  backgroundColor: colo,
                  data: [
                    <?php foreach ($institucion as $key => $val): ?>
                      <?= $val['can'] ?>,
                    <?php endforeach ?>
                  ]
              }]
          },
          options: {
              responsive: true,
              title: {
                  display: true,
                  text: "Pasantes registrados"
              },
              legend: {
                  display: true,
                  position: 'right',
                  labels: {
                    fontSize: 9
                  }
              }
          }
      });

    //datatable
    $(document).ready(function() {
      $('#tabla').DataTable({
        ordering: false
      });
    });
  </script>
<!-- fin de script -->