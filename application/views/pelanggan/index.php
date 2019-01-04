<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pelanggan Index
                <small>Daftar Pelanggan</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('pelanggan/create');?>">Input Pelanggan</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo site_url('pelanggan');?>">Daftar Pelanggan</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table Pelanggan</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('pelanggan?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <?php //echo search_form('customer');?>
                                      <div class="col-md-2">
                                        <div class="form-group">
                                          <label for="id">Search By</label>
                                          <select class="form-control" id="search_by" name="search_by">
                                            <option value="">-- Search By --</option>
                                            <option value="id_customer" <?php echo !empty($_GET['search_by']) && $_GET['search_by'] == 'id_customer' ? 'selected' : '';?>>ID Pelanggan</option>
                                            <option value="customer_name" <?php echo !empty($_GET['search_by']) && $_GET['search_by'] == 'customer_name' ? 'selected' : '';?>>Nama Pelanggan</option>
                                            <option value="status" <?php echo !empty($_GET['search_by']) && $_GET['search_by'] == 'status' ? 'selected' : '';?>>Jenis Pelanggan</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="col-md-2" id="div1">
                                        <div class="form-group">
                                          <label for="value">Value</label>
                                          <input type="text" id="val1" class="form-control" name="value" value="<?php echo !empty($_GET['value']) ? $_GET['value'] : '';?>"/>
                                        </div>
                                      </div>
                                      <div class="col-md-2" id="div2">
                                        <div class="form-group">
                                          <label>Jenis Pelanggan</label>
                                            <select class="form-control" id="val2" name="value">
                                                <option value="">-- Jenis --</option>
                                                <option value="zero" <?php echo !empty($_GET['value']) && $_GET['value'] == 'zero' ? 'selected' : '';?>>Pelanggan Biasa</option>
                                                <option value="1" <?php echo !empty($_GET['value']) && $_GET['value'] == '1' ? 'selected' : '';?>>Reseller</option>
                                                <option value="2" <?php echo !empty($_GET['value']) && $_GET['value'] == '2' ? 'selected' : '';?>>Dropshipper</option>
                                            </select>
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
                                            <a href="<?php echo site_url('pelanggan/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="data-pelanggan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Kategori Pelanggan</th>
                                    <th>Panggilan</th>
                                    <th>Jenis</th>
                                    <th>Telephon</th>
                                    <th width="20%">Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($pelanggans) && is_array($pelanggans)){ ?>
                                    <?php foreach($pelanggans as $pelanggan){?>
                                        <tr>
                                            <td><?php echo $pelanggan->id_customer;?></td>
                                            <td><?php echo $pelanggan->customer_name;?></td>
                                            <td><?php echo $pelanggan->customer_category;?></td>
                                            <td><?php echo $pelanggan->calling;?></td>
                                            <td><?php 
                                                if ($pelanggan->status == 0) {
                                                    echo "Pelanggan Biasa";
                                                } elseif ($pelanggan->status == 1) {
                                                    echo "Reseller";
                                                } else {
                                                    echo "Dropshipper";
                                                }
                                            ?></td>
                                            <td><?php echo $pelanggan->customer_phone;?></td>
                                            <td><?php echo $pelanggan->customer_address;?></td>
                                            <td>
                                                <a href="<?php echo site_url('pelanggan/edit').'/'.$pelanggan->id_customer;?>" class="btn btn-xs btn-primary">Ubah</a>
                                                <a href="<?php echo site_url('pelanggan/statistik').'/'.$pelanggan->id_customer;?>" class="btn btn-xs btn-default">Statistik</a>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus data pelanggan ini?');" href="<?php echo site_url('pelanggan/delete').'/'.$pelanggan->id_customer;?>" class="btn btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Kategori Pelanggan</th>
                                    <th>Panggilan</th>
                                    <th>Jenis</th>
                                    <th>Telephon</th>
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
    $("#data-pelanggan").dataTable();
    var cond = $("#search_by").val();
    if (cond == "status") {
        $('#div1').addClass('hidden');
        $('#div2').removeClass('hidden');
        $('#val1').attr('disabled', 'disabled');
        $('#val2').removeAttr('disabled');
      } else if (cond == "id_customer" || cond == "customer_name") {
        $('#div1').removeClass('hidden');
        $('#div2').addClass('hidden');
        $('#val1').removeAttr('disabled');
        $('#val2').attr('disabled', 'disabled');
      }
});
$("#search_by").on("change",function(e){
  e.preventDefault();
  if (this.value == "status") {
    $('#div1').addClass('hidden');
    $('#div2').removeClass('hidden');
    $('#val1').attr('disabled', 'disabled');
    $('#val2').removeAttr('disabled');
  } else if (this.value == "id_customer" || this.value == "customer_name") {
    $('#div1').removeClass('hidden');
    $('#div2').addClass('hidden');
    $('#val1').removeAttr('disabled');
    $('#val2').attr('disabled', 'disabled');
  }
});
</script>