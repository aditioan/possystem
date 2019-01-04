<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Karyawan Form
        <small>Daftar Karyawan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Karyawan Form</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('karyawan/create');?>"><?php echo !empty($karyawan)?'Ubah Karyawan':'Tambah Karyawan';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('karyawan');?>">Daftar karyawan</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Karyawan</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($karyawan)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('karyawan/save').'/'.$karyawan['id_karyawan'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('karyawan/save');?>">
            <?php } ?>
              <div class="box-body">
                <input type="hidden" name="id_karyawan" value="<?php echo !empty($karyawan) ? $karyawan['id_karyawan'] : '';?>" id="id_karyawan" class="form-control"/>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="nama_karyawan">Nama</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($karyawan) ? $karyawan['nama_karyawan'] : '';?>" name="nama_karyawan" placeholder="Nama Karyawan" id="nama" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="alamat_karyawan">Alamat</label>
                    <div class="col-sm-8">
                      <textarea name="alamat_karyawan" placeholder="Alamat" id="address" class="form-control"/><?php echo !empty($karyawan) ? $karyawan['alamat_karyawan'] : '';?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="email_karyawan">Email</label>
                    <div class="col-sm-8">
                      <input type="email" value="<?php echo !empty($karyawan) ? $karyawan['email_karyawan'] : '';?>" name="email_karyawan" placeholder="Alamat Email" id="email_karyawan" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="gaji">Gaji Karyawan</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($karyawan) ? $karyawan['gaji_karyawan'] : '';?>" name="gaji_karyawan" placeholder="Gaji Karyawan" id="gaji" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="phone">Telephon</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($karyawan) ? $karyawan['phone_karyawan'] : '';?>" name="phone_karyawan" placeholder="Nomor Telephon" id="phone" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="wa">WA</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($karyawan) ? $karyawan['wa_karyawan'] : '';?>" name="wa_karyawan" placeholder="Nomor WA" id="wa" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="line">LINE</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($karyawan) ? $karyawan['line_karyawan'] : '';?>" name="line_karyawan" placeholder="ID/Nomor LINE" id="line" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="posisi">Posisi</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($karyawan) ? $karyawan['posisi_karyawan'] : '';?>" name="posisi_karyawan" placeholder="Posisi Karyawan" id="posisi_karyawan" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('karyawan');?>">Batal</a>
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