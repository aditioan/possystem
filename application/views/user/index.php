<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User Index
                <small>Daftar User</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <!-- <li role="presentation"><a href="<?php echo site_url('user/create');?>">Input User</a></li> -->
                        <li role="presentation" class="active"><a href="<?php echo site_url('user');?>">Daftar User</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table User</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('user?search=true');?>" method="GET">
                                <input type="hidden" class="form-control" name="search" value="true"/>
                                <div class="box-body pad">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="id">Search by</label>
                                                <select name="search_by" class="form-control">
                                                    <option value="full_name" <?php echo !empty($_GET['search_by']) && $_GET['search_by'] == 'full_name' ? 'selected' : '';?>>Nama</option>
                                                    <option value="email" <?php echo !empty($_GET['search_by']) && $_GET['search_by'] == 'email' ? 'selected' : '';?>>Email</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="customer_name">Value</label>
                                                <input type="text" class="form-control" name="value" value="<?php echo !empty($_GET['value']) ? $_GET['value'] : '';?>"/>
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
                                            <a href="<?php echo site_url('user/export_csv').get_uri();?>" class="form-control btn btn-success"><i class="fa fa-file-excel-o"></i> Export Excel</a>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <button type="button" class="form-control btn btn-warning" data-toggle="modal" data-target="#addUser"><i class="fa fa-plus"></i> Tambah User</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="data-user" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID User</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Telephon</th>
                                    <th>Posisi</th>
                                    <!-- <th>Profile</th> -->
                                    <th width="10%">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($users) && is_array($users)){ ?>
                                    <?php foreach($users as $user){?>
                                        <tr>
                                            <td><?php echo $user->id_user;?></td>
                                            <td><?php echo $user->full_name;?></td>
                                            <td><?php echo $user->username;?></td>
                                            <td><?php echo $user->phone_karyawan;?></td>
                                            <td><?php echo $user->posisi_karyawan;?></td>
                                            <!-- <td><?php //echo $user->photo_profile;?></td> -->
                                            <td>
                                                <a href="<?php echo site_url('user/permission').'/'.$user->id_user;?>" class="btn btn-block btn-flat btn-xs btn-default">Hak Akses</a>
                                                <a href="<?php echo site_url('karyawan/edit').'/'.$user->id_karyawan;?>" class="btn btn-xs btn-block btn-flat btn-primary">Ubah</a>
                                                <a onclick="return confirm('Password akan diubah menjadi sama seperti username. Apakah anda yakin?');" href="<?php echo site_url('user/reset_password').'/'.$user->id_user;?>" class="btn btn-xs btn-block btn-flat btn-warning">Reset Password</a>
                                                <a onclick="return confirm('Are you sure you want to delete this user?');" href="<?php echo site_url('user/delete').'/'.$user->id_user;?>" class="btn btn-xs btn-block btn-flat btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID User</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Telephon</th>
                                    <th>Posisi</th>
                                    <!-- <th>Profile</th> -->
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

    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myAddAdmin" aria-hidden="true"> 
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h4 class="modal-title" id="myAddAdmin">Tambah User</h4>
                </div>
                <?php
                $attributes = array('class' => 'form-validation', 'role' => 'form');

                echo form_open('user/save', $attributes);
                ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Karyawan</label>
                        <select class="form-control selectize validate[required]" id="name" name="id_karyawan" placeholder="-- Choose Your Name --">
                            <option value="">-- Nama Karyawan --</option>
                            <?php foreach ($karyawan as $key => $item): ?>
                            <option value="<?php echo $item->id_karyawan ?>"><?php echo $item->nama_karyawan ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <p class="help-block" id="load-data"></p>
                    <dl class="dl-horizontal hidden">
                        <dt>Posisi :</dt>
                        <input type="hidden" name="full_name" id="full_name" value="">
                        <dd id="posisi"></dd>
                        <dt>Email :</dt>
                        <input type="hidden" name="email" id="email" value="">
                        <dd id="email_data"></dd>
                        <dt>Alamat :</dt>
                        <dd id="alamat"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"> Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-fw fa-save"></i> Tambah</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
<?php $this->load->view('element/footer');?>
<script src="<?php echo js_url('selectize.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    <?php if ($this->session->flashdata('message_success') != ''): ?>
    toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('message_error') != ''): ?>
    toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
    <?php endif ?>
    $("#data-user").dataTable();
    $('.selectize').selectize({
      sortField: 'text'
    });
});

$('#name').change(function() {
    var id = $('#name').val();
    $('#load-data').html('');
    $('.dl-horizontal').addClass('hidden');
    if (id != '') {
        $('#load-data').html('<i class="fa fa-spinner fa-spin"></i> Load Data...');
        $.get("<?php echo site_url('user/get_karyawan/"+ id +"') ?>")
        .done(function(result) {
            //console.log(result);
            var data = jQuery.parseJSON(result);
            $('#posisi').text(data[0]['posisi_karyawan']);
            $('#email_data').text(data[0]['email_karyawan']);
            $('#alamat').text(data[0]['alamat_karyawan']);
            $('#full_name').val(data[0]['nama_karyawan']);
            $('#email').val(data[0]['email_karyawan']);

            $('.dl-horizontal').removeClass('hidden');
            $('#load-data').html('');
        })
    };
    
});
</script>