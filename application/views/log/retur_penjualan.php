<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>Retur Penjualan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data Retur Penjualan</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a>Log Data Retur Penjualan</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data Retur Penjualan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="data-retur-penjualan" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID Retur</th>
                    <th>ID Transaksi</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Bentuk Pengembalian</th>
                    <th>Tanggal Retur</th>
                    <th>Dihapus Pada</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(isset($retur_penjualans) && is_array($retur_penjualans)){ ?>
                  <?php foreach($retur_penjualans as $retur_penjualan){?>
                  <tr>
                    <td><?php echo $retur_penjualan->id_sretur;?></td>
                    <td>
                    <?php echo $retur_penjualan->id_stransaction;?>
                    <a target="_blank" href="<?php echo site_url('penjualan/detail').'/'.$retur_penjualan->id_stransaction;?>" class="btn btn-xs btn-primary">
                      detail
                    </a>
                    </td>
                    <td><?php echo $retur_penjualan->total_item;?></td>
                    <td class="form-price-format"><?php echo $retur_penjualan->total_price;?></td>
                    <td><?php echo $retur_penjualan->return_by == 1 ? "Barang" : "Uang";?></td>
                    <td><?php echo $retur_penjualan->created_at;?></td>
                    <td><?php echo $retur_penjualan->deleted_at;?></td>
                    <td>
                    <a href="<?php echo site_url('log/retur_penjualan_detail').'/'.$retur_penjualan->id_sretur;?>" class="btn btn-xs btn-default">Detail</a>
                    <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Retur Penjualan ini?');" href="<?php echo site_url('log/retur_penjualan_return').'/'.$retur_penjualan->id_sretur.'/'.$retur_penjualan->return_by;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                    <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Retur Penjualan ini?');" href="<?php echo site_url('log/retur_penjualan_delete').'/'.$retur_penjualan->id_sretur;?>" class="btn btn-xs btn-danger">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID Retur</th>
                    <th>ID Transaksi</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Bentuk Pengembalian</th>
                    <th>Tanggal Retur</th>
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
    $('#data-retur-penjualan').dataTable();
});
</script>