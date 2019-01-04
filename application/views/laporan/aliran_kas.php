<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Aliran Kas Index
                <small>Laporan Aliran Kas</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-xs-12">
                <ul class="nav nav-tabs">
                  <li role="presentation" class="active"><a>Laporan Aliran Kas</a></li>
                  <!-- <li role="presentation"><a href="<?php echo site_url('laporan/create');?>">Input laporan</a></li> -->
                  <!-- <li role="presentation"><a href="<?php echo site_url('laporan/record');?>">Record laporan</a></li> -->
                  <!-- <li role="presentation"><a href="<?php echo site_url('laporan/chart');?>">Chart laporan</a></li> -->
                </ul>
                <div class="box">
                  <div class="box-header">
                      <h3 class="box-title">Laporan Aliran Kas</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <div class="col-md-7">
                      <form action="<?php echo site_url('laporan/aliran_kas?search=true');?>" method="GET">
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
                      <!-- <form method="POST" action="<?php echo site_url('laporan/export_csv/aliran_kas');?>"> -->
                        <div class="form-group">
                          <label for="submit">&nbsp;</label>
                          <!-- <button type="submit" class="btn btn-default pull-right" id="laporan-export"><i class="fa fa-file-excel-o"></i> Export Excel</button> -->
                          <button class="btn btn-default pull-right" id="btn-image"><i class="fa fa-file-excel-o"></i> Export to PNG</button>
                        </div>
                        <table id="table-laporan" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              <th colspan="3">
                                <h4 class="text-center"><strong>Laporan Aliran Kas Periode <?php echo date('Y');?></strong></h4>
                              </th>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <th class="text-center">Jumlah Uang</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="2"><strong>Aliran Kas Aktivitas Operasi</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"><em><strong>Ditambahkan</strong></em></td>
                            </tr>
                            <tr>
                                <td>Kas diterima dari kas tahun lalu</td>
                                <td>
                                    <span class="form-price-format"><?php echo $income['kas_awal'];?></span>,-
                                    <input type="hidden" name="Kas diterima dari modal awal" value="<?php echo $income['kas_awal'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas diterima dari modal</td>
                                <td>
                                    <span class="form-price-format"><?php echo $income['modal_total'];?></span>,-
                                    <input type="hidden" name="Kas diterima dari modal awal" value="<?php echo $income['modal_total'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas diterima dari penjualan produk</td>
                                <td>
                                    <span class="form-price-format"><?php echo $income['sales_bersih'];?></span>,-
                                    <input type="hidden" name="Kas diterima dari penjualan" value="<?php echo $income['sales_bersih'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas diterima dari penyewaan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $income['sewa_tambah'];?></span>,-
                                    <input type="hidden" name="Kas diterima dari penjualan" value="<?php echo $income['sewa_tambah'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas diterima dari pemasukan lain</td>
                                <td>
                                    <span class="form-price-format"><?php echo $income['other_income'];?></span>,-
                                    <input type="hidden" name="Kas diterima dari pemasukan lain" value="<?php echo $income['other_income'];?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><em><strong>Dikurangkan</strong></em></td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk membayar gaji</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['gaji'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk membayar gaji" value="(<?php echo $outcome['gaji'];?>)">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk pembelian produk</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['purchase_bersih'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk pembelian produk" value="(<?php echo $outcome['purchase_bersih'];?>)">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk penyewaan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['sewa_kurang'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk pembelian produk" value="(<?php echo $outcome['sewa_kurang'];?>)">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk membeli peralatan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['peralatan'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk membeli peralatan" value="(<?php echo $outcome['peralatan'];?>)">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk membeli perlengkapan</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['perlengkapan'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk membeli perlengkapan" value="(<?php echo $outcome['perlengkapan'];?>)">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk perawatan alat</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['perawatan'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk perawatan alat" value="(<?php echo $outcome['perawatan'];?>)">
                                </td>
                            </tr>
                            <tr>
                                <td>Kas dibayarkan untuk keperluan lain</td>
                                <td>
                                    <span class="form-price-format"><?php echo $outcome['other_outcome'];?></span>,-
                                    <input type="hidden" name="Kas dibayarkan untuk keperluan lain" value="(<?php echo $outcome['other_outcome'];?>)">
                                </td>
                            </tr>
                            <tr class="warning">
                                <td><strong>Total Kas Aktivitas Operasi</strong></td>
                                <td>
                                    <span class="form-price-format"><?php echo $kas;?></span>,-
                                    <input type="hidden" name="Total Kas Aktivitas Operasi" value="<?php echo $kas;?>">
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
        link.download = 'laporan_aliran_kas_'+date+'.png';
        link.href = dataUrl;
        link.click();
    });
  });
});
</script>