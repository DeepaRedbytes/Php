<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Community services | Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url();?>theme/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="<?= base_url();?>theme/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="<?= base_url();?>theme/css/style.css" rel="stylesheet">

   
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5c765f034c495400114fe1a6&product=sticky-share-buttons' async='async'></script>  
  </head>

  <body>

    <section>
      <div class="row">
        <div class="col-md-12 no-padding">
          <div class="row">
            <div class="login-image col-sm-5">
              <div class="log-info">Login</div>
            </div>
            <div class="login-panel col-sm-7">
              <div class="container">
                <div class="row">
                  <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                    <div class="card-2">
                      <div class="card-signin my-5">
                        <div class="card-body login-card">                          
                          <div class="logo-holder">
                            <img class="card-title logo text-center" src="<?= base_url();?>theme/img/logo.png"/>
                          </div> 

                          <span class="flastMessage" style="margin-left: 25%;"><?php echo $this->session->flashdata('login');?></span> 

                          <?php echo form_open('login/adminlogin', ['id' => 'adminLoginForm','class'=>'form-signin','enctype'=>"multipart/form-data"]); ?>
                            <div class="form-label-group">                            
                              <input type="text" name="email" id="inputEmail" class="form-control" required="required" 
                               placeholder="Email address">
                              <label for="inputEmail"><span class="u-icon"><i class="far fa-user"></i></span>Email</label>
                            </div>
                            <div class="form-label-group"> 
                              <input type="password" name="password" id="inputPassword" class="form-control" required="required" placeholder="Password">
                              <label for="inputPassword"><span class="u-icon"><i class="fas fa-unlock-alt"></i></span>Password</label>
                            </div>
                            <button class="btn btn-lg btn-block started" type="submit" >Login</button>
                          <?php echo form_close(); ?>

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url();?>theme/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url();?>theme/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Plugin JavaScript -->
    <script src="<?= base_url();?>theme/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url();?>theme/js/main.js"></script>

  </body>
</html>
