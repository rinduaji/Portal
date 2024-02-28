    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Dokumen</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
              <nav class="navbar navbar-light bg-light justify-content-between">
                <p style="padding-left: 1.5rem;padding-top: 0.75rem"><button class="btn btn-primary btn-sm mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus-circle"></i>&nbsp;Add</button></p>
                <form class="form-inline" method="post" action="<?=site_url('Dokumen')?>">
                  <label>Tanggal Awal &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_awal" id="date_awal" autocomplete="off">
                  <label>Tanggal Akhir &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                  <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus>
                  <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="btnSearch">Search</button>
                </form>
              </nav>
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
              
              if(empty($data_dokumen)) {
                ?>
                <div class="alert alert-danger" role="alert" style="color: white;">
                  Data Tidak Ditemukan!
                </div>
                <?php
                }
                ?>
                <div class="card-header pb-0">
                  <h6>Total Data : <?=$total_data?></h6>
                </div>
              <div class="table-responsive p-0" >
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Kategori</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Item</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Unit</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul Dokumen</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kode Dokumen</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Berlaku</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Verifikasi</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama File Dokumen</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($data_dokumen as $data) {
                    ?>
                    <tr>
                      <td style="padding: 0.75rem 1.5rem;">
                        <span class="text-secondary text-xs font-weight-bold"><?=++$start?></span>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->nama_kategori?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->nama_item?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=(($data->tingkatan == 3) ? $data->nama_unit : '-')?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->judul_dokumen?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->deskripsi?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->kode_dokumen?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->tanggal_berlaku?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->tanggal_verifikasi?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><a href="<?=base_url('uploads/dokumen/').$data->file_dokumen?>" target="_blank" class="btn btn-info btn-small" type="button"><i class="fa fa-download"></i>&nbsp;<?=$data->file_dokumen?></a></p>
                      </td>
                      <td class="align-middle text-center">
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#editModal"  data-id="<?=$data->id_dokumen?>"><i class="fas fa-edit"></i> Edit</a>  
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal"  data-id="<?=$data->id_dokumen?>"><i class="fas fa-trash"></i> Hapus</a>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
                <?=$this->pagination->create_links();?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dokumen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form method="post" action="<?=site_url('Dokumen/add')?>" enctype="multipart/form-data">
      <div class="modal-body">
          <input type="hidden" class="form-control" id="id" name="id">
          <div class="mb-3">
            <label for="tingkatan" class="col-form-label">Tingkatan</label>
            <select class="form-control" id="tingkatan" name="tingkatan" required>
                    <option value="">-- Pilih Tingkatan --</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
            </select>
          </div>
          <div class="mb-3" id="select-item">
            <label for="id_item" class="col-form-label">Nama Item Kategori</label>
            <select class="form-control" id="id_item" name="id_item">
                    <option value="">-- Pilih Nama Item Kategori --</option>
                    <?php
                        foreach($nama_dokumen_kategori as $ndk) {
                    ?>
                    <option value="<?=$ndk->id_item?>"><?=$ndk->nama_kategori?> | <?=$ndk->nama_item?></option>
                    <?php
                        }
                    ?>
                    <?php
                        foreach($nama_dokumen_item as $ndi) {
                    ?>
                    <option value="<?=$ndi->id_unit?>"><?=$ndi->nama_kategori?> | <?=$ndi->nama_item?> | <?=$ndi->nama_unit?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>
          <div class="mb-3" id="select-unit">
            <label for="id_unit" class="col-form-label">Nama Unit Item Kategori</label>
            <select class="form-control" id="id_unit" name="id_unit">
                    <option value="">-- Pilih Nama Unit Item Kategori --</option>
                    <?php
                        foreach($nama_dokumen_item as $ndi) {
                    ?>
                    <option value="<?=$ndi->id_unit?>"><?=$ndi->nama_kategori?> | <?=$ndi->nama_item?> | <?=$ndi->nama_unit?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="judul_dokumen" class="col-form-label">Judul Dokumen</label>
            <input type="text" class="form-control" id="judul_dokumen" name="judul_dokumen" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="col-form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
          </div>
          <div class="mb-3">
            <label for="kode_dokumen" class="col-form-label">Kode Dokumen</label>
            <input type="text" class="form-control" id="kode_dokumen" name="kode_dokumen" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_berlaku" class="col-form-label">Tanggal Berlaku</label>
            <input type="date" class="form-control" id="tanggal_berlaku" name="tanggal_berlaku" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_verifikasi" class="col-form-label">Tanggal Verifikasi</label>
            <input type="date" class="form-control" id="tanggal_verifikasi" name="tanggal_verifikasi" required>
          </div>
          <div class="mb-3">
            <label for="file_dokumen" class="col-form-label">File Dokumen</label>
            <input type="file" class="form-control" id="file_dokumen" name="file_dokumen" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dokumen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form method="post" action="<?=site_url('Dokumen/edit')?>" enctype="multipart/form-data">
      <div class="modal-body">
          <input type="hidden" class="form-control" id="id_edit" name="id">
          <div class="mb-3">
            <label for="tingkatan-edit" class="col-form-label">Tingkatan</label>
            <select class="form-control" id="tingkatan-edit" name="tingkatan-edit" required>
                    <option value="">-- Pilih Tingkatan --</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
            </select>
          </div>
          <div class="mb-3" id="select-item-edit">
            <label for="id_item" class="col-form-label">Nama Item Kategori</label>
            <select class="form-control" id="id_item_edit" name="id_item">
                    <option value="">-- Pilih Nama Item Kategori --</option>
                    <?php
                        foreach($nama_dokumen_kategori as $ndk) {
                    ?>
                    <option value="<?=$ndk->id_item?>"><?=$ndk->nama_kategori?> | <?=$ndk->nama_item?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>
          <div class="mb-3" id="select-unit-edit">
            <label for="id_item" class="col-form-label">Nama Unit Item Kategori</label>
            <select class="form-control" id="id_item_edit" name="id_item" >
                    <option value="">-- Pilih Nama Unit Item Kategori --</option>
                    <?php
                        foreach($nama_dokumen_item as $ndi) {
                    ?>
                    <option value="<?=$ndi->id_unit?>"><?=$ndi->nama_kategori?> | <?=$ndi->nama_item?> | <?=$ndi->nama_unit?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="judul_dokumen" class="col-form-label">Judul Dokumen</label>
            <input type="text" class="form-control" id="judul_dokumen_edit" name="judul_dokumen" required>
          </div>
          <div class="mb-3">
            <label for="deskripsi" class="col-form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi_edit" name="deskripsi" required></textarea>
          </div>
          <div class="mb-3">
            <label for="kode_dokumen" class="col-form-label">Kode Dokumen</label>
            <input type="text" class="form-control" id="kode_dokumen_edit" name="kode_dokumen" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_berlaku" class="col-form-label">Tanggal Berlaku</label>
            <input type="date" class="form-control" id="tanggal_berlaku_edit" name="tanggal_berlaku" required>
          </div>
          <div class="mb-3">
            <label for="tanggal_verifikasi" class="col-form-label">Tanggal Verifikasi</label>
            <input type="date" class="form-control" id="tanggal_verifikasi_edit" name="tanggal_verifikasi" required>
          </div>
          <div class="mb-3">
            <label for="file_dokumen" class="col-form-label">File Dokumen</label>
            <input type="file" class="form-control" id="file_dokumen_edit" name="file_dokumen" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?=site_url('Dokumen/hapus')?>">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_hapus" name="id">
          Apakah anda Yakin ingin menghapus data ini ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){   
      $("#select-item").hide();
      $("#select-unit").hide();
      $("#select-item-edit").hide();
      $("#select-unit-edit").hide();
  });

  var exampleModal = document.getElementById('exampleModal');
  exampleModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var site_url= "<?=site_url()?>";
    $(document).ready(function(){   

      $("#tingkatan").change(function() {
        var val = $(this).val();
        // let val = $(this).children("option:selected").val();
        // alert(val);
        if(val == 2) {
            $("#select-item").show();
            $("#select-unit").hide();
        }
        else if(val == 3) {
            $("#select-unit").show();
            $("#select-item").hide();
        }
      });
    });
  });

  var editModal = document.getElementById('editModal');
  editModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var id = button.getAttribute('data-id')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    document.getElementById('id_edit').value = id;
    var site_url= "<?=site_url()?>";
    $(document).ready(function(){   
      // alert(val);
      $("#tingkatan-edit").change(function() {
        // alert("a");
        var val = $(this).val();
        // let val = $(this).children("option:selected").val();
        if(val == 2) {
            $("#select-item-edit").show();
            $("#select-unit-edit").hide();
        }
        else if(val == 3) {
            $("#select-unit-edit").show();
            $("#select-item-edit").hide();
        }
      });

        $.ajax({
            type: "GET",
            url: site_url + "/Dokumen/get_by_id/" + id,  
            dataType: 'json',
            success: 
             function(data){
              //  alert(data);  //as a debugging message.
             document.getElementById('id_item_edit').value = data.id_item;
             document.getElementById('judul_dokumen_edit').value = data.judul_dokumen;
             document.getElementById('deskripsi_edit').value = data.deskripsi;
             document.getElementById('kode_dokumen_edit').value = data.kode_dokumen;
             document.getElementById('tanggal_berlaku_edit').value = data.tanggal_berlaku;
             document.getElementById('tanggal_verifikasi_edit').value = data.tanggal_verifikasi;
             }
         });
    });
  });

  var hapusModal = document.getElementById('hapusModal')
  hapusModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var id = button.getAttribute('data-id')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    document.getElementById('id_hapus').value = id;
    
  });

  
  
</script>
          
      
      