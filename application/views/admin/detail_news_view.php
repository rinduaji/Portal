
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Detail News</h6>
            </div>
            <div class="card-body px-2 pt-4 pb-4" >
            <div class="card">
                <img class="card-img-top" src="<?=base_url()?>uploads/gambar/news/<?=(isset($ddn->image)) ? $ddn->image : 'no_image.jpg'?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?=$ddn->judul?></h5>
                    <div>
                        <small class="text-muted"><strong>Posted By :</strong> <?=$ddn->upd?> </small> &nbsp;&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><strong>Posted Date : </strong><?=date("l, d F Y", strtotime($ddn->tanggal))?></small>
                        <hr>
                    </div>
                    <p class="card-text"><?=$ddn->description?></p>
                </div>
                <div class="card-footer">
                    <hr>
                    <a href="<?=site_url('News/index')?>" class="btn btn-info">Back</a>
                    <?php
                    if(isset($ddn->file_news)) {
                    ?>
                    <a href="<?=base_url('uploads/file/news/')?><?=$ddn->file_news?>" target="_blank" class="btn btn-primary">Download File <?='('.$ddn->file_news.')'?></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>



          
      
      