
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>News</h6>
            </div>
            <div class="card-body px-2 pt-4 pb-4" >
            <?php
                $no = 1;
                foreach($data_news as $dn) {
                  if($no == 1) {
              ?>
                <div class="card-deck px-3 pb-3">
                    <div class="card">
                        <img class="card-img-top" src="<?=base_url()?>uploads/gambar/news/<?=isset($dn->image) ? $dn->image : 'no_image.jpg'?>" alt="Card image cap" width="20%">
                        <div class="card-body">
                        <h5 class="card-title"><?=$dn->judul?></h5>
                        <small class="text-muted">Posting by : <?=$dn->upd?></small>
                        <hr>
                        <p class="card-text"><?=$dn->short_description?>...</p>
                        </div>
                        
                        <div class="card-footer">
                        <a href="<?=site_url('DetailNews/index/')?><?=$dn->id_news?>" class="btn btn-primary">Load More</a>
                            <hr>
                        <small class="text-muted">Tanggal Upload : <?=date("l, d F Y", strtotime($dn->tanggal))?></small>
                        </div>
                    </div>
                    <?php
                      $no++;
                    }
                    else if($no == 2) {
                    ?>
                    <div class="card">
                        <img class="card-img-top" src="<?=base_url()?>uploads/gambar/news/<?=isset($dn->image) ? $dn->image : 'no_image.jpg'?>" alt="Card image cap" width="20%">
                        <div class="card-body">
                        <h5 class="card-title"><?=$dn->judul?></h5>
                        <small class="text-muted">Posting by : <?=$dn->upd?></small>
                        <hr>
                        <p class="card-text"><?=$dn->short_description?>...</p>
                        </div>
                        
                        <div class="card-footer">
                        <a href="<?=site_url('DetailNews/index/')?><?=$dn->id_news?>" class="btn btn-primary">Load More</a>
                            <hr>
                        <small class="text-muted">Tanggal Upload : <?=date("l, d F Y", strtotime($dn->tanggal))?></small>
                        </div>
                    </div>
                    <?php
                    $no++;
                    }
                    else if ($no == 3) {
                    ?>
                    <div class="card">
                        <img class="card-img-top" src="<?=base_url()?>uploads/gambar/news/<?=isset($dn->image) ? $dn->image : 'no_image.jpg'?>" alt="Card image cap" width="20%">
                        <div class="card-body">
                        <h5 class="card-title"><?=$dn->judul?></h5>
                        <small class="text-muted">Posting by : <?=$dn->upd?></small>
                        <hr>
                        <p class="card-text"><?=$dn->short_description?>...</p>
                        </div>
                        
                        <div class="card-footer">
                        <a href="<?=site_url('DetailNews/index/')?><?=$dn->id_news?>" class="btn btn-primary">Load More</a>
                            <hr>
                        <small class="text-muted">Tanggal Upload : <?=date("l, d F Y", strtotime($dn->tanggal))?></small>
                        </div>
                    </div>
                    </div>
                    <?php
                    $no = 1;
                    }
                }
                ?>
            </div>
          </div>
        </div>
      </div>



          
      
      