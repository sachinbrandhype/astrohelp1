<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from radixtouch.in/templates/admin/aegis/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Apr 2020 09:45:18 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Aegis - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bundles/bootstrap-social/bootstrap-social.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url();?>assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
		   <?php
		if($this->session->flashdata('message')) {
		  $message = $this->session->flashdata('message');
		  ?>
		<div class="alert alert-<?php echo $message['class']; ?>">
		<button class="close" data-dismiss="alert" type="button">x</button>
		<?php echo $message['message']; ?>
		</div>
		<?php
		}
		?>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Reset Password</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Password</label>
                    <input type="password" name="password" class="form-control required" placeholder="Password" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Confirm Password</label>
                      
                    </div>
                   <input type="password" name="con_password" class="form-control required" placeholder="Confirm Password" required>
                    <div class="invalid-feedback">
                      please fill in your Confirm password
                    </div>
                  </div>
                 
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Submit
                    </button>
					 
                  </div>
                </form>
              
              </div>
            </div>
          
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="<?php echo base_url();?>assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url();?>assets/js/custom.js"></script>
  <br>
  <br>
  <br>
  <br>
</body>


<!-- Mirrored from radixtouch.in/templates/admin/aegis/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Apr 2020 09:45:18 GMT -->
</html>





