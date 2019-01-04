<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Pembelian Supplier <?php echo !empty($transaksis) ? $transaksis[0]->supplier_name:"";?>
        <small>Daftar Transaksi</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('supplier/create');?>">Input supplier</a></li> -->
            <li role="presentation" class="active"><a href="<?php echo site_url('supplier');?>">Daftar Pembelian</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Pembelian</h3>
              <div class="pull-right">
                  <span><a href="<?php echo site_url('supplier');?>" class="btn btn-sm btn-danger">Kembali</a></span>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
              <form action="<?php echo site_url('supplier/statistik/'.$id_supplier);?>" method="GET">
                <input type="hidden" name="search" value="true"/>
                <input type="hidden" name="data" value="purchase_transaction"/>
                <div class="box-body pad">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Date From</label>
                        <div class="input-group date">
                          <input type="text" class="form-control datepicker-transaksi" name="date_from" value="<?php echo !empty($_GET['date_from']) ? $_GET['date_from'] : '';?>"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
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
                </div>
            </form>
              <div class="col-md-6">
              <table class="table table-bordered" id="table-laporan">
                  <tr>
                      <td colspan="2"><h4 class="tex-center">Data Transaksi Supplier <?php echo !empty($transaksis) ? $transaksis[0]->supplier_name." (".date("d-m-Y").")":""; ?></h4></td>
                  </tr>
                  <tr>
                      <td><strong>Pembelian</strong></td>
                      <td class="form-price-format"><strong><?php echo $pembelian;?></strong></td>
                  </tr>
                  <tr>
                      <td><strong>Retur Pembelian (Uang)</strong></td>
                      <td class="form-price-format"><strong><?php echo $retur;?></strong></td>
                  </tr>
                  <tr class="warning">
                      <td><strong>Total Pembelian</strong></td>
                      <td class="form-price-format"><strong><?php echo $pembelian-$retur;?></strong></td>
                  </tr>
                  <tr class="warning">
                      <td><strong>Total Utang</strong></td>
                      <td class="form-price-format"><strong><?php echo $utang;?></strong></td>
                  </tr>
              </table>
              </div>
              </div>
              <h4 class="box-title"><strong>Data Pembelian dan Retur Supplier <?php echo !empty($transaksis) ? $transaksis[0]->supplier_name:"";?></strong></h4>
              <div class="col-md-2 pull-right">
                  <a href="<?php echo site_url('supplier/export_pembelian').'/'.$id_supplier.get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
              </div>
              <br>
              <br>
              <table id="data-pembelian" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Transaksi</th>
                  <th>Nama Produk</th>
                  <th>Total Item</th>
                  <th>Harga/Item</th>
                  <th>Total Harga</th>
                  <th>Metode Pembayaran</th>
                  <th>Tanggal Transaksi</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($transaksis) && is_array($transaksis)){ ?>
                  <?php foreach($transaksis as $transaksi){?>
                    <tr>
                      <td><?php echo $transaksi->id_ptransaction;?></td>
                      <td><?php echo $transaksi->product_name;?></td>
                      <td><?php echo $transaksi->data_qty;?></td>
                      <td class="form-price-format"><?php echo $transaksi->price_item;?></td>
                      <td class="form-price-format"><?php echo $transaksi->subtotal;?></td>
                      <td><?php echo $transaksi->is_cash == 1 ? "<span class='alert-success'>Tunai</span>" : "<span class='alert-warning'>Utang</span>";?></td>
                      <td><?php echo $transaksi->created_at;?></td>
                      <td>
                        <a target="_blank" href="<?php echo $transaksi->is_cash == 1 ? site_url('transaksi/detail').'/'.$transaksi->id_ptransaction : site_url('hutang/detail').'/'.$transaksi->id_ptransaction;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus data pembelian ini?');" href="<?php echo site_url('transaksi/delete').'/'.$transaksi->id_ptransaction;?>" class="btn btn-xs btn-danger">Hapus</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID Transaksi</th>
                  <th>Nama Produk</th>
                  <th>Total Item</th>
                  <th>Harga/Item</th>
                  <th>Total Harga</th>
                  <th>Metode Pembayaran</th>
                  <th>Tanggal Transaksi</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
              <h4 class="box-title"><strong>Data Retur Pembelian Supplier <?php echo !empty($transaksis) ? $transaksis[0]->supplier_name:"";?></strong></h4>
              <div class="col-md-2 pull-right">
                  <a href="<?php echo site_url('supplier/export_retur').'/'.$id_supplier.get_uri()?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
              </div>
              <br>
              <br>
              <table id="data-pembelian" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Retur</th>
                  <th>ID Transaksi</th>
                  <th>Nama Produk</th>
                  <th>Total Item</th>
                  <th>Harga/Item</th>
                  <th>Total Harga</th>
                  <th>Bentuk Pengembalian</th>
                  <th>Tanggal Retur</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($data_retur) && is_array($data_retur)){ ?>
                  <?php foreach($data_retur as $transaksi){?>
                    <tr>
                      <td><?php echo $transaksi->id_pretur;?></td>
                      <td><?php echo $transaksi->id_ptransaction;?> <a target="_blank" href="<?php echo site_url('transaksi/detail').'/'.$transaksi->id_ptransaction;?>" class="btn btn-xs btn-primary">
                      detail
                    </a></td>
                      <td><?php echo $transaksi->product_name;?></td>
                      <td><?php echo $transaksi->data_qty;?></td>
                      <td class="form-price-format"><?php echo $transaksi->price_item;?></td>
                      <td class="form-price-format"><?php echo $transaksi->subtotal;?></td>
                      <td><?php echo $transaksi->return_by == 1 ? "<strong>Barang</strong>" : "<strong>Uang</strong>";?></td>
                      <td><?php echo $transaksi->created_at;?></td>
                      <td>
                        <a target="_blank" href="<?php echo site_url('retur_purchase/detail').'/'.$transaksi->id_pretur;?>" class="btn btn-xs btn-default">Detail</a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus data retur pembelian ini?');" href="<?php echo site_url('retur_purchase/delete').'/'.$transaksi->id_pretur;?>" class="btn btn-xs btn-danger">Hapus</a>
                      </td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID Retur</th>
                  <th>ID Transaksi</th>
                  <th>Nama Produk</th>
                  <th>Total Item</th>
                  <th>Harga/Item</th>
                  <th>Total Harga</th>
                  <th>Bentuk Pengembalian</th>
                  <th>Tanggal Retur</th>
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
    $("#data-pembelian").dataTable();
});
</script>