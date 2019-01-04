<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Neraca Form
        <small>List Neraca</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('neraca');?>">List Neraca</a></li> -->
            <li role="presentation" class="active"><a href="<?php echo site_url('neraca/create');?>">Input Neraca</a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('neraca/record');?>">Record Neraca</a></li> -->
            <!-- <li role="presentation"><a href="<?php echo site_url('neraca/chart');?>">Chart Neraca</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Neraca</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($neraca)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('neraca/save').'/'.$neraca['id_otransaction'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('neraca/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_otransaction">Kode Neraca</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($id_transaction) ? $id_transaction : '';?>" id="id_transaction" class="form-control" disabled/>
                      <span class="help-inline label label-danger" id="status_kode"></span>
                      <input type="hidden" name="id_transaction" value="<?php echo !empty($id_transaction) ? $id_transaction : '';?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="type">Jenis Neraca</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="type" name="type">
                        <option value="modal">Modal</option>
                        <option value="perawatan">Perawatan</option>
                        <option value="peralatan">Pembelian Peralatan</option>
                        <option value="atk">Pembelian ATK</option>
                        <option value="gaji">Gaji Karyawan</option>
                        <option value="lain-lain">Lain-Lain</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="aksi">Jenis Aksi</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="aksi" name="aksi">
                        <option value="0">Pengurangan</option>
                        <option value="1">Penambahan</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Besar Uang</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control form-price-format discount-trx" data-attr="0" id="sale_price" name="cash" placeholder="Besar Uang" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Deskripsi</label>
                    <div class="col-sm-8">
                      <textarea name="description" placeholder="Description" maxlength="200" id="desc" class="form-control"/><?php echo !empty($neraca) ? $neraca['category_desc'] : '';?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('neraca');?>">Cancel</a>
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
    <?php if ($this->session->flashdata('message_success') != ''): ?>
    toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('message_error') != ''): ?>
    toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
    <?php endif ?>
});
</script>