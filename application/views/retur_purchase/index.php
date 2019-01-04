<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Retur Pembelian
        <small>Daftar Retur Pembelian</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('retur_purchase/create');?>">Input Retur Purchase</a></li> -->
            <li role="presentation" class="active"><a href="<?php echo site_url('retur_purchase');?>">Daftar Retur Pembelian</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Retur Pembelian</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('retur_purchase?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="id">Kode Retur</label>
                      <input type="text" class="form-control" name="id_pretur" value="<?php echo !empty($_GET['id_pretur']) ? $_GET['id_pretur'] : '';?>"/>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date From</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker-transaksi" name="date_from" value="<?php echo !empty($_GET['date_from']) ? $_GET['date_from'] : '';?>"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label>Date End</label>
                      <div class="input-group date">
                        <input type="text" class="form-control datepicker-transaksi" name="date_end" value="<?php echo !empty($_GET['date_end']) ? $_GET['date_end'] : '';?>"/>
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
                      <a href="<?php echo site_url('retur_purchase/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="data-retur-pembelian" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Retur</th>
                  <th>ID Transaksi</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Bentuk Pengembalian</th>
                  <th>Tanggal Retur</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($penjualans) && is_array($penjualans)){ ?>
                  <?php foreach($penjualans as $penjualan){?>
						    <tr>
						      <td><?php echo $penjualan->id_pretur;?></td>
    						  <td>
    							<?php echo $penjualan->id_ptransaction;?>
    							<a target="_blank" href="<?php echo strpos($penjualan->id_ptransaction,'RETS') === false ? site_url('transaksi/detail') : site_url('retur_penjualan/detail');?>/<?php echo $penjualan->id_ptransaction;?>" class="btn btn-xs btn-primary">
    							  detail
    							</a>
    						  </td>
    						  <td><?php echo $penjualan->total_item;?></td>
    						  <td class="form-price-format"><?php echo $penjualan->total_price;?></td>
    						  <td><?php echo $penjualan->return_by == 1 ? "<strong>Barang</strong>" : "<strong>Uang</strong>";?></td>
    						  <td><?php echo $penjualan->created_at;?></td>
    						  <td>
    								<a href="<?php echo site_url('retur_purchase/detail').'/'.$penjualan->id_pretur;?>" class="btn btn-xs btn-default">Detail</a>
    							<?php if($penjualan->is_return == 0){?>
    								<!-- <a href="<?php echo site_url('retur_purchase/edit').'/'.$penjualan->id_pretur;?>" class="btn btn-xs btn-primary">Edit</a> -->
    							<?php }else{ ?>
    								<!-- <span class="btn-xs btn-success">Complete</span>		 -->
    							<?php } ?>
    							
    							<a onclick="return confirm('Apakah anda yakin ingin menghapus data retur pembelian ini?');" href="<?php echo site_url('retur_purchase/delete').'/'.$penjualan->id_pretur;?>" class="btn btn-xs btn-danger">Hapus</a>
    						  </td>
    						</tr>
                  <?php } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>ID Retur</th>
                    <th>ID Transaksi</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                    <th>Bentuk Pengembalian</th>
                    <th>Tanggal Retur</th>
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
    $("#data-retur-pembelian").dataTable();
});
</script>