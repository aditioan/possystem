<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>Transaksi Lain</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data Transaksi Lain</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a>Log Data Transaksi Lain</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data Transaksi Lain</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="data-other" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                      <th>Kode Transaksi</th>
                      <th>Jenis Transaksi</th>
                      <th>Uang Transaksi</th>
                      <th>Aksi Transaksi</th>
                      <th>Deskripsi</th>
                      <th>Tanggal Transaksi</th>
                      <th>Tanggal Diupdate</th>
                      <th>Dihapus Pada</th>
                      <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if(isset($others) && is_array($others)){ ?>
                      <?php foreach($others as $other){?>
                          <tr>
                              <td><?php echo $other->id_otransaction;?></td>
                              <td><?php echo $other->type;?></td>
                              <td class="form-price-format"><?php echo $other->cash_trx;?></td>
                              <?php if($other->action == 1): ?>
                              <td>Penambahan</td>
                              <?php else: ?>
                              <td>Pengurangan</td>
                              <?php endif ?>
                              <td><?php echo $other->description;?></td>
                              <td><?php echo $other->created_at;?></td>
                              <td><?php echo $other->updated_at;?></td>
                              <td><?php echo $other->deleted_at;?></td>
                              <td>
                                <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Transaksi ini?');" href="<?php echo site_url('log/other_return').'/'.$other->id_otransaction;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                                <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Transaksi ini?');" href="<?php echo site_url('log/other_delete').'/'.$other->id_otransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
                              </td>
                          </tr>
                      <?php } ?>
                  <?php } ?>
                  </tbody>
                  <tfoot>
                  <tr>
                      <th>Kode Transaksi</th>
                      <th>Jenis Transaksi</th>
                      <th>Uang Transaksi</th>
                      <th>Aksi Transaksi</th>
                      <th>Deskripsi</th>
                      <th>Tanggal Transaksi</th>
                      <th>Tanggal Diupdate</th>
                      <th>Dihapus Pada</th>
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
    $('#data-other').dataTable();
});
</script>