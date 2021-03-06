<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Penjualan
        <small>Daftar Transaksi</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('penjualan/create');?>">Input Penjualan</a></li> -->
            <li role="presentation" class="active"><a href="<?php echo site_url('penjualan');?>">Daftar Penjualan</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Penjualan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('penjualan?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="id">ID Transaksi</label>
                      <input type="text" class="form-control" name="id_stransaction" value="<?php echo !empty($_GET['id_stransaction']) ? $_GET['id_stransaction'] : '';?>"/>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date From</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker-transaksi" name="date_from" value="<?php echo !empty($_GET['date_from']) ? $_GET['date_from'] : '';?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date End</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker-transaksi" name="date_end" value="<?php echo !empty($_GET['date_end']) ? $_GET['date_end'] : '';?>"/>
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
                      <a href="<?php echo site_url('penjualan/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
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
                            //echo $penjualan->status;
                            if ($penjualan->via == 0) {
                                echo "Langsung";
                            } elseif ($penjualan->via == 1) {
                                echo "Reseller";
                            } else {
                                echo "Dropshipper";
                            }
                        ?></td>
                      <td><?php echo $penjualan->total_item;?></td>
                      <td class="form-price-format"><?php echo $penjualan->total_price;?></td>
                      <td><?php echo $penjualan->is_cash == 1 ? "<span class='alert-success'>Tunai</span>" : "<span class='alert-warning'>Kredit</span>";?></td>
                      <td><?php echo $penjualan->created_at;?></td>
                      <td>
                        <a href="<?php echo site_url('penjualan/detail').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-default">Detail</a>
                        <a href="<?php echo site_url('pengiriman/create').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-warning">Kirim</a>
                        <a href="<?php echo site_url('penjualan/print_now').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-primary btnPrint">Print</a>
                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data penjualan ini?');" href="<?php echo site_url('penjualan/delete').'/'.$penjualan->id_stransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
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
    $("#data-penjualan").dataTable();
});
</script>