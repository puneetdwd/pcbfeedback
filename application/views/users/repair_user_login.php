<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8"/>
        <title>SQIM | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link rel="shortcut icon" href="favicon.ico"/>
        
        <link href="<?php echo base_url(); ?>assets/layouts/layout5/css/font.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/layouts/layout5/css/new_design.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        
    </head>
    <body>
        <div class="wrapper text-center">
            <header>
                <div class="container">
                    <a class="ir" href="#" id="logo" role="banner" title="Home">LG India</a>
                    
                    <div id="utils">
                        
                        <form class="form navbar-form" role="form" method="post" action="supplier_login" accept-charset="UTF-8" id="login-nav">
                            <?php if(isset($error)) { ?>
                                <div class="login-error text-danger text-left" style="margin-top:-28px;">
                                    <i class="fa fa-ban"></i>
                                    <strong> Error ! </strong>
                                    <?php echo $error; ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                 <label class="sr-only" for="username">UserID</label>
                                 <input type="text" id="username-login" class="form-control input-sm" placeholder="Email" name="username" required>
                            </div>
                            <div class="form-group">
                                 <label class="sr-only" for="password">Password</label>
                                 <input type="password" class="form-control input-sm" name="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="button normals" style="margin-top: -7px; padding-bottom: 1px; padding-top: 1px;">
                                Sign in
                            </button>
                            
                            <div class="text-left">
                                <a href="javascript:void(0);" id="forgot-password-login" style="margin-left: 50px;">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                    
                    <div class="page-logo-text" style="text-align: center; font-size: 20px; margin-top: 34px; color: #C80541;">SQIM - Supplier Quality Integrated Module</div>
                </div>
            </header>
            
            <div class="container">
                <section id="hero-area" class="hero-area tab">
                    <img src="assets/images/banner.jpg" >
                </section>
            </div>
            
            <footer>
                <div class="container">
                    <div class="legal">
                        <span class="copy">Copyright &copy; 2016 LG Electronics Powered By Corporate Renaissance Group. All Rights Reserved.</span>
                    </div>
                </div>
            </footer>
        </div>
        
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        
        <script>
            $('#forgot-password-login').click(function() {
                var username = $('#username-login').val();
                if(username == '') {
                    alert('Please enter username.');
                    
                    return false;
                }
                
                window.location.href = '<?php echo base_url(); ?>'+'users/forgot_password?username='+username;
            });
            
            <?php if($this->session->flashdata('alert')) {?>
                alert('<?php echo $this->session->flashdata('alert');?>');
            <?php } ?>
        </script>
    </body>
</html>