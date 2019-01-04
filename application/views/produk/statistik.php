<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Statistik Transaksi
                <small><?php echo $produk['product_name']; ?></small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('penjualan/create');?>">Input Penjualan</a></li> -->
                        <!-- <li role="presentation" class="active"><a href="<?php echo site_url('penjualan');?>">List Penjualan</a></li> -->
                        <li role="presentation" class="active"><a>Statistik Barang</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"><strong><?php echo $produk['product_name']; ?></strong></h3>
                            <div class="pull-right">
                                <span><a href="<?php echo site_url('produk');?>" class="btn btn-sm btn-danger">Kembali</a></span>
                                <button class="btn btn-sm btn-default" id="btn-image"><i class="fa fa-file-excel-o"></i> Export to PNG</button>
                            </div>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <div class="row">
                            <div class="col-md-4">
                            <table class="table table-bordered" id="table-laporan">
                                <tr>
                                    <td colspan="2"><h4 class="tex-center">Data Produk <?php echo $produk['product_name']." (".date("d-m-Y").")"; ?></h4></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Penjualan</strong></td>
                                    <td class="form-price-format"><strong><?php echo $total_penjualan;?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Total HPP</strong></td>
                                    <td class="form-price-format"><strong><?php echo $hpp;?></strong></td>
                                </tr>
                                <tr class="warning">
                                    <td><strong>Total Keuntungan</strong></td>
                                    <td class="form-price-format"><strong><?php echo $total_penjualan-$hpp;?></strong></td>
                                </tr>
                            </table>
                            </div>
                            </div>
                            <br>
                            <h4 class="box-title"><strong>Penjualan <?php echo $produk['product_name']; ?></strong></h4>
                            <div class="col-md-2 pull-right">
                                <a href="<?php echo site_url('produk/export_penjualan').'/'.$produk['id_product'];?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            </div>
                            <br>
                            <br>
                            <table id="data-penjualan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Total Item</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($penjualan) && is_array($penjualan)){ ?>
                                    <?php foreach($penjualan as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi->id_stransaction;?></td>
                                            <td><?php echo $transaksi->created_at;?></td>
                                            <td><?php echo $transaksi->product_name;?></td>
                                            <td><?php echo $transaksi->data_qty;?></td>
                                            <td class="form-price-format">Rp <?php echo $transaksi->price_item;?></td>
                                            <td class="form-price-format">Rp <?php echo $transaksi->subtotal;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>Total Penjualan</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="form-price-format"><?php echo $total_penjualan;?></td>
                                </tr>
                                </tfoot>
                            </table>
                            <h4 class="box-title"><strong>Pembelian <?php echo $produk['product_name']; ?></strong></h4>
                            <div class="col-md-2 pull-right">
                                <a href="<?php echo site_url('produk/export_pembelian').'/'.$produk['id_product'];?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            </div>
                            <br>
                            <br>
                            <table id="data-pembelian" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Total Item</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($pembelian) && is_array($pembelian)){ ?>
                                    <?php foreach($pembelian as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi->id_ptransaction;?></td>
                                            <td><?php echo $transaksi->created_at;?></td>
                                            <td><?php echo $transaksi->product_name;?></td>
                                            <td><?php echo $transaksi->data_qty;?></td>
                                            <td class="form-price-format"><?php echo $transaksi->price_item;?></td>
                                            <td class="form-price-format"><?php echo $transaksi->subtotal;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>Total Pembelian</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="form-price-format">Rp <?php echo $total_pembelian;?></td>
                                </tr>
                                </tfoot>
                            </table>
                            <h4 class="box-title"><strong>Retur Penjualan <?php echo $produk['product_name']; ?></strong></h4>
                            <div class="col-md-2 pull-right">
                                <a href="<?php echo site_url('produk/export_retur_penjualan').'/'.$produk['id_product'];?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            </div>
                            <br>
                            <br>
                            <table id="data-retur-penjualan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Total Item</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($retur_penjualan) && is_array($retur_penjualan)){ ?>
                                    <?php foreach($retur_penjualan as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi->id_srdata;?></td>
                                            <td><?php echo $transaksi->created_at;?></td>
                                            <td><?php echo $transaksi->product_name;?></td>
                                            <td><?php echo $transaksi->data_qty;?></td>
                                            <td class="form-price-format">Rp <?php echo $transaksi->price_item;?></td>
                                            <td class="form-price-format">Rp <?php echo $transaksi->subtotal;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>Total Retur Penjualan</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="form-price-format"><?php echo $total_retur_penjualan;?></td>
                                </tr>
                                </tfoot>
                            </table>
                            <h4 class="box-title"><strong>Retur Pembelian <?php echo $produk['product_name']; ?></strong></h4>
                            <div class="col-md-2 pull-right">
                                <a href="<?php echo site_url('produk/export_retur_pembelian').'/'.$produk['id_product'];?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                            </div>
                            <br>
                            <br>
                            <table id="data-retur-pembelian" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Total Item</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($retur_pembelian) && is_array($retur_pembelian)){ ?>
                                    <?php foreach($retur_pembelian as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi->id_prdata;?></td>
                                            <td><?php echo $transaksi->created_at;?></td>
                                            <td><?php echo $transaksi->product_name;?></td>
                                            <td><?php echo $transaksi->data_qty;?></td>
                                            <td class="form-price-format"><?php echo $transaksi->price_item;?></td>
                                            <td class="form-price-format"><?php echo $transaksi->subtotal;?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td>Total Retur Pembelian</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="form-price-format">Rp <?php echo $total_retur_pembelian;?></td>
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
    $("#data-pembelian").dataTable();
    $("#data-retur-penjualan").dataTable();
    $("#data-retur-pembelian").dataTable();

  $("#btn-image").on('click', function () {
    var today = new Date();
    var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
    domtoimage.toPng(document.getElementById('table-laporan'))
    .then(function (dataUrl) {
        var link = document.createElement('a');
        link.download = 'statistik_produk_'+date+'.png';
        link.href = dataUrl;
        link.click();
    });
  });
});
</script>