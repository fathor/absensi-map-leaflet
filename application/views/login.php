<!doctype html>
<html lang="en">

<head>
  <title>My Apps</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/linearicons/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/chartist/css/chartist-custom.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url(); ?>assets/img/apple-icon.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/img/favicon.png">
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/chartist/js/chartist.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/scripts/klorofil-common.js"></script>
</head>

<body>
  <!-- WRAPPER -->
  <div id="wrapper">
    <div class="vertical-align-wrap">
      <div class="vertical-align-middle">
        <div class="auth-box ">
          <div class="left">
            <div class="content">
              <div class="header">
                <p class="lead">Login to your account</p>
              </div>
              <form class="form-auth-small" method="post">
                <div class="form-group">
                  <label for="signin-email" class="control-label sr-only">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="signin-password" class="control-label sr-only">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="button" onclick="login()" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                <div class="bottom">
                  <span class="helper-text" id="info" style="color: red;"></i> <a></a></span>
                </div>
              </form>
            </div>
          </div>
          <div class="right">
            <div class="overlay"></div>
            <div class="content text">
              <h1 class="heading">Login to your account</h1>
              <p>by my web store</p>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function login(){ 
      $.ajax({
        url : "<?php echo site_url('login/cek_login')?>",
        type: "POST",
        data: {
          'username':$('#username').val(),
          'password':$('#password').val(),
        },
        dataType: "JSON",
        success: function(data){
          if(data.status == false){
            $('#info').text(data.msg);
          }else{
            window.location.href = "<?php echo site_url('home') ?>";
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          swal({ type:"danger", title: "Gagal!", text: "Error System"});
          reload_table_data();
        }
      });
    }
  </script>