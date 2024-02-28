<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Inbox</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
              <nav class="navbar navbar-light bg-light justify-content-between">
                <?php
                if($jb_user[0] == "ADMIN" || $jb_user[0] == "TL" || $jb_user[0] == "SUPERVISOR" || $jb_user[0] == "MANAGER" || $jb_user[0] == "DUKTEK") {
                ?>
                    <p style="padding-left: 1.5rem;padding-top: 0.75rem"><a href="<?=site_url('Inbox/add')?>" class="btn btn-primary btn-sm mb-2 "><i class="fa fa-plus-circle"></i>&nbsp;Add</a></p>
                <?php
                }
                ?>
                <form class="form-inline" method="post" action="<?=site_url('Inbox/index')?>">
                  <label>Tanggal Awal &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_awal" id="date_awal" autocomplete="off">
                  <label>Tanggal Akhir &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                  <select class="form-control mr-sm-2" name="filter" id="filter">
                    <?php
                    if($jb_user[0] == "ADMIN" || $jb_user[0] == "TL" || $jb_user[0] == "SUPERVISOR" || $jb_user[0] == "MANAGER" || $jb_user[0] == "DUKTEK") {
                    ?>
                    <option value="KIRIM INBOX">PENGIRIM INBOX</option>
                    <option value="BLAST INBOX">BLAST INBOX</option>
                    <option value="PRIVATE INBOX">PRIVATE INBOX</option>
                    <?php
                    }
                    else {
                    ?>
                    <option value="BLAST INBOX">BLAST INBOX</option>
                    <option value="PRIVATE INBOX">PRIVATE INBOX</option>
                    <?php
                    }
                    ?>
                  </select>
                  <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus>
                  <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="btnSearch" value="btnSearch">Search</button>
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
              
                if($btnSearch == NULL) {
                }
                else {
                  if(empty($data_inbox)) {
                  ?>
                  <div class="alert alert-danger" role="alert" style="color: white;">
                    Data Tidak Ditemukan!
                  </div>
                  <?php
                  }
                }
                ?>
                <div class="card-header pb-0">
                  <h6>Total Data : <?=(!empty($total_data)) ? $total_data : '0'?></h6>
                </div>
              <div class="table-responsive p-0" >
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Topik</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Inbox</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Inbox</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Inbox</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gambar Profile</th> -->
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama File Dokumen</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th> -->
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(!empty($data_inbox)) {
                      foreach($data_inbox as $data) {
                    ?>
                    <tr>
                      <td style="padding: 0.75rem 1.5rem;">
                        <span class="text-secondary text-xs font-weight-bold"><?=++$start?></span>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->judul?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->topik?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->tanggal?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->upd?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->jenis?></p>
                      </td>
                      <!-- <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><a href="<?=base_url('uploads/gambar/inbox/')?><?=($data->image != NULL)? $data->image : 'no_image.jpg'?>" target="_blank"><img src="<?=base_url('uploads/gambar/inbox/')?><?=($data->image != "")? $data->image : 'no_image.jpg'?>" width="100px" height="100px"></img></a></p>
                      </td> -->
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php if($data->file_inbox != "") { ?><a href="<?=base_url('uploads/file/inbox/').$data->file_inbox?>" class="btn btn-info btn-small" type="button"><i class="fa fa-download"></i>&nbsp;<?=$data->file_inbox?></a><?php } ?></p>
                      </td>
                      <!-- <td class="align-middle text-center text-sm">
                        <?php
                        if($data->status == "AKTIF") {
                        ?>
                          <span class="badge badge-sm bg-gradient-success"><?=$data->status?></span>
                        <?php
                        }
                        else if($data->status == "NO AKTIF") {
                        ?>
                          <span class="badge badge-sm bg-gradient-danger"><?=$data->status?></span>
                        <?php
                        }
                        ?>
                      </td> -->
                      <td class="align-middle text-center">
                        <a href="<?=site_url('Inbox/detail/')?><?=$data->id_inbox?>" class="btn btn-small" type="button"><i class="fa fa-info-circle"></i> Detail</a>  
                        <?php
                        if($jb_user[0] == "ADMIN" || $jb_user[0] == "TL" || $jb_user[0] == "SUPERVISOR" || $jb_user[0] == "MANAGER" || $jb_user[0] == "DUKTEK") {
                        ?>
                        <a href="<?=site_url('Inbox/add/')?><?=$data->id_inbox?>" class="btn btn-small" type="button"><i class="fas fa-edit"></i> Edit</a>  
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal"  data-id="<?=$data->id_inbox?>"><i class="fas fa-trash"></i> Hapus</a>
                      <?php
                        }
                      ?>
                      </td>
                    </tr>
                    <?php
                      }
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
   
<!-- Modal -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?=site_url('Inbox/hapus')?>">
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
          
      
      