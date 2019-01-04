<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pelanggan Form
        <small>Tambah Pelanggan</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('pelanggan/create');?>"><?php echo !empty($pelanggan)?'Ubah Pelanggan':'Tambah Pelanggan';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('pelanggan');?>">List Pelanggan</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pelanggan</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($pelanggan)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('pelanggan/save').'/'.$pelanggan['id_customer'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('pelanggan/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_customer">Kode Pelanggan</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($pelanggan) ? $pelanggan['id_customer'] : $code_pelanggan;?>" id="id_customer" class="form-control" disabled/>
                      <input type="hidden" name="id_customer" value="<?php echo !empty($pelanggan) ? $pelanggan['id_customer'] : $code_pelanggan;?>" id="id_customer" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($pelanggan) ? $pelanggan['customer_name'] : '';?>" name="customer_name" placeholder="Nama Pelanggan" id="name" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="panggilan">Panggilan</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="calling" name="calling">
                        <option value="" <?php if(!empty($pelanggan) && $pelanggan['calling'] == "") echo 'selected="selected"';?>>-- Panggilan --</option>
                        <option value="Mas" <?php if(!empty($pelanggan) && $pelanggan['calling'] == "Mas") echo 'selected="selected"';?>>Mas</option>
                        <option value="Mbak" <?php if(!empty($pelanggan) && $pelanggan['calling'] == "Mbak") echo 'selected="selected"';?>>Mbak</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="category">Kategori Pelanggan</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($pelanggan) ? $pelanggan['customer_category'] : '';?>" name="customer_category" placeholder="Kategori Pelanggan" id="category" class="form-control" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="phone">Telephon</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($pelanggan) ? $pelanggan['customer_phone'] : '';?>" name="customer_phone" placeholder="Phone" id="phone" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="status">Jenis</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="status" name="status">
                        <?php if(isset($status) && is_array($status)){?>
                          <?php foreach($status as $item){?>
                            <option value="<?php echo $item['status'];?>" <?php if(!empty($pelanggan) && $item['status'] == $pelanggan['status']) echo 'selected="selected"';?>>
                              <?php echo $item['name'];?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Alamat</label>
                    <div class="col-sm-8">
                      <textarea name="customer_address" placeholder="Alamat" id="address" class="form-control"/><?php echo !empty($pelanggan) ? $pelanggan['customer_address'] : '';?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('pelanggan');?>">Batal</a>
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