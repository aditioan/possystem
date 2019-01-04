<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Produk Kongsinyasi Index
                <small>Daftar Produk Kongsinyasi</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('produk/create');?>">Input Produk</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo site_url('produk');?>">Daftar Produk Kongsinyasi</a></li>
                        <!-- <li role="presentation"><a href="<?php echo site_url('produk/restock');?>">Data Restock</a></li> -->
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Produk Kongsinyasi</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('kongsinyasi/create');?>" method="POST">
                                <div class="box-body pad">
                                  <!-- <div class="col-md-2">
                                    <div class="form-group">
                                      <label class="col-sm-4 control-label" for="category_id">Supplier</label>u
                                      <select class="form-control" id="supplier_id" name="id_supplier">
                                        <?php if(isset($suppliers) && is_array($suppliers)){?>
                                          <?php foreach($suppliers as $item){?>
                                            <option value="<?php echo $item->id_supplier;?>" <?php if(!empty($transaksi) && $item->id_supplier == $transaksi[0]->id_supplier) echo 'selected="selected"';?>>
                                              <?php echo $item->supplier_name;?>
                                            </option>
                                          <?php }?>
                                        <?php }?>
                                      </select>
                                    </div>
                                  </div> -->
                               <!--    <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Kategori</label>
                                        <select class="form-control" id="transaksi_category_id" name="id_category">
                                          <option value="0">
                                            -- Kategori --
                                          </option>
                                          <?php if(isset($kategoris) && is_array($kategoris)){?>
                                            <?php foreach($kategoris as $item){?>
                                              <option value="<?php echo $item->id_category;?>">
                                                <?php echo $item->category_name;?>
                                              </option>
                                            <?php }?>
                                          <?php }?>
                                        </select>
                                    </div>
                                  </div> -->
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Kode Online</label>
                                        <select class="form-control selectize" id="id_online" name="category_id">
                                          <option value=" ">
                                            -- Kode --
                                          </option>
                                          <?php if(isset($onlines) && is_array($onlines)){?>
                                            <?php foreach($onlines as $item){?>
                                              <option value="<?php echo $item->id_online;?>">
                                                <?php echo $item->id_online;?>
                                              </option>
                                            <?php }?>
                                          <?php }?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Nama Produk</label>
                                        <select class="form-control" name="id_product" id="transaksi_product_id"></select>
                                    </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Jumlah</label>
                                        <input type="number" id="jumlah" class="form-control" name="kongsinyasi" min="1" value="1"/>
                                    </div>
                                  </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <input type="submit" value="Tambah" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <a href="<?php echo site_url('kongsinyasi/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div> -->
                                </div>
                            </form>
                            <table id="data-produk" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Jml Awal</th>
                                    <th>Jml Sekarang</th>
                                    <th>Satuan</th>
                                    <th>HPP</th>
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
                                        <tr>
                                            <td><?php echo $produk['id_product'];?></td>
                                            <td><?php echo $produk['product_name'];?></td>
                                            <td><?php echo $produk['category_name'];?></td>
                                            <td><?php echo $produk['kongsinyasi'];?></td>
                                            <td><?php echo $produk['product_qty'];?></td>
                                            <td><?php echo $produk['product_unit'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['hpp'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type1'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type2'];?></td>
                                            <td class="form-price-format balance"><?php echo $produk['sale_price_type3'];?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-xs btn-block btn-finish" data-toggle="modal" data-target="#finishModal" data-id="<?php echo $produk['id_product']; ?>">Selesai</button>
                                                <button type="button" class="btn btn-info btn-xs btn-block btn-edit" data-toggle="modal" data-target="#editModal" data-id="<?php echo $produk['id_product']; ?>" data-jumlah="<?php echo $produk['product_qty']; ?>" data-kongsinyasi="<?php echo $produk['kongsinyasi']; ?>" data-unit="<?php echo $produk['product_unit']; ?>">Ubah</button>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus data kongsinyasi produk ini?');" href="<?php echo site_url('kongsinyasi/delete').'/'.$produk['id_product'];?>" class="btn btn-xs btn-block btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                   <th>Kode</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Jml Awal</th>
                                    <th>Jml Sekarang</th>
                                    <th>Satuan</th>
                                    <th>HPP</th>
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myRestock" aria-hidden="true"> 
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-aqua">
                    <h4 class="modal-title" id="myEdit">Edit Kongsinyasi</h4>
                </div>
                <?php
                $attributes = array('class' => 'form-validation', 'role' => 'form');
                echo form_open('kongsinyasi/edit', $attributes);
                ?>
                <div class="modal-body">
                    <input type="hidden" id="id_product" name="id_product">
                    <input type="hidden" id="product_qty" name="product_qty">
                    <input type="hidden" id="kongsinyasi_old" name="kongsinyasi_old">
                    <div class="form-group">
                        <label for="number">Jumlah Awal Kongsinyasi</label>
                        <div class="input-group">
                            <input type="text" class="form-control validate[required,custom[number]]" id="kongsinyasi_new" name="kongsinyasi_new" placeholder="Masukkan jumlah awal kongsinyasi">
                            <div class="input-group-addon"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> Batal</button>
                    <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-fw fa-save"></i> Simpan</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>                             
    <div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="myRestock" aria-hidden="true"> 
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-orange">
                    <h4 class="modal-title" id="myFinish">Finish Kongsinyasi</h4>
                </div>
                <?php
                $attributes = array('class' => 'form-validation', 'role' => 'form');
                echo form_open('kongsinyasi/finish', $attributes);
                ?>
                <div class="modal-body">
                    <input type="hidden" id="id_product2" name="id_product">
                    <div class="form-group">
                        <label class="control-label" for="category_id">Pilih Supplier</label>
                          <select class="form-control selectize" id="supplier_id" name="id_supplier">
                            <option value=" ">
                                -- Supplier --
                            </option>
                            <?php if(isset($suppliers) && is_array($suppliers)){?>
                              <?php foreach($suppliers as $item){?>
                                <option value="<?php echo $item->id_supplier;?>" <?php if(!empty($transaksi) && $item->id_supplier == $transaksi[0]->id_supplier) echo 'selected="selected"';?>>
                                  <?php echo $item->supplier_name;?>
                                </option>
                              <?php }?>
                            <?php }?>
                          </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> Batal</button>
                    <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-save"></i> Finish</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
<?php $this->load->view('element/footer');?>
<script src="<?php echo js_url('selectize.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    <?php if ($this->session->flashdata('message_success') != ''): ?>
    toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('message_error') != ''): ?>
    toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
    <?php endif ?>
    $("#data-produk").dataTable();
    $('.selectize').selectize({
      sortField: 'text'
    });
});
$(document).on('click', '.btn-edit', function () {
    $('#id_product').val($(this).data('id'));
    $('#product_qty').val($(this).data('jumlah'));
    $('#kongsinyasi_old').val($(this).data('kongsinyasi'));
    $('#kongsinyasi_new').val($(this).data('kongsinyasi'));
    $('#editModal').find('.input-group-addon').text($(this).data('unit'));
});
$(document).on('click', '.btn-finish', function () {
    $('#id_product2').val($(this).data('id'));
});
$('#id_online').change(function() {
    var url =  $("base").attr("url") + 'kongsinyasi/check_id_online/' + this.value;
    $.get(url, function(data, status){
        if(status == 'success'){
            var arr = $.parseJSON(data);
            $("#transaksi_product_id").text("");
            $.each(arr, function(key,value){
                var default_value = '';
                if(key == 0){
                    var default_value = '<option value="">Silahkan pilih produk</option>';
                }
                var opt_value = '<option value="'+value.id_product+'">'+value.product_name+'</option>';
                $('#transaksi_product_id').append(default_value+opt_value);
            });
        }
    });
});
</script>