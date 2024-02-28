
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form News</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-4" >
                <form method="post" action="<?=site_url('listNews/addProses')?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="aksi" name="aksi" value="<?=($aksi == 'add') ? 'add' : 'edit' ?>">
                    <input type="hidden" class="form-control" id="id_news" name="id_news" value="<?=(isset($detail_data_news->id_news)) ? $detail_data_news->id_news : '' ?>">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$_SESSION['nama']?>">
                    <input type="hidden" class="form-control" id="tanggal" name="tanggal" value="<?=date("Y-m-d")?>">       
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="judul">Judul Berita</label>
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Berita" value="<?=(isset($detail_data_news->judul)) ? $detail_data_news->judul : '' ?>" required>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="topik">Topik Berita</label>
                            <select class="form-control" id="topik" name="topik" required>
                                <option value="">-- Pilih Topik --</option>
                                <option value="147" <?=(isset($detail_data_news)) ? (($detail_data_news->topik == "147") ? 'selected' : '' ) : '' ?>>147</option>
                                <option value="TAM" <?=(isset($detail_data_news)) ? (($detail_data_news->topik == "TAM") ? 'selected' : '' ) : ''  ?>>TAM</option>
                                <option value="ALL" <?=(isset($detail_data_news)) ? (($detail_data_news->topik == "ALL") ? 'selected' : '' ) : ''  ?>>ALL</option>
                            </select>
                
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="AKTIF" <?=(isset($detail_data_news)) ? (($detail_data_news->status == "AKTIF") ? 'selected' : '' ) : ''  ?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?=(isset($detail_data_news)) ? (($detail_data_news->status == "TIDAK AKTIF") ? 'selected' : '' ) : ''  ?>>TIDAK AKTIF</option>
                            </select>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="short_description">Short Description</label>
                            <input type="text" class="form-control" id="short_description" name="short_description" placeholder="Short Description" value="<?=(isset($detail_data_news->short_description)) ? $detail_data_news->short_description : '' ?>" required>
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="image">Gambar Profile</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" placeholder="Gambar Profile" required>
                
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="file_news">File Berita</label>
                            <input type="file" class="form-control" id="file_news" name="file_news" placeholder="File Berita">
                
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="summernote" name="description" required><?=(isset($detail_data_news->description)) ? $detail_data_news->description : '' ?></textarea>
                        </div>
                    </div>
                    <br><br>
                    <button class="btn btn-primary" type="submit">Save Berita</button>
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



          
      
      