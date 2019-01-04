<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Karyawan Index
        <small>Daftar Karyawan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Karyawan Index</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <!-- <li role="presentation"><a href="<?php echo site_url('karyawan/create');?>">Input karyawan</a></li> -->
                <li role="presentation" class="active"><a href="<?php echo site_url('karyawan');?>">Daftar Karyawan</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('karyawan?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <?php echo search_form('karyawan');?>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <input type="submit" value="Cari" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <a href="<?php echo site_url('karyawan/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="data-karyawan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>Telephon</th>
                  <th>WA</th>
                  <th>Line</th>
                  <th>Posisi</th>
                  <th>Gaji</th>
                  <th>Bonus</th>
                  <th>Gaji Total</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
				<?php if(isset($karyawans) && is_array($karyawans)){ ?>
				  <?php foreach($karyawans as $karyawan){?>
					<tr>
            <td><?php echo $karyawan->id_karyawan;?></td>
					  <td><?php echo $karyawan->nama_karyawan;?></td>
            <td><?php echo $karyawan->alamat_karyawan;?></td>
            <td><?php echo $karyawan->email_karyawan;?></td>
					  <td><?php echo $karyawan->phone_karyawan;?></td>
            <td><?php echo $karyawan->wa_karyawan;?></td>
            <td><?php echo $karyawan->line_karyawan;?></td>
            <td><?php echo $karyawan->posisi_karyawan;?></td>
            <td class="form-price-format"><?php echo $karyawan->gaji_karyawan;?></td>
            <td class="form-price-format"><?php echo $karyawan->bonus_karyawan;?></td>
            <td class="form-price-format"><?php echo $karyawan->gaji_karyawan+$karyawan->bonus_karyawan;?></td>
					  <td>
            <a onclick="return confirm('Apakah anda yakin akan membayar gaji karyawan <?php echo $karyawan->nama_karyawan;?> bulan ini?');" href="<?php echo site_url('karyawan/bayar').'/'.$karyawan->id_karyawan;?>" class="btn btn-block btn-xs btn-warning">Gaji</a>
						<a href="<?php echo site_url('karyawan/edit').'/'.$karyawan->id_karyawan;?>" class="btn btn-block btn-xs btn-primary">Ubah</a>
						<a onclick="return confirm('Apakah anda yakin akan menghapus data Karyawan ini?');" href="<?php echo site_url('karyawan/delete').'/'.$karyawan->id_karyawan;?>" class="btn btn-block btn-xs btn-danger">Hapus</a>
					  </td>
					</tr>
				  <?php } ?>
				<?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Email</th>
                  <th>Telephon</th>
                  <th>WA</th>
                  <th>Line</th>
                  <th>Posisi</th>
                  <th>Gaji</th>
                  <th>Bonus</th>
                  <th>Gaji Total</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
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
    $("#data-karyawan").dataTable();
});
</script>