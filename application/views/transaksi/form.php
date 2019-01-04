<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembelian Form
        <small>List Pembelian</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Pembelian Form</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('transaksi/create');?>"><?php echo !empty($transaksi)?'Ubah Pembelian':'Tambah Pembelian';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('transaksi');?>">List Transaki</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Pembelian</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($transaksi)){?>
            <form id="transaction-form" class="form-horizontal" method="POST" action="<?php echo site_url('transaksi/update').'/'.$transaksi[0]->id_ptransaction;?>">
            <?php }else{?>
            <form id="transaction-form" class="form-horizontal" method="POST" action="<?php echo site_url('transaksi/add_process');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Transaksi</label>
                    <div class="col-sm-8">
                      <input data-attr="true" type="text" name="id_ptransaction" data-origin="<?php echo !empty($transaksi) ? $transaksi[0]->id_ptransaction : $id_ptransaction;?>" value="<?php echo !empty($transaksi) ? $transaksi[0]->id_ptransaction : $id_ptransaction;?>" id="kode_transaksi" class="form-control" disabled/>
                      <span class="help-inline label label-danger" id="status_kode"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="category_id">Supplier</label>
                    <div class="col-sm-8">
                      <select class="form-control selectize" id="supplier_id" name="id_supplier">
                        <option value="">-- Pilih Supplier --</option>
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
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="metode">Metode Pembayaran</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="is_cash" name="is_cash">
                        <option value="1" <?php if(!empty($transaksi) && $transaksi[0]->is_cash == true) echo 'selected="selected"';?>>
                          Tunai
                        </option>
                        <option value="0" <?php if(!empty($transaksi) && $transaksi[0]->is_cash == false) echo 'selected="selected"';?>>
                          Utang
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <h3 class="content-title">Informasi Barang</h3>
                  <div class="content-process">
                    <table class="table">
                      <thead>
                        <tr>
                          <td>Kode Online</td>
                          <td>Nama Barang</td>
                          <td>Jumlah</td>
                          <td>Harga Beli Satuan</td>
                          <td>% Disc 1</td>
                          <td>% Disc 2</td>
                          <td>% Disc 3</td>
                          <td>Harga Satuan Net</td>
                          <td>Input Barang</td>
                        </tr>
                      </thead>
                      <tbody id="transaksi-item">
                        <tr>
                          <!-- <td>
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
                          </td> -->
                          <td>
                            <select class="form-control selectize" id="id_online" name="id_category">
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
                          </td>
                          <td>
                            <select class="form-control" name="id_product" id="transaksi_product_id"></select>
                          </td>
                          <td>
                            <input type="number" id="jumlah" class="form-control" name="jumlah" min="1" value="1"/>
                          </td>
                          <td>
                            <input type="text" class="form-control form-price-format discount-trx" data-attr="0" id="sale_price" name="sale_price" placeholder="Harga" required/>
                          </td>
                          <td>
                            <input type="number" value="0" min="0" max="100" class="form-control discount-trx" data-attr="1" id="disc_1" name="disc_1" placeholder="Diskon 1" disabled/>
                          </td>
                          <td>
                            <input type="number" value="0" min="0" max="100" class="form-control discount-trx" data-attr="2" id="disc_2" name="disc_2" placeholder="Diskon 2" disabled/>
                          </td>
                          <td>
                            <input type="number" value="0" min="0" max="100" class="form-control discount-trx" data-attr="3" id="disc_3" name="disc_3" placeholder="Diskon 3" disabled/>
                          </td>
                          <td>
                            <input type="text" class="form-control" id="harga_satuan_net" name="harga_satuan_net" placeholder="Harga Satuan Net"/>
                          </td>
                          <td>
                            <a href="#" class="btn btn-xs btn-primary" id="tambah-barang">Input Barang</a>
                          </td>
                        </tr>
                        <?php if(!empty($carts) && is_array($carts)){?>
                            <?php foreach($carts['data'] as $k => $cart){?>
                              <tr id="<?php echo $k;?>" class="cart-value">
                                <td><?php echo $cart['category_name'];?></td>
                                <td><?php echo $cart['name'];?></td>
                                <td><?php echo $cart['qty'];?></td>
                                <td>Rp<?php echo number_format($cart['price']);?></td>
                                <td><span class="btn btn-danger btn-sm transaksi-delete-item" data-cart="<?php echo $k;?>">x</span></td>
                              </tr>
                            <?php }?>
                        <?php }?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="3">Total Pembelian</th>
                          <th colspan="2" id="total-pembelian"><?php echo !empty($carts) ? 'Rp'.number_format($carts['total_price']) : '';?></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('transaksi');?>">Batal</a>
                  <a class="btn btn-info pull-right" href="#" id="submit-transaksi">Simpan</a>
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
<script src="<?php echo js_url('selectize.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    <?php if ($this->session->flashdata('message_success') != ''): ?>
    toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('message_error') != ''): ?>
    toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
    <?php endif ?>
    $('.selectize').selectize({
      sortField: 'text'
    });
});
$('#id_online').change(function() {
    var url =  $("base").attr("url") + 'penjualan/check_id_online/' + this.value;
    $.get(url, function(data, status){
        if(status == 'success'){
            var arr = $.parseJSON(data);
            $("#transaksi_product_id").text("");
            $("#sale_price").text("");
            $.each(arr, function(key,value){
                var default_value = '';
                if(key == 0){
                    var default_value = '<option value="0">Silahkan pilih produk</option>';
                }
                var opt_value = '<option value="'+value.id_product+'">'+value.product_name+'</option>';
                $('#transaksi_product_id').append(default_value+opt_value);
            });
        }
    });
});
</script>