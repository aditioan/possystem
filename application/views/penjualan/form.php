<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Penjualan Form
        <small>Penjualan</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('penjualan/create');?>"><?php echo !empty($penjualan)?'Ubah Penjualan':'Tambah Penjualan';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('penjualan');?>">List Penjualan</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Penjualan</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($penjualan)){?>
            <form id="transaction-form" class="form-horizontal" method="POST" action="<?php echo site_url('penjualan/update').'/'.$penjualan[0]->id_stransaction;?>">
            <?php }else{?>
            <form id="transaction-form" class="form-horizontal" method="POST" action="<?php echo site_url('penjualan/add_process');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Penjualan</label>
                    <div class="col-sm-8">
                      <input type="text" name="id" value="<?php echo !empty($code_penjualan) ? $code_penjualan : '';?>" class="form-control" disabled/>
                      <input type="hidden" name="penjualan_id" id="penjualan_id" value="<?php echo !empty($code_penjualan) ? $code_penjualan : '';?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="status">Jenis Pelanggan</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="status" name="status">
                        <option value=""> -- Jenis Pelanggan --</option>
                        <?php if(isset($status) && is_array($status)){?>
                          <?php foreach($status as $item){?>
                            <option value="<?php echo $item['status'];?>" <?php if(!empty($penjualan) && $item['status'] == $penjualan['status']) echo 'selected="selected"';?>>
                              <?php echo $item['name'];?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="col-sm-4 control-label" for="id_product">Kode Barcode</label>
                    <div class="col-sm-8">
                      <input type="text" id="id" name="id_product" class="form-control" autofocus="true"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="category_id">Metode Pembayaran</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="is_cash" name="is_cash">
                        <option value="1" <?php if(!empty($penjualan) && $penjualan[0]->is_cash == true) echo 'selected="selected"';?>>
                          Tunai
                        </option>
                        <option value="0" <?php if(!empty($penjualan) && $penjualan[0]->is_cash == false) echo 'selected="selected"';?>>
                          Kredit
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group hidden" id="dropshipper">
                    <label class="col-sm-4 control-label" for="dropshipper">Dropshipper</label>
                    <div class="col-sm-8">
                      <select class="form-control selectize dropshipper" id="id_dropshipper" name="id_dropshipper">
                        <option value=""> -- Pilih Dropshipper --</option>
                        <?php if(isset($dropshippers) && is_array($dropshippers)){?>
                          <?php foreach($dropshippers as $item){?>
                            <option value="<?php echo $item->id_customer;?>" <?php if(!empty($transaksi) && $item->id_customer == $transaksi[0]->id_customer) echo 'selected="selected"';?>>
                              <?php echo $item->customer_name;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group hidden" id="pelanggan">
                    <label class="col-sm-4 control-label" for="pelanggan">Pelanggan</label>
                    <div class="col-sm-8">
                      <select class="form-control selectize pelanggan" id="customer_id" name="customer_id">
                        <option value=""> -- Pilih Pelanggan --</option>
                        <?php if(isset($pelanggans) && is_array($pelanggans)){?>
                          <?php foreach($pelanggans as $item){?>
                            <option value="<?php echo $item->id_customer;?>" <?php if(!empty($transaksi) && $item->id_customer == $transaksi[0]->id_customer) echo 'selected="selected"';?>>
                              <?php echo $item->customer_name;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group hidden" id="reseller">
                    <label class="col-sm-4 control-label" for="reseller">Reseller</label>
                    <div class="col-sm-8">
                      <select class="form-control selectize reseller" id="reseller_id" name="customer_id">
                        <option value=""> -- Pilih Reseller --</option>
                        <?php if(isset($resellers) && is_array($resellers)){?>
                          <?php foreach($resellers as $item){?>
                            <option value="<?php echo $item->id_customer;?>" <?php if(!empty($transaksi) && $item->id_customer == $transaksi[0]->id_customer) echo 'selected="selected"';?>>
                              <?php echo $item->customer_name;?>
                            </option>
                          <?php }?>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-11 col-md-offset-1">
                  <h3 class="content-title">Informasi Barang</h3>
                  <div class="content-process">
                    <table class="table">
                      <thead>
                        <tr>
                          <td>Kode Online</td>
                          <td>Nama Barang</td>
                          <td>Jumlah</td>
                          <td>Harga Jual Satuan</td>
                          <td>% Disc</td>
                          <td>Harga Akhir</td>
                          <td>Input Barang</td>
                        </tr>
                      </thead>
                      <tbody id="transaksi-item">
                        <tr>
                          <!-- <td>
                            <select class="form-control" id="transaksi_category_id" name="category_id">
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
                          </td>
                          <td>
                            <select class="form-control sales_product" id="transaksi_product_id" name="product_id"></select>
                          </td>
                          <td>
                            <input type="number" id="jumlah" class="form-control" name="jumlah" min="1" value="1"/>
                          </td>
                          <td>
                            <select class="form-control" id="sale_price" name="sale_price"></select>
                          </td>
                          <td>
                            <input type="number" value="0" min="0" max="100" class="form-control discount-sales" id="disc_sales" name="disc_sales"/>
                          </td>
                          <td>
                            <input type="text" class="form-control" id="harga_satuan_net" name="harga_satuan_net" placeholder="Harga Satuan Net"/>
                          </td>
                          <td>
                            <a href="#" class="btn btn-primary" id="tambah-barang2">Input Barang</a>
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
                          <td>Total Penjualan</td>
                          <td id="total-pembelian"><?php echo !empty($carts) ? 'Rp'.number_format($carts['total_price']) : '';?></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-3 col-md-offset-4">
                  <a class="btn btn-default" href="<?php echo site_url('penjualan');?>">Batal</a>
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
$("#status").on("change",function(e){
  e.preventDefault();
  // var url =  $("base").attr("url") + 'penjualan/get_pelanggan/' + this.value;
  // $.get(url, function(data, status){
  //     if(status == 'success'){
  //       $('#customer').removeClass('hidden');
  //       $('.pelanggan').html('');
  //       var arr = $.parseJSON(data);
  //       $.each(arr, function(key,value){
  //         if (value.status == 1) {$('#label').text('Reseller');}
  //         $('.pelanggan').append('<option value="'+value.id_customer+'">'+value.customer_name+'</option>');
  //       });
  //     }
  // });
  // if (this.value == 2) {
  //   var url =  $("base").attr("url") + 'penjualan/get_pelanggan/0';
  //   $.get(url, function(data, status){
  //       if(status == 'success'){
  //         $('#customer2').removeClass('hidden');
  //         $('.pelanggan2').html('');
  //         var arr = $.parseJSON(data);
  //         $.each(arr, function(key,value){
  //           $('#label').text('Dropshipper');
  //           $('.pelanggan').attr('id', 'id_dropshipper');
  //           $('.pelanggan2').attr('id', 'customer_id');
  //           $('.pelanggan2').append('<option value="'+value.id_customer+'">'+value.customer_name+'</option>');
  //         });
  //       }
  //   });
  // }
  if (this.value == 0) {
    $('#pelanggan').removeClass('hidden');
    $('#reseller').addClass('hidden');
    $('#dropshipper').addClass('hidden');
    $('.pelanggan').attr('id', 'customer_id');
    $('.reseller').attr('id', 'reseller_id');
  }else if (this.value == 1){
    $('#pelanggan').addClass('hidden');
    $('#reseller').removeClass('hidden');
    $('#dropshipper').addClass('hidden');
    $('.pelanggan').attr('id', 'reseller_id');
    $('.reseller').attr('id', 'customer_id');
  }else{
    $('#dropshipper').removeClass('hidden');
    $('#pelanggan').removeClass('hidden');
    $('#reseller').addClass('hidden');
    $('.pelanggan').attr('id', 'customer_id');
    $('.reseller').attr('id', 'reseller_id');
  }
});
document.addEventListener('keydown', function(event) {
  if (event.keyCode == 13) {
    var id = $('#id').val();
    if (id != '') {
      var url =  $("base").attr("url") + 'penjualan/check_product_id/' + id;
      $.get(url, function(data, status){
          if(status == 'success'){
              var arr = $.parseJSON(data);
              $("#transaksi_product_id").text("");
              $("#sale_price").text("");
              $.each(arr, function(key,value){
                  $('#transaksi_product_id').append('<option value="'+value.id_product+'">'+value.product_name+'</option>');
                  var sale_value = '<option value="' + value.sale_price + '">' + price(parseInt(value.sale_price)) + ' Default</option>';
                    if(value.sale_price_type1 != "0"){
                        var type1 = '<option value="' + value.sale_price_type1 + '">' + price(parseInt(value.sale_price_type1)) + ' Type 1 </option>';
                    }
                    if(value.sale_price_type2 != "0"){
                        var type2 = '<option value="' + value.sale_price_type2 + '">' + price(parseInt(value.sale_price_type2)) + ' Type 2</option>';
                    }
                    if(value.sale_price_type3 != "0") {
                        var type3 = '<option value="' + value.sale_price_type3 + '">' + price(parseInt(value.sale_price_type3)) + ' Type 3</option>';
                    }
                    $('#sale_price').append(sale_value+type1+type2+type3);
              });
          }
      });
    };
  }
}, true);
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
$("#tambah-barang2").on("click",function(e){
    e.preventDefault();

    var id_product = $("#transaksi_product_id").val();
    var quantity = $("#jumlah").val();
    var sale_price = $("#sale_price").val();
    if($('#harga_satuan_net').val() != '' && $('#harga_satuan_net').val() != '0'){
        sale_price = $('#harga_satuan_net').unmask();
    }
    if(id_product !== null && sale_price !== null){
        $.ajax({
            url: $("base").attr("url") + 'transaksi/add_item',
            data: {
                'id_product' : id_product,
                'data_qty' : quantity,
                'sale_price' : sale_price
            },
            type: 'POST',
            beforeSend : function(){
                $el.faLoading();
            },
            success: function(data){
                var res = $.parseJSON(data);
                $(".cart-value").remove();
                $.each(res.data, function(key,value) {
                    var row_2 = "";
                    if($('#harga_satuan_net').length){
                        //row_2 = "colspan='2'";
                    }
                    var display = '<tr class="cart-value" id="'+ key +'">' +
                                '<td>'+ value.id_online +'</td>' +
                                '<td>'+ value.category_name +'</td>' +
                                '<td>'+ value.name +'</td>' +
                                '<td>'+ value.qty +'</td>' +
                                '<th '+row_2+'>Rp'+ price(value.subtotal) +'</th>' +
                                '<td><span class="btn btn-danger btn-sm transaksi-delete-item" data-cart="'+ key +'">x</span></td>' +
                                '</tr>';
                    $("#transaksi-item tr:last").after(display);
                });
                $("#total-pembelian").text('Rp'+price(res.total_price));
                $("#transaksi-item").find("input[type=text], input[type=number]").val("0");
                $el.faLoading(false);
                console.log(res);
            },
            error: function(){
                alert('Preketek banget!!!');
            }
        });
    }else{
        alert("Silahkan isi semua box");
    }
});
$('.discount-sales').bind("keyup change", function(e){
    //e.preventDefault();
    var next = parseInt($(this).attr('data-attr')) + 1;
    var disc = parseInt($(this).val());
    var disc_unmask = $(this).unmask();

    if(disc > 100){
        $(this).val("100");
    }
    var sale_price = $("#sale_price").val();
    var disc = $("#disc_sales").val();
    var final_price = count_discount(sale_price,disc,'','');
    $("#harga_satuan_net").val("Rp "+price(final_price));
    //$("#harga_satuan_net").val(final_price);
});
</script>