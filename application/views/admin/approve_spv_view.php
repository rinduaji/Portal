
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>CCM Aprove SPV</h6>
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
                <form method="post" action="<?=site_url('ListCCM/updateApproveSpv')?>" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$this->session->userdata('username')?>">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?=$this->uri->segment(3)?>" readonly>
                        <input type="hidden" class="form-control" id="lup_spv" name="lup_spv" value="<?=date("Y-m-d h:i:s")?>" readonly>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="login_agent">Login</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="text" class="form-control" id="login_agent" name="login_agent" value="<?=$data_approve_spv->username?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_agent">Nama</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="text" class="form-control" id="nama_agent" name="nama_agent" value="<?=$data_approve_spv->name?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="jabatan">Jabatan</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?=$data_approve_spv->jabatan?>" readonly>
                            </div>
                        </div>
                        <?php
                          if($hasil_jabatan == "TL") {
                        ?>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_tl">Nama Team Leader</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="hidden" class="form-control" id="id_tl" name="id_tl" value="<?=$data_nama_groupmail->id_tl?>" readonly>
                                <input type="text" class="form-control" id="nama_tl" name="nama_tl" value="<?=$data_nama_groupmail->nama_tl?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_spv">Nama SPV</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="hidden" class="form-control" id="id_spv" name="id_spv" value="<?=$data_nama_groupmail->id_spv?>" readonly>
                                <input type="text" class="form-control" id="nama_spv" name="nama_spv" value="<?=$data_nama_groupmail->nama_spv?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_manager">Nama Manager</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="hidden" class="form-control" id="id_manager" name="id_manager" value="<?=$data_nama_groupmail->id_manager?>" readonly>
                                <input type="text" class="form-control" id="nama_manager" name="nama_manager" value="<?=$data_nama_groupmail->nama_manager?>" readonly>
                            </div>
                        </div>
                        <?php
                          }
                          elseif($hasil_jabatan == "SUPERVISOR") {
                            
                        ?>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_spv">Nama SPV</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="hidden" class="form-control" id="id_spv" name="id_spv" value="<?=$data_nama_groupmail->id_spv?>" readonly>
                                <input type="text" class="form-control" id="nama_spv" name="nama_spv" value="<?=$data_nama_groupmail->nama_spv?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_manager">Nama Manager</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="hidden" class="form-control" id="id_manager" name="id_manager" value="<?=$data_nama_groupmail->id_manager?>" readonly>
                                <input type="text" class="form-control" id="nama_manager" name="nama_manager" value="<?=$data_nama_groupmail->nama_manager?>" readonly>
                            </div>
                        </div>
                        <?php
                          }
                          elseif($hasil_jabatan == "MANAGER") {
                            // print_r($data_nama_groupmail);
                        ?>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="nama_manager">Nama Manager</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="hidden" class="form-control" id="id_manager" name="id_manager" value="<?=$data_nama_groupmail->id_manager?>" readonly>
                                <input type="text" class="form-control" id="nama_manager" name="nama_manager" value="<?=$data_nama_groupmail->nama_manager?>" readonly>
                            </div>
                        </div>
                        <?php
                          }
                        ?>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="status_ccm">Status CCM</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <input type="text" class="form-control" id="status_ccm" name="status_ccm" value="<?=$data_approve_spv->kode.' '.$data_approve_spv->level?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="tgl_awal">Tanggal CCM</label>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" id="tgl_awal" name="tgl_awal" value="<?=date("l, d F Y",strtotime($data_approve_spv->tgl_mulai))?>" readonly>
                            </div>
                            <div class="col-md-1 mb-3">
                                <label for="tgl_awal"> Sampai </label>
                            </div>
                            <div class="col-md-5 mb-3">
                                <input type="text" class="form-control" id="tgl_akhir" name="tgl_akhir" value="<?=date("l, d F Y",strtotime($data_approve_spv->tgl_akhir))?>" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="pelanggaran">Pelanggaran</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <textarea class="form-control" id="pelanggaran" name="pelanggaran" rows="5" readonly><?=$data_approve_spv->pelanggaran?></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="alasan">Alasan</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <textarea class="form-control" id="alasan" name="alasan" rows="5" readonly><?=$data_approve_spv->alasan?></textarea>
                            </div>
                        </div>
                        <?php
                          if($hasil_jabatan == 'TL') {
                        ?>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="komitmen">Komitmen</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <textarea class="form-control" id="komitmen" name="komitmen" rows="5" readonly><?=$data_approve_spv->komitmen?></textarea>
                            </div>
                        </div>
                        <?php
                          }
                          elseif($hasil_jabatan == 'SUPERVISOR') {
                        ?>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="penyuluhan">Penyuluhan</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <textarea class="form-control" id="penyuluhan" name="penyuluhan" rows="5" readonly><?=$data_approve_spv->penyuluhan?></textarea>
                            </div>
                        </div>
                        <?php
                          }
                          else if($hasil_jabatan == 'MANAGER') {
                        ?>
                         <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="penyuluhan">Penyuluhan</label>
                            </div>
                            <div class="col-md-10 mb-3">
                                <textarea class="form-control" id="penyuluhan" name="penyuluhan" rows="5"></textarea>
                            </div>
                        </div>
                        <?php
                          }
                        ?>
                    </div>
                    <button class="btn btn-primary" type="submit">Approve</button>
                </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function() {
            $('#pilih_jabatan').change(function() { // Jika Select Box id provinsi dipilih
                var pilih_jabatan = $(this).val(); // Ciptakan variabel provinsi
                $.ajax({
                    type: 'POST', // Metode pengiriman data menggunakan POST
                    url: '<?=site_url('CCM147/getNamaAgent/')?>', // File yang akan memproses data
                    data: {'pilih_jabatan' : pilih_jabatan},
                    dataType : "JSON", // Data yang akan dikirim ke file pemroses
                    success: function(data) { // Jika berhasil
                        var html = '';
                        var i;
                        if(data.length > 0) {
                          html += "<option value=''>-- Pilih Agent --</option>";
                          for(i=0; i<data.length; i++){
                              html += '<option value="' + data[i].username + '">'+data[i].username+' | ' + data[i].name + '</option>';
                          }
                        }
                        else{
                          html += "<option value=''>-- Pilih Agent --</option>";
                        }
                        $('#pilih_agent').html(html);
                        console.log(html);
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
                        $.ajax({
                            type: 'POST', // Metode pengiriman data menggunakan POST
                            url: '<?=site_url('CCM147/getDetailKategori/')?>', // File yang akan memproses data
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
                                        html += '<input class="form-check-input" type="radio" name="detail_kategori" id="detail_kategori' + i + '" value="' + data1[i].id + '">';
                                        html += '<label class="form-check-label" for="detail_kategori' + i + '">' + data1[i].detail+' | ' + (data1[i].kode).toUpperCase() + '</label>';
                                        html += '</div><hr>';
                                    }
                                }
                                else{
                                    // html += "<option value=''>-- Pilih Detail Kategori --</option>";
                                }
                                $('#pilihan_detail_kategori').html(html);
                                console.log(html);
                                console.log(data1);
                            }
                        });
                    }
                });
            });
        });
      </script>



          
      
      