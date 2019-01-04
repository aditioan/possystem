<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data Supplier</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <!-- <li role="presentation"><a href="<?php echo site_url('supplier/create');?>">Input Supplier</a></li> -->
                <li role="presentation" class="active"><a>Log Data Supplier</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data Suppliers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- <form action="<?php echo site_url('log/supplier?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <?php echo search_form('supplier');?>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <input type="submit" value="Cari" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <a href="<?php echo site_url('log/export_csv/supplier').get_uri();?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form> -->
              <table id="data-supplier" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID Supplier</th>
                  <th>Nama Supplier</th>
                  <th>Nama Perusahaan</th>
                  <th>Email</th>
                  <th>Telephon</th>
                  <th>WA</th>
                  <th>Line</th>
                  <th>Alamat</th>
                  <th>Dibuat Pada</th>
                  <th>Dihapus Pada</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
          				<?php if(isset($suppliers) && is_array($suppliers)){ ?>
          				  <?php foreach($suppliers as $supplier){?>
          					<tr>
                      <td><?php echo $supplier->id_supplier;?></td>
                      <td><?php echo $supplier->supplier_name;?></td>
                      <td><?php echo $supplier->company_name;?></td>
                      <td><?php echo $supplier->supplier_email;?></td>
                      <td><?php echo $supplier->supplier_phone;?></td>
                      <td><?php echo $supplier->supplier_wa;?></td>
                      <td><?php echo $supplier->supplier_line;?></td>
          					  <td><?php echo $supplier->supplier_address;?></td>
                      <td><?php echo $supplier->created_at;?></td>
                      <td><?php echo $supplier->deleted_at;?></td>
          					  <td>
          						<a onclick="return confirm('Apakah anda yakin akan mengembalikan data Supplier ini?');" href="<?php echo site_url('log/supplier_return').'/'.$supplier->id_supplier;?>" class="btn btn-block btn-xs btn-warning">Pulihkan</a>
          						<a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Supplier ini beserta data transaksinya?');" href="<?php echo site_url('log/supplier_delete').'/'.$supplier->id_supplier;?>" class="btn btn-block btn-xs btn-danger">Hapus</a>
          					  </td>
          					</tr>
          				  <?php } ?>
          				<?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID Supplier</th>
                  <th>Nama Supplier</th>
                  <th>Nama Perusahaan</th>
                  <th>Email</th>
                  <th>Telephon</th>
                  <th>WA</th>
                  <th>Line</th>
                  <th>Alamat</th>
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
    $('#data-supplier').dataTable();
});
</script>