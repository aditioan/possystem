<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Supplier Index
        <small>Daftar Supplier</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Supplier Index</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <!-- <li role="presentation"><a href="<?php echo site_url('supplier/create');?>">Input Supplier</a></li> -->
                <li role="presentation" class="active"><a href="<?php echo site_url('supplier');?>">Daftar Supplier</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Suppliers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form action="<?php echo site_url('supplier?search=true');?>" method="GET">
                <input type="hidden" class="form-control" name="search" value="true"/>
                <div class="box-body pad">
                  <?php echo search_form('supplier');?>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <input type="submit" value="Cari" class="form-control btn btn-primary">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="submit">&nbsp;</label>
                      <a href="<?php echo site_url('supplier/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                    </div>
                  </div>
                </div>
              </form>
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
					  <td>
						<a href="<?php echo site_url('supplier/edit').'/'.$supplier->id_supplier;?>" class="btn btn-xs btn-primary">Ubah</a>
            <a href="<?php echo site_url('supplier/statistik').'/'.$supplier->id_supplier;?>" class="btn btn-xs btn-default">Statistik</a>
						<a onclick="return confirm('Apakah anda yakin akan menghapus data supplier ini?');" href="<?php echo site_url('supplier/delete').'/'.$supplier->id_supplier;?>" class="btn btn-xs btn-danger">Hapus</a>
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
    $("#data-supplier").dataTable();
});
</script>