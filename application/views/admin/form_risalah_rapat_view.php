
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form Risalah Rapat</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-4" >
                <form method="post" action="<?=site_url('RisalahRapat/addProses')?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="aksi" name="aksi" value="<?=($aksi == 'add') ? 'add' : 'edit' ?>">
                    <input type="hidden" class="form-control" id="id_risalah_rapat" name="id_risalah_rapat" value="<?=(isset($detail_data_risalah_rapat->id_risalah_rapat)) ? $detail_data_risalah_rapat->id_risalah_rapat : '' ?>">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$_SESSION['nama']?>">
                    <input type="hidden" class="form-control" id="tanggal_posting" name="tanggal_posting" value="<?=date("Y-m-d")?>">       
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="judul">Judul Risalah Rapat</label>
                            <input type="text" class="form-control" id="judul_risalah_rapat" name="judul_risalah_rapat" placeholder="judul_risalah_rapat" value="<?=(isset($detail_data_risalah_rapat->judul_risalah_rapat)) ? $detail_data_risalah_rapat->judul_risalah_rapat : '' ?>" required>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="area">area</label>
                            <select class="form-control" id="area" name="area" required>
                                <option value="">-- Pilih Area --</option>
                                <option value="MALANG" <?=(isset($detail_data_risalah_rapat)) ? (($detail_data_risalah_rapat->area == "MALANG") ? 'selected' : '' ) : '' ?>>MALANG</option>
                                <option value="SEMARANG" <?=(isset($detail_data_risalah_rapat)) ? (($detail_data_risalah_rapat->area == "SEMARANG") ? 'selected' : '' ) : ''  ?>>SEMARANG</option>
                            </select>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="file_risalah_rapat">File</label>
                            <input type="file" class="form-control" id="file_risalah_rapat" name="file_risalah_rapat" placeholder="File">
                        </div>
                    </div>
                    <br><br>
                    <button class="btn btn-primary" type="submit">Save</button>
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



          
      
      