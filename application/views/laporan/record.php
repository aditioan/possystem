<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Neraca Index
                <small>List Neraca</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('neraca');?>">List Neraca</a></li> -->
                        <!-- <li role="presentation"><a href="<?php echo site_url('neraca/create');?>">Input Neraca</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo site_url('neraca/record');?>">Record Neraca</a></li>
                        <!-- <li role="presentation"><a href="<?php echo site_url('neraca/chart');?>">Chart Neraca</a></li> -->
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table Transaksi Lain</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('neraca/record?search=true');?>" method="GET">
                            <input type="hidden" class="form-control" name="search" value="true"/>
                            <div class="box-body pad">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="id">Kode Transaksi</label>
                                  <input type="text" class="form-control" name="id_transaction" value="<?php echo !empty($_GET['id_transaction']) ? $_GET['id_transaction'] : '';?>"/>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label>Jenis Transaksi</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="">-- Jenis --</option>
                                        <option value="modal" <?php echo !empty($_GET['type']) && $_GET['type'] == 'modal' ? 'selected' : '';?>>Modal</option>
                                        <option value="pembelian" <?php echo !empty($_GET['type']) && $_GET['type'] == 'pembelian' ? 'selected' : '';?>>Pembelian</option>
                                        <option value="penjualan" <?php echo !empty($_GET['type']) && $_GET['type'] == 'penjualan' ? 'selected' : '';?>>Penjualan</option>
                                        <option value="retur" <?php echo !empty($_GET['type']) && $_GET['type'] == 'retur' ? 'selected' : '';?>>Retur</option>
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
                                  <a href="<?php echo site_url('retur_penjualan/export_csv').get_uri();?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                </div>
                              </div>
                            </div>
                          </form>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Uang Sebelum</th>
                                    <th>Uang Transaksi</th>
                                    <th>Total Kas</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($neracas) && is_array($neracas)){ ?>
                                    <?php foreach($neracas as $neraca){?>
                                        <tr>
                                            <td><?php echo $neraca->id_transaction;?></td>
                                            <td><?php echo $neraca->type;?></td>
                                            <td class="form-price-format"><?php echo $neraca->cash_total-$neraca->cash_trx;?>,-</td>
                                            <td class="form-price-format"><?php echo $neraca->cash_trx;?>, -</td>
                                            <td class="form-price-format"><?php echo $neraca->cash_total;?>, -</td>
                                            <td><?php echo $neraca->description;?></td>
                                            <td><?php echo $neraca->created_at;?></td>
                                            <td>
                                                <?php if ($neraca->type == 'penjualan' || $neraca->type == 'pembelian' || $neraca->type == 'retur'): ?>
                                                    <?php 
                                                        if ($neraca->type == 'pembelian') {
                                                            $neraca->type = 'transaksi';
                                                        }
                                                        if ($neraca->type == 'retur' && $neraca->action == 1) {
                                                            $neraca->type = 'retur_purchase';
                                                        }
                                                        if ($neraca->type == 'retur' && $neraca->action == 0) {
                                                            $neraca->type = 'retur_penjualan';
                                                        } 
                                                    ?>
                                                <a target="_blank" href="<?php echo site_url($neraca->type.'/detail').'/'.$neraca->id_transaction;?>" class="btn btn-xs btn-default">Detail</a>
                                                <?php endif ?>
                                                <a onclick="return confirm('Are you sure you want to delete this neraca?');" href="<?php echo site_url('neraca/delete').'/'.$neraca->id_balance;?>" class="btn btn-xs btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Uang Sebelum</th>
                                    <th>Uang Transaksi</th>
                                    <th>Total Kas</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Transaksi</th>
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