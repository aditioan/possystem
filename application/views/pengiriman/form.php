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
            <li role="presentation" class="active"><a><?php echo !empty($pengiriman)?'Ubah Pengiriman':'Tambah Pengiriman';?></a></li>
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
            <?php if(!empty($pengiriman)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('pengiriman/save').'/'.$pengiriman['id_pengiriman'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('pengiriman/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode penjualan</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($code_penjualan) ? $code_penjualan : "";?>" id="kode" class="form-control" disabled/>
                      <input type="hidden" name="id_stransaction" value="<?php echo !empty($code_penjualan) ? $code_penjualan : "";?>" id="id_penjualan" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="service">Dikirim Via</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="service" name="service">
                        <option value="JNE" <?php if(!empty($pengiriman) && $pengiriman['service'] == "JNE") echo 'selected="selected"';?>>JNE</option>
                        <option value="Wahana" <?php if(!empty($pengiriman) && $pengiriman['service'] == "Wahana") echo 'selected="selected"';?>>Wahana</option>
                        <option value="TIKI" <?php if(!empty($pengiriman) && $pengiriman['service'] == "TIKI") echo 'selected="selected"';?>>TIKI</option>
                        <option value="POS" <?php if(!empty($pengiriman) && $pengiriman['service'] == "POS") echo 'selected="selected"';?>>POS</option>
                        <option value="Tikindo" <?php if(!empty($pengiriman) && $pengiriman['service'] == "Tikindo") echo 'selected="selected"';?>>Tikindo</option>
                        <option value="Pahala" <?php if(!empty($pengiriman) && $pengiriman['service'] == "Pahala") echo 'selected="selected"';?>>Pahala</option>
                        <option value="Dakota Cargo" <?php if(!empty($pengiriman) && $pengiriman['service'] == "Dakota Cargo") echo 'selected="selected"';?>>Dakota Cargo</option>
                        <option value="Lion Parcel" <?php if(!empty($pengiriman) && $pengiriman['service'] == "Lion Parcel") echo 'selected="selected"';?>>Lion Parcel</option>
                        <option value="Lainnya" <?php if(!empty($pengiriman) && $pengiriman['service'] == "Lainnya") echo 'selected="selected"';?>>Lainnya</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="no_resi">Nomor Resi</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($pengiriman) ? $pengiriman['no_resi'] : '';?>" name="no_resi" placeholder="Nomor Resi" id="no_resi" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="ongkir">Biaya Pengiriman</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($pengiriman) ? $pengiriman['ongkir'] : '';?>" name="ongkir" placeholder="Biaya Pengiriman" id="ongkir" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="ongkir_terpakai">Biaya Terpakai</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($pengiriman) ? $pengiriman['ongkir_terpakai'] : '';?>" name="ongkir_terpakai" placeholder="Biaya Terpakai" id="ongkir_terpakai" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <?php if(!empty($pengiriman)){?>
                  <a class="btn btn-default" href="<?php echo site_url('pengiriman');?>">Batal</a>
                  <?php }else{?>
                  <a class="btn btn-default" href="<?php echo site_url('penjualan');?>">Batal</a>
                  <?php } ?>
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