<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Restock
        <small>List Restock</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <ul class="nav nav-tabs">
            <!-- <li role="presentation"><a href="<?php echo site_url('produk/create');?>">Input Produk</a></li>
            <li role="presentation"><a href="<?php echo site_url('produk');?>">List Produk</a></li> -->
            <li role="presentation" class="active"><a href="<?php echo site_url('produk/restock');?>">Data Restock</a></li>
          </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Restock Product</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('produk/restock?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <?php echo search_form('product');?>
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
                      <a href="<?php echo site_url('produk/export_csv/restock').get_uri();?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Jumlah Awal</th>
                  <th>Jumlah Restok</th>
                  <th>Jumlah Akhir</th>
                  <th>Unit</th>
                  <th>Tanggal</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($restock) && is_array($restock)){ ?>
                  <?php foreach($restock as $restok){?>
                    <tr>
                      <td><?php echo $restok->id_product;?></td>
                      <td><?php echo $restok->product_name;?></td>
                      <td><?php echo $restok->category_name;?></td>
                      <td><?php echo $restok->qty_before;?></td>
                      <td><?php echo $restok->stock_qty;?></td>
                      <td><?php echo $restok->qty_before+$restok->stock_qty;?></td>
                      <td><?php echo $restok->product_unit;?></td>
                      <td><?php echo $restok->created_at;?></td>
                      <td>
                        <a onclick="return confirm('Are you sure you want to delete this data?');" href="<?php echo site_url('produk/delete_restock').'/'.$restok->id_restock;?>" class="btn btn-xs btn-danger">Delete</a>
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
                    <th>Jumlah Awal</th>
                    <th>Jumlah Restok</th>
                    <th>Jumlah Akhir</th>
                    <th>Unit</th>
                    <th>Tanggal</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="text-center">
              <?php echo $paggination;?>
            </div>
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