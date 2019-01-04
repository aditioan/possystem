<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengiriman Form
        <small>Pengiriman</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Pengiriman Form</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
  
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('penjualan/kirim');?>">Tambah Pengiriman</a></li>
          </ul>
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pengiriman</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="<?php echo site_url('penjualan/kirim_proses');?>">
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode penjualan</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($code_penjualan) ? $code_penjualan : "";?>" id="kode" class="form-control" disabled/>
                      <input type="hidden" name="id_stransaction" value="<?php echo !empty($penjualan) ? $code_penjualan : "";?>" id="id_penjualan" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Dikirim Via</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($penjualan) ? $penjualan['penjualan_name'] : '';?>" name="penjualan_name" placeholder="Nama penjualan" id="name" class="form-control" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="phone">Telephon</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($penjualan) ? $penjualan['penjualan_phone'] : '';?>" name="penjualan_phone" placeholder="Phone" id="phone" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Alamat</label>
                    <div class="col-sm-8">
                      <textarea name="penjualan_address" placeholder="Alamat" id="address" class="form-control"/><?php echo !empty($penjualan) ? $penjualan['penjualan_address'] : '';?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('penjualan');?>">Batal</a>
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