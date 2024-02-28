<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Briefing</h6>
            </div>
            <div class="card-body px-2 pt-0 pb-2" >
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
              <div class="container mb-3">
                <form method="post" action="<?=site_url('Briefing/addProses')?>" enctype="multipart/form-data">
                    <div class="mb-3">
                    <input type="hidden" class="form-control" id="tl" name="tl" value="<?=$this->session->userdata('username')?>">
                            <label for="agent">Login & Nama</label>
                            <select class="form-control js-example-basic-single" id="agent" name="agent" required>
                                <option value=''>-- Pilih Login & Nama Agent --</option>
                                <?php
                                foreach($list_agent as $la) {
                                ?>
                                <option value='<?=$la->user1?>'><?=$la->user1?> | <?=$la->user2?> | <strong><?=$la->pola?></strong> | <?=$la->user3?></option>
                                <?php
                                }
                                ?>
                            </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Save</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
      </script>
          
      
      