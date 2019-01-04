<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Produk Index
                <small>Daftar Produk</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('produk/create');?>">Input Produk</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo site_url('produk');?>">Daftar Produk</a></li>
                        <!-- <li role="presentation"><a href="<?php echo site_url('produk/restock');?>">Data Restock</a></li> -->
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Produk</h3>
                            <div class="pull-right">
                                <h4><strong>Total Persediaan Saat Ini: <span class="form-price-format"><?php echo $persediaan;?></span>,-</strong></h4>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <?php if (!isset($warning)): ?>
                            <form action="<?php echo site_url('produk?search=true');?>" method="GET">
                            <?php else: ?>
                            <form action="<?php echo site_url('produk/warning?search=true');?>" method="GET">
                            <?php endif ?>
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Kategori</label>
                                        <select class="form-control" id="id_category" name="id_category">
                                            <option value="">-- Jenis --</option>
                                            <?php if(isset($kategoris) && is_array($kategoris)){?>
                                              <?php foreach($kategoris as $item){?>
                                                <option value="<?php echo $item->id_category;?>" <?php echo !empty($_GET['id_category']) && $_GET['id_category'] == $item->id_category ? 'selected' : '';?>>
                                                  <?php echo $item->category_name;?>
                                                </option>
                                              <?php }?>
                                            <?php }?>
                                        </select>
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
                                            <?php if (!isset($warning)): ?>
                                            <a href="<?php echo site_url('produk/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                            <?php else: ?>
                                            <a href="<?php echo site_url('produk/export_csv/warning').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <?php if (!isset($warning)): ?>
                                            <a href="<?php echo site_url('produk/warning');?>" class="form-control btn btn-warning"><i class="fa fa-exclamation-triangle"></i> Show Warning Stock</a>
                                            <?php else: ?>
                                            <a href="<?php echo site_url('produk');?>" class="form-control btn btn-info"><i class="fa fa-check"></i> Show All Stock</a>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="data-produk" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Kode Barcode</th>
                                    <th>Kode Online</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jml</th>
                                    <th>Satuan</th>
                                    <th>HPP</th>
                                    <?php if ($this->session->userdata('permission') == 0): ?>
                                    <th>Bonus</th>
                                    <?php endif ?>
                                    <th>Harga Jual</th>
                                    <th>Harga 1</th>
                                    <th>Harga 2</th>
                                    <th>Harga 3</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($produks) && is_array($produks)){ ?>
                                    <?php foreach($produks as $produk){?>
                                        <?php if ($produk['product_qty'] < $produk['minimum_qty']): ?>
                                        <tr class="danger">
                                            <td><?php echo $produk['id_product'];?></td>
                                            <td><?php echo $produk['id_online'];?></td>
                                            <td><?php echo $produk['product_name'];?></td>
                                            <td><?php echo $produk['category_name'];?></td>
                                            <td><?php echo $produk['product_desc'];?></td>
                                            <td><?php echo $produk['product_qty'];?></td>
                                            <td><?php echo $produk['product_unit'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['hpp'];?></td>
                                            <?php if ($this->session->userdata('permission') == 0): ?>
                                            <td class="form-price-format balance"><?php echo $produk['bonus'];?></td>
                                            <?php endif ?>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type1'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type2'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type3'];?></td>
                                            <td>
                                                <a href="<?php echo site_url('produk/statistik').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-default">Statistik</a>
                                                <a href="<?php echo site_url('produk/edit').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-primary">Ubah</a>
                                                <a target="_blank" href="<?php echo site_url('produk/generate_barcode').'/'.$produk['id_product'].'/'.$produk['product_name'];?>" class="btn btn-xs btn-block btn-info btn-barcode">Barcode</a>
                                                <!-- <button type="button" class="btn btn-warning btn-xs btn-restock" data-toggle="modal" data-target="#restockModal" data-id="<?php echo $produkid_product; ?>" data-unit="<?php echo $produk['product_unit']; ?>">Restock</button> -->
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus data produk ini?');" href="<?php echo site_url('produk/delete').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php else: ?>
                                        <?php if (!isset($warning)): ?>
                                        <tr>
                                            <td><?php echo $produk['id_product'];?></td>
                                            <td><?php echo $produk['id_online'];?></td>
                                            <td><?php echo $produk['product_name'];?></td>
                                            <td><?php echo $produk['category_name'];?></td>
                                            <td><?php echo $produk['product_desc'];?></td>
                                            <td><?php echo $produk['product_qty'];?></td>
                                            <td><?php echo $produk['product_unit'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['hpp'];?></td>
                                            <?php if ($this->session->userdata('permission') == 0): ?>
                                            <td class="form-price-format balance"><?php echo $produk['bonus'];?></td>
                                            <?php endif ?>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type1'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type2'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type3'];?></td>
                                            <td>
                                                <a href="<?php echo site_url('produk/statistik').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-default">Statistik</a>
                                                <a href="<?php echo site_url('produk/edit').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-primary">Ubah</a>
                                                <a target="_blank" href="<?php echo site_url('produk/generate_barcode').'/'.$produk['id_product'].'/'.$produk['product_name'];?>" class="btn btn-xs btn-block btn-info btn-barcode">Barcode</a>
                                                <!-- <button type="button" class="btn btn-warning btn-xs btn-restock" data-toggle="modal" data-target="#restockModal" data-id="<?php echo $produkid_product; ?>" data-unit="<?php echo $produk['product_unit']; ?>">Restock</button> -->
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus data produk ini?');" href="<?php echo site_url('produk/delete').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <?php endif ?>
                                        <?php endif ?>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Kode Barcode</th>
                                    <th>Kode Online</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jml</th>
                                    <th>Satuan</th>
                                    <th>HPP</th>
                                    <?php if ($this->session->userdata('permission') == 0): ?>
                                    <th>Bonus</th>
                                    <?php endif ?>
                                    <th>Harga Jual</th>
                                    <th>Harga 1</th>
                                    <th>Harga 2</th>
                                    <th>Harga 3</th>
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
                                        
    <div class="modal fade" id="restockModal" tabindex="-1" role="dialog" aria-labelledby="myRestock" aria-hidden="true"> 
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h4 class="modal-title" id="myRestock">Re-Stock Item</h4>
                </div>
                <?php
                $attributes = array('class' => 'form-validation', 'role' => 'form');
                if (!isset($warning)){
                    echo form_open('produk/restock_product', $attributes);
                }else{
                    echo form_open('produk/restock_product/warning', $attributes);
                }
                ?>
                <div class="modal-body">
                    <input type="hidden" id="restock_id" name="id_product">
                    <div class="form-group">
                        <label for="number">Re-Stock Amount</label>
                        <div class="input-group">
                            <input type="text" class="form-control validate[required,custom[number]]" id="restock_qty" name="qty" placeholder="Enter Amount">
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> Cancel</button>
                    <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-save"></i> Save</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
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
$(document).on('click', '.btn-restock', function () {
    $('#restock_id').val($(this).data('id'));       
    $('#restockModal').find('.input-group-addon').text($(this).data('unit'));
});
</script>