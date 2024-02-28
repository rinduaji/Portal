
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Form Inbox</h6>
            </div>
            <div class="card-body px-4 pt-4 pb-4" >
                <form method="post" action="<?=site_url('Inbox/addProses')?>" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="aksi" name="aksi" value="<?=($aksi == 'add') ? 'add' : 'edit' ?>">
                    <input type="hidden" class="form-control" id="id_inbox" name="id_inbox" value="<?=(isset($detail_data_inbox->id_inbox)) ? $detail_data_inbox->id_inbox : '' ?>">
                    <input type="hidden" class="form-control" id="upd" name="upd" value="<?=$_SESSION['nama']?>">
                    <input type="hidden" class="form-control" id="login" name="login" value="<?=$_SESSION['username']?>">
                    <input type="hidden" class="form-control" id="tanggal" name="tanggal" value="<?=date("Y-m-d")?>">       
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="judul">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="<?=(isset($detail_data_inbox->judul)) ? $detail_data_inbox->judul : '' ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis">Jenis Inbox</label>
                            <select class="form-control" id="jenis" name="jenis" required>
                                <option value="BLAST">BLAST</option>
                                <option value="PRIVATE">PRIVATE</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="login_private">Login Private</label>
                            <select class="form-control" id="login_private" name="login_private">
                                <option value="">-- Pilih Login Private --</option>
                                <?php
                                foreach($list_agent as $la) {
                                    if(
                                    ($la->user3 == 'AGENT KOMPLAIN' && $jabatan == 'TL 147') ||
                                    ($la->user3 == 'AGENT REFORMASI' && $jabatan == 'TL 147') ||
                                    ($la->user3 == 'AGENT T1 ENGLISH' && $jabatan == 'TL 147') ||
                                    ($la->user3 == 'SOO' && $jabatan == 'TL INPUTER') ||
                                    ($la->user3 == 'INPUTER' && $jabatan == 'TL INPUTER') || 
                                    ($la->user3 == 'SUPPOORT HC' && $jabatan == 'TL INPUTER')) {
                                    ?>
                                  <option value="<?=$la->user1?>"><?=$la->user1?> | <?=$la->user2?> | <?=$la->user3?></option>
                                  <?php
                                    }
                                    elseif(
                                    ($la->user3 == 'TL INPUTER'  && $jabatan == 'SUPERVISOR 147') ||
                                    ($la->user3 == 'TL 147'  && $jabatan == 'SUPERVISOR 147')) {
                                    ?>
                                    <option value="<?=$la->user1?>"><?=$la->user1?> | <?=$la->user2?> | <?=$la->user3?></option>
                                  <?php
                                    }
                                    elseif($la->user3 == 'SUPERVISOR 147' && $jabatan == 'MANAGER') {
                                    ?>
                                    <option value="<?=$la->user1?>"><?=$la->user1?> | <?=$la->user2?> | <?=$la->user3?></option>
                                  <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="topik">Topik</label>
                            <select class="form-control" id="topik" name="topik" required>
                                <option value="">-- Pilih Topik --</option>
                                <option value="147" <?=(isset($detail_data_inbox)) ? (($detail_data_inbox->topik == "147") ? 'selected' : '' ) : '' ?>>147</option>
                                <option value="TAM" <?=(isset($detail_data_inbox)) ? (($detail_data_inbox->topik == "TAM") ? 'selected' : '' ) : ''  ?>>TAM</option>
                                <option value="ALL" <?=(isset($detail_data_inbox)) ? (($detail_data_inbox->topik == "ALL") ? 'selected' : '' ) : ''  ?>>ALL</option>
                            </select>
                        </div>
                        <!-- <div class="col-md-6 mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="AKTIF" <?=(isset($detail_data_inbox)) ? (($detail_data_inbox->status == "AKTIF") ? 'selected' : '' ) : ''  ?>>AKTIF</option>
                                <option value="TIDAK AKTIF" <?=(isset($detail_data_inbox)) ? (($detail_data_inbox->status == "TIDAK AKTIF") ? 'selected' : '' ) : ''  ?>>TIDAK AKTIF</option>
                            </select>
                        </div> -->
                        <div class="col-md-4 mb-4">
                            <label for="short_description">Short Description</label>
                            <input type="text" class="form-control" id="short_description" name="short_description" placeholder="Short Description" value="<?=(isset($detail_data_inbox->short_description)) ? $detail_data_inbox->short_description : '' ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="file_inbox">File</label>
                            <input type="file" class="form-control" id="file_inbox" name="file_inbox" placeholder="File">
                        </div>
                    </div>
                    <!-- <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="image">Gambar Profile</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" placeholder="Gambar Profile">
                        </div>
                    </div> -->
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="summernote" name="description" required><?=(isset($detail_data_inbox->description)) ? $detail_data_inbox->description : '' ?></textarea>
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
        
          $('select[name="login_private"]').prop('disabled', true);
          $('select[name="jenis"]').change(function() {
            if(this.value == "PRIVATE"){
                $('select[name="login_private"]').prop('disabled', false);
            }
            else{
                $('select[name="login_private"]').prop('disabled', true);
            }
          });
        });
      </script>



          
      
      