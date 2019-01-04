<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>Penjualan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data Penjualan</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a>Log Data Penjualan</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data Penjualan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="data-penjualan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Transaksi</th>
                  <th>Nama Kustomer</th>
                  <th>Via</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Metode Pembayaran</th>
                  <th>Tanggal Transaksi</th>
                  <th>Dihapus Pada</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($penjualans) && is_array($penjualans)){ ?>
                  <?php foreach($penjualans as $penjualan){?>
                    <tr>
                      <td><?php echo $penjualan->id_stransaction;?></td>
                      <td><?php echo $penjualan->customer_name;?></td>
                      <td><?php 
                            if ($penjualan->via == 0) {
                                echo "Langsung";
                            } elseif ($pelanggan->via == 1) {
                                echo "Reseller";
                            } else {
                                echo "Dropshipper";
                            }
                        ?></td>
                      <td><?php echo $penjualan->total_item;?></td>
                      <td class="form-price-format"><?php echo $penjualan->total_price;?></td>
                      <td><?php echo $penjualan->is_cash == 1 ? "<span class='alert-success'>Tunai</span>" : "<span class='alert-warning'>Kredit</span>";?></td>
                      <td><?php echo $penjualan->created_at;?></td>
                      <td><?php echo $penjualan->deleted_at;?></td>
                      <td>
                        <a href="<?php echo site_url('log/penjualan_detail').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Apakah anda yakin akan mengembalikan data penjualan ini?');" href="<?php echo site_url('log/penjualan_return').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data penjualan ini?');" href="<?php echo site_url('log/penjualan_delete').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Kustomer</th>
                    <th>Via</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Transaksi</th>
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
    $('#data-penjualan').dataTable();
});
</script>