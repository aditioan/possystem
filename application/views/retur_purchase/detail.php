<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Retur Pembelian Detail
                <small>Detail Retur Pembelian</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('retur_purchase/create');?>">Input Retur Purchase</a></li> -->
                        <!-- <li role="presentation" class="active"><a href="<?php echo site_url('retur_purchase');?>">List Retur Purchase</a></li> -->
                        <li role="presentation" class="active"><a>Detail Retur Pembelian</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Retur Pembelian Detail <?php echo $details[0]->id_pretur;?></h3>
                            <div class="pull-right">
                                <span><a href="<?php echo site_url('retur_purchase');?>" class="btn btn-sm btn-danger">Kembali</a></span>
								<?php if($details[0]->is_return == 0){?>
                                <span><a href="<?php echo site_url('retur_purchase/edit');?>/<?php echo $details[0]->id;?>" class="btn btn-sm btn-success">Edit</a></span>								
								<?php } ?>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Total Item</th>
                                    <th>Total</th>
                                    <th>Dikembalikan Dalam</th>
                                    <th>Tanggal</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $details[0]->id_ptransaction;?></td>
                                        <td><?php echo $details[0]->total_item;?></td>
                                        <td class="form-price-format"><?php echo $details[0]->total_price;?></td>
                                        <td><?php echo $details[0]->return_by == 1 ? "Barang" : "Uang";?></td>
                                        <td><?php echo $details[0]->created_at;?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr />
                            <h4>Data Transaksi Retur</h4>
                            <table class="table table-bordered table-striped">
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
});
</script>