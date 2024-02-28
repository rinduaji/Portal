<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>IMPORT ROOSTER</h6>
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
                <form method="post" action="<?=site_url('ImportRooster/importExcelRooster')?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="file_rooster_excel" class="form-label">File Rooster Excel</label>
                        <input class="form-control form-control-lg" id="file_rooster_excel" name="file_rooster_excel" type="file" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-auto">
                            <a href="<?=base_url('assets/templateExcel/Rooster/template_upload_rooster.xlsx')?>" class="btn btn-info mb-3" target="_blank">Download Template Excel</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Import Excel</button>
                        </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
<script>

</script>
          
      
      