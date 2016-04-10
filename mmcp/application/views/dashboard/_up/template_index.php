<!DOCTYPE html>
<?php 
  if(!$this->session->userdata('admin')) 
  {
    header( 'Location: '.base_url().'dashboard/' );
  }
?>
<html lang="en">
  <head>
    <title>Kibif Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/bootstrap.min.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/iconFont.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/sb-admin.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/font-awesome.min.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/datepicker.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/datepicker3.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/bootstrapwysiwyg.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/fancybox/jquery.fancybox.css';?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url().'css/dashboard/private/dashboard.css';?>" />
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
            <a class="navbar-brand" href="<?php echo base_url() ?>dashboard/main/">Kibif Dashboard</a>
          </div>
          <!--Topbar-->
          <?php echo empty($topbar)?'':$topbar; ?>
          <!--End Topbar-->
          <!--Sidebar-->
          <?php echo empty($sidebar)?'':$sidebar; ?>
          <!--End Sidebar-->
      </nav>
      <div id="page-wrapper">
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">
                  <?php echo empty($header)?'':$header; ?>
              </h1>
            </div>
          </div>
          <?php echo empty($content)?'':$content; ?>
        </div>
      </div>
    </div>
    <!-- /#wrapper -->
    
    <!--Custom Modals-->
    <?php 
      if(!empty($modal))
      {
        if(count($modal) > 0)
        {
          foreach ($modal as $m) {
            echo $m;
          }
        }
      }
    ?>
    <!--End Custom Modals-->
    
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/jquery-1.11.0.min.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/bootstrap.min.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/ajaxfileupload.js';?>"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/raphael.min.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/bootstrap-datepicker.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/wysiwyg-toolbar.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/handlebar.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/bootstrapwysiwyg.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/jquery.fancybox.js';?>"></script>
    <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/function.js';?>"></script>
    <?php if ($header === "Admin") {?>
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/admin.js';?>"></script>
    <?php }?>
    <?php if ($header === "News") {?> 
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/news.js';?>"></script>
    <?php }?>
    <?php if ($header === "Banner") {?>
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/banner.js';?>"></script>
    <?php }?>
    <?php if ($header === "Recipe") {?>
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/recipe.js';?>"></script>
    <?php }?>
    <?php if ($header === "Partner") {?>
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/partner.js';?>"></script>
    <?php }?>
    <?php if ($header === "Price List") {?>
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/pricelist.js';?>"></script>
    <?php }?>
    <?php if ($header === "User") {?>
      <script type="text/javascript" src="<?php echo base_url().'js/dashboard/private/user.js';?>"></script>
    <?php }?>
  </body>
</html>