<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Penjualan Form
        <small>List Penjualan</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
  
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="box box-solid box-primary">
              <div class="box-header">
                <h3 class="box-title">Pencarian Barang</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <form role="form" id="cart-form">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="barcode">Kode Barang</label>
                        <input type="text" name="barcode" id="goods" class="form-control validate[required]" autofocus="true">
                      </div>
                    </div>
                    <div class="col-md-4 col-xs-6">
                      <div class="form-group">
                        <div class="input-group">
                          <input type="text" class="form-control hidden" id="qty">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-solid box-danger">
              <div class="box-header">
                <h3 class="box-title">Total Pembayaran</h3>
              </div>
              <div class="box-body">
                <table class="table">
                  <tr>
                    <td><h4><strong>Harga Total</strong></h4></td>
                    <td><h4>: <strong id="amount">Rp. 0 ,-</strong></h4></td>
                  </tr>
                  <tr>
                    <td><h4><strong>Pembayaran</strong></h4></td>
                    <td><h4>: Rp. <input type="text" name="pay" id="pay" class="validate[required,custom[number]]" value="0"> ,-</h4></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-solid box-warning">
            <div class="box-header">
              <h3 class="box-title">Keranjang</h3>
            </div>
            <div class="box-body">
              <h2 id="cart-empty" class="text-center">Keranjang Kosong</h2>
              <input type="hidden" name="total_amount" id="total_amount" value="0">
              <div class="table-responsive hidden" id="cart"> 
                <button class="btn btn-default btn-flat pull-right" data-toggle="modal" data-target="#printChart">Print</button>
                <table class="table table-hover table-bordered">
                  <thead class="bg-info">
                    <tr>
                      <td width="7%">#</td>
                      <td>Barang</td>
                      <td width="13%">Jml</td>
                      <td width="13%">Total Harga</td>
                    </tr>
                  </thead>
                  <tbody id="cart-table-body">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
    <!-- row -->
    </section>
    <!-- /.content -->
  </div>
  
  <div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="myQuantity" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-aqua">
          <h4 class="modal-title" id="myRestock">Input Barang</h4>
        </div>
        <form role="form" id="jumlah-form">
          <div class="modal-body">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="sale_price" name="sale_price">
            <input type="hidden" id="product_name" name="product_name">
            <div class="form-group">
              <strong><p class="help-block" id="name"></p></strong>
            </div>
            <div class="form-group">
              <strong><p class="help-block" id="price"></p></strong>
            </div>
            <div class="form-group">
              <label for="product_qty">Jumlah Barang</label>
              <div class="input-group">
                <input type="text" class="form-control validate[required,custom[number]]" id="product_qty" name="product_qty">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> Batal</button>
            <button type="submit" class="btn btn-primary btn-flat"> OK</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="printChart" tabindex="-1" role="dialog" aria-labelledby="myPrint" aria-hidden="true"> 
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header bg-aqua">
          <h4 class="modal-title" id="myRestock">Simpan &amp; Print Struk</h4>
        </div>
        <form role="form" id="print-form" method="POST" action="<?php echo site_url('kasir/add_process');?>">
          <input type="hidden" name="customer_id" id="customer_id" value="CUSTKASIR">
          <input type="hidden" name="is_cash" id="is_cash" value="1">
          <input type="hidden" name="total_price" id="total_price">
          <input type="hidden" name="total_pay" id="total_pay">
          <input type="hidden" name="total_item" id="total_item" value="0">
          <div class="modal-body">
            <table class="table table-hover table-bordered">
              <thead class="bg-info">
                <tr>
                  <td>Barang</td>
                  <td>Jml</td>
                  <td>Harga</td>
                </tr>
              </thead>
              <tbody id="print-table-body">
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">Total Harga</td>
                  <td>Rp. <strong id="print_amount"></strong> ,-</td>
                </tr>
                <tr>
                  <td colspan="2">Total Pembayaran</td>
                  <td>Rp. <strong id="print_pay"></strong> ,-</td>
                </tr>
                <tr>
                  <td colspan="2">Total Kembalian</td>
                  <td>Rp. <strong id="print_refund"></strong> ,-</td>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> Batal</button>
            <button type="submit" class="btn btn-primary btn-flat" id="printSubmit"> Print &amp; Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('element/footer');?>
<script src="<?php echo js_url('validation-engine.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo js_url('bootbox.min.js') ?>" type="text/javascript"></script>
<script src="<?php echo js_url('no_back_func.js') ?>" type="text/javascript" defer></script>
<script type="text/javascript">
  var num = 0;
  $(function() {
    jQuery(".form-validation").validationEngine({
      validateNonVisibleFields: true,
    });
  });

  // $('#goods').change(function() {
  //   var id = $('#goods').val();
  //   if (id != '') {
  //     $.get("<?php //echo site_url('kasir/get_stock/"+id+"') ?>", function(result){
  //       $('#id').val(result['id']);
  //       $('#category_id').val(result['category_id']);
  //       $('#product_name').val(result['product_name']);
  //       $('#sale_price').val(result['sale_price']);
  //       $('#name').html('Nama produk : '+result['product_name']);
  //       $('#price').html('Harga Satuan : '+result['sale_price']);
  //       $('#product_qty').val('1');
  //     }, "json");
  //     $('#quantityModal').modal('show');
  //   };
  // });

  $('#jumlah-form').submit(function(event) {
    event.preventDefault();
    var amount = parseInt($('#total_amount').val());
    var item = parseInt($('#total_item').val());
    var id = $('#id').val();
    //var category_id = $('#category_id').val();
    var product_name = $('#product_name').val();
    var sale_price = $('#sale_price').val();
    var product_qty = parseInt($('#product_qty').val());
    var total_price = sale_price*product_qty;
    var total_amount = amount+total_price;

    if ($('#cart').hasClass('hidden')) {
      $('#cart').removeClass('hidden');
      $('#cart-empty').addClass('hidden');
    }

    $('#cart-table-body').append('<tr><td><button class="btn btn-danger btn-xs delete-goods" data-category="category_'+id+'" data-name="name_'+id+'" data-qty="qty_'+id+'" data-product="product_'+id+'" data-print="print_'+id+'" data-price="price_'+id+'" data-total="total_'+id+'" data-amount="'+total_price+'"><i class="fa fa-close"></i></button></td><td>'+product_name+'</td><td>'+product_qty+'</td><td>Rp '+total_price+' ,-</td></tr>');
    $('#print-table-body').append('<tr id="print_'+id+'"><td>'+product_name+'</td><td>'+product_qty+'</td><td>Rp '+total_price+' ,-</td></tr>');
    $('#print-form').append('<input type="hidden" id="product_'+id+'" name="kasir['+num+'][product_id]" value="'+id+'"><input type="hidden" id="name_'+id+'" name="kasir['+num+'][product_name]" value="'+product_name+'"><input type="hidden" id="qty_'+id+'" name="kasir['+num+'][product_qty]" value="'+product_qty+'"><input type="hidden" id="price_'+id+'" name="kasir['+num+'][price_item]" value="'+sale_price+'"><input type="hidden" id="total_'+id+'" name="kasir['+num+'][subtotal]" value="'+total_price+'">');

    $('#amount').html('Rp. '+total_amount+' ,-');
    $('#total_amount').val(total_amount);
    $('#total_price').val(total_amount);
    $('#total_item').val(item+product_qty);
    $('#goods').val('');
    $('#quantityModal').modal('toggle');
    $('#goods').focus();
    num++;
  });

  $(document).on('click', '.delete-goods', function () {
    var product_item = $(this).data('product');
    var print_item = $(this).data('print');
    var qty_item = $(this).data('qty');
    var product_name = $(this).data('name');
    var category_item = $(this).data('category');
    var price_item = $(this).data('price');
    var total_item = $(this).data('total');
    var old_amount = parseInt($('#total_amount').val());
    var amount = parseInt($(this).data('amount'));
    var total_amount = old_amount-amount;
    var item = parseInt($('#total_item').val());
    var product_qty = parseInt($('#'+qty_item).val());

    $(this).parent().parent().remove();
    $('#'+product_item).remove();
    $('#'+product_name).remove();
    $('#'+qty_item).remove();
    $('#'+category_item).remove();
    $('#'+price_item).remove();
    $('#'+total_item).remove();
    $('#'+print_item).remove();

    if ($('#order').html() == '') {
      $('#cart-empty').removeClass('hidden');
      $('#cart').addClass('hidden');
    };

    $('#total_item').val(item-product_qty);
    $('#amount').html('Rp. '+total_amount+' ,-');
    $('#total_amount').val(total_amount);
    $('#total_price').val(total_amount);
    $('#goods').val('');
    $('#goods').focus();
  });

  document.addEventListener('keydown', function(event) {
    if (event.keyCode == 32) {
      var amount = parseInt($('#total_amount').val());
      var pay = parseInt($('#pay').val());
      var refund = pay-amount;

      $('#total_pay').val(pay);
      $('#print_amount').html(amount);
      $('#print_pay').html(pay);
      $('#print_refund').html(refund);
      $('#printChart').modal('show');
    }
  }, true);

  document.addEventListener('keydown', function(event) {
    if (event.keyCode == 39) {
      var id = $('#goods').val();
      if (id != '') {
        $.get("<?php echo site_url('kasir/get_stock/"+id+"') ?>", function(result){
          $('#id').val(result['id_product']);
          //$('#category_id').val(result['category_id']);
          $('#product_name').val(result['product_name']);
          $('#sale_price').val(result['sale_price']);
          $('#name').html('Nama produk : '+result['product_name']);
          $('#price').html('Harga Satuan : '+result['sale_price']);
          $('#product_qty').val('1');
        }, "json");
        $('#quantityModal').modal('show');
      };
    }
  }, true);

  $('#quantityModal').on('shown.bs.modal', function () {
    $('#product_qty').focus();
  });

  $('#quantityModal').on('hidden.bs.modal', function () {
    $('#goods').val('');
    $('#goods').focus();
  });

  $('#printChart').on('shown.bs.modal', function () {
    $('#printSubmit').focus();
  });

  $('#printChart').on('hidden.bs.modal', function () {
    $('#goods').val('');
    $('#goods').focus();
  });

</script>