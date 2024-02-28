
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form Master Pola</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-4" >
                <form method="post" action="<?=site_url('MasterPola/addProses')?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="aksi" name="aksi" value="<?=($aksi == 'add') ? 'add' : 'edit' ?>">
                    <input type="hidden" class="form-control" id="id_master_pola" name="id_master_pola" value="<?=(isset($detail_data_master_pola->id)) ? $detail_data_master_pola->id : '' ?>">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$_SESSION['username']?>">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="pola">Pola</label>
                            <input type="text" class="form-control" id="pola" name="pola" placeholder="Pola" value="<?=(isset($detail_data_master_pola->pola)) ? $detail_data_master_pola->pola : '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="masuk">Masuk</label>
                            <input type="text" class="form-control" id="masuk" name="masuk" placeholder="Masuk" value="<?=(isset($detail_data_master_pola->masuk)) ? $detail_data_master_pola->masuk : '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pulang">Pulang</label>
                            <input type="text" class="form-control" id="pulang" name="pulang" placeholder="Pulang" value="<?=(isset($detail_data_master_pola->pulang)) ? $detail_data_master_pola->pulang : '' ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="ist1">Istirahat 1</label>
                            <input type="text" class="form-control" id="ist1" name="ist1" placeholder="Istirahat 1" value="<?=(isset($detail_data_master_pola->ist1)) ? $detail_data_master_pola->ist1 : '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ist2">Istirahat 2</label>
                            <input type="text" class="form-control" id="ist2" name="ist2" placeholder="Istirahat 2" value="<?=(isset($detail_data_master_pola->ist2)) ? $detail_data_master_pola->ist2 : '' ?>" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ist3">Istirahat 3</label>
                            <input type="text" class="form-control" id="ist3" name="ist3" placeholder="Istirahat 3" value="<?=(isset($detail_data_master_pola->ist3)) ? $detail_data_master_pola->ist3 : '' ?>" >
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="ist4">Istirahat 4</label>
                            <input type="text" class="form-control" id="ist4" name="ist4" placeholder="Istirahat 4" value="<?=(isset($detail_data_master_pola->ist4)) ? $detail_data_master_pola->ist4 : '' ?>" >
                        </div>
                    </div>
                    <br><br>
                    <button class="btn btn-primary" type="submit">Save Pola</button>
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



          
      
      