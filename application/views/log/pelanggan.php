<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Log Data
                <small>Pelanggan</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('pelanggan/create');?>">Input Pelanggan</a></li> -->
                        <li role="presentation" class="active"><a>Log Data Pelanggan</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Log Data Pelanggan</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- <form action="<?php echo site_url('log/pelanggan?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <?php echo search_form('customer');?>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <input type="submit" value="Cari" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <a href="<?php echo site_url('log/export_csv/customer').get_uri();?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form> -->
                            <table id="data-pelanggan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Panggilan</th>
                                    <th>Jenis Pelanggan</th>
                                    <th>No. Telephon</th>
                                    <th>Alamat</th>
                                    <th>Dibuat Pada</th>
                                    <th>Dihapus Pada</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($pelanggans) && is_array($pelanggans)){ ?>
                                    <?php foreach($pelanggans as $pelanggan){?>
                                        <tr>
                                            <td><?php echo $pelanggan->id_customer;?></td>
                                            <td><?php echo $pelanggan->customer_name;?></td>
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
                                            <td><?php echo $pelanggan->created_at;?></td>
                                            <td><?php echo $pelanggan->deleted_at;?></td>
                                            <td>
                                                <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Pelanggan ini?');" href="<?php echo site_url('log/pelanggan_return').'/'.$pelanggan->id_customer;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Pelanggan ini beserta data transaksinya?');" href="<?php echo site_url('log/pelanggan_delete').'/'.$pelanggan->id_customer;?>" class="btn btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Panggilan</th>
                                    <th>Jenis Pelanggan</th>
                                    <th>No. Telephon</th>
                                    <th>Alamat</th>
                                    <th>Dibuat Pada</th>
                                    <th>Dihapus Pada</th>
                                    <th>Action</th>
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
    $('#data-pelanggan').dataTable();
});
</script>