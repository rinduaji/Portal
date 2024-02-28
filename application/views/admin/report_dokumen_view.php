
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Report Dokumen</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
                <nav class="navbar navbar-light bg-light mb-4">
                    <form class="form-inline" method="post" action="<?=site_url('ReportDokumen')?>">
                        <label for="kategori">Kategori Dokumen &nbsp;&nbsp;</label>
                        <select class="form-control mr-sm-2" name="kategori" id="kategori">
                            <option value="">-- Pilih Kategori Dokumen --</option>
                            <?php
                            foreach($nama_dokumen_kategori as $nk) {
                            ?>
                            <option value="<?=$nk->id_kategori?>"><?=$nk->nama_kategori?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </nav>
              <div class="table-responsive p-0" >
                <?php
                if($nama_kategori != null) {
                ?> 
                <div class="px-3 pt-0 pb-4"><h5><?=$nama_kategori->nama_kategori?></h5></div>
                <?php
                }
                ?>
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kode Dokumen</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Berlaku</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Dokumen</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Old Version</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Used Version</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Verifikasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $huruf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                    $huruf1 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                    
                    $angka = 0;
                    $no = 1;
                    $angka1 = 1;
                    $no1 = 1;
                    $no_unit = 0;
                    $nama_item = null;
                    $kode_dokumen = null;
                    $nama_unit = null;
                    $id_item = NULL;
                    $id_unit = NULL;
                    if(isset($data_tingkat)) {
                      if($data_tingkat == 2) {
                        if(!empty($data_report_dokumen)) {
                            foreach($data_report_dokumen as $data) {
                                if($nama_item == null OR $nama_item != $data->nama_item) {
                                    $nama_item = $data->nama_item;
                                ?>
                                <tr class="success">
                                    <td style="padding: 0.75rem 1.5rem;">
                                        <span class="text-xs font-weight-bold" style="color:red"><?=$huruf[$angka]?></span>
                                    </td>
                                    <td colspan="6">
                                        <p class="text-xs font-weight-bold mb-0" style="color:red"><?=$data->nama_item?></p>
                                    </td>
                                </tr>
                                <?php
                                    $angka++;
                                    $no=1;
                                }
                                if(($kode_dokumen == null OR $kode_dokumen != $data->kode_dokumen)) {
                                    $kode_dokumen = $data->kode_dokumen;
                            ?>
                                <tr class="active">
                                    <td style="padding: 0.75rem 1.5rem;">
                                        <span class="text-secondary text-xs font-weight-bold"><?=$no?></span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data->kode_dokumen?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y", strtotime($data->tanggal_berlaku))?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data->judul_dokumen?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=($data->old_version >= 0) ? 'Rev. '.$data->old_version : ''?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><a href="<?=base_url('uploads/dokumen/').$data->file_dokumen?>" target="_blank" class="btn btn-info btn-small" type="button"><i class="fa fa-download"></i>&nbsp;Rev. <?=$data->used_version?></a></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=date("l, d F Y", strtotime($data->tanggal_verifikasi))?></p>
                                    </td>
                                </tr>
                            <?php
                                    $no++;
                                }
                            }
                        }
                      }
                      elseif($data_tingkat == 3) {
                        if(!empty($data_report_dokumen_t3)) {
                          foreach($data_report_dokumen_t3 as $data_t3) {
                              // print_r($data_t3);
                              if($nama_item == null OR $nama_item != $data_t3->nama_item) {
                                  $nama_item = $data_t3->nama_item;
                              ?>
                              <tr class="success">
                                  <td style="padding: 0.75rem 1.5rem;">
                                      <span class="text-xs font-weight-bold" style="color:red"><?=$huruf[$angka]?></span>
                                  </td>
                                  <td colspan="6" style="padding: 0.75rem 1.5rem;">
                                      <p class="text-xs font-weight-bold mb-0" style="color:red"><?=$data_t3->nama_item?></p>
                                  </td>
                              </tr>
                              <?php
                                  $angka++;
                                  $no=1;
                              }
                              if($nama_unit == null OR $nama_unit != $data_t3->nama_unit) {
                                $nama_unit = $data_t3->nama_unit;
                                if($id_item == NULL) {
                                  $id_item = $data_t3->id_item;
                                  $angka1=1;
                                  // print_r($id_item);
                                }
                                elseif($id_item == $data_t3->id_item) {
                                  $id_item = $data_t3->id_item;
                                  $angka1++;
                                  // print_r($id_item);
                                  $no1=1;
                                }
                                else {
                                  // $angka1 = 0;
                                  $angka1 = 1;
                                  // print_r($id_item);
                                }
                                
                              ?>
                              <tr class="success">
                                  <td style="padding: 0.75rem 2rem;">
                                      <!-- <span class="text-xs font-weight-bold" style="color:blue"><?=$angka1?></span> -->
                                  </td>
                                  <td colspan="6" style="padding: 0.75rem 2rem;">
                                      <p class="text-xs font-weight-bold mb-0" style="color:blue"><i><?=$data_t3->nama_unit?><i></p>
                                  </td>
                              </tr>
                              <?php
                                
                              }
                              if(($kode_dokumen == null OR $kode_dokumen != $data_t3->kode_dokumen)) {
                                  $kode_dokumen = $data_t3->kode_dokumen;
                                  
                                  if($id_unit == NULL) {
                                    $id_unit = $data_t3->nama_unit;
                                    $no_unit++;
                                  }
                                  elseif($id_unit == $data_t3->nama_unit) {
                                    $no_unit++;
                                  }
                                  else{
                                    $no_unit = 1;
                                  }
                          ?>
                              <tr class="active">
                                  <td style="padding: 0.75rem 2.5rem;">
                                      <span class="text-secondary text-xs font-weight-bold"><?=$no_unit?></span>
                                  </td>
                                  <td style="padding: 0.75rem 2.5rem;">
                                      <p class="text-xs font-weight-bold mb-0"><?=$data_t3->kode_dokumen?></p>
                                  </td>
                                  <td>
                                      <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y", strtotime($data_t3->tanggal_berlaku))?></p>
                                  </td>
                                  <td>
                                      <p class="text-xs font-weight-bold mb-0"><?=$data_t3->judul_dokumen?></p>
                                  </td>
                                  <td>
                                      <p class="text-xs font-weight-bold mb-0"><?=($data_t3->old_version >= 0) ? 'Rev. '.$data_t3->old_version : ''?></p>
                                  </td>
                                  <td>
                                      <p class="text-xs font-weight-bold mb-0"><a href="<?=base_url('uploads/dokumen/').$data_t3->file_dokumen?>" target="_blank" class="btn btn-info btn-small" type="button"><i class="fa fa-download"></i>&nbsp;Rev. <?=$data_t3->used_version?></a></p>
                                  </td>
                                  <td>
                                      <p class="text-center text-xs font-weight-bold mb-0"><?=date("l, d F Y", strtotime($data_t3->tanggal_verifikasi))?></p>
                                  </td>
                              </tr>
                          <?php
                                  
                              }
                          }
                        }
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>



          
      
      