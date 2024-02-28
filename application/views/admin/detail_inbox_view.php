
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Detail Inbox</h6>
            </div>
            <div class="card-body px-2 pt-4 pb-4" >
            <div class="card">
                <!-- <img class="card-img-top" src="<?=base_url()?>uploads/gambar/inbox/<?=(isset($detail_data_inbox->image)) ? $detail_data_inbox->image : 'no_image.jpg'?>" alt="Card image cap"> -->
                <div class="card-body">
                    <h5 class="card-title"><?=$detail_data_inbox->judul?></h5>
                    <div>
                        <small class="text-muted"><strong>Posted By :</strong> <?=$detail_data_inbox->upd?> </small> &nbsp;&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><strong>Posted Date : </strong><?=date("l, d F Y", strtotime($detail_data_inbox->tanggal))?></small>
                        <hr>
                    </div>
                    <p class="card-text"><?=$detail_data_inbox->description?></p>
                </div>
                <div class="card-footer">
                    <hr>
                    <a href="<?=site_url('Inbox/index')?>" class="btn btn-info">Back</a>
                    <?php
                    if(isset($detail_data_inbox->file_inbox)) {
                    ?>
                    <a href="<?=base_url('uploads/file/inbox/')?><?=$detail_data_inbox->file_inbox?>" target="_blank" class="btn btn-primary">Download File <?='('.$detail_data_inbox->file_inbox.')'?></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>



          
      
      