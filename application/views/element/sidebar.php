
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar left-side sidebar-offcanvas collapse-left">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo img_url($this->session->userdata('photo_profile'));?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('username');?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form (Optional) -->
      <form action="#" method="get" class="sidebar-form">
       <!-- <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div> -->
      </form>
      <!-- /.search form -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!--<li class="header">HEADER</li>-->
        <!-- Optionally, you can add icons to the links -->
        <li class="<?php echo is_menu('home','dashboard');?>"><a href="<?php echo site_url();?>"><i class="fa fa-dashboard" aria-hidden="true"></i> <span>Dashboard</span></a></li>
        <?php foreach($this->session->userdata('menus') as $menu){?>
          <?php if($menu->has_child == '1'):?>
            <li class="treeview <?php echo is_menu($menu->menu_slug);?>">
              <a href="#"><i class="fa <?php echo $menu->menu_icon;?>"></i> <span><?php echo $menu->menu_name;?></span> <i class="fa fa-angle-left pull-right"></i></a>
              <ul class="treeview-menu">
                <?php foreach($this->session->userdata('mchilds') as $mchilds){?>
                  <?php if($menu->id_menu == $mchilds->id_menu):?>
                    <li class="<?php echo is_menu($mchilds->mchild_active);?>"><a href="<?php echo site_url($mchilds->mchild_slug);?>"><i class="fa <?php echo $mchilds->mchild_icon;?>" aria-hidden="true"></i> <span><?php echo $mchilds->mchild_name;?></span></a></li>
                  <?php endif ?>
                <?php } ?>
              </ul>
            </li>
          <?php else:?>
            <li class="<?php echo is_menu($menu->menu_slug);?>"><a href="<?php echo site_url($menu->menu_slug);?>"><i class="fa <?php echo $menu->menu_icon;?>" aria-hidden="true"></i> <span><?php echo $menu->menu_name;?></span></a></li>
          <?php endif ?>
        <?php } ?>
      </ul>
      <br />
      <br />
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
