<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Log Penjualan Detail
                <small>Detail Log</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a>Detail Penjualan</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Log Penjualan Detail <?php echo $details[0]->id_stransaction;?></h3>
                            <div class="pull-right">
                                <span><a href="<?php echo site_url('log/penjualan');?>" class="btn btn-sm btn-danger">Kembali</a></span>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="data-tunggakan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Nama Kustomer</th>
                                    <th>Via</th>
                                    <th>Total Item</th>
                                    <th>Total</th>
                                    <th>Metode</th>
                                    <?php if($details[0]->is_cash == 0): ?>
                                    <th>Deadline Tunggakan</th>
                                    <?php endif ?>
                                    <th>Tanggal Transaksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?php echo $details[0]->id_stransaction;?></td>
                                    <td><?php echo $details[0]->customer_name;?></td>
                                      <td><?php 
                                            if ($penjualan->via == 0) {
                                                echo "Langsung";
                                            } elseif ($pelanggan->via == 1) {
                                                echo "Reseller";
                                            } else {
                                                echo "Dropshipper";
                                            }
                                        ?></td>
                                    <td><?php echo $details[0]->total_item;?></td>
                                    <td class="form-price-format"><?php echo $details[0]->total_price;?></td>
                                    <td><?php echo $details[0]->is_cash == 1 ? "<span class='alert-success'>Tunai</span>" : "<span class='alert-warning'>Kredit</span>";?></td>
                                    <?php if($details[0]->is_cash == 0): ?>
                                    <td class="bg-orange"><i><?php echo $details[0]->pay_deadline_date;?></i></td>
                                    <?php endif ?>
                                    <td><?php echo $details[0]->created_at;?></td>
                                </tr>
                                </tbody>
                            </table>
                            <hr />
                            <h4>Data Transaksi</h4>
                            <table id="data-detail" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga/item</th>
                                    <th>Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($details) && is_array($details)){ ?>
                                    <?php foreach($details as $transaksi){?>
                                        <tr>
                                            <td><?php echo $transaksi->product_name;?></td>
                                            <td><?php echo $transaksi->category_name;?></td>
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
    $("#data-detail").dataTable();
});
</script>