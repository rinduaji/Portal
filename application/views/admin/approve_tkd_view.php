
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Report TKD</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
                <nav class="navbar navbar-light bg-light mb-4">
                    <form class="form-inline" method="post" action="<?=site_url('ApproveTkd/index')?>">
                        <label>Tanggal TKD &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" min="<?=$tanggal_start?>" name="date" id="date" autocomplete="off">
                        <!-- <label>Tanggal Akhir &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                        <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus> -->
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="search" value="1">Search</button>
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
                ?>
              <div class="table-responsive p-0" >
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">TANGGAL</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LOGIN PEMOHON</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NAMA PEMOHON</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POLA PEMOHON</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LOGIN TERMOHON</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NAMA TERMOHON</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POLA TERMOHON</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">STATUS</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // print_r($data_tampil);
                    $no = 0;
                    $page = 1;
                    
                    // print_r($data_tampil2);
                    if(!empty($data_tampil2)) {
                        while($no < COUNT($data_tampil)) {
                        ?>
                                <tr class="active">
                                    <td style="padding: 0.75rem 1.5rem;" rowspan="2">
                                        <span class="text-secondary text-xs font-weight-bold"><?=$page?></span>
                                    </td>
                                    <?php
                                        
                                        if($totalCekPemohon != "0") {
                                    ?>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y",strtotime($data_tampil[$no]['tgl']))?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['loginTermohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['termohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pola_termohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['loginPemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pola_pemohon']?></p>
                                    </td>
                                    <td rowspan="2">
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['status']?></p>
                                    </td>
                                    <?php
                                        }
                                        else {
                                    ?>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y",strtotime($data_tampil[$no]['tgl']))?></p>
                                                </td>
                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['loginPemohon']?></p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pemohon']?></p>
                                            </td>
                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pola_pemohon']?></p>
                                            </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['loginTermohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['termohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pola_termohon']?></p>
                                        </td>
                                        <td rowspan="2">
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['status']?></p>
                                        </td>
                                    <?php
                                        }
                                    ?>
                                    <td rowspan="2">
                                        <?php
                                        // print_r($totalCekPemohon.' '.$totalCekPemohon2);
                                        if($totalCekPemohon == "0" && $totalCekPemohon2 == "0") {
                                        ?>
                                        <form class="form-inline" method="post" action="<?=site_url('ApproveTkd/approvalTkd')?>">
                                            <input type='hidden' name='login_termohon1' value="<?=$data_tampil[$no]['loginTermohon']?>"/>
                                            <input type='hidden' name='login_pemohon1' value="<?=$data_tampil[$no]['loginPemohon']?>"/>
                                            <input type='hidden' name='tanggal_app1' value="<?=$data_tampil[$no]['tgl']?>"/>
                                            <input type='hidden' name='polaTermohon1' value="<?=$data_tampil[$no]['pola_pemohon']?>"/>
                                            <input type='hidden' name='polaPemohon1' value="<?=$data_tampil[$no]['pola_termohon']?>"/>
                                            <input type='hidden' name='login_termohon2' value="<?=$data_tampil2[$no]['loginTermohon']?>"/>
                                            <input type='hidden' name='login_pemohon2' value="<?=$data_tampil2[$no]['loginPemohon']?>"/>
                                            <input type='hidden' name='tanggal_app2' value="<?=$data_tampil2[$no]['tgl']?>"/>
                                            <input type='hidden' name='polaTermohon2' value="<?=$data_tampil2[$no]['pola_pemohon']?>"/>
                                            <input type='hidden' name='polaPemohon2' value="<?=$data_tampil2[$no]['pola_termohon']?>"/>
                                            <button type="submit" class="btn btn-info" name="buttonAppTKD" value="ReqAppTKD">Approve</button>
                                        </form>
                                        <?php
                                        }
                                        ?>
                                        <form class="form-inline" method="post" action="<?=site_url('ApproveTkd/rejectedTkd')?>">
                                            <input type='hidden' name='login_termohon1' value="<?=$data_tampil[$no]['loginTermohon']?>" />
											<input type='hidden' name='login_pemohon1' value="<?=$data_tampil[$no]['loginPemohon']?>" />
											<input type='hidden' name='tanggal_app1' value="<?=$data_tampil[$no]['tgl']?>" />
											<input type='hidden' name='polaTermohon1' value="<?=$data_tampil[$no]['pola_pemohon']?>" />
											<input type='hidden' name='polaPemohon1' value="<?=$data_tampil[$no]['pola_termohon']?>" />
											<input type='hidden' name='login_termohon2' value="<?=$data_tampil2[$no]['loginTermohon']?>" />
											<input type='hidden' name='login_pemohon2' value="<?=$data_tampil2[$no]['loginPemohon']?>" />
											<input type='hidden' name='tanggal_app2' value="<?=$data_tampil2[$no]['tgl']?>" />
											<input type='hidden' name='polaTermohon2' value="<?=$data_tampil2[$no]['pola_pemohon']?>" />
											<input type='hidden' name='polaPemohon2' value="<?=$data_tampil2[$no]['pola_termohon']?>" />
                                            <button type="submit" class="btn btn-primary" name="buttonRejectTKD" value="ReqRejectTKD">Reject</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                        if($totalCekPemohon2 != "0") {
                                    ?>  
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y",strtotime($data_tampil2[$no]['tgl']))?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['loginPemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['pemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['pola_pemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['loginTermohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['termohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['pola_termohon']?></p>
                                    </td>
                                    <?php
                                        }
                                        else {
                                    ?>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y",strtotime($data_tampil2[$no]['tgl']))?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['loginTermohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['termohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['pola_termohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['loginPemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['pemohon']?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?=$data_tampil2[$no]['pola_pemohon']?></p>
                                    </td>
                                    <?php
                                        }
                                    ?>

                                </tr>
                    <?php
                                $no++;
                                $page++;
                                }
                            }
                            else {
                                $page=1;
                                $no = 0;
                                if(isset($data_tampil)){
                                    while($no < COUNT($data_tampil)) {
                          
                    ?>
                                    <tr class="active">
                                        <td style="padding: 0.75rem 1.5rem;">
                                            <span class="text-secondary text-xs font-weight-bold"><?=$page?></span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=date("l, d F Y",strtotime($data_tampil[$no]['tgl']))?></p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['loginPemohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pemohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pola_pemohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['loginTermohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['termohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['pola_termohon']?></p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0"><?=$data_tampil[$no]['status']?></p>
                                        </td>
                                        <td>
                                            <?php
                                            if($login != $data_tampil[$no]['loginPemohon']) {
                                                // print_r(site_url('ApproveTkd/approvalTkd'));
                                                ?>
                                                <form class="form-inline" method="post" action="<?=site_url('ApproveTkd/approvalTkd')?>">
                                                    <input type='hidden' name='login_termohon1' value="<?=$data_tampil[$no]['loginTermohon']?>" />
													<input type='hidden' name='login_pemohon1' value="<?=$data_tampil[$no]['loginPemohon']?>" />
													<input type='hidden' name='tanggal_app1' value="<?=$data_tampil[$no]['tgl']?>" />
													<input type='hidden' name='polaTermohon1' value="<?=$data_tampil[$no]['pola_pemohon']?>" />
													<input type='hidden' name='polaPemohon1' value="<?=$data_tampil[$no]['pola_termohon']?>" />
                                                    <button type="submit" class="btn btn-info" name="buttonAppTKD" value="ReqAppTKD">Approve</button>
                                                </form>
                                            <?php
                                            }
                                            ?>
                                            <form class="form-inline" method="post" action="<?=site_url('ApproveTkd/rejectedTkd')?>">
                                                    <input type='hidden' name='login_termohon1' value="<?=$data_tampil[$no]['loginTermohon']?>"/>
													<input type='hidden' name='login_pemohon1' value="<?=$data_tampil[$no]['loginPemohon']?>"/>
													<input type='hidden' name='tanggal_app1' value="<?=$data_tampil[$no]['tgl']?>"/>
													<input type='hidden' name='polaTermohon1' value="<?=$data_tampil[$no]['pola_pemohon']?>"/>
													<input type='hidden' name='polaPemohon1' value="<?=$data_tampil[$no]['pola_termohon']?>"/>
                                                    <button type="submit" class="btn btn-primary" name="buttonRejectTKD" value="ReqRejectTKD">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                        $no++;
                                        $page++;
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



          
      
      