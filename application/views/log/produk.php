<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Log Data
                <small>Produk</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('produk/create');?>">Input Produk</a></li> -->
                        <li role="presentation" class="active"><a>Log Data Produk</a></li>
                        <!-- <li role="presentation"><a href="<?php echo site_url('produk/restock');?>">Data Restock</a></li> -->
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Log Data Produk</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- <form action="<?php echo site_url('log/produk?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <?php echo search_form('product');?>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Date From</label>
                                      <div class="input-group date">
                                        <input type="text" class="form-control datepicker" name="date_from" value="<?php echo !empty($_GET['date_from']) ? $_GET['date_from'] : '';?>"/>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Date End</label>
                                      <div class="input-group date">
                                        <input type="text" class="form-control datepicker" name="date_end" value="<?php echo !empty($_GET['date_end']) ? $_GET['date_end'] : '';?>"/>
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
                                            <a href="<?php echo site_url('log/export_csv/product').get_uri();?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form> -->
                            <table id="data-produk" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Jml</th>
                                    <th>Unit</th>
                                    <th>HPP</th>
                                    <th>Harga</th>
                                    <th>Harga 1</th>
                                    <th>Harga 2</th>
                                    <th>Harga 3</th>
                                    <th>Dibuat Pada</th>
                                    <th>Dihapus Pada</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($produks) && is_array($produks)){ ?>
                                    <?php foreach($produks as $produk){?>
                                        <tr>
                                            <td><?php echo $produk->id_product;?></td>
                                            <td><?php echo $produk->product_name;?></td>
                                            <td><?php echo $produk->product_desc;?></td>
                                            <td><?php echo $produk->product_qty;?></td>
                                            <td><?php echo $produk->product_unit;?></td>
                                            <td><?php echo $produk->hpp;?></td>
                                            <td><?php echo $produk->sale_price;?></td>
                                            <td class="form-price-format balance"><?php echo $produk->sale_price_type1;?></td>
                                            <td class="form-price-format balance"><?php echo $produk->sale_price_type2;?></td>
                                            <td class="form-price-format balance"><?php echo $produk->sale_price_type3;?></td>
                                            <td><?php echo $produk->created_at;?></td>
                                            <td><?php echo $produk->deleted_at;?></td>
                                            <td>
                                            <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Produk ini?');" href="<?php echo site_url('log/produk_return').'/'.$produk->id_product;?>" class="btn btn-xs btn-warning btn-block">Pulihkan</a>
                                            <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Produk ini beserta data transaksinya?');" href="<?php echo site_url('log/produk_delete').'/'.$produk->id_product;?>" class="btn btn-xs btn-danger btn-block">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                   <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Jml</th>
                                    <th>Unit</th>
                                    <th>HPP</th>
                                    <th>Harga</th>
                                    <th>Harga 1</th>
                                    <th>Harga 2</th>
                                    <th>Harga 3</th>
                                    <th>Dibuat Pada</th>
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
    $("#data-produk").dataTable();
});
</script>