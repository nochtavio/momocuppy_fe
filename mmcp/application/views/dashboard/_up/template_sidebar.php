<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
<?php 
  $adminlevel = empty($adminlevel)?0:$adminlevel; 
?>
<div class="collapse navbar-collapse navbar-ex1-collapse">
  <ul class="nav navbar-nav side-nav">
    <?php 
      if($adminlevel == 1)
      {
        ?>
        <li class="<?php if($header==='admin'){echo "active";} ?> ">
          <a href="<?php echo base_url() ?>dashboard/admin/"><i class="fa fa-fw fa-user"></i> Admin</a>
        </li>
        <?php
      }
    ?>
    <li class="<?php if($header==='user'){echo "active";} ?> ">
      <a href="<?php echo base_url() ?>dashboard/user/"><i class="fa fa-fw fa-user"></i> User</a>
    </li>
    <li class="<?php if($header==='news'){echo "active";} ?> ">
      <a href="<?php echo base_url() ?>dashboard/news/"><i class="fa fa-fw fa-file-text"></i> News</a>
    </li>
    <li class="<?php if($header==='recipe'){echo "active";} ?> ">
      <a href="<?php echo base_url() ?>dashboard/recipe/"><i class="fa fa-fw fa-file-text"></i> Recipe</a>
    </li>
<!--    <li class="<?php //if($header==='banner'){echo "active";} ?> ">
      <a href="<?php //echo base_url() ?>dashboard/banner/"><i class="fa fa-fw fa-image"></i> Banner</a>
    </li>-->
    <li class="<?php if($header==='partner'){echo "active";} ?> ">
      <a href="<?php echo base_url() ?>dashboard/partner/"><i class="fa fa-fw fa-group"></i> Partner</a>
    </li>
    <li class="<?php if($header==='pricelist'){echo "active";} ?> ">
      <a href="<?php echo base_url() ?>dashboard/pricelist/"><i class="fa fa-fw fa-file-text"></i> Price List</a>
    </li>
  </ul>
</div>
<!-- /.navbar-collapse -->