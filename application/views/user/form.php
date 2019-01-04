<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Form
        <small>Tambah User</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('user/create');?>">Tambah user</a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('user');?>">List user</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Tambah User</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($user)){?>
            <form class="form-horizontal form-validation" enctype="multipart/form-data" method="POST" action="<?php echo site_url('user/save').'/'.$user['id_user'];?>">
            <?php }else{?>
            <form class="form-horizontal form-validation" enctype="multipart/form-data" method="POST" action="<?php echo site_url('user/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="full_name">Full Name</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($user) ? $user['full_name'] : '';?>" name="full_name" placeholder="Full Name" id="full_name" class="form-control validate[required]" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="username">Username</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($user) ? $user['username'] : '';?>" name="username" placeholder="Username" id="username" class="form-control validate[required]" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="email">Email</label>
                    <div class="col-sm-8">
                      <input type="email" value="<?php echo !empty($user) ? $user['email'] : '';?>" name="email" placeholder="Email" id="email" class="form-control validate[required]" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="password">Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="password" placeholder="Password" id="password" class="form-control validate[required]"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="password_repeat">Ulangi Password</label>
                    <div class="col-sm-8">
                      <input type="password" name="password_repeat" placeholder="Ulangi Password" id="password_repeat" class="form-control validate[required,equals[password]]"/>
                    </div>
                  </div>
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
                  <a class="btn btn-default" href="<?php echo site_url('user');?>">Batal</a>
                  <button class="btn btn-info pull-right" type="submit">Simpan</button>
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