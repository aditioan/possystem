<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Transaksi Lain Index
                <small>Daftar Transakti Lain</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('other');?>">List other</a></li> -->
                        <!-- <li role="presentation"><a href="<?php echo site_url('other/create');?>">Input other</a></li> -->
                        <li role="presentation" class="active"><a>Transaksi Lain</a></li>
                        <!-- <li role="presentation"><a href="<?php echo site_url('other/chart');?>">Chart other</a></li> -->
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Transaksi Lain</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('other_transaction?search=true');?>" method="GET">
                            <input type="hidden" class="form-control" name="search" value="true"/>
                            <div class="box-body pad">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="id">Kode Transaksi</label>
                                  <input type="text" class="form-control" name="id_otransaction" value="<?php echo !empty($_GET['id_otransaction']) ? $_GET['id_otransaction'] : '';?>"/>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label>Jenis Transaksi</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="">-- Jenis --</option>
                                        <option value="modal" <?php echo !empty($_GET['type']) && $_GET['type'] == 'modal' ? 'selected' : '';?>>Modal</option>
                                        <option value="peralatan" <?php echo !empty($_GET['type']) && $_GET['type'] == 'peralatan' ? 'selected' : '';?>>Peralatan</option>
                                        <option value="perlengkapan" <?php echo !empty($_GET['type']) && $_GET['type'] == 'perlengkapan' ? 'selected' : '';?>>Perlengkapan</option>
                                        <option value="sewa" <?php echo !empty($_GET['type']) && $_GET['type'] == 'sewa' ? 'selected' : '';?>>Sewa</option>
                                        <option value="kas" <?php echo !empty($_GET['type']) && $_GET['type'] == 'kas' ? 'selected' : '';?>>Kas Awal</option>
                                        <option value="persediaan" <?php echo !empty($_GET['type']) && $_GET['type'] == 'persediaan' ? 'selected' : '';?>>Persediaan Awal</option>
                                        <option value="utang" <?php echo !empty($_GET['type']) && $_GET['type'] == 'utang' ? 'selected' : '';?>>Utang</option>
                                        <option value="perawatan" <?php echo !empty($_GET['type']) && $_GET['type'] == 'perawatan' ? 'selected' : '';?>>Perawatan</option>
                                        <option value="gaji" <?php echo !empty($_GET['type']) && $_GET['type'] == 'gaji' ? 'selected' : '';?>>Gaji Karyawan</option>
                                        <option value="lain-lain" <?php echo !empty($_GET['type']) && $_GET['type'] == 'lain-lain' ? 'selected' : '';?>>Lain-Lain</option>
                                    </select>
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
                                  <a href="<?php echo site_url('other_transaction/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                </div>
                              </div>
                            </div>
                          </form>
                            <table id="data-other" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Uang Transaksi</th>
                                    <th>Aksi Transaksi</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Tanggal Diupdate</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($others) && is_array($others)){ ?>
                                    <?php foreach($others as $other){?>
                                        <tr>
                                            <td><?php echo $other->id_otransaction;?></td>
                                            <td><strong><?php echo strtoupper($other->type);?></strong></td>
                                            <td class="form-price-format"><?php echo $other->cash_trx;?></td>
                                            <?php if($other->action == 1): ?>
                                            <td>Penambahan</td>
                                            <?php else: ?>
                                            <td>Pengurangan</td>
                                            <?php endif ?>
                                            <td><?php echo $other->description;?></td>
                                            <td><?php echo $other->created_at;?></td>
                                            <td><?php echo $other->updated_at;?></td>
                                            <td>
                                                <a href="<?php echo site_url('other_transaction/edit').'/'.$other->id_otransaction;?>" class="btn btn-block btn-xs btn-primary">Ubah</a>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus transaksi ini?');" href="<?php echo site_url('other_transaction/delete').'/'.$other->id_otransaction;?>" class="btn btn-block btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Uang Transaksi</th>
                                    <th>Aksi Transaksi</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Tanggal Diupdate</th>
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
    $("#data-other").dataTable();
});
</script>