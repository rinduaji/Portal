
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form Absensi</h6>
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
                <form method="post" action="<?=site_url('Absensi/addProses')?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" name="id_rooster" value="<?=(isset($data_absen->id)) ? $data_absen->id : '' ?>" >
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="jam">Jam 
                                <?php 
                                date_default_timezone_set('Asia/Jakarta');
                                ?>
                            </label>
                            <p id="time"><?=date("Y-m-d H:i:s")?></p>
                            <!-- <input type="text" class="form-control" id="jam" name="jam" placeholder="Jam" value="<?=(isset($data_absen->ist4)) ? $data_absen->ist4 : '' ?>" > -->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?=(isset($login)) ? $login : '' ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?=(isset($nama)) ? $nama : '' ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan" value="<?=(isset($jabatan)) ? $jabatan : '' ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="area">Area</label>
                            <input type="text" class="form-control" id="area" name="area" placeholder="Area" value="<?=(isset($area)) ? $area : '' ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="pola">Pola</label>
                            <input type="text" class="form-control" id="pola" name="pola" placeholder="Pola" value="<?=(isset($data_absen->pola)) ? $data_absen->pola : '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="masuk">Masuk</label>
                            <input type="text" class="form-control" id="masuk" name="masuk" placeholder="Masuk" value="<?=(isset($data_absen->masuk)) ? $data_absen->masuk : '' ?>" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pulang">Pulang</label>
                            <input type="text" class="form-control" id="pulang" name="pulang" placeholder="Pulang" value="<?=(isset($data_absen->pulang)) ? $data_absen->pulang : '' ?>" >
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label for="ist1">Istirahat 1</label>
                            <input type="text" class="form-control" id="ist1" name="ist1" placeholder="Istirahat 1" value="<?=(isset($data_absen->ist1)) ? $data_absen->ist1 : '' ?>" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ist2">Istirahat 2</label>
                            <input type="text" class="form-control" id="ist2" name="ist2" placeholder="Istirahat 2" value="<?=(isset($data_absen->ist2)) ? $data_absen->ist2 : '' ?>" >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ist3">Istirahat 3</label>
                            <input type="text" class="form-control" id="ist3" name="ist3" placeholder="Istirahat 3" value="<?=(isset($data_absen->ist3)) ? $data_absen->ist3 : '' ?>" >
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ist4">Istirahat 4</label>
                            <input type="text" class="form-control" id="ist4" name="ist4" placeholder="Istirahat 4" value="<?=(isset($data_absen->ist4)) ? $data_absen->ist4 : '' ?>" >
                        </div>
                    </div>
                    <br><br>
                    <?php
                    if(count((array)$data_absen) > 0) {
                        if($data_absen->pola !== "X" || $data_absen->pola !== "CT") {
                    ?>
                    <button class="btn btn-primary" name="absen_masuk" type="submit" <?=($cek_absen_masuk != '0') ? 'disabled' : 'enabled'?>>Absen Masuk</button>
                    <button class="btn btn-success" name="absen_pulang" type="submit" <?=($cek_absen_masuk == '1' && $cek_absen_pulang == '1') ? 'disabled' : (($cek_absen_masuk == '0') ? 'disabled' : 'enabled') ?>>Absen Pulang</button>
                    <?php
                        }
                    }
                    ?>
                </form>
            </div>
          </div>
        </div>
      </div>

      <script>
        $(document).ready(function() {
          $('#summernote').summernote();
        });
      </script>



          
      
      