
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form Create User</h6>
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
                <form method="post" action="<?=site_url('CreateUser/addProses')?>" enctype="multipart/form-data">
                    
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label for="user1">Username</label>
                                <input type="text" class="form-control" id="user1" name="user1" placeholder="Username" value="" required>
                            </div>
                            <div class="col-md-10 mb-3">
                                <label for="user2">Name</label>
                                <input type="text" class="form-control" id="user2" name="user2" placeholder="Name" value="" required>
                            </div>
                        </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="user3">Jabatan</label>
                            <select class="form-control" id="user3" name="user3" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <?php
                                foreach($data_jabatan as $dj) {
                                ?>
                                <option value="<?=$dj->user3?>"><?=$dj->user3?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user5">Site</label>
                            <select class="form-control" id="user5" name="user5" required>
                                <option value="">-- Pilih Site --</option>
                                <option value="MALANG" >MALANG</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="user6">Layanan</label>
                            <select class="form-control" id="user6" name="user6" required>
                                <option value="">-- Pilih Layanan --</option>
                                <option value="CC147" >CC147</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="tl">TL</label>
                            <select class="form-control" id="tl" name="tl">
                                <option value="">-- Pilih TL --</option>
                                <?php
                                foreach($data_tl as $dl) {
                                ?>
                                <option value="<?=$dl->user1?>"><?=$dl->user1.' || '.$dl->user2.' || '.$dl->user3?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="spv">SPV</label>
                            <select class="form-control" id="spv" name="spv">
                                <option value="">-- Pilih SPV --</option>
                                <?php
                                foreach($data_spv as $ds) {
                                ?>
                                <option value="<?=$ds->user1?>"><?=$ds->user1.' || '.$ds->user2.' || '.$ds->user3?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="manager">Manager</label>
                            <select class="form-control" id="manager" name="manager">
                                <option value="">-- Pilih Manager --</option>
                                <?php
                                foreach($data_manager as $dm) {
                                ?>
                                <option value="<?=$dm->user1?>"><?=$dm->user1.' || '.$dm->user2.' || '.$dm->user3?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br><br>
                    <button class="btn btn-primary" type="submit">Save User</button>
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