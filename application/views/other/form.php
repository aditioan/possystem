<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Lain Form
        <small>Form Transaksi Lain</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('other_transaction');?>">List other_transaction</a></li> -->
            <li role="presentation" class="active"><a><?php echo !empty($other)?'Ubah Transaksi':'Tambah Transaksi';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('other_transaction/record');?>">Record other_transaction</a></li> -->
            <!-- <li role="presentation"><a href="<?php echo site_url('other_transaction/chart');?>">Chart other_transaction</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Transaksi Lain</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($other)){?>
            <form class="form-horizontal form-validation" method="POST" action="<?php echo site_url('other_transaction/save').'/'.$other['id_otransaction'];?>">
            <?php }else{?>
            <form class="form-horizontal form-validation" method="POST" action="<?php echo site_url('other_transaction/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_otransaction">Kode Transaksi</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($id_otransaction) ? $id_otransaction : ''; echo !empty($other['id_otransaction']) ? $other['id_otransaction'] : '';?>" id="id_otransaction" class="form-control" disabled/>
                      <span class="help-inline label label-danger" id="status_kode"></span>
                      <input type="hidden" name="id_otransaction" value="<?php echo !empty($id_otransaction) ? $id_otransaction : ''; echo !empty($other['id_otransaction']) ? $other['id_otransaction'] : '';?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="type">Jenis Transaksi</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="type" name="type">
                        <option value="modal" <?php if(!empty($other) && $other['type'] == 'modal') echo 'selected="selected"';?>>Modal</option>
                        <option value="perawatan" <?php if(!empty($other) && $other['type'] == 'perawatan') echo 'selected="selected"';?>>Perawatan</option>
                        <option value="peralatan" <?php if(!empty($other) && $other['type'] == 'peralatan') echo 'selected="selected"';?>>Peralatan Awal</option>
                        <option value="peralatan" <?php if(!empty($other) && $other['type'] == 'peralatan') echo 'selected="selected"';?>>Pembelian Peralatan</option>
                        <option value="perlengkapan" <?php if(!empty($other) && $other['type'] == 'perlengkapan') echo 'selected="selected"';?>>Pembelian Perlengkapan</option>
                        <option value="sewa" <?php if(!empty($other) && $other['type'] == 'sewa') echo 'selected="selected"';?>>Sewa</option>
                        <option value="kas" <?php if(!empty($other) && $other['type'] == 'kas') echo 'selected="selected"';?>>Kas Awal</option>
                        <option value="persediaan" <?php if(!empty($other) && $other['type'] == 'persediaan') echo 'selected="selected"';?>>Persediaan Awal</option>
                        <option value="utang" <?php if(!empty($other) && $other['type'] == 'utang') echo 'selected="selected"';?>>Utang</option>
                        <option value="gaji" <?php if(!empty($other) && $other['type'] == 'gaji') echo 'selected="selected"';?>>Gaji Karyawan</option>
                        <option value="lain-lain" <?php if(!empty($other) && $other['type'] == 'lain-lain') echo 'selected="selected"';?>>Lain-Lain</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="aksi">Jenis Aksi</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="aksi" name="action">
                        <option value="1" <?php if(!empty($other) && $other['action'] == '1') echo 'selected="selected"';?>>Penambahan</option>
                        <option value="0" <?php if(!empty($other) && $other['action'] == '0') echo 'selected="selected"';?>>Pengurangan</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Besar Uang</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($other) ? $other['cash_trx'] : '';?>"  class="form-control form-price-format discount-trx" data-attr="0" id="sale_price" name="cash_trx" placeholder="Besar Uang" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="deskripsi">Deskripsi</label>
                    <div class="col-sm-8">
                      <textarea name="description" placeholder="Deskripsi" maxlength="200" id="desc" class="form-control"/><?php echo !empty($other) ? $other['description'] : '';?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('other_transaction');?>">Batal</a>
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

  $('#type').on('change', function() {
    var type = $('#type').val();
    var type_text = $('#type option:selected').text();
    // console.log(type_text);
    if (type_text == 'Kas Awal' || type_text == 'Persediaan Awal' || type_text == 'Peralatan Awal' || type_text == 'Utang') {
      $('#aksi').html('<option value="1">Penambahan</option>');
    } else if (type_text == 'Gaji Karyawan' || type_text == 'Perawatan' || type_text == 'Pembelian Perlengkapan' || type_text == 'Pembelian Peralatan') {
      $('#aksi').html('<option value="0">Pengurangan</option>');
    } else {
      $('#aksi').html('<option value="1">Penambahan</option><option value="0">Pengurangan</option>');
    };
  });
</script>