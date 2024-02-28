<footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                INFRATEL IT MALANG.
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script> -->
  <script src="<?=base_url()?>assets/coreui/js/coreui.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/coreui/js/coreui.min.js"></script>
  <script src="<?=base_url()?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?=base_url()?>assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?=base_url()?>assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="<?=base_url()?>assets/js/plugins/chartjs.min.js"></script>
  <script src="<?=base_url()?>assets/plugins/font-awesome/kit-font-awesome.js"></script>
  <script src="<?=base_url()?>assets/sweetalert2/package/dist/sweetalert2.min.js"></script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
      
      element.addEventListener('click', function (e) {

        let nextEl = element.nextElementSibling;
        let parentEl  = element.parentElement;	

          if(nextEl) {
              e.preventDefault();	
              let mycollapse = new bootstrap.Collapse(nextEl);
              
              if(nextEl.classList.contains('show')){
                mycollapse.hide();
              } else {
                  mycollapse.show();
                  // find other submenus with class=show
                  var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                  // if it exists, then close all of them
                  if(opened_submenu){
                    new bootstrap.Collapse(opened_submenu);
                  }
              }
          }
      }); // addEventListener
    }) // forEach
  }); 
  // DOMContentLoaded  end
    // var ctx1 = document.getElementById("chart-line").getContext("2d");

    // var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    // gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    // gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    // gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    // new Chart(ctx1, {
    //   type: "line",
    //   data: {
    //     labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    //     datasets: [{
    //       label: "Mobile apps",
    //       tension: 0.4,
    //       borderWidth: 0,
    //       pointRadius: 0,
    //       borderColor: "#5e72e4",
    //       backgroundColor: gradientStroke1,
    //       borderWidth: 3,
    //       fill: true,
    //       data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
    //       maxBarThickness: 6

    //     }],
    //   },
    //   options: {
    //     responsive: true,
    //     maintainAspectRatio: false,
    //     plugins: {
    //       legend: {
    //         display: false,
    //       }
    //     },
    //     interaction: {
    //       intersect: false,
    //       mode: 'index',
    //     },
    //     scales: {
    //       y: {
    //         grid: {
    //           drawBorder: false,
    //           display: true,
    //           drawOnChartArea: true,
    //           drawTicks: false,
    //           borderDash: [5, 5]
    //         },
    //         ticks: {
    //           display: true,
    //           padding: 10,
    //           color: '#fbfbfb',
    //           font: {
    //             size: 11,
    //             family: "Open Sans",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //         }
    //       },
    //       x: {
    //         grid: {
    //           drawBorder: false,
    //           display: false,
    //           drawOnChartArea: false,
    //           drawTicks: false,
    //           borderDash: [5, 5]
    //         },
    //         ticks: {
    //           display: true,
    //           color: '#ccc',
    //           padding: 20,
    //           font: {
    //             size: 11,
    //             family: "Open Sans",
    //             style: 'normal',
    //             lineHeight: 2
    //           },
    //         }
    //       },
    //     },
    //   },
    // });
    $(document).ready(function() {
    
            $('.bukaNotif').click(function() { // Jika Select Box id provinsi dipilih
                var user_id = <?=$this->session->userdata('user_id')?>;
                // alert(user_id);
                $.ajax({
                    type: 'POST', // Metode pengiriman data menggunakan POST
                    url: '<?=site_url('Notif/updateStatusNotif/')?>', // File yang akan memproses data
                    data: {'user_id' : user_id},
                    dataType : "JSON", // Data yang akan dikirim ke file pemroses
                    success: function(data) { // Jika berhasil
                        console.log(data);
                        // $('.list-notifikasi').empty();

                    }
                });
            });

            $('.bukaNotifInbox').click(function() { // Jika Select Box id provinsi dipilih
                var username = <?=$this->session->userdata('username')?>;
                // alert(username);
                $.ajax({
                    type: 'POST', // Metode pengiriman data menggunakan POST
                    url: '<?=site_url('Notif/updateStatusNotifInbox/')?>', // File yang akan memproses data
                    data: {'username' : username},
                    dataType : "JSON", // Data yang akan dikirim ke file pemroses
                    success: function(data) { // Jika berhasil
                        console.log(data);
                        // $('.list-notifikasi').empty();

                    }
                });
            });
  }); 
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script>
    var timestamp = '<?=time();?>';
    function updateTime(){
      $('#time').html(Date(timestamp));
      timestamp++;
    }
    $(function(){
      setInterval(updateTime, 1000);
    });
  </script>
  <!-- Github buttons -->
  <!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->
  <script src="<?=base_url()?>assets/plugins/buttons/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <!-- <script src="<?=base_url()?>assets/js/argon-dashboard.min.js"></script> -->
</body>

</html>