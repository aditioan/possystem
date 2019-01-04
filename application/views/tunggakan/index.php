<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tunggakan
        <small>Daftar Tunggakan</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('tunggakan');?>">Daftar Tunggakan</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Tunggakan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('tunggakan?search=true');?>" method="GET">
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
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date From</label>
                      <select class="form-control" name="date_range" id="tunggakan-date-range">
                        <option value="">Pilih Hari</option>
                        <option value="7" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 7 ? "selected":"";?>>7 Hari</option>
                        <option value="14" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 14 ? "selected":"";?>>14 Hari</option>
                        <option value="30" <?php echo !empty($_GET['date_range']) && $_GET['date_range'] == 30 ? "selected":"";?>>30 Hari</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date Transaction</label>
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
                      <a href="<?php echo site_url('tunggakan/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="data-tunggakan" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                    <th>Deadline Tunggakan</th>
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
                      <td>
                        <a href="<?php echo site_url('tunggakan/update_lunas').'/'.$tunggakan->id_stransaction;?>" onclick="return confirm('Apakah anda yakin menandai ini sebagai lunas?');" class="btn btn-xs btn-success">Lunas</a>
                        <a href="<?php echo site_url('tunggakan/detail').'/'.$tunggakan->id_stransaction;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus data tunggakan ini?');" href="<?php echo site_url('tunggakan/delete').'/'.$tunggakan->id_stransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
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