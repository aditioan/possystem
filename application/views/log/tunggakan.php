<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>Tunggakan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data Tunggakan</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a>Log Data Tunggakan</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data Tunggakan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="data-tunggakan" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Deadline Tunggakan</th>
                    <th>Dihapus Pada</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(isset($tunggakans) && is_array($tunggakans)){ ?>
                  <?php foreach($tunggakans as $tunggakan){?>
                    <tr>
                      <td><?php echo $tunggakan->id_stransaction;?></td>
                      <td><?php echo $tunggakan->customer_name;?></td>
                      <td><?php echo $tunggakan->total_item;?></td>
                      <td class="form-price-format"><?php echo $tunggakan->total_price;?></td>
                      <td><?php echo $tunggakan->created_at;?></td>
                      <td class="bg-orange"><?php echo $tunggakan->pay_deadline_date;?></td>
                      <td><?php echo $tunggakan->deleted_at;?></td>
                      <td>
                        <a href="<?php echo site_url('log/tunggakan_detail').'/'.$tunggakan->id_stransaction;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Tunggakan ini?');" href="<?php echo site_url('log/tunggakan_return').'/'.$tunggakan->id_stransaction;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Tunggakan ini?');" href="<?php echo site_url('log/tunggakan_delete').'/'.$tunggakan->id_stransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                   <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Deadline Tunggakan</th>
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
    $("#data-tunggakan").dataTable();
});
</script>