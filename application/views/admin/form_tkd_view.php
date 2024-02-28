
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Report TKD</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
                <nav class="navbar navbar-light bg-light mb-4">
                    <div>
                        <h6> Pilih Tanggal TKD</h6>
                    </div>
                    <form class="form-inline" method="post" action="<?=site_url('FormTkd/index')?>">
                        <label>Tanggal TKD &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" min="<?=$tanggal_start?>" name="date_tkd" id="date_tkd" autocomplete="off">
                        <!-- <label>Tanggal Akhir &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" min="<?=$tanggal_start?>" name="date_akhir" id="date_akhir" autocomplete="off">
                        <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus> -->
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="btnSearchTglTkd" value="1">Search</button>
                    </form>
                </nav>
                <?php
                // print_r($tampil_pola);
                if(!empty($tampil_pola)) {
                   foreach($tampil_pola as $tp) {
                ?>
                <nav class="navbar navbar-light bg-light mb-4">
                    <h6> Pilih Tukar Pola</h6>
                    <form class="form-inline" method="post" action="<?=site_url('FormTkd/index')?>">
                        
                        <input class="form-control mr-sm-2" type="hidden" name="id" id="id" value="<?=$tp->id?>" />
                        <label>Tanggal TKD &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="input" name="date_cari" id="date_cari" autocomplete="off" value="<?=$tp->tgl_masuk?>" readonly>
                        <label>Pola Anda &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="input" name="pola_anda" id="pola_anda" autocomplete="off" value="<?=$tp->pola?>" readonly>
                        <label for="pola_tukar">Pola Tukar &nbsp;&nbsp;</label>
                        <select class="form-control mr-sm-2" name="pola_tukar" id="pola_tukar">
                            <option value="">-- Pilih Pola Tukar --</option>
                            <?php
                            if(!empty($tampil_pola_tukar)) {
                                if($tp->pola != "CT") {
                                    foreach($tampil_pola_tukar as $tpk) {
                                        if($tpk->pola != "CT" && $tp->pola != $tpk->pola) {
                            ?>
                                            <option value="<?=$tpk->pola?>"><?=$tpk->pola?> || <?=$tpk->masuk?> || <?=$tpk->pulang?></option>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </select>
                        <button class="btn btn-outline-danger my-2 my-sm-0" type="submit" name="btnSearch" value="1">Search</button>
                       
                        <!-- <label>Tanggal Akhir &nbsp;&nbsp;</label>
                        <input class="form-control mr-sm-2" type="date" name="date_akhir" id="date_akhir" autocomplete="off">
                        <input class="form-control mr-sm-2" type="search" name="cari" placeholder="Cari..." aria-label="Search" autocomplete="off" autofocus> -->
                    </form>
                </nav>
                <?php
                   }
                }
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
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LOGIN</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NAMA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">JABATAN</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">AREA</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">POLA</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ACTION</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $no_js = 0;
                    $data_js[0]['login'] = "";
                    $data_js[0]['id'] = "";
                    if(!empty($tampil_rooster_tkd)) {
                        foreach($tampil_rooster_tkd as $data) {
                            $data_js[$no_js]['login'] = $data->user1;
                            $data_js[$no_js]['id'] = $data->id;
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
                                    <?php
                                        if($data->pola == 'X') {
                                    ?>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal<?=$data->id?>">Request TKD Libur</button>
                                    </td>
                                    <?php
                                        }
                                        else if($pola_anda == 'X'){
                                    ?>
                                    <td>
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalLibur<?=$data->id?>">Request TKD Libur</button>
                                    </td>
                                    <?php
                                            }
                                            else {
                                    ?>
                                    <td>
                                        <form method="POST" action="<?=site_url('FormTkd/tkdRooster')?>">
                                            <input type='hidden' name='id_termohon' value="<?=$data->id?>"/>
                                            <input type='hidden' name='id_pemohon' value="<?=$id2?>"/>
                                            <input type='hidden' name='login_pemohon' value="<?=$username?>"/>
                                            <input type='hidden' name='login_termohon' value="<?=$data->user1?>"/>
                                                
                                            <button class="btn btn-primary" name="buttonTKD" value="ReqTKD">Request TKD</button>
                                        </form>
                                    </td>
							    </tr>
                                <?php
										}
                                ?>
                                <!-- Modal -->
											<div class="modal fade" id="myModal<?=$data->id?>" role="dialog" tabindex="-1" role="dialog" aria-labelledby="Form TKD Libur" aria-hidden="true" data-backdrop="false">
												<div class="modal-dialog">
												
													<!-- Modal content-->
													<div class="modal-content">
													<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Form Libur TKD</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<form method="POST" action="<?=site_url('FormTkd/tkdLibur')?>" id="FormRekom_qa">
																		<div class="modal-body">
																			<div class="form-group">
																			<input type='hidden' name='id_termohon' value='<?=$data->id?>'/>
																			<input type='hidden' name='id_pemohon' value='<?=$id2?>'/>
																			<input type='hidden' name='login_pemohon' value='<?=$username?>'/>
																			<input type='hidden' name='login_termohon' value='<?=$data->user1?>'/>
																			<input type='hidden' name='tgl_libur_termohon' value='<?=$data->tgl_masuk?>'/>
																				<div class="form-group">
																					<label for="tgl_libur_pemohon">Tanggal Libur Pemohon</label>
																				    <select class="form-control" name="tgl_libur_pemohon">
																					    <option value="">-- Pilih Tanggal --</option>
                                                                                        <?php
                                                                                        foreach($tampil_data_libur as $tdl) {
                                                                                        ?>
                                                                                        <option value="<?=$tdl->tgl_masuk?>"><?=$tdl->tgl_masuk?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
																				    </select>
																				</div>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="submit" class="btn btn-primary">Save</button>
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																		</div>
																	</form>
													</div>
													
												</div>
											</div>

											<!-- Modal -->
											<div class="modal fade" id="myModalLibur<?=$data->id?>" role="dialog" tabindex="-1" role="dialog" aria-labelledby="Form TKD Libur" aria-hidden="true" data-backdrop="false">
												<div class="modal-dialog">
												
													<!-- Modal content-->
													<div class="modal-content">
													<div class="modal-header">
																		<h5 class="modal-title" id="exampleModalLabel">Form Libur TKD</h5>
																		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<form method="POST" action="<?=site_url('FormTkd/tkdLibur')?>" id="FormRekom_qa">
																		<div class="modal-body">
																			<div class="form-group">
																			<input type='hidden' name='id_termohon' value='<?=$data->id?>'/>
																			<input type='hidden' name='id_pemohon' value='<?=$id2?>'/>
																			<input type='hidden' name='login_pemohon' value='<?=$username?>'/>
																			<input type='hidden' name='login_termohon' value='<?=$data->user1?>'/>
																			<input type='hidden' name='tgl_libur_termohon' value='<?=$data->tgl_masuk?>'/>
																				<div class="form-group">
																					<label for="tgl_libur_pemohon">Tanggal Libur Pemohon</label>
                                                                                    <?php
                                                                                    
?>
                                                                                    <select class="form-control" name="tgl_libur_pemohon" id ="tgl_libur_pemohon">
                                                                                        <option value="">-- Pilih Tanggal --</option>
                                                                                        <?php
                                                                                        // foreach($select_tanggal_option as $sto) {
                                                                                            echo $select_tanggal_option[$data->id];
                                                                                        // }
                                                                                        ?>
                                                                                    </select>
																				</div>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="submit" class="btn btn-primary">Save</button>
																			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																		</div>
																	</form>
													</div>
													
												</div>
											</div>

                            </tr>
                            <?php
                            $no++;
                            $no_js++;
                        }
                    }
                    // print_r($data_js);
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
                            <!-- <script type="text/javascript">
                                $(document).ready(function(){
                                    let tanggalTkd = "<?=$tanggal_tkd?>";
                                    let loginPilih = '';
                                    let data_js = [];
                                    if(tanggalTkd != '') {
                                        let login = "<?=$data_js[0]['login']?>";
                                        let id = "<?=$data_js[0]['id']?>";
                                        if(login != "" && id != "") {
                                            let total_data_rooster_tkd = "<?=COUNT($data_js)?>";
                                            let data_js = <?=json_encode($data_js)?>;
                                            // print_r(data_js);
                                            let data_option = [];
                                            let no = 0;
                                            while(no < total_data_rooster_tkd) {
                                                loginPilih = data_js[no]['login']; 
                                                idDataJs = data_js[no]['id']; 
                                                
                                                console.log(loginPilih);
                                                console.log(idDataJs);

                                                $.ajax({
                                                    url : "<?php echo site_url('FormTkd/get_data_libur');?>",
                                                    method : "POST",
                                                        data : {
                                                            tanggal: tanggalTkd,
                                                            login: data_js[no]['login']
                                                        },
                                                        dataType : 'json',
                                                        success: function(data){
                                                            let html = '<option value="">-- Pilih Tanggal --</option>';
                                                            let i;
                                                            for(i=0; i<data.length; i++){
                                                                html += '<option value="'+data[i].tgl_masuk+'">'+data[i].tgl_masuk+'</option>';
                                                                // console.log(html);
                                                            }
                                                            $(`#myModalLibur${data_js[no]['id']} #tgl_libur_pemohon`).html(html);
                                                        }
                                                    });
                                                //     return false;
                                                // }); 
                                                no++;
                                            }
                                        }
                                    }    
                                });
                            </script>
                             -->


          
      
      