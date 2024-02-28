
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>CCM 147</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-4" >
                <?php 
                  if ($this->session->flashdata('success')) { 
                  ?>
                  <div class="alert alert-success" role="alert" style="color: white;">
                    <?php echo $this->session->flashdata('success'); ?>
                  </div>
                  <?php 
                  }
                  else if($this->session->flashdata('gagal')) { 
                  ?>
                  <div class="alert alert-warning" role="alert" style="color: white;">
                    <?php echo $this->session->flashdata('gagal'); ?>
                  </div>
                  <?php
                  }
                ?>
                <form method="post"  enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$this->session->userdata('username')?>">
                    <div class="col-md-12 mb-3">
                        <label for="pilih_jabatan">Pilih Jabatan</label>
                            <select class="form-control" id="pilih_jabatan" name="pilih_jabatan" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <?php
                                foreach($list_jabatan_agent as $lja) {
                                ?>
                                    <option value="<?=$lja->user3?>"><?=$lja->user3?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                            </div>
                            <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="pilih_kategori">Pilih Kategori</label>
                            <select class="form-control" id="pilih_kategori" name="pilih_kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php
                                foreach($list_kategori as $lk) {
                                ?>
                                    <option value="<?=$lk->id_kat?>"><?=$lk->kategori?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        </div>
                            <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="pilih_agent">Pilih Nama</label>
                            <select class="form-control js-example-basic-single" id="pilih_agent" name="pilih_agent" required>
                                <option value=''>-- Pilih Nama --</option>
                            </select>
                        </div>
                        </div>
                            <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <div id="pilihan_detail_kategori" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="hasil_status_ccm_now" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="hasil_status_ccm" required>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="hasil_kronologis" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="alasan">Alasan / Akar masalah</label>
                            <textarea class="form-control" id="alasan" name="alasan" required></textarea>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="save" id="save">Save</button>
                </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function() {
            $('#pilih_kategori').prop('disabled', true);
            $('#pilih_agent').prop('disabled', true);
            $('#alasan').prop('disabled', true);

            $('.js-example-basic-single').select2();

            $("form").on("submit", function(event){
              event.preventDefault();
      
              var formValues= $(this).serialize();
              let upd = $('#upd').val();
              let pilih_jabatan = $('#pilih_jabatan').val();
              let pilih_kategori = $('#pilih_kategori').val();
              let pilih_agent = $('#pilih_agent').val();
              let alasan = $('#alasan').val();
              let detail_kategori = $('input[name="detail_kategori"]:checked').parent().text();
              let id_detail_kategori = $('input[name="detail_kategori"]:checked').val();
              
              let status_ccm_now = $('#status_ccm_now').val();
              let status_ccm_akhir = $('#status_ccm_akhir').val();
              let kronologis = $('#kronologis').val();

              let text_pop_up = `<hr>
                            <b>LOGIN AGENT</b> : ${pilih_agent} <br><hr>
                            <b>JABATAN</b> : ${pilih_jabatan} <br><hr>
                            <b>STATUS CCM TERAKHIR</b> : ${status_ccm_now}<br><hr>
                            <b>STATUS CCM SELANJUTNYA</b> : ${status_ccm_akhir}<br><hr>
                            <b>DETAIL KATEGORI</b> : ${detail_kategori} <br><hr>
                            <b>ALASAN</b> : ${alasan} <br><hr>
                            <b>KRONOLOGIS</b> : ${(typeof kronologis !== "undefined") ? kronologis : ''} <br>
                            <hr>`;
              Swal.fire({
                  icon: 'warning',
                  title: "Apakah anda yakin menyimpan CCM ini?",
                  html: text_pop_up,
                  type: "warning",
                  showDenyButton: false,
                  showCancelButton: true,
                  confirmButtonClass: "btn-success",
                  confirmButtonText: "Yes, Save CCM!",
                  cancelButtonText: "No, Cancel CCM!",
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {

                  // Ajax config
                  $.ajax({
                          url: '<?=site_url('CCM147/save')?>',
                          type: 'POST',
                          // data: {
                          //       upd: upd,
                          //       pilih_jabatan: pilih_jabatan,
                          //       pilih_kategori: pilih_kategori,
                          //       pilih_agent: pilih_agent,
                          //       alasan: alasan,
                          //       detail_kategori: detail_kategori,
                          //       status_ccm_akhir: status_ccm_akhir,
                          //       kronologis: kronologis,
                          // },
                          data: formValues,
                          error: function() {
                              alert('Something is wrong');
                          },
                          success: function(data) {
                                // $("#"+id).remove();
                                // Swal.fire("Save!", "Data Telah disimpan.", "success");
                                Swal.fire({
                                    icon: 'success',
                                    title: "Save!",
                                    html: "Data Telah disimpan.",
                                    type: "success",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "OK",
                                }).then((result) => {
                                  if (result.isConfirmed) {
                                    window.location.replace("<?=site_url('CCM147/index')?>");
                                  }
                                });
                          }
                  });
                } else  {
                  Swal.fire("Cancelled", "Data belum tersimpan", "error");
                }
              });
            });

            $('#pilih_jabatan').change(function() { // Jika Select Box id provinsi dipilih
                var pilih_jabatan = $(this).val(); // Ciptakan variabel provinsi
                $.ajax({
                    type: 'POST', // Metode pengiriman data menggunakan POST
                    url: '<?=site_url('CCM147/getNamaAgent/')?>', // File yang akan memproses data
                    data: {'pilih_jabatan' : pilih_jabatan},
                    dataType : "JSON", // Data yang akan dikirim ke file pemroses
                    success: function(data) { // Jika berhasil
                      
                        $('#pilih_kategori').prop('disabled', false);
                        $('#pilih_agent').prop('disabled', false);
                        var html = '';
                        var i;
                        if(data.length > 0) {
                          html += "<option value=''>-- Pilih Nama --</option>";
                          for(i=0; i<data.length; i++){
                              html += '<option value="' + data[i].username + '">'+data[i].username+' | ' + data[i].name + '</option>';
                          }
                        }
                        else{
                          html += "<option value=''>-- Pilih Nama --</option>";
                        }
                        $('#pilih_agent').html(html);
                        // console.log(html);

                    }
                });
            });

            $('#pilih_agent').change(function() { // Jika Select Box id provinsi dipilih
                var pilih_agent = $(this).val(); // Ciptakan variabel provinsi
                $.ajax({
                    type: 'POST', // Metode pengiriman data menggunakan POST
                    url: '<?=site_url('CCM147/getJabatanAgent/')?>', // File yang akan memproses data
                    data: {'pilih_agent' : pilih_agent},
                    dataType : "JSON", // Data yang akan dikirim ke file pemroses
                    success: function(data) { // Jika berhasil
                        var id_kat = $('#pilih_kategori').val();
                        var cekJabatan = $('#pilih_jabatan').val();
                        var jabatan = cekJabatan.split(" ");
                        // var jabatan_tl = '';
                        // if(jabatan[1] == 'LEADER') {
                        //     jabatan_tl = jabatan[0] + ' ' + jabatan[1];
                        // }
                        var dataUrl = '';
                        if(jabatan[0] == 'AGENT') {
                          dataUrl = '<?=site_url('CCM147/getDetailKategori/')?>';
                        }
                        else if(jabatan[0] == 'TL') {
                          dataUrl = '<?=site_url('CCM147/getDetailKategoriTl/')?>';
                        }
                        else if(jabatan[0] == 'QCO') {
                          dataUrl = '<?=site_url('CCM147/getDetailKategoriQc/')?>';
                        }
                        else if(jabatan[0] == 'QA') {
                          dataUrl = '<?=site_url('CCM147/getDetailKategoriSpv/')?>';
                        }
                        else if(jabatan[0] == 'SUPERVISOR') {
                          dataUrl = '<?=site_url('CCM147/getDetailKategoriSpv/')?>';
                        }
                        else if(jabatan[0] == 'INPUTER' || jabatan[0] == 'SUPPORT' || jabatan[0] == 'SOO') {
                          dataUrl = '<?=site_url('CCM147/getDetailKategoriSupport/')?>';
                        }
                        else {
                          dataUrl = '<?=site_url('CCM147/getDetailKategori/')?>';
                        }
                        // console.log(jabatan[0]);
                        $.ajax({
                            type: 'POST', // Metode pengiriman data menggunakan POST
                            url: dataUrl, // File yang akan memproses data
                            data: {'id_kat' : id_kat},
                            dataType : "JSON", // Data yang akan dikirim ke file pemroses
                            success: function(data1) { // Jika berhasil
                                // $('#jabatan_agent').val(data.user3);
                                var html = '';
                                var i;
                                if(data1.length > 0) {
                                    // html += "<option value=''>-- Pilih Detail Kategori --</option>";
                                    html += '<label for="Detail_kategori">Detail Kategori</label><hr>';
                                    for(i=0; i<data1.length; i++){
                                        // html += '<option value="' + data1[i].id + '">'+data1[i].detail+' | ' + (data1[i].kode).toUpperCase() + '</option>';
                                        html += '<div class="form-check">';
                                        html += '<input class="form-check-input detail_kategori" type="radio" name="detail_kategori" id="detail_kategori' + i + '" value="' + data1[i].id + '">';
                                        html += '<label class="form-check-label" for="detail_kategori' + i + '">' + data1[i].detail+'</label>' ;
                                        html += '</div>';
                                        html += '<div class="form-input"><b>( ' + (data1[i].kode).toUpperCase() + ' )</b></div><hr>';
                                    }
                                }
                                else{
                                    // html += "<option value=''>-- Pilih Detail Kategori --</option>";
                                }
                                $('#pilihan_detail_kategori').html(html);
                                // console.log(html);
                                // console.log(data1);

                                $('input[name="detail_kategori"]').change(function() { // Jika Select Box id provinsi dipilih
                                if($('input[name="detail_kategori"]').is(':checked')) 
                                { 
                                  var detail_kategori = $(this).val(); // Ciptakan variabel provinsi
                                  var pilih_agent = $('#pilih_agent').val();
                                  var pilih_jabatan = $('#pilih_jabatan').val();
                                  // alert(detail_kategori);
                                  $.ajax({
                                      type: 'POST', // Metode pengiriman data menggunakan POST
                                      url: '<?=site_url('CCM147/statusCCM/')?>', // File yang akan memproses data
                                      data: {
                                        'pilih_agent' : pilih_agent,
                                        'detail_kategori': detail_kategori,
                                        'pilih_jabatan' : pilih_jabatan
                                      },
                                      dataType : "JSON", // Data yang akan dikirim ke file pemroses
                                      success: function(data) { // Jika berhasil
                                        console.log(data);
                                        // alert(data.coba);
                                          var html1 = '';
                                          var html2 = '';
                                          var html3 = '';
                                          html1 += '<label for="status_ccm_akhir">Status CCM Selanjutnya</label>';
                                          html1 += '<input type="text" class="form-control" name="status_ccm_akhir" id="status_ccm_akhir" value="' + data.kode + ' ' + data.level + '" required readonly>'
                                          
                                          html2 += '<label for="kronologis">Kronologis</label>';
                                          html2 += '<textarea class="form-control" name="kronologis" id="kronologis" required></textarea>';
                                          
                                          html3 += '<label for="status_ccm_now">Status CCM Terakhir</label>';
                                          html3 += '<input type="text" class="form-control" name="status_ccm_now" id="status_ccm_now" value="' + data.kode_now + ' ' + data.level_now + '" required readonly>'
                                          
                                          $('#hasil_status_ccm').html(html1);
                                          $('#hasil_status_ccm_now').html(html3);
                                          if(data.kode == 'sp' && data.level == '3') {
                                            $('#hasil_kronologis').html(html2);
                                          }
                                          $('#alasan').prop('disabled', false);
                                          console.log(data);
                                      }
                                  });
                                }
                              });
                            }
                        });
                    }
                });
            });

            
            
        });
      </script>



          
      
      