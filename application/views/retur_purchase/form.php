<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Retur Pembelian Form
        <small>Retur Pembelian</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('retur_purchase/create');?>"><?php echo !empty($edit)?'Ubah Retur Pembelian':'Tambah Retur Pembelian';?></a></li>
            <!-- <li role="presentation"><a href="<?php echo site_url('retur_purchase');?>">List Retur Purchase</a></li> -->
          </ul>
		  <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Retur Pembelian</h3>
              <?php if($this->session->flashdata('form_false')){?>
                <div class="alert alert-danger text-center">
                  <strong><?php echo $this->session->flashdata('form_false');?></strong>
                </div>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php if(!empty($edit) && $edit){?>
            <form id="transaction-form" class="form-horizontal" method="POST" action="<?php echo site_url('retur_purchase/update').'/'.$id_pretur;?>">
            <?php }else{?>
            <form id="transaction-form" class="form-horizontal" method="POST" action="<?php echo site_url('retur_purchase/add_process');?>">
            <?php } ?>
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">Kode Retur</label>
                    <div class="col-sm-8">
                      <input type="text" name="id_pretur" value="<?php echo !empty($id_pretur) ? $id_pretur : '';?>" class="form-control" disabled/>
                      <input type="hidden" name="id_pretur" id="retur_id" value="<?php echo !empty($id_pretur) ? $id_pretur : '';?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="kode">ID Pembelian TRX</label>
                     <div class="col-sm-8">
                       <input type="text" name="id_ptransaction" value="<?php echo !empty($id_ptransaction) ? $id_ptransaction : '';?>" class="form-control" disabled/>
                       <input type="hidden" attr="true" name="id_ptransaction" id="retur_code" value="<?php echo !empty($id_ptransaction) ? $id_ptransaction : '';?>"/>
                     </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label" for="date">Tanggal</label>
                    <div class="col-sm-8">
                      <input type="text" value="<?php echo !empty($date) ? $date : date('Y-m-d H:i:s');?>" id="date" class="form-control" disabled/>
                      <input type="hidden" name="created_at" value="<?php echo !empty($date) ? $date : date('Y-m-d H:i:s');?>" id="created_at" class="form-control"/>
                    </div>
                  </div>
                  <?php //if(!empty($edit) && $edit){?>
                  <!-- <div class="form-group">
                    <label class="col-sm-4 control-label" for="date">Pengembalian Barang</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="is_return" id="is_return">
                            <option value="1" <?php //echo (int)$details[0]->is_return == 1 ? "selected" : "";?>>Yes</option>
                            <option value="0" <?php //echo (int)$details[0]->is_return == 0 ? "selected" : "";?>>No</option>
                        </select>
                    </div>
                  </div> -->
                    <div class="form-group">
                      <label class="col-sm-4 control-label" for="date">Bentuk Retur</label>
                      <div class="col-sm-8">
                        <select class="form-control" name="return_by" id="return_by">
                          <option value="0" <?php //echo (int)$details[0]->return_by == 1 ? "selected" : "";?>>Uang</option>
                          <option value="1" <?php //echo (int)$details[0]->return_by == 0 ? "selected" : "";?>>Barang</option>
                        </select>
                      </div>
                    </div>
                  <?php //} ?>
                </div>
                <div class="col-md-11 col-md-offset-1">
                  <h3 class="content-title">Informasi Barang yang ingin di Retur</h3>
                  <div class="content-process">
                    <table class="table">
                      <thead>
                        <tr>
                          <td>Kategori</td>
                          <td>Nama Barang</td>
                          <td>Jumlah</td>
                          <td>Harga Beli Satuan</td>
                          <td>Action</td>
                        </tr>
                      </thead>
                      <tbody id="transaksi-item">
                        <?php if(!empty($carts) && is_array($carts)){?>
                            <?php foreach($carts['data'] as $k => $cart){?>
                              <tr id="<?php echo $k;?>" class="cart-value">
                                <td><?php echo $cart['category_name'];?></td>
                                <td><?php echo $cart['name'];?></td>
                                <td><input type="number" row-id="<?php echo $k;?>" class="retur_purchase_qty" value="<?php echo $cart['qty'];?>" max="<?php echo $cart['qty'];?>" min="1"/></td>
                                <td>Rp<?php echo number_format($cart['price']);?></td>
                                <td><span class="btn btn-danger btn-sm transaksi-delete-item" data-cart="<?php echo $k;?>">x</span></td>
                              </tr>
                            <?php }?>
                        <?php }?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td>Total Pembelian</td>
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
                  <a class="btn btn-default" href="<?php echo site_url('retur_purchase/create');?>">Batal</a>
                  <!-- <button type="Submit" class="btn btn-info pull-right">Submit</button> -->
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