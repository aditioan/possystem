<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi Penjualan Detail
                <small>Detail Transaksi</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('penjualan/create');?>">Input Penjualan</a></li> -->
                        <!-- <li role="presentation" class="active"><a href="<?php echo site_url('penjualan');?>">List Penjualan</a></li> -->
                        <li role="presentation" class="active"><a>Detail Penjualan</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Transaksi Detail <?php echo $details[0]->id_stransaction;?></h3>
                            <div class="pull-right">
                                <span><a href="<?php echo site_url('penjualan');?>" class="btn btn-sm btn-danger">Kembali</a></span>
                                <span><a href="<?php echo site_url('penjualan/print_now').'/'.$details[0]->id_stransaction;?>" class="btn btn-sm btn-primary btnPrint"><i class="fa fa-print"></i> Print</a></span>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Via</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Metode</th>
                                    <th>Tgl Jatuh Tempo</th>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $details[0]->id_stransaction;?></td>
                                        <td><?php echo $details[0]->customer_name;?></td>
                                      <td><?php 
                                            if ($details[0]->via == 0) {
                                                echo "Langsung";
                                            } elseif ($details[0]->via == 1) {
                                                echo "Reseller";
                                            } else {
                                                echo "Dropshipper";
                                            }
                                        ?></td>
                                        <td><?php echo $details[0]->total_item;?></td>
                                        <td class="form-price-format"><?php echo $details[0]->total_price;?></td>
                                        <td><?php echo $details[0]->is_cash == 1 ? "Tunai" : "Kredit";?></td>
                                        <td><span class="alert-warning"><?php echo $details[0]->is_cash == 1 ? "" : $details[0]->pay_deadline_date;?></span></td>
                                        <td><?php echo $details[0]->created_at;?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <h4>Pengiriman Data</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Pengiriman Via</th>
                                        <th>Nomor Resi</th>
                                        <th>Ongkos Kirim</th>
                                        <th>Tanggal Kirim</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($pengirimans) && is_array($pengirimans)){ ?>
                                    <?php foreach($pengirimans as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi['service'];?></td>
                                            <td><?php echo $transaksi['no_resi'];?></td>
                                            <td class="form-price-format"><?php echo $transaksi['ongkir'];?></td>
                                            <td class="form-price-format"><?php echo $transaksi['ongkir_terpakai'];?></td>
                                            <td><?php echo $transaksi['created_at'];?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                            </table>
                            <hr />
                            <h4>Transaksi Data</h4>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Barcode</th>
                                        <th>Kode Online</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga/item</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($details) && is_array($details)){ ?>
                                    <?php foreach($details as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi->id_product;?></td>
                                            <td><?php echo $transaksi->id_online;?></td>
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
                                        <th colspan="4" align="center">Total</th>
                                        <th class="form-price-format"><?php echo $transaksi->total_price;?></th>
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
});
</script>