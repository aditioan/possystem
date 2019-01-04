<?php $this->load->view('element/head');?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Data
        <small>User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Log Data User</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a>Log Data User</a></li>
            </ul>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Log Data User</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="data-user" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID User</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Dihapus Pada</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($users) && is_array($users)){ ?>
                    <?php foreach($users as $user){?>
                        <tr>
                            <td><?php echo $user->id_user;?></td>
                            <td><?php echo $user->full_name;?></td>
                            <td><?php echo $user->username;?></td>
                            <td><?php echo $user->email;?></td>
                            <td><?php echo $user->deleted_at;?></td>
                            <td>
                                <a onclick="return confirm('Apakah anda yakin akan mengembalikan data User ini?');" href="<?php echo site_url('log/user_return').'/'.$user->id_user;?>" class="btn btn-xs btn-warning">Pulihkan</a>
                                <a onclick="return confirm('Apakah anda yakin akan menghapus secara total data User ini beserta data transaksinya?');" href="<?php echo site_url('log/user_delete').'/'.$user->id_user;?>" class="btn btn-xs btn-danger">Hapus</a>
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
                    <th>Email</th>
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
    $('#data-user').dataTable();
});
</script>