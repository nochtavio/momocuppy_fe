<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MomoCuppy CMS Panel</title>
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/bootstrap.min.css'; ?>" />
    <link rel="stylesheet" media="screen" type="text/css" href="<?php echo base_url() . 'css/dashboard/index.css'; ?>" />
  </head>
  <body>
    <div class="container">
      <input type="hidden" name="base" id="base" value="<?php echo base_url(); ?>" />
      <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Sign In</h2>
        <input type="text" id="txt_username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" id="txt_password" class="form-control" placeholder="Password" required>
        <p id="dashboardlogin-warning"></p>
        <button id="btn_login_" class="btn btn-lg btn-primary btn-block" type="button">Sign in</button>
      </form>
    </div>
  </body>

  <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/jquery-1.11.0.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/bootstrap.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo base_url() . 'js/dashboard/private/function.js'; ?>"></script>
</html>
