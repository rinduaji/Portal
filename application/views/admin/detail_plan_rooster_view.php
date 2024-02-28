
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Detail Plan Rooter</h6>
            </div>
            <div class="card-body px-2 pt-4 pb-4" >
            <div class="card">
                <img class="card-img-top" src="<?=base_url()?>uploads/gambar/plan_rooster/<?=(isset($detail_data_plan_rooster->image)) ? $detail_data_plan_rooster->image : 'no_image.jpg'?>" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?=$detail_data_plan_rooster->judul?></h5>
                    <div>
                        <small class="text-muted"><strong>Posted By :</strong> <?=$detail_data_plan_rooster->upd?> </small> &nbsp;&nbsp;&nbsp;&nbsp;
                        <small class="text-muted"><strong>Posted Date : </strong><?=date("l, d F Y", strtotime($detail_data_plan_rooster->tanggal))?></small>
                        <hr>
                    </div>
                    <p class="card-text"><?=$detail_data_plan_rooster->description?></p>
                </div>
                <div class="card-footer">
                    <hr>
                    <a href="<?=site_url('PlanRooster/index')?>" class="btn btn-info">Back</a>
                    <?php
                    if(isset($detail_data_plan_rooster->file_plan_rooster)) {
                    ?>
                    <a href="<?=base_url('uploads/file/plan_rooster/')?><?=$detail_data_plan_rooster->file_plan_rooster?>" target="_blank" class="btn btn-primary">Download File <?='('.$detail_data_plan_rooster->file_plan_rooster.')'?></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>



          
      
      