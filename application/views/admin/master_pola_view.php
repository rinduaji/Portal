<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Manage Master Pola</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
              <nav class="navbar navbar-light bg-light justify-content-between">
                <p style="padding-left: 1.5rem;padding-top: 0.75rem"><a href="<?=site_url('MasterPola/add')?>" class="btn btn-primary btn-sm mb-2 "><i class="fa fa-plus-circle"></i>&nbsp;Add</a></p>
                <form class="form-inline" method="post" action="<?=site_url('MasterPola/index')?>">
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
              
              if(empty($data_master_pola)) {
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POLA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">MASUK</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PULANG</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 1</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 2</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 3</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 4</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">UPD</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach($data_master_pola as $data) {
                    ?>
                    <tr>
                      <td style="padding: 0.75rem 1.5rem;">
                        <span class="text-secondary text-xs font-weight-bold"><?=++$start?></span>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->pola?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->masuk?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->pulang?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->ist1?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->ist2?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->ist3?></p>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?=$data->ist4?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->upd?></p>
                      </td>
                      <td class="align-middle text-center">
                        <a href="<?=site_url('MasterPola/add/')?><?=$data->id?>" class="btn btn-small" type="button"><i class="fas fa-edit"></i> Edit</a>  
                        <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal"  data-id="<?=$data->id?>"><i class="fas fa-trash"></i> Hapus</a>
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
   
<!-- Modal -->
<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" action="<?=site_url('MasterPola/hapus')?>">
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
          
      
      