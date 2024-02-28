<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?=base_url()?>/assets/img/favicon.png">
  <title>
    Portal New
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url()?>/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?=base_url()?>/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="<?=base_url()?>/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?=base_url()?>/assets/css/argon-dashboard.css?v=2.0.0" rel="stylesheet" />
  <style>
    .alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    }

    .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
    }

    .closebtn:hover {
    color: black;
    }
    </style>
</head>

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">
                  <h4 class="font-weight-bolder">Sign In</h4>
                  
                  <?php
                  if($this->session->flashdata('mesg') == "true") {
                  ?>
                  <div class="alert">
                      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                      <strong>Login Gagal</strong><br> - Username atau Password salah ! <br> - Silahkan Hubungi TL untuk Pembukaan Akses Aplikasi !
                  </div>
                  <?php
                  }
                  else {
                  ?>
                  <p class="mb-0">Enter your username and password to sign in</p>
                  <?php
                  }
                  ?>
                </div>
                <div class="card-body">
                  <form method="post" action="<?=site_url('/login/cekLogin')?>" role="form">
                    <div class="mb-3">
                      <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" aria-label="username">
                    </div>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-lg btn-danger btn-lg w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-danger h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('<?=base_url('/assets/img/5686371.jpg')?>');background-size: cover;">
                <span class="mask bg-gradient-danger opacity-6"></span>
                <h4 class="mt-5 text-white font-weight-bolder position-relative">Portal CC Infomedia Malang</h4>
                <!-- <p class="text-white position-relative">Aplikasi terkait Pembinaan, Rooster, Denah, Berita dan Performansi Pegawai.</p> -->

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="<?=base_url()?>/assets/js/core/popper.min.js"></script>
  <script src="<?=base_url()?>/assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url()?>/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?=base_url()?>/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url()?>/assets/js/argon-dashboard.min.js?v=2.0.0"></script>
</body>

</html>