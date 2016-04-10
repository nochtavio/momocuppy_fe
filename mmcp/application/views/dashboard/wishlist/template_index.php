<!DOCTYPE html>
<?php
if (!$this->session->userdata('admin')) {
  header('Location: ' . base_url());
}
?>
<html lang="en">
  <head>
    <title>MomoCuppy CMS Panel</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/bootstrap.min.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/bootstrap-custom.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/iconFont.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/sb-admin.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/font-awesome.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/datepicker.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/datepicker3.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/pickacolor.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/summernote.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/private/dashboard.css'; ?>" />
  </head>
  <body>
    <input type="hidden" name="base" id="base" value="<?php echo base_url(); ?>" />
    <div id="wrapper">
      <!-- Navigation -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url() ?>dashboard/main/">MomoCuppy CMS Panel</a>
        </div>
        <!--Topbar-->
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $this->session->userdata('admin') ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li>
                <a href="#" id="btn_logout_"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
              </li>
            </ul>
          </li>
        </ul>
        <!--End Topbar-->
        <!--Sidebar-->
        <?php
        $adminlevel = empty($adminlevel) ? 0 : $adminlevel;
        ?>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li class="<?php
            if ($page === 'Admin') {
              echo "active";
            }
            ?> ">
              <a href="<?php echo base_url() ?>dashboard/admin/"><i class="fa fa-fw fa-user"></i> Admin</a>
            </li>
            <li class="<?php
            if ($page === 'Color') {
              echo "active";
            }
            ?> ">
              <a href="<?php echo base_url() ?>dashboard/color/"><i class="fa fa-fw fa-magic"></i> Color</a>
            </li>
            <li class="<?php
                if ($page === 'Category') {
                  echo "active";
                }
            ?> ">
              <a href="<?php echo base_url() ?>dashboard/category/"><i class="fa fa-fw fa-tag"></i> Category</a>
            </li>
            <li>
              <a href="javascript:;" data-toggle="collapse" data-target="#pages"><i class="fa fa-fw fa-angle-double-down"></i> Pages <i class="fa fa-fw fa-caret-down"></i></a>
              <ul id="pages" class="collapse">
                <li class="<?php
                    if ($page === 'Contact Us') {
                      echo "active";
                    }
                    ?> ">
                  <a href="<?php echo base_url() ?>dashboard/contact_us/"><i class="fa fa-fw fa-angle-right"></i> Contact Us</a>
                </li>
                <li class="<?php
                if ($page === 'About Us') {
                  echo "active";
                }
                ?> ">
                  <a href="<?php echo base_url() ?>dashboard/about_us/"><i class="fa fa-fw fa-angle-right"></i> About Us</a>
                </li>
              </ul>
            </li>
            <li class="<?php
            if ($page === 'Voucher') {
              echo "active";
            }
            ?> ">
              <a href="<?php echo base_url() ?>dashboard/voucher/"><i class="fa fa-fw fa-money"></i> Voucher</a>
            </li>
            <li class="<?php
            if ($page === 'Product') {
              echo "active";
            }
            ?> ">
              <a href="<?php echo base_url() ?>dashboard/product/"><i class="fa fa-fw fa-tree"></i> Product</a>
            </li>
            <li class="<?php
                if ($page === 'Product Redeem') {
                  echo "active";
                }
            ?> ">
              <a href="<?php echo base_url() ?>dashboard/product_redeem/"><i class="fa fa-fw fa-tree"></i> Product Redeem</a>
            </li>
            <li class="<?php
                if ($page === 'Payment') {
                  echo "active";
                }
                ?> ">
              <a href="<?php echo base_url() ?>dashboard/payment/"><i class="fa fa-fw fa-shopping-cart"></i> Payment</a>
            </li>
            <li class="<?php
                if ($page === 'Member') {
                  echo "active";
                }
                ?> ">
              <a href="<?php echo base_url() ?>dashboard/member/"><i class="fa fa-fw fa-users"></i> Member</a>
            </li>
            <li class="<?php
                if ($page === 'Order') {
                  echo "active";
                }
                ?> ">
              <a href="<?php echo base_url() ?>dashboard/order/"><i class="fa fa-fw fa-shopping-cart"></i> Order</a>
            </li>
            <li class="<?php
                if ($page === 'Subscriber') {
                  echo "active";
                }
                ?> ">
              <a href="<?php echo base_url() ?>dashboard/subscriber/"><i class="fa fa-fw fa-mail-forward"></i> Subscriber</a>
            </li>
          </ul>
        </div>
        <!--End Sidebar-->
      </nav>
      <div id="page-wrapper">
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">
<?php echo empty($page) ? '' : $page; ?>
              </h1>
            </div>
          </div>
<?php echo empty($content) ? '' : $content; ?>
        </div>
      </div>
    </div>
    <!-- /#wrapper -->

    <!--Custom Modals-->
    <?php
    if (!empty($modal)) {
      if (count($modal) > 0) {
        foreach ($modal as $m) {
          echo $m;
        }
      }
    }
    ?>
    <!--End Custom Modals-->

    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/jquery-1.11.0.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/bootstrap.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/ajaxfileupload.js'; ?>"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/raphael.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/bootstrap-datepicker.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/jquery.fancybox.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/tinycolor.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/pickacolor.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/summernote.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/private/function.js'; ?>"></script>

    <!--JS-->
<?php
if (!empty($js)) {
  if (count($js) > 0) {
    foreach ($js as $j) {
      ?>
          <script type="text/javascript" src="<?php echo base_url() . $j; ?>"></script>
      <?php
    }
  }
}
?>
  </body>
</html>