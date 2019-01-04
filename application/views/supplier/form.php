<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Supplier Form
        <small>Daftar Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Supplier Form</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('supplier/create');?>"><?php echo !empty($supplier)?'Ubah Supplier':'Tambah Supplier';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('supplier');?>">Daftar Supplier</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Supplier</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($supplier)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('supplier/save').'/'.$supplier['id_supplier'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('supplier/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Supplier</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['id_supplier'] : $code_supplier;?>" id="kode" class="form-control" disabled/>
                      <input type="hidden" name="id_supplier" value="<?php echo !empty($supplier) ? $supplier['id_supplier'] : $code_supplier;?>" id="id_supplier" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['supplier_name'] : '';?>" name="supplier_name" placeholder="Nama Supplier" id="name" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="company_name">Nama Perusahaan</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['company_name'] : '';?>" name="company_name" placeholder="Nama Perusahaan" id="company_name" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="supplier_email">Alamat Email</label>
                    <div class="col-sm-8">
                      <input type="email" value="<?php echo !empty($supplier) ? $supplier['supplier_email'] : '';?>" name="supplier_email" placeholder="Alamat Email" id="supplier_email" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="phone">Telephon</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($supplier) ? $supplier['supplier_phone'] : '';?>" name="supplier_phone" placeholder="Nomor Telephon" id="phone" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="wa">WA</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($supplier) ? $supplier['supplier_wa'] : '';?>" name="supplier_wa" placeholder="Nomor WA" id="wa" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="line">LINE</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($supplier) ? $supplier['supplier_line'] : '';?>" name="supplier_line" placeholder="ID/Nomor LINE" id="line" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Alamat</label>
                    <div class="col-sm-8">
                      <textarea name="supplier_address" placeholder="Alamat" id="address" class="form-control"/><?php echo !empty($supplier) ? $supplier['supplier_address'] : '';?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('supplier');?>">Batal</a>
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