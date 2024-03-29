<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Execute CCM</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
              <nav class="navbar navbar-light bg-light justify-content-between">
                <!-- <p style="padding-left: 1.5rem;padding-top: 0.75rem"><button class="btn btn-primary btn-sm mb-2 " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa fa-plus-circle"></i>&nbsp;Add</button></p> -->
                <form class="form-inline" method="post" action="<?=site_url('ExecuteCCM/index')?>">
                  <label>Tanggal Awal &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_awal" id="date_awal" autocomplete="off">
                  <label>Tanggal Akhir &nbsp;&nbsp;</label>
                  <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                  <label for="status">Status &nbsp;&nbsp;</label>
                  <select class="form-control mr-sm-2" name="status" id="status">
                    <option value="">ALL STATUS</option>
                    <option value="AKTIF">AKTIF</option>
                    <option value="TIDAK AKTIF">TIDAK AKTIF</option>
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
              
              if(empty($data_list_ccm)) {
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Username</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jabatan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Pen CCM</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Mulai</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Akhir</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pelanggaran</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Pelanggaran</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Keterangan</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Detail</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // print_r($data_list_ccm);
                    foreach($data_list_ccm as $data) {
                    ?>
                    <tr>
                      <td style="padding: 0.75rem 1.5rem;">
                        <span class="text-center text-xs font-weight-bold"><?=++$start?></span>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=$data->username?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=$data->nama_anak?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=$data->user3?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=$data->nama_tl?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=date("d F y",strtotime($data->tgl_mulai))?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=date("d F y",strtotime($data->tgl_akhir))?></p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold"><?=$data->kode?></p>
                      </td>
                      
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0">
                        <span class="badge badge-sm bg-gradient-success">
                          <?php
                            if($data->status == 0) {
                              echo "NEED APPROVE BY AGENT";
                            }
                            elseif($data->status == 1) {
                              echo "NEED APPROVE BY TL";
                            }
                            elseif($data->status == 2) {
                              echo "NEED APPROVE BY SPV";
                            }
                            elseif($data->status == 3) {
                              echo "NEED APPROVE BY MANAGER";
                            }
                            elseif($data->status == 4) {
                              echo "NEED VERIFIKASI";
                            }
                            elseif($data->status == 5) {
                              echo "DONE";
                            }
                          ?>
                          </span>
                        </p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0">
                        
                        <?php
                            $date_now = date("Y-m-d");
                            if($data->tgl_akhir < $date_now) {
                              echo '<span class="badge badge-sm bg-gradient-danger">TIDAK AKTIF</span>';
                            }
                            else {
                              echo '<span class="badge badge-sm bg-gradient-success">AKTIF</span>';
                            }
                          ?>
                        </p>
                      </td>
                      <td>
                        <p class="text-center text-xs font-weight-bold mb-0"><?=strtoupper($data->kode)?> <?=strtoupper($data->level)?> </p>
                      </td>
                      <td>
                        <a href="<?=site_url('ReportCCM/detailCCM/'.$data->id)?>" class="pull-right btn btn-warning btn-large my-2 my-sm-0" style="float:left;margin-left:10px" type="button" ><i class="fa fa-info-circle"></i> Detail CCM</a>  
                      </td>
                      <td class="align-middle text-center">
                        <?php
                          $tanggal_sekarang = date("Y-m-d");
                          
                          if($tanggal_sekarang < $data->tgl_akhir) {
                            if($data->status == 0) {
                              if($hasil_jabatan == "AGENT" || $hasil_jabatan == "INPUTER") {
                              ?>
                              <a href="<?=site_url('ExecuteCCM/ApproveAgent/').$data->id?>" class="btn btn-small btn-info" type="button"><i class="fas fa-edit"></i>Komitmen Agent</a>  
                              <?php
                              }
                              else {
                                echo "-";
                              }
                            }
                            elseif($data->status == 1) {
                              if($hasil_jabatan == "TL" || $hasil_jabatan == "TL INPUTER") {
                              ?>
                              <a href="<?=site_url('ExecuteCCM/ApproveTL/').$data->id?>" class="btn btn-small btn-info" type="button"><i class="fas fa-edit"></i> Approve Team Leader</a>  
                              <?php
                              }
                              else {
                                echo "-";
                              }
                            }
                            elseif($data->status == 2) {
                              if($hasil_jabatan == "SUPERVISOR") {
                              ?>
                              <a href="<?=site_url('ExecuteCCM/ApproveSPV/').$data->id?>" class="btn btn-small btn-info" type="button"><i class="fas fa-edit"></i> Approve SPV</a>  
                              <?php
                              }
                              else {
                                echo "-";
                              }
                            }
                            elseif($data->status == 3) {
                              if($hasil_jabatan == "MANAGER") {
                              ?>
                              <a href="<?=site_url('ExecuteCCM/ApproveManager/').$data->id?>" class="btn btn-small btn-info" type="button"><i class="fas fa-edit"></i> Approve Manager</a>  
                              <?php
                              }
                              else {
                                echo "-";
                              }
                            }
                            elseif($data->status == 4) {
                            //   print_r($data);
                              if(isset($data->spv)) {
                                if($data->spv == $this->session->userdata('user_id')) {
                              ?>
                              <a href="<?=site_url('ExecuteCCM/Verifikasi/').$data->id?>" class="btn btn-small btn-info" type="button"><i class="fas fa-edit"></i> Verifikasi</a>  
                              <?php
                                }
                              }
                              else {
                                echo "-";
                              }
                            }
                            else {
                              echo "-";
                            }
                          }
                          else {
                            echo "-";
                          }
                        ?>
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
            <label for="id_item" class="col-form-label">Nama Item Kategori</label>
            <select class="form-control" id="id_item" name="id_item" required>
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
          <input type="text" class="form-control" id="id_edit" name="id">
          <div class="mb-3">
            <label for="id_item" class="col-form-label">Nama Item Kategori</label>
            <select class="form-control" id="id_item_edit" name="id_item" required>
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
          
      
      