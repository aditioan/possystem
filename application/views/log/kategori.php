<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Log Data
                <small>Kategori</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('kategori/create');?>">Input Kategori</a></li> -->
                        <li role="presentation" class="active"><a>Log Data Kategori</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Log Data Kategori</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- <form action="<?php echo site_url('log/kategori?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <?php echo search_form('category');?>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <input type="submit" value="Cari" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <a href="<?php echo site_url('log/export_csv/category').get_uri();?>" class="form-control btn btn-default"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                </div>
                            </form> -->
                            <table id="data-kategori" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Kategori</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Dibuat Pada</th>
                                    <th>Dihapus Pada</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($kategoris) && is_array($kategoris)){ ?>
                                    <?php foreach($kategoris as $kategori){?>
                                        <tr>
                                            <td><?php echo $kategori->id_category;?></td>
                                            <td><?php echo $kategori->category_name;?></td>
                                            <td><?php echo $kategori->category_desc;?></td>
                                            <td><?php echo $kategori->created_at;?></td>
                                            <td><?php echo $kategori->deleted_at;?></td>
                                            <td>
                                                <a onclick="return confirm('Apakah anda yakin akan mengembalikan data Kategori ini?');" href="<?php echo site_url('log/kategori_return').'/'.$kategori->id_category;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data Kategori ini beserta data produknya?');" href="<?php echo site_url('log/kategori_delete').'/'.$kategori->id_category;?>" class="btn btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID Kategori</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
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
    $('#data-kategori').dataTable();
});
</script>