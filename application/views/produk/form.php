<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Produk Form
        <small>Produk</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('produk/create');?>"><?php echo !empty($produk)?'Ubah Produk':'Tambah Produk';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('produk');?>">List Produk</a></li>
            <li role="presentation"><a href="<?php echo site_url('produk/restock');?>">Data Restock</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Produk</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($produk)){?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('produk/save').'/'.$produk['id_product'];?>">
            <?php }else{?>
            <form class="form-horizontal" method="POST" action="<?php echo site_url('produk/save');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_product">Kode Barcode</label>
                    <div class="col-sm-5">
                      <input type="text" name="id_product" value="<?php echo !empty($produk) ? $produk['id_product'] : '';?>" id="id_product" class="form-control <?php echo !empty($produk) ? 'hidden' : '';?>" autocomplete="off" autofocus="true" />
                      <span class="help-inline label label-danger" id="status_kode"></span>
                    </div>
                    <div class="col-sm-2">
                      <button class="btn btn-info btn-code" <?php echo !empty($produk) ? 'disabled' : '';?>>Generate Kode</button>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_online">Kode Online</label>
                    <div class="col-sm-5">
                      <input type="text" name="id_online" value="<?php echo !empty($produk) ? $produk['id_online'] : '';?>" id="id_online" class="form-control" placeholder="Kode Produk Online" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="name">Nama Produk</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($produk) ? $produk['product_name'] : '';?>" name="product_name" placeholder="Nama Produk" id="name" class="form-control" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_category">Kategori</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="id_category" name="id_category">
                        <?php if(isset($category) && is_array($category)){?>
                          <?php foreach($category as $item){?>
                            <option value="<?php echo $item->id_category;?>" <?php if(!empty($produk) && $item->id_category == $produk['id_category']) echo 'selected="selected"';?>>
                              <?php echo $item->category_name;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Deskripsi</label>
                    <div class="col-sm-10">
                      <textarea name="product_desc" placeholder="Deskripsi" id="desc" class="form-control"/><?php echo !empty($produk) ? $produk['product_desc'] : '';?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Jumlah</label>
                    <div class="col-sm-2">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['product_qty'] : '';?>" name="product_qty" placeholder="Jumlah" id="qty" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Minimum Stock</label>
                    <div class="col-sm-2">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['minimum_qty'] : '';?>" name="minimum_qty" placeholder="Jumlah Minimum" id="qty" class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="unit">Satuan</label>
                    <div class="col-sm-1">
                      <select class="form-control" id="product_unit" name="product_unit">
                        <?php if(isset($unit) && is_array($unit)){?>
                          <?php foreach($unit as $item){?>
                            <option value="<?php echo $item;?>" <?php if(!empty($produk) && $item == $produk['product_unit']) echo 'selected="selected"';?>>
                              <?php echo $item;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="hpp">Harga Pokok Pembelian</label>
                    <div class="col-sm-4">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['hpp'] : '';?>" name="hpp" placeholder="Harga Pokok Pembelian" id="sale" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="bonus">Bonus Penjualan</label>
                    <div class="col-sm-4">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['bonus'] : '';?>" name="bonus" placeholder="Bonus Penjualan" id="sale" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="address">Harga Jual</label>
                    <div class="col-sm-4">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['sale_price'] : '';?>" name="sale_price" placeholder="Harga Jual" id="sale" class="form-control" required/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Harga Tipe 1</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['sale_price_type1'] : '';?>" name="sale_price_type1" placeholder="Harga Jual tipe 1" id="product_sale_type1" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Harga Tipe 2</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['sale_price_type2'] : '';?>" name="sale_price_type2" placeholder="Harga Jual tipe 2" id="product_sale_type2" class="form-control"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="address">Harga Tipe 3</label>
                    <div class="col-sm-8">
                      <input type="number" value="<?php echo !empty($produk) ? $produk['sale_price_type3'] : '';?>" name="sale_price_type3" placeholder="Harga Jual tipe 3" id="product_sale_type3" class="form-control"/>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('produk');?>">Batal</a>
                  <button class="btn btn-info pull-right" type="submit">Simpan</button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
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
$(document).on('click', '.btn-code', function () {
    var code = Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString()+Math.floor((Math.random() * 10) + 0).toString();
    $('#id_product').val(code);
});  
</script>