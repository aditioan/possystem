<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Laba Rugi Index
                <small>Laporan Laba Rugi</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Laporan Laba Rugi</a></li>
                  <!-- <li role="presentation"><a href="<?php echo site_url('laporan/create');?>">Input laporan</a></li> -->
                  <!-- <li role="presentation"><a href="<?php echo site_url('laporan/record');?>">Record laporan</a></li> -->
                  <!-- <li role="presentation"><a href="<?php echo site_url('laporan/chart');?>">Chart laporan</a></li> -->
                </ul>
                <div class="box">
                  <div class="box-header">
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="col-md-7">
                      <form action="<?php echo site_url('laporan/laba_rugi?search=true');?>" method="GET">
                        <input type="hidden" class="form-control" name="search" value="true"/>
                        <div class="box-body pad">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label>Date From</label>
                                <div class="input-group date">
                                  <input type="text" class="form-control datepicker-transaksi" name="date_from" value="<?php echo !empty($_GET['date_from']) ? $_GET['date_from'] : '';?>"/>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-3">
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
                        </div>
                    </form>
                      <!-- <form method="POST" action="<?php echo site_url('laporan/export_csv/laba_rugi');?>"> -->
                        <div class="form-group">
                          <label for="submit">&nbsp;</label>
                          <!-- <button type="submit" class="btn btn-default pull-right" id="laporan-export"><i class="fa fa-file-excel-o"></i> Export Excel</button> -->
                          <button class="btn btn-default pull-right" id="btn-image"><i class="fa fa-file-excel-o"></i> Export to PNG</button>
                        </div>
                        <table id="table-laporan" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th colspan="3">
                                <h4 class="text-center"><strong>Laporan Laba Rugi Periode <?php echo date('Y');?></strong></h4>
                                <h5 class="text-center"><strong>(Hingga Tanggal <?php echo date('d-m-Y');?>)</strong></h5>
                              </th>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th colspan="2" class="text-center">Jumlah Uang</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><strong>Penjualan</strong></td>
                                <td>
                                    <strong><span class="form-price-format"><?php echo $income['all_sales'];?></span>,-</strong>
                                    <input type="hidden" name="Penjualan" value="<?php echo $income['all_sales'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><em>Dikurangi:</em></td>
                            </tr>
                            <tr>
                                <td>Retur Penjualan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $income['sales_retur'];?></span>,-
                                    <input type="hidden" name="Retur Penjualan" value="<?php echo $income['sales_retur'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Perjualan Bersih</strong></td>
                                <td>
                                    <strong><span class="form-price-format"><?php echo $income['sales_all_bersih'];?></span>,-</strong>
                                    <input type="hidden" name="Perjualan Bersih" value="<?php echo $income['sales_all_bersih'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><em>Dikurangi:</em></td>
                            </tr>
                            <tr>
                                <td>HPP</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['hpp'];?></span>,-
                                    <input type="hidden" name="HPP" value="<?php echo $outcome['hpp'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr class="warning">
                                <td><strong>Laba Kotor</strong></td>
                                <td></td>
                                <td>
                                    <strong><span class="form-price-format"><?php echo $laba_kotor;?></span>,-</strong>
                                    <input type="hidden" name="Laba Kotor" value="<?php echo $laba_kotor;?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"><em>Ditambah:</em></td>
                            </tr>
                            <tr class="warning">
                                <td><strong>Pendapatan Sewa</strong></td>
                                <td>
                                    <strong><span class="form-price-format"><?php echo $income['sewa_tambah'];?></span>,-</strong>
                                    <input type="hidden" name="Pendapatan Sewa" value="<?php echo $income['sewa_tambah'];?>">
                                </td>
                                <td><strong><span class="form-price-format"><?php echo $income['sewa_tambah']+$laba_kotor;?></span>,-</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"><em>Dikurangi:</em></td>
                            </tr>
                            <tr>
                                <td>Biaya Perawatan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['perawatan'];?></span>,-
                                    <input type="hidden" name="Biaya Perawatan" value="<?php echo $outcome['perawatan'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Biaya Pembelian Perlengkapan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['perlengkapan'];?></span>,-
                                    <input type="hidden" name="Biaya Perlengkapan" value="<?php echo $outcome['perlengkapan'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Biaya Sewa</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['sewa_kurang'];?></span>,-
                                    <input type="hidden" name="Biaya Sewa" value="<?php echo $outcome['sewa_kurang'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Biaya Gaji</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['gaji'];?></span>,-
                                    <input type="hidden" name="Biaya Gaji" value="<?php echo $outcome['gaji'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Biaya Pengeluaran Lain</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['other_outcome'];?></span>,-
                                    <input type="hidden" name="Pengeluaran Pengeluaran Lain" value="<?php echo $outcome['other_outcome'];?>">
                                </td>
                                <td></td>
                            </tr>
                            <tr class="warning">
                                <td><strong>Total Biaya</strong></td>
                                <td></td>
                                <td>
                                    <strong><span class="form-price-format"><?php echo $outcome['total_beban'];?></span>,-</strong>
                                    <input type="hidden" name="Total Biaya" value="<?php echo $outcome['total_beban'];?>">
                                </td>
                            </tr>
                            <tr class="warning">
                                <td><strong>Laba (Rugi) Bersih</strong></td>
                                <td></td>
                                <td>
                                    <strong><span class="form-price-format"><?php echo $laba_bersih;?></span>,-</strong>
                                    <input type="hidden" name="Laba (Rugi) Bersih" value="<?php echo $laba_bersih;?>">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                      <!-- </form> -->
                    </div>
                    <div class="col-md-5">
                      <div class="col-md-12">
                          <br><br>
                      </div>
                      <div class="col-md-12">
                          <!-- Info Boxes Style 2 -->
                          <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-tag"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Modal Total</span>
                              <span class="info-box-number form-price-format"><?php echo $income['modal_total'];?></span>
                              <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                              </div>
                              <span class="progress-description">
                                Modal Total Periode Ini
                              </span>
                            </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                          <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Besar Kas Peridode Ini</span>
                              <span class="info-box-number form-price-format"><?php echo $kas;?></span>
                              <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $kas != 0? $kas/$kas*100: '0';?>%"></div>
                              </div>
                              <span class="progress-description">
                                Sisa Kas Saat ini
                              </span>
                            </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                          <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-minus"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Total Kas Keluar Peridode Ini</span>
                              <span class="info-box-number form-price-format"><?php echo $outcome['chart_outcome'];?></span>
                              <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $kas != 0? $outcome['chart_outcome']/$kas*100: '0';?>%"></div>
                              </div>
                              <span class="progress-description">
                                Pembelian+Perawatan+Gaji+Sewa+Dll
                              </span>
                            </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                          <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-plus"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Total Kas Masuk Peridode Ini</span>
                              <span class="info-box-number form-price-format"><?php echo $income['chart_income'];?></span>
                              <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $kas != 0? $income['chart_income']/$kas*100: '0';?>%"></div>
                              </div>
                              <span class="progress-description">
                                Kas Lalu+Modal+Penjualan+Sewa+Pemasukan Lain
                              </span>
                            </div><!-- /.info-box-content -->
                          </div><!-- /.info-box -->
                        </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              <!-- /.col -->
              </div>
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

  $("#btn-image").on('click', function () {
    var today = new Date();
    var date = today.getDate()+'-'+(today.getMonth()+1)+'-'+today.getFullYear();
    domtoimage.toPng(document.getElementById('table-laporan'))
    .then(function (dataUrl) {
        var link = document.createElement('a');
        link.download = 'laporan_laba_rugi_'+date+'.png';
        link.href = dataUrl;
        link.click();
    });
  });
});
</script>