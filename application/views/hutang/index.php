<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Utang
        <small>Daftar Utang</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('hutang');?>">Daftar Utang</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Utang</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('hutang?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <div class="col-md-1">
                    <div class="form-group">
                      <label>&nbsp;</label>
                      <a href="#" id="tunggakan-reset" class="btn btn-default btn-sm pull-left">Reset</a>
                    </div>
                  </div>
                  <!-- <div class="col-md-3">
                    <div class="form-group">
                      <label for="id">Kode Transaksi</label>
                      <input type="text" class="form-control" name="id_stransaction" value="<?php echo !empty($_GET['id_stransaction']) ? $_GET['id_stransaction'] : '';?>"/>
                    </div>
                  </div> -->
                  <!-- <div class="col-md-2">
                    <div class="form-group">
                      <label>Date From</label>
                      <select class="form-control" name="date_range" id="tunggakan-date-range">
                        <option value="">Pilih Hari</option>
                        <option value="7" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 7 ? "selected":"";?>>7 Hari</option>
                        <option value="14" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 14 ? "selected":"";?>>14 Hari</option>
                        <option value="30" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 30 ? "selected":"";?>>30 Hari</option>
                      </select>
                    </div>
                  </div> -->
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Tanggal Transaksi</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker" name="date_trx" value="<?php echo !empty($_GET['date_trx']) ? $_GET['date_trx'] : '';?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <input type="submit" value="Cari" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <a href="<?php echo site_url('hutang/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="data-hutang" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Supplier</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(isset($hutangs) && is_array($hutangs)){ ?>
                  <?php foreach($hutangs as $hutang){?>
                    <tr>
                      <td><?php echo $hutang->id_ptransaction;?></td>
                      <td><?php echo $hutang->supplier_name;?></td>
                      <td><?php echo $hutang->total_item;?></td>
                      <td class="form-price-format"><?php echo $hutang->total_price;?></td>
                      <td><?php echo $hutang->created_at;?></td>
                      <td>
                        <a href="<?php echo site_url('hutang/update_lunas').'/'.$hutang->id_ptransaction;?>" onclick="return confirm('Apakah anda yakin menandai ini sebagai lunas?');" class="btn btn-xs btn-success">Lunas</a>
                        <a href="<?php echo site_url('hutang/detail').'/'.$hutang->id_ptransaction;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus data hutang ini?');" href="<?php echo site_url('hutang/delete').'/'.$hutang->id_ptransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                   <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Supplier</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
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
    $("#data-hutang").dataTable();
});
</script>