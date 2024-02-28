<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Risalah Rapat</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
              <nav class="navbar navbar-light bg-light justify-content-between">
                <?php
                if($jb_user[0] == "ADMIN" || $jb_user[0] == "DUKTEK" || $jb_user[0] == "DOCUMENT") {
                ?>
                    <p style="padding-left: 1.5rem;padding-top: 0.75rem"><a href="<?=site_url('RisalahRapat/add')?>" class="btn btn-primary btn-sm mb-2 "><i class="fa fa-plus-circle"></i>&nbsp;Add</a></p>
                <?php
                }
                ?>
                <form class="form-inline" method="post" action="<?=site_url('RisalahRapat/index')?>">
                  <label>Tanggal Awal &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_awal" id="date_awal" autocomplete="off">
                  <label>Tanggal Akhir &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                  <select class="form-control mr-sm-2" type="area" name="area" autocomplete="off" autofocus>
                    <option value="">ALL</option>
                    <option value="MALANG">MALANG</option>
                    <option value="SEMARANG">SEMARANG</option>
                  </select>
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
              
              if(empty($data_risalah_rapat)) {
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Judul Risalah Rapat</th>
                      <th class="text-center text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Posting</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama File Risalah Rapat</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Area</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">UPD</th>
                      <?php
                        if($jb_user[0] == "ADMIN" || $jb_user[0] == "DUKTEK" || $jb_user[0] == "DOCUMENT") {
                        ?>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        <?php
                        }
                        ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($data_risalah_rapat as $data) {
                    ?>
                    <tr>
                      <td style="padding: 0.75rem 1.5rem;">
                        <span class="text-secondary text-xs font-weight-bold"><?=++$start?></span>
                      </td>
                      <td>
                        <p class="text-center font-weight-bold mb-0"><?=$data->judul_risalah_rapat?></p>
                      </td>
                      <td>
                        <p class="text-center font-weight-bold mb-0"><?=date("l, d F Y", strtotime($data->tanggal_posting))?></p>
                      </td>
                      <td>
                        <p class="text-center font-weight-bold mb-0"><?php if($data->file_risalah_rapat != "") { ?><a href="<?=base_url('uploads/file/risalah_rapat/').$data->file_risalah_rapat?>" class="btn btn-info btn-small" type="button"><i class="fa fa-download"></i>&nbsp;<?=$data->file_risalah_rapat?></a><?php } ?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->area?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->upd?></p>
                      </td>
                        <?php
                        if($jb_user[0] == "ADMIN" || $jb_user[0] == "DUKTEK" || $jb_user[0] == "DOCUMENT") {
                        ?>
                      <td class="align-middle text-center">
                        <a href="<?=site_url('RisalahRapat/add/')?><?=$data->id_risalah_rapat?>" class="btn btn-small" type="button"><i class="fas fa-edit"></i> Edit</a>  
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal"  data-id="<?=$data->id_risalah_rapat?>"><i class="fas fa-trash"></i> Hapus</a>
                      </td>
                      <?php
                        }
                      ?>
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
   
<!-- Modal -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?=site_url('RisalahRapat/hapus')?>">
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
          
      
      