
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Report Absensi</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
                <nav class="navbar navbar-light bg-light mb-4">
                    <form class="form-inline" method="post" action="<?=site_url('ReportAbsensi/index')?>">
                        <label>Tanggal Awal &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" name="date_awal" id="date_awal" autocomplete="off">
                        <label>Tanggal Akhir &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                        <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus>
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="btnSearch">Search</button>
                    </form>
                </nav>
              <div class="table-responsive p-0" >
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TANGGAL</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LOGIN</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NAMA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">JABATAN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">AREA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POLA</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">JAM ABSEN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">KETERANGAN</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TERLAMBAT</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    if(!empty($data_report_absensi)) {
                        foreach($data_report_absensi as $data) {
                            // print_r($data->masuk);
                            $date_sub = date("Y-m-d")." ".$data->masuk.":00";	
                            $dateBegin = date("Y-m-d H:i:s", strtotime($data->date_absen));
                            $dateEnd = date("Y-m-d H:i:s", strtotime($date_sub));
                            if($dateBegin > $dateEnd){									
                                $datetime1 = new DateTime($date_sub);
                                $datetime2 = new DateTime($data->date_absen);
                                $interval = $datetime2->diff($datetime1);
                                $elapsed = $interval->format('%h Jam %i Menit %s Detik');
                            }
                            else {
                                $elapsed = "TIDAK TERLAMBAT";
                            }
                            
                            if($data->keterangan == "IN") {
                        ?>
                                <tr class="active">
                                <td style="padding: 0.75rem 1.5rem;">
                                    <span class="text-secondary text-xs font-weight-bold"><?=$no?></span>
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
                                    <p class="text-xs font-weight-bold mb-0"><?=date("H:i:s", strtotime($data->date_absen))?></p>
                                </td>
                                <td>
                                    <p class="text-center text-xs font-weight-bold mb-0"><?=$data->keterangan." || Jam Masuk (".$data->masuk.":00) || JamPulang (".$data->pulang.":00)"?></p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0"><?=$elapsed?></p>
                                </td>
                            </tr>
                            <?php
                            }
                            else if($data->keterangan == "OUT") {
                            ?>
                            <tr class="active">
                                    <td style="padding: 0.75rem 1.5rem;">
                                        <span class="text-secondary text-xs font-weight-bold"><?=$no?></span>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y",strtotime($data->tgl_masuk))?></p>
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
                                        <p class="text-xs font-weight-bold mb-0"><?=date("H:i:s", strtotime($data->date_absen))?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data->keterangan." || Jam Masuk (".$data->masuk.":00) || JamPulang (".$data->pulang.":00)"?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">-</p>
                                    </td>
                                </tr>
                            <?php
                            }	
                            $no++;
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



          
      
      