<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User Hak Akses
                <small>Daftar Hak Akses</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="active"><a>Hak Akses</a></li>
                    </ul>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data hak akses user <strong><?php echo $user[0]['full_name'];?></strong></h3>
                             <div class="pull-right">
                                <span><a href="<?php echo site_url('user');?>" class="btn btn-sm btn-danger">Kembali</a></span>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form action="<?php echo site_url('user/add_menu');?>" method="POST">
                                <div class="box-body pad">
                                    <input type="hidden" name="id_user" value="<?php echo $user[0]['id_user'];?>">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="list_menu">Daftar Menu</label>
                                            <select class="form-control" id="id_menu" name="id_menu">
                                                <option value="*">Tambahkan Semua Menu</option>
                                                <?php if(isset($list_menus) && is_array($list_menus)){?>
                                                  <?php foreach($list_menus as $item){?>
                                                    <option value="<?php echo $item->id_menu;?>">
                                                      <?php echo $item->menu_name;?>
                                                    </option>
                                                  <?php }?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <input type="submit" value="Tambahkan Akses" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2">
                                      <div class="form-group">
                                        <label for="export">&nbsp;</label>
                                        <a href="<?php echo site_url('user/add_all_menu').'/'.$user[0]['id_user']?>" class="form-control btn btn-success"> Tambah Semua Akses</a>
                                      </div>
                                    </div> -->
                                </div>
                            </form>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Menu</th>
                                    <th>Nama Menu</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($user_menus) && is_array($user_menus)){ ?>
                                    <?php foreach($user_menus as $user_menu){?>
                                        <tr>
                                            <td><?php echo $user_menu->id_menu;?></td>
                                            <td><?php echo $user_menu->menu_name;?></td>
                                            <td>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus hak akses menu ini?');" href="<?php echo site_url('user/delete_menu').'/'.$user_menu->id_umenu.'/'.$user[0]['id_user'];?>" class="btn btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID Menu</th>
                                    <th>Nama Menu</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                            </table>
                            <form action="<?php echo site_url('user/add_submenu');?>" method="POST">
                                <div class="box-body pad">
                                    <input type="hidden" name="id_user" value="<?php echo $user[0]['id_user'];?>">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="list_submenu">Daftar Submenu</label>
                                            <select class="form-control" id="id_mchild" name="id_mchild">
                                                <option value="*">Tambahkan Semua Submenu</option>
                                                <?php if(isset($list_submenus) && is_array($list_submenus)){?>
                                                  <?php foreach($list_submenus as $item){?>
                                                    <option value="<?php echo $item->id_mchild;?>">
                                                      <?php echo $item->mchild_name;?>
                                                    </option>
                                                  <?php }?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="submit">&nbsp;</label>
                                            <input type="submit" value="Tambahkan Akses" class="form-control btn btn-primary">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2">
                                      <div class="form-group">
                                        <label for="export">&nbsp;</label>
                                        <a href="<?php echo site_url('user/add_all_submenu').'/'.$user[0]['id_user']?>" class="form-control btn btn-success"> Tambah Semua Akses</a>
                                      </div>
                                    </div> -->
                                </div>
                            </form>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>ID Submenu</th>
                                    <th>Nama Submenu</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(isset($user_submenus) && is_array($user_submenus)){ ?>
                                    <?php foreach($user_submenus as $user_submenu){?>
                                        <tr>
                                            <td><?php echo $user_submenu->id_umchild;?></td>
                                            <td><?php echo $user_submenu->mchild_name;?></td>
                                            <td>
                                                <a onclick="return confirm('Apakah anda yakin akan menghapus hak akses submenu ini?');" href="<?php echo site_url('user/delete_submenu').'/'.$user_submenu->id_umchild.'/'.$user[0]['id_user'];?>" class="btn btn-xs btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>ID submenu</th>
                                    <th>Nama Menu</th>
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
});
</script>