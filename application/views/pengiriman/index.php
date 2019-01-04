<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pengiriman Index
                <small>Daftar Pengiriman</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('pengiriman/create');?>">Input pengiriman</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo site_url('pengiriman');?>">Daftar Pengiriman</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Pengiriman</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('pengiriman?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                          <label for="id">ID Penjualan</label>
                                          <input type="text" class="form-control" name="id_stransaction" value="<?php echo !empty($_GET['id_stransaction']) ? $_GET['id_stransaction'] : '';?>"/>
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
                                            <a href="<?php echo site_url('pengiriman/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="data-pengiriman" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Penjualan</th>
                                    <th>Via</th>
                                    <th>No Resi</th>
                                    <th>Ongkir</th>
                                    <th>Ongkir Terpakai</th>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($pengirimans) && is_array($pengirimans)){ ?>
                                    <?php foreach($pengirimans as $pengiriman){?>
                                        <tr>
                                            <td><?php echo $pengiriman->id_stransaction;?> <a target="_blank" href="<?php echo site_url('penjualan/detail').'/'.$pengiriman->id_stransaction;?>" class="btn btn-xs btn-primary">detail</a></td>
                                            <td><?php echo $pengiriman->service;?></td>
                                            <td><?php echo $pengiriman->no_resi;?></td>
                                            <td class="form-price-format"><?php echo $pengiriman->ongkir;?></td>
                                            <td class="form-price-format"><?php echo $pengiriman->ongkir_terpakai;?></td>
                                            <td><?php echo $pengiriman->created_at;?></td>
                                            <td>
                                                <a href="<?php echo site_url('pengiriman/edit').'/'.$pengiriman->id_pengiriman;?>" class="btn btn-xs btn-primary">Ubah</a>
                                                <a onclick="return confirm('Apakah anda yakin untuk menghapus data pengiriman ini?');" href="<?php echo site_url('pengiriman/delete').'/'.$pengiriman->id_pengiriman;?>" class="btn btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID Penjualan</th>
                                    <th>Via</th>
                                    <th>No Resi</th>
                                    <th>Ongkir</th>
                                    <th>Ongkir Terpakai</th>
                                    <th>Tanggal Pengiriman</th>
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
    $("#data-pengiriman").dataTable();
});
</script>