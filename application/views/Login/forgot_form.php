<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from radixtouch.in/templates/admin/aegis/source/light/auth-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Apr 2020 10:00:19 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Aegis - Admin Dashboard Template</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/app.min.css">
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
                <h4>Forgot Password</h4>
              </div>
              <div class="card-body">
                <p class="text-muted">We will send a link to reset your password</p>
                <form method="POST">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Forgot Password
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>
  </div>
  <!-- General JS Scripts -->
  <script src="<?php echo base_url();?>assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="<?php echo base_url();?>assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url();?>assets/js/custom.js"></script>
</body>


<!-- Mirrored from radixtouch.in/templates/admin/aegis/source/light/auth-forgot-password.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Apr 2020 10:00:19 GMT -->
</html>