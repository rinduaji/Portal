<!DOCTYPE html>
<html lang="en">
<?php
  if(!isset($_SESSION['nama'])) 
  { 
      redirect(site_url('login/logout')); 
  }
?>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url()?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="<?=base_url()?>assets/img/favicon.png">
  <title>
    Portal New
  </title>
  <!--     Fonts and icons     -->
  
  <link href="<?=base_url()?>assets/plugins/font-awesome/font-awesome.css" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url()?>assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css">
  <!-- Font Awesome Icons -->
  <link href="<?=base_url()?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/coreui/css/coreui.min.css" rel="stylesheet" />
  <link href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?=base_url()?>assets/css/argon-dashboard.css" rel="stylesheet" />
  
  <script src="<?=base_url()?>assets/bootstrap/js/jquery-3.6.0.min.js"></script>
  <script src="<?=base_url()?>assets/js/core/popper.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script> -->
  <script src="<?=base_url()?>assets/plugins/popper/popper.min.js"></script>
  <script src="<?=base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
  <link href="<?=base_url()?>assets/plugins/summernote/summernote.min.css" rel="stylesheet" />
  <script src="<?=base_url()?>assets/plugins/summernote/summernote.min.js"></script>
  <link href="<?=base_url()?>assets/sweetalert2/package/dist/sweetalert2.min.css" rel="stylesheet" />
  <script src="<?=base_url()?>assets/select2/select2.min.js"></script>
  <link href="<?=base_url()?>assets/select2/select2.min.css" rel="stylesheet" />
  
  <style>
  footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    padding: 25px;
  }

  .notification {
  color: white;
  text-decoration: none;
  padding: 15px 26px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}


.notification .badge {
  position: absolute;
  top: -10px;
  right: -20px;
  padding: 5px 5px;
  border-radius: 50%;
  background: black;
  color: white;
}

.nav-link.active .nav-link-text {
    color: #fff !important;
}

.nav-link.active {
    color: #344767;
    background-color: rgba(255, 255, 255, 0.13);
}
  </style>
</head>
<?php
  $jabatan_user = $this->session->userdata('jabatan');
  $jb = explode(" ",$jabatan_user);
  if(isset($jb[1])) {
    $jb_tl = ($jb[0].' '.$jb[1]);
  }
  else {
    $jb_tl = $jb[0];
  }
?>
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main" data-color="danger">
    <div class="sidenav-header">
      <!-- <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i> -->
      <a class="navbar-brand m-0" href="" target="_blank">
        <img src="<?=base_url()?>assets/img/infomedia_logo.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">Portal New</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav flex-column">
      
        <!-- <li class="nav-item">
          <a class="nav-link active" href="<?=site_url('dashboard')?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="VisiMisi") ? 'active' : '')?>" href="<?=site_url('VisiMisi')?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Visi Misi </span>
          </a>
        </li>
        <?php
        if($jb[0] == "TL" || $jb[0] == "DUKTEK") { 
        ?>
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="LinkAplikasi") ? 'active' : '')?>" href="<?=site_url('LinkAplikasi')?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Link Aplikasi</span>
          </a>
        </li>
        <?php
        }
        ?>
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="LinkPansol") ? 'active' : '')?>" href="<?=site_url('LinkPansol')?>">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Panduan Solusi</span>
          </a>
        </li>
        <?php
        if($jb[0] == 'DUKTEK') {
        ?>
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="CreateUser") ? 'active' : '')?>" href="<?=site_url()?>/CreateUser">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-circle-08 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Create User</span>
          </a>
        </li>
        <?php
        }
        ?>
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="Inbox") ? 'active' : '')?> " href="<?=site_url()?>/Inbox">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-envelope-o text-warning text-sm opacity-10" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Inbox</span>
          </a>
        </li>
        <?php
        if($jb[0] == "TL" || $jb[0] == "SUPERVISOR" || $jb[0] == "DUKTEK") { 
        ?>
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="Briefing") ? 'active' : '')?> " href="<?=site_url()?>/Briefing">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-plus text-warning text-sm opacity-10" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Briefing</span>
          </a>
        </li>
        <?php
        }
        ?>
         <?php
        if($jb[0] == "TL" || $jb[0] == "SUPERVISOR" || $jb[0] == "DUKTEK" || 
        $jb[0] == "ADMIN" || $jb[0] == "DOCUMENT" || $jb[0] == "TEAM" || 
        $jb[0] == "TRAINER" || $jb[0] == "Maintenance" || $jb[0] == "LO" || 
        $jb[0] == "SUPPORT" || $jb[0] == "SOO" || $jb[0] == "MANAGER"
        ) { 
        ?>
        <li class="nav-item">
          <a class="nav-link <?=(($this->uri->segment(1)=="RisalahRapat") ? 'active' : '')?> " href="<?=site_url()?>/RisalahRapat">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-bars text-warning text-sm opacity-10" aria-hidden="true"></i>
            </div>
            <span class="nav-link-text ms-1">Risalah Rapat</span>
          </a>
        </li>
        <?php
        }
        ?>
        <!-- <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/login/cekDokumen">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Tables</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/billing.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-credit-card text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Billing</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/virtual-reality.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-app text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Virtual Reality</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../pages/rtl.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-world-2 text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">RTL</span>
          </a>
        </li> -->
        
        <?php 
          // if($jb[0] == "AGENT") {
        ?>
        <!-- <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/DaftarCCM">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List CCM 147</span>
          </a>
        </li> -->
        <?php 
          // }
          // elseif($jb_tl == "TL") { 
        ?>
        <!-- <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/CCM147">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">CCM 147 Entry Data</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/ListCCM">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List yang di CCM</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/DaftarCCM">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List CCM 147</span>
          </a>
        </li> -->
        <?php
          // }
          // elseif($jb[0] == "SUPERVISOR") { 
        ?>
        <!-- <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/CCM147">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">CCM 147 Entry Data</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/ListCCM">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List yang di CCM</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="<?=site_url()?>/DaftarCCM">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">List CCM 147</span>
          </a>
        </li> -->
        <?php
          // }
          // elseif($jb_tl == "TL") { 
        ?>
        <?php
        if($jb[0] == "TL" || $jb[0] == "SUPERVISOR" || $jb[0] == "DUKTEK") { 
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(1)=="ReportCCM") ? 'active' : '')?><?=(($this->uri->segment(1)=="DaftarCCM") ? 'active' : '')?><?=(($this->uri->segment(1)=="ListCCM") ? 'active' : '')?><?=(($this->uri->segment(1)=="CCM147") ? 'active' : '')?>" href="#CCM" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">CCM</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="CCM" data-parent="#left-navigation">
              <a class="nav-item nav-link <?=(($this->uri->segment(1)=="CCM147") ? 'active' : '')?>" href="<?=site_url()?>/CCM147">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CCM 147 Entry Data</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ListCCM") ? 'active' : '')?>" href="<?=site_url()?>/ListCCM">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CCM 147 
                  <?php
                    if($jb[0]=="TL") {
                      echo "AGENT";
                    }
                    else if($jb[0]=="SUPERVISOR") {
                      echo "TL";
                    }
                    else if($jb[0]=="MANAGER") {
                      echo "SUPERVISOR";
                    }
                  ?>
                </span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="DaftarCCM") ? 'active' : '')?>" href="<?=site_url()?>/DaftarCCM">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CCM 147 <?=$jb[0]?></span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ReportCCM") ? 'active' : '')?>" href="<?=site_url()?>/ReportCCM/">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Report CCM 147</span>
              </a>
            </div>
          </li>
        
        <?php
          }
          elseif($jb[0] == "MANAGER") { 
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(1)=="ReportCCM") ? 'active' : '')?><?=(($this->uri->segment(1)=="ListCCM") ? 'active' : '')?><?=(($this->uri->segment(1)=="CCM147") ? 'active' : '')?>" href="#CCM" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">CCM</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="CCM" data-parent="#left-navigation">
              <a class="nav-item nav-link <?=(($this->uri->segment(1)=="CCM147") ? 'active' : '')?>" href="<?=site_url()?>/CCM147">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CCM 147 Entry Data</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ListCCM") ? 'active' : '')?>" href="<?=site_url()?>/ListCCM">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CCM 147 
                  <?php
                    if($jb[0]=="TL") {
                      echo "AGENT";
                    }
                    else if($jb[0]=="SUPERVISOR") {
                      echo "TL";
                    }
                    else if($jb[0]=="MANAGER") {
                      echo "SUPERVISOR";
                    }
                  ?>
                </span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ReportCCM") ? 'active' : '')?>" href="<?=site_url()?>/ReportCCM/">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Report CCM 147</span>
              </a>
            </div>
          </li>
        
        <?php
          }
          elseif($jb[0] == "AGENT" || $jb[0] == "INPUTER"  || $jb[0] == "SUPPORT"  || $jb[0] == "SOO") {
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(1)=="ReportCCM") ? 'active' : '')?><?=(($this->uri->segment(1)=="DaftarCCM") ? 'active' : '')?>" href="#CCM" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">CCM</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="CCM" data-parent="#left-navigation">
              <a class="nav-link <?=(($this->uri->segment(1)=="DaftarCCM") ? 'active' : '')?>" href="<?=site_url()?>/DaftarCCM">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">CCM 147 <?=$jb[0]?></span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ReportCCM") ? 'active' : '')?>" href="<?=site_url()?>/ReportCCM/">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-ruler-pencil text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Report CCM 147</span>
              </a>
            </div>
          </li>
        <?php
          }
        ?>
        
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(1)=="News") ? 'active' : '')?><?=(($this->uri->segment(1)=="ListNews") ? 'active' : '')?>" href="#news" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-album-2 text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Berita</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="news" data-parent="#left-navigation">
              <?php
              if($jb[0] != "AGENT" || $jb[0] != "INPUTER"  || $jb[0] != "SUPPORT HC"  || $jb[0] != "SOO") {
              ?>
              <a class="nav-link <?=(($this->uri->segment(1)=="ListNews") ? 'active' : '')?>" href="<?=site_url()?>/ListNews">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-album-2 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Manage News</span>
              </a>
              <?php
              }
              ?>
              <a class="nav-link <?=(($this->uri->segment(1)=="News") ? 'active' : '')?>" href="<?=site_url()?>/News">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-album-2 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">News</span>
              </a>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(2)=="lt7.htm") ? 'active' : '')?><?=(($this->uri->segment(2)=="lt6.htm") ? 'active' : '')?><?=(($this->uri->segment(2)=="evakuasi7.htm") ? 'active' : '')?><?=(($this->uri->segment(2)=="evakuasi6.htm") ? 'active' : '')?>" href="#denah" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-map-big text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Denah</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="denah" data-parent="#left-navigation">
              <a class="nav-link <?=(($this->uri->segment(2)=="evakuasi6.htm") ? 'active' : '')?>" href="<?=base_url()?>/Evakuasi/evakuasi6.htm" target="_blank">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-map-big text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Denah Evakuasi Lantai 6</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(2)=="evakuasi7.htm") ? 'active' : '')?>" href="<?=base_url()?>/Evakuasi/evakuasi7.htm" target="_blank">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-map-big text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Denah Evakuasi Lantai 7</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(2)=="lt6.htm") ? 'active' : '')?>" href="<?=base_url()?>/Denah6/lt6.htm" target="_blank">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-map-big text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Denah Lantai 6</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(2)=="lt7.htm") ? 'active' : '')?>" href="<?=base_url()?>/Denah7/lt7.htm" target="_blank">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-map-big text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Denah Lantai 7</span>
              </a>
            </div>
          </li>
        
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(1)=="ReportDokumen") ? 'active' : '')?><?=(($this->uri->segment(1)=="Dokumen") ? 'active' : '')?><?=(($this->uri->segment(1)=="DokumenUnit") ? 'active' : '')?><?=(($this->uri->segment(1)=="DokumenItem") ? 'active' : '')?><?=(($this->uri->segment(1)=="DokumenKategori") ? 'active' : '')?>" href="#dc" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-collection text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Dokumen</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="dc" data-parent="#left-navigation">
              <?php
              if($jb[0] == "DUKTEK" || $jb[0] == "DOCUMENT") {
              ?>
              <a class="nav-link <?=(($this->uri->segment(1)=="DokumenKategori") ? 'active' : '')?>" href="<?=site_url()?>/DokumenKategori">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-collection text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dokumen Kategori</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="DokumenItem") ? 'active' : '')?>" href="<?=site_url()?>/DokumenItem">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-collection text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dokumen Item</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="DokumenUnit") ? 'active' : '')?>" href="<?=site_url()?>/DokumenUnit">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-collection text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dokumen Unit</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="Dokumen") ? 'active' : '')?>" href="<?=site_url()?>/Dokumen">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-collection text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Upload Dokumen</span>
              </a>
              <?php
              }
              ?>
              <a class="nav-link <?=(($this->uri->segment(1)=="ReportDokumen") ? 'active' : '')?>" href="<?=site_url()?>/ReportDokumen">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-collection text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Dokumen</span>
              </a>
            </div>
          </li>
        
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle collapsed <?=(($this->uri->segment(1)=="ApproveTkd") ? 'active' : '')?><?=(($this->uri->segment(1)=="FormTkd") ? 'active' : '')?><?=(($this->uri->segment(1)=="ReportRooster") ? 'active' : '')?><?=(($this->uri->segment(1)=="ReportAbsensi") ? 'active' : '')?><?=(($this->uri->segment(1)=="Absensi") ? 'active' : '')?><?=(($this->uri->segment(1)=="PlanRooster") ? 'active' : '')?><?=(($this->uri->segment(1)=="MasterPola") ? 'active' : '')?><?=(($this->uri->segment(1)=="ImportRooster") ? 'active' : '')?>" href="#rooster" id="navbarDropdownMenuLink2" data-toggle="collapse" aria-haspopup="true" aria-expanded="false">
              <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
              </div>
              <span class="nav-link-text ms-1">Rooster</span>
            </a>
            <div class="dropdown-menu0 collapse" aria-labelledby="navbarDropdownMenuLink2" id="rooster" data-parent="#left-navigation">
              <?php
                if($jb[0] == "DUKTEK" || $jb[0] == "ADMIN") {
              ?>
              <a class="nav-link <?=(($this->uri->segment(1)=="ImportRooster") ? 'active' : '')?>" href="<?=site_url()?>/ImportRooster">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Import Rooster</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="MasterPola") ? 'active' : '')?>" href="<?=site_url()?>/MasterPola">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Master Pola</span>
              </a>
              <?php
                }
              ?>
              <a class="nav-link <?=(($this->uri->segment(1)=="PlanRooster") ? 'active' : '')?>" href="<?=site_url()?>/PlanRooster">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Plan Rooster</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="Absensi") ? 'active' : '')?>" href="<?=site_url()?>/Absensi">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Absensi</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ReportAbsensi") ? 'active' : '')?>" href="<?=site_url()?>/ReportAbsensi">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Report Absensi</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ReportRooster") ? 'active' : '')?>" href="<?=site_url()?>/ReportRooster">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Report Rooster</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="FormTkd") ? 'active' : '')?>" href="<?=site_url()?>/FormTkd">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Pengajuan TKD</span>
              </a>
              <a class="nav-link <?=(($this->uri->segment(1)=="ApproveTkd") ? 'active' : '')?>" href="<?=site_url()?>/ApproveTkd">
                <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                </div>
                <span class="nav-link-text ms-1">Approve TKD</span>
              </a>
            </div>
          </li>
      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <div class="card card-plain shadow-none" id="sidenavCard">
        <img class="w-50 mx-auto" src="<?=base_url()?>assets/img/illustrations/icon-documentation.svg" alt="sidebar_illustration">
      </div>
      <a class="btn btn-dark btn-sm w-100 mb-3" href="<?=site_url('Login/logout')?>" type="button">Logout</a>
    </div>
  </aside>
  <main class="main-content position-relative border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">147</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">147</h6>
        </nav>
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"><?=$_SESSION['nama']?> | <?=$_SESSION['jabatan']?> | <?=$_SESSION['area']?></span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                  <i class="sidenav-toggler-line bg-white"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">

            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0 notification bukaNotifInbox" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                INBOX NOTIF&nbsp;&nbsp;&nbsp;<i class="fa fa-bell cursor-pointer"></i>
                <span class="badge badge-warning navbar-badge"><?=$total_notif_inbox?></span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
              <span class="text-center dropdown-item dropdown-header"><?=$total_notif_inbox?> Notifikasi</span>
              <div class="dropdown-divider"></div>
              <?php
                foreach($data_notif_inbox as $dni) {
              ?>
                <li class="mb-2 list-notifikasi">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="<?=base_url()?>assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">FROM : <?=$dni->name?></span> <br>
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          <?=date("l, d F Y", strtotime($dni->date_notif))?>
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <?php
                }
                ?>
                <div class="dropdown-divider"></div>
                <a href="<?=site_url('Inbox')?>">
                  <span class="text-center dropdown-item dropdown-footer">Lihat Semua Notifikasi Inbox</span>
                </a>
              </ul>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">

            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-white p-0 notification bukaNotif" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                CCM NOTIF&nbsp;&nbsp;&nbsp;<i class="fa fa-bell cursor-pointer"></i>
                <span class="badge badge-warning navbar-badge"><?=$total_notif?></span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
              <span class="text-center dropdown-item dropdown-header"><?=$total_notif?> Notifikasi</span>
              <div class="dropdown-divider"></div>
              <?php
                foreach($data_notif as $dn) {
              ?>
                <li class="mb-2 list-notifikasi">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="<?=base_url()?>assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">FROM : <?=$dn->name?></span> <br>
                          <?php
                          if($dn->status == 0) {
                            echo "NEED APPROVE BY AGENT";
                          }
                          elseif($dn->status == 1) {
                            echo "NEED APPROVE BY TL";
                          }
                          elseif($dn->status == 2) {
                            echo "NEED APPROVE BY SPV";
                          }
                          elseif($dn->status == 3) {
                            echo "NEED APPROVE BY MANAGER";
                          }
                          elseif($dn->status == 4) {
                            echo "AKTIF";
                          }
                          elseif($dn->status == 5) {
                            echo "TIDAK AKTIF";
                          }
                          ?>
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          <?=date("l, d F Y", strtotime($dn->date_notif))?>
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <?php
                }
                ?>
                <div class="dropdown-divider"></div>
                <a href="<?=site_url('ListCCM')?>">
                  <span class="text-center dropdown-item dropdown-footer">Lihat Semua Notifikasi</span>
                </a>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  