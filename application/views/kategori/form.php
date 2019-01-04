<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kategori Form
        <small>Daftar Kategori</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('kategori/create');?>"><?php echo !empty($kategori)?'Ubah Kategori':'Tambah Kategori';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('kategori');?>">List Kategori</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Kategori</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($kategori)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('kategori/save').'/'.$kategori['id_category'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('kategori/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_category">Kode Kategori</label>
                    <div class="col-sm-8">
                      <!-- <input type="text" name="id_category" value="<?php echo !empty($kategori) ? $kategori['id_category'] : '';?>" id="id_category" class="form-control" autocomplete="off" maxlength="15" required/> -->
                      <input type="text" value="<?php echo !empty($kategori) ? $kategori['id_category'] : $code_category;?>" id="id_category" class="form-control" disabled/>
                      <input type="hidden" name="id_category" value="<?php echo !empty($kategori) ? $kategori['id_category'] : $code_category;?>" id="id_category" class="form-control"/>
                      <span class="help-inline label label-danger" id="status_kode"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Nama Kategori</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($kategori) ? $kategori['category_name'] : '';?>" name="category_name" placeholder="Nama Kategori" id="name" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Deskripsi</label>
                    <div class="col-sm-8">
                      <textarea name="category_desc" placeholder="Deskripsi" id="desc" class="form-control"/><?php echo !empty($kategori) ? $kategori['category_desc'] : '';?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('kategori');?>">Batal</a>
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
    <?php if ($this->session->flashdata('message_success') != ''): ?>
    toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('message_error') != ''): ?>
    toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
    <?php endif ?>
});
</script>