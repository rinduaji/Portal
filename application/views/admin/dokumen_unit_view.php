<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Dokumen Unit</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
              <nav class="navbar navbar-light bg-light justify-content-between">
                <p style="padding-left: 1.5rem;padding-top: 0.75rem"><button class="btn btn-primary btn-sm mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus-circle"></i>&nbsp;Add</button></p>
                <form class="form-inline" method="post" action="<?=site_url('DokumenUnit')?>">
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

              if(empty($data_dokumen_unit)) {
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($data_dokumen_unit as $data_u) {
                    ?>
                    <tr>
                      <td style="padding: 0.75rem 1.5rem;">
                        <span class="text-secondary text-xs font-weight-bold"><?=++$start?></span>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data_u->nama_kategori?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data_u->nama_item?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data_u->nama_unit?></p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <?php
                        if($data_u->status == "AKTIF") {
                        ?>
                          <span class="badge badge-sm bg-gradient-success"><?=$data_u->status?></span>
                        <?php
                        }
                        else if($data_u->status == "NO AKTIF") {
                        ?>
                          <span class="badge badge-sm bg-gradient-danger"><?=$data_u->status?></span>
                        <?php
                        }
                        ?>
                      </td>
                      <td class="align-middle text-center">
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#editModal"  data-id="<?=$data_u->id_unit?>"><i class="fas fa-edit"></i> Edit</a>  
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal"  data-id="<?=$data_u->id_unit?>"><i class="fas fa-trash"></i> Hapus</a>
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
        <h5 class="modal-title" id="exampleModalLabel">Dokumen Unit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form method="post" action="<?=site_url('DokumenUnit/add')?>">
      <div class="modal-body">
          <input type="hidden" class="form-control" id="id" name="id">
          <div class="mb-3">
            <label for="nama_unit" class="col-form-label">Nama Unit</label>
            <input type="text" class="form-control" id="nama_unit" name="nama_unit" required>
          </div>
          <div class="mb-3">
            <label for="id_item" class="col-form-label">Nama Item</label>
            <select class="form-control" id="id_item" name="id_item" required>
                    <option value="">-- Pilih Nama Item --</option>
                    <?php
                        foreach($nama_dokumen_item as $ndk) {
                    ?>
                    <option value="<?=$ndk->id_item?>"><?=$ndk->nama_kategori?> | <?=$ndk->nama_item?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="status" class="col-form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="AKTIF">AKTIF</option>
                    <option value="NO AKTIF">NO AKTIF</option>
            </select>
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
        <h5 class="modal-title" id="exampleModalLabel">Dokumen Unit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form method="post" action="<?=site_url('DokumenUnit/edit')?>">
      <div class="modal-body">
          <input type="hidden" class="form-control" id="id_edit" name="id">
          <div class="mb-3">
            <label for="nama_unit" class="col-form-label">Nama Unit</label>
            <input type="text" class="form-control" id="nama_unit_edit" name="nama_unit" required>
          </div>
          <div class="mb-3">
            <label for="id_item" class="col-form-label">Nama Item</label>
            <select class="form-control " id="id_item_edit" name="id_item" required>
                    <option value="">-- Pilih Nama Item --</option>
                    <?php
                        foreach($nama_dokumen_item as $ndk) {
                    ?>
                    <option value="<?=$ndk->id_item?>"><?=$ndk->nama_kategori?> | <?=$ndk->nama_item?></option>
                    <?php
                        }
                    ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="col-form-label">Status</label>
            <select class="form-control" id="status_edit" name="status" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="AKTIF">AKTIF</option>
                    <option value="NO AKTIF">NO AKTIF</option>
            </select>
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
      <form method="post" action="<?=site_url('DokumenUnit/hapus')?>">
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
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
  });
  var editModal = document.getElementById('editModal')
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
    
    $.ajax({
        type: "GET",
        url: site_url + "/DokumenUnit/get_by_id/" + id,  
        dataType: 'json',
        success: 
             function(data){
              //  alert(data);  //as a debugging message.
              document.getElementById('id_edit').value = data.id_unit;
             document.getElementById('id_item_edit').value = data.id_item;
             document.getElementById('nama_unit_edit').value = data.nama_unit;
             document.getElementById('status_edit').value = data.status;
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
          
      
      