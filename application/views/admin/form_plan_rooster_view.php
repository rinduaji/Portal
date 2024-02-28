
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form Plan Rooster</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-4" >
                <form method="post" action="<?=site_url('PlanRooster/addProses')?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="aksi" name="aksi" value="<?=($aksi == 'add') ? 'add' : 'edit' ?>">
                    <input type="hidden" class="form-control" id="id_plan_rooster" name="id_plan_rooster" value="<?=(isset($detail_data_plan_rooster->id_plan_rooster)) ? $detail_data_plan_rooster->id_plan_rooster : '' ?>">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$_SESSION['nama']?>">
                    <input type="hidden" class="form-control" id="tanggal" name="tanggal" value="<?=date("Y-m-d")?>">       
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="<?=(isset($detail_data_plan_rooster->judul)) ? $detail_data_plan_rooster->judul : '' ?>" required>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="topik">Topik</label>
                            <select class="form-control" id="topik" name="topik" required>
                                <option value="">-- Pilih Topik --</option>
                                <option value="147" <?=(isset($detail_data_plan_rooster)) ? (($detail_data_plan_rooster->topik == "147") ? 'selected' : '' ) : '' ?>>147</option>
                                <option value="TAM" <?=(isset($detail_data_plan_rooster)) ? (($detail_data_plan_rooster->topik == "TAM") ? 'selected' : '' ) : ''  ?>>TAM</option>
                                <option value="ALL" <?=(isset($detail_data_plan_rooster)) ? (($detail_data_plan_rooster->topik == "ALL") ? 'selected' : '' ) : ''  ?>>ALL</option>
                            </select>
                
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="AKTIF" <?=(isset($detail_data_plan_rooster)) ? (($detail_data_plan_rooster->status == "AKTIF") ? 'selected' : '' ) : ''  ?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?=(isset($detail_data_plan_rooster)) ? (($detail_data_plan_rooster->status == "TIDAK AKTIF") ? 'selected' : '' ) : ''  ?>>TIDAK AKTIF</option>
                            </select>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="short_description">Short Description</label>
                            <input type="text" class="form-control" id="short_description" name="short_description" placeholder="Short Description" value="<?=(isset($detail_data_plan_rooster->short_description)) ? $detail_data_plan_rooster->short_description : '' ?>" required>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="image">Gambar Profile</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" placeholder="Gambar Profile" required>
                
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="file_plan_rooster">File</label>
                            <input type="file" class="form-control" id="file_plan_rooster" name="file_plan_rooster" placeholder="File">
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="summernote" name="description" required><?=(isset($detail_data_plan_rooster->description)) ? $detail_data_plan_rooster->description : '' ?></textarea>
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



          
      
      