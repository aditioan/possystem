<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>Retur Pembelian</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data Retur Pembelian</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a>Log Data Retur Pembelian</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data Retur Pembelian</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="data-retur-pembelian" class="table table-bordered table-striped">
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
                <?php if(isset($retur_pembelians) && is_array($retur_pembelians)){ ?>
                  <?php foreach($retur_pembelians as $retur_pembelian){?>
                <tr>
                  <td><?php echo $retur_pembelian->id_pretur;?></td>
                  <td>
                  <?php echo $retur_pembelian->id_ptransaction;?>
                  <a target="_blank" href="<?php echo strpos($retur_pembelian->id_ptransaction,'RETS') === false ? site_url('transaksi/detail') : site_url('retur_retur_pembelian/detail');?>/<?php echo $retur_pembelian->id_ptransaction;?>" class="btn btn-xs btn-primary">
                    detail
                  </a>
                  </td>
                  <td><?php echo $retur_pembelian->total_item;?></td>
                  <td class="form-price-format"><?php echo $retur_pembelian->total_price;?></td>
                  <td><?php echo $retur_pembelian->return_by == 1 ? "Barang" : "Uang";?></td>
                  <td><?php echo $retur_pembelian->created_at;?></td>
                  <td><?php echo $retur_pembelian->deleted_at;?></td>
                  <td>
                    <a href="<?php echo site_url('log/retur_pembelian_detail').'/'.$retur_pembelian->id_pretur;?>" class="btn btn-xs btn-default">Detail</a>
                    <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Retur Pembelian ini?');" href="<?php echo site_url('log/retur_pembelian_return').'/'.$retur_pembelian->id_pretur.'/'.$retur_pembelian->return_by;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                    <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Retur Pembelian ini?');" href="<?php echo site_url('log/retur_pembelian_delete').'/'.$retur_pembelian->id_pretur;?>" class="btn btn-xs btn-danger">Hapus</a>
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
    $('#data-retur-pembelian').dataTable();
});
</script>