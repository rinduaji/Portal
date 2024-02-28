
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Report Rooster</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
                <nav class="navbar navbar-light bg-light mb-4">
                    <form class="form-inline" method="post" action="<?=site_url('ReportRooster/index')?>">
                        <label>Tanggal Awal &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-1" type="date" name="date_awal" id="date_awal" autocomplete="off">
                        <label>Tanggal Akhir &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-1" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                        <?php
                        if($jabatan_user == 'TL 147' || $jabatan_user == 'TL INPUTER') {
                        ?>
                        <select class="form-control mr-sm-2" name="jabatan">
                          <option value="">-- All Jabatan --</option>
                          <?php
                          foreach($list_jabatan as $lj) {
                            if($lj->user3 == 'AGENT KOMPLAIN' ||
                            $lj->user3 == 'AGENT REFORMASI' ||
                            $lj->user3 == 'AGENT ENGLISH' ||
                            $lj->user3 == 'SOO' ||
                            $lj->user3 == 'INPUTER' ||
                            $lj->user3 == 'SUPPORT HC' ||
                            $lj->user3 == 'TL 147' || 
                            $lj->user3 == 'TL INPUTER') {
                            ?>
                          <option value="<?=$lj->user3?>"><?=$lj->user3?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                        <?php
                        }
                        elseif($jabatan_user == 'SUPERVISOR 147') {
                          ?>
                          <select class="form-control mr-sm-2" name="jabatan">
                            <option value="">-- All Jabatan --</option>
                        <?php
                            foreach($list_jabatan as $lj) {
                              if($lj->user3 == 'AGENT KOMPLAIN' ||
                              $lj->user3 == 'AGENT REFORMASI' ||
                              $lj->user3 == 'AGENT ENGLISH' ||
                              $lj->user3 == 'SOO' ||
                              $lj->user3 == 'INPUTER' ||
                              $lj->user3 == 'SUPPORT HC' || 
                              $lj->user3 == 'TL INPUTER' ||
                              $lj->user3 == 'TL 147' || 
                              $lj->user3 == 'SUPERVISOR 147') {
                              ?>
                            <option value="<?=$lj->user3?>"><?=$lj->user3?></option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                          <?php 
                        }
                        elseif($jabatan_user == 'DUKTEK' || $jabatan_user == 'ADMIN' || $jabatan_user == 'MANAGER') {
                          ?>
                          <select class="form-control mr-sm-2" name="jabatan">
                            <option value="">-- All Jabatan --</option>
                        <?php
                            foreach($list_jabatan as $lj) {
                            ?>
                            <option value="<?=$lj->user3?>"><?=$lj->user3?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <?php
                        }
                        else {
                          ?>
                          <select class="form-control mr-sm-2" name="jabatan">
                          <option value="">-- All Jabatan --</option>
                          <?php
                          foreach($list_jabatan as $lj) {
                            if($lj->user3 == 'AGENT KOMPLAIN' ||
                            $lj->user3 == 'AGENT REFORMASI' ||
                            $lj->user3 == 'AGENT ENGLISH' ||
                            $lj->user3 == 'SOO' ||
                            $lj->user3 == 'INPUTER' ||
                            $lj->user3 == 'SUPPORT HC') {
                            ?>
                          <option value="<?=$lj->user3?>"><?=$lj->user3?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                        <?php
                        }
                        ?>
                        <!-- <select class="form-control mr-sm-2" name="pola">
                          <option value="">-- All Pola --</option>
                          <?php
                          foreach($list_pola as $lp) {
                            ?>
                          <option value="<?=$lp->pola?>"><?=$lp->pola?></option>
                          <?php
                          }
                          ?> -->
                        <!-- </select> -->
                        <input class="form-control mr-sm-1" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus>
                        <button class="btn btn-outline-danger my-1 my-sm-0" type="submit" name="btnSearch" value="search">Search</button>
                        <?php
                        if($jabatan_user == 'ADMIN' || $jabatan_user == 'DUKTEK') {
                        ?>
                        <!-- <button class="pull-right btn btn-info btn-large my-2 my-sm-0" style="float:left;margin-left:10px" name="exportExcelJabatan" value="exportExcelJabatan"><i class="fa fa-file-excel-o"></i> &nbsp;Rooster Jabatan</button> -->
                        <button class="pull-right btn btn-info btn-large my-2 my-sm-0" style="float:left;margin-left:10px" name="exportExcelAsli" value="exportExcelAsli"><i class="fa fa-file-excel-o"></i> &nbsp;Rooster Asli</button>
                        <?php
                        }
                        ?>
                        <button class="pull-right btn btn-warning btn-large my-2 my-sm-0" style="float:left;margin-left:10px" name="exportExcel" value="exportExcel"><i class="fa fa-file-excel-o"></i>&nbsp; Rooster Update</button>
                    </form>
                </nav>
              <div class="table-responsive p-0" >
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PERIODE</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TANGGAL</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LOGIN</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NAMA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">JABATAN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">AREA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POLA</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">MASUK</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PULANG</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 1</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 2</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 3</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ISTIRAHAT 4</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">KETERANGAN <?=$this->session->userdata('jabatan')?></th>
                      <?php
                      if($this->session->userdata('jabatan') == 'ADMIN' || $this->session->userdata('jabatan') == 'DUKTEK'){
                      ?>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ACTION</th>
                      <?php
                      }
                      ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    if(!empty($data_report_rooster)) {
                        foreach($data_report_rooster as $data) {
                        ?>
                                <tr class="active">
                                <td style="padding: 0.75rem 1.5rem;">
                                    <span class="text-secondary text-xs font-weight-bold"><?=++$no?></span>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->periode?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=date("d F Y",strtotime($data->tgl_masuk))?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->user1?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->user2?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->user3?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->user5?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->pola?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->masuk?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->pulang?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->ist1?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->ist2?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->ist3?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->ist4?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$data->nama_tkd?></p>
                                </td>
                                  <?php
                                  if($this->session->userdata('jabatan') == 'ADMIN' || $this->session->userdata('jabatan') == 'DUKTEK'){
                                  ?>
                                <td class="align-middle text-center">
                                  <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#editModal"  data-id="<?=$data->id?>"><i class="fas fa-edit"></i> Edit</a>  
                                  <a class="btn btn-small" type="button" data-bs-toggle="modal" data-bs-target="#hapusModal"  data-id="<?=$data->id?>"><i class="fas fa-trash"></i> Hapus</a>
                                </td>
                                <?php
                                  }
                                  ?>
                            </tr>
                           <?php
                        }
                    }
                    ?>
                  </tbody>
                </table>
                <!-- <?=$this->pagination->create_links();?> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Rooster</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form method="post" action="<?=site_url('ReportRooster/edit')?>">
      <div class="modal-body">
          <input type="hidden" class="form-control" id="id_edit" name="id">
          <div class="mb-3">
            <label for="pola" class="col-form-label">Pola</label>
            <select class="form-control" id="pola_edit" name="pola" required>
                    <option value="">-- Pilih Pola --</option>
                    <?php
                    foreach($list_pola as $lp) {
                    ?>
                    <option value="<?=$lp->pola?>"><?=$lp->pola?></option>
                    <?php
                    }
                    ?>
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
      <form method="post" action="<?=site_url('ReportRooster/hapus')?>">
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
        url: site_url + "/DokumenKategori/get_by_id/" + id,  
        dataType: 'json',
        success: 
             function(data){
              //  alert(data);  //as a debugging message.
             document.getElementById('pola_edit').value = data.pola;
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
          




          
      
      