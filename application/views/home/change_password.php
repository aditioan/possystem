<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Change Password Form
        <small>Change Password User</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('user/create');?>">Input user</a></li> -->
            <!-- <li role="presentation"><a href="<?php echo site_url('user');?>">List user</a></li> -->
            <!-- <li role="presentation" class="active">Change Password User</li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password User</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal form-validation" enctype="multipart/form-data" method="POST" action="<?php echo site_url('home/save_password');?>">
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="old_password">Password Lama</label>
                    <div class="col-sm-8">
                      <input type="password" name="old_password" placeholder="Password" id="old_password" class="form-control validate[required]"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="new_password">Password Baru</label>
                    <div class="col-sm-8">
                      <input type="password" name="new_password" placeholder="Password Baru" id="new_password" class="form-control validate[required]"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="new_password_repeat">Ulangi Password Baru</label>
                    <div class="col-sm-8">
                      <input type="password" name="new_password_repeat" placeholder="Ulangi Password Baru" id="new_password_repeat" class="form-control validate[required,equals[new_password]]"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <!-- <div class="form-group">
                    <label class="col-sm-4 control-label" for="password">Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="password" placeholder="Password" id="password" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="password_repeat">Ulangi Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="password_repeat" placeholder="Ulangi Password" id="password_repeat" class="form-control validate[required]"/>
                    </div>
                  </div> -->
                  <!-- <div class="form-group">
                    <label class="col-sm-4 control-label" for="photo_profil">Photo Profil</label>
                    <div class="col-sm-8">
                      <input type="file" name="photo_profil" d="photo_profil" class="form-control"/>
                    </div>
                  </div>
                </div> -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('home');?>">Cancel</a>
                  <button class="btn btn-info pull-right" type="submit">Save</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
		</div>
        <!-- /.col -->
      </div>
	  <!-- row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('element/footer');?>
<script type="text/javascript">
$(function() {
  jQuery('.form-validation').validationEngine();
  <?php if ($this->session->flashdata('message_success') != ''): ?>
  toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
  <?php endif ?>
  <?php if ($this->session->flashdata('message_error') != ''): ?>
  toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
  <?php endif ?>
});
</script>