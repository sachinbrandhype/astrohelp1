

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
		<div class="alert alert-success" id="otp_sus" style="display:none">
		<button class="close" data-dismiss="alert" type="button">x</button>
		<span id="span_id"></span>
		</div>
		<div class="alert alert-danger" id="otp_dns" style="display:none">
		<button class="close" data-dismiss="alert" type="button">x</button>
		<span id="span_idd"></span>
		</div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate="" id="login-form">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="username" tabindex="1" required autofocus placeholder="Email">
                    <div class="invalid-feedback" id="invalid_email">
                      Please fill in your valid email
                    </div>
					<div class="invalid-feedback" id="invalid_email_check">
                      Email Not Found
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="<?php echo base_url(); ?>login/forgot_password/" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required placeholder="Password">
                    <div class="invalid-feedback" id="invalid_password">
                      please fill in your password
                    </div>
                  </div>
				   <div class="form-group" style="display:none" id="otp_div">
                    <div class="d-block">
                      <label for="otp" class="control-label">OTP</label> 
                    </div>
                    <input id="otp" type="text" class="form-control" name="otp" tabindex="2" required placeholder="OTP">
                    <div class="invalid-feedback">
                      please fill in your Otp
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="button" onclick="send_otp();" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
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
<script>

function send_otp(){
	$('#invalid_email').hide();
	$('#invalid_email_check').hide();
	$('#invalid_password').hide();
	$('#otp_sus').hide();
	$('#otp_dns').hide();
	var email = $("#email").val();
	var password = $("#password").val();
	var otp = $("#otp").val();
	if(otp == "") {
	if(email != ""){
		validateEmail(email);
		var url = "<?=base_url()?>login/send_otp_by_email/";
		$.ajax({
            url: url,
            data: {email : email}, // change this to send js object
            type: "post",
			beforeSend: function(  ) {
				$('.loader').show();
			 },
            success: function(data){
				$('.loader').hide();
				if(data == 2) {
					$('#invalid_email_check').show();
				} else {
					$("#span_id").html("Check your Email for Otp");
					$("#otp_div").show();
					$("#otp_sus").show();
					
				}
				
            }
        });
	} else {
		$('#invalid_email').show();
		return false;
	}
	
	} else {
		if(password != ""){
			var url = "<?=base_url()?>login/check_login_ajax/";
		$.ajax({
            url: url,
            data: {email : email,password:password,otp:otp}, // change this to send js object
            type: "post",
			beforeSend: function(  ) {
				$('.loader').show();
			 },
            success: function(data){
				$('.loader').hide();
				//alert(data);
				if(data == 1){
					$("#span_id").html("Login Sucessfull!");
					$("#otp_sus").show();
					$("#login-form").submit();
				} else if(data == 2) {
					
					$("#span_idd").html("Password Incorrect!");
					$("#otp_dns").show();
				} else {
					$("#span_idd").html("Otp Incorrect!");
					$("#otp_dns").show();
				}
				
				
            }
        });
			
		} else {
			$('#invalid_password').show();
		}
	}
}
 function validateEmail(emailID) {
	atpos = emailID.indexOf("@");
	dotpos = emailID.lastIndexOf(".");
	if (atpos < 1 || ( dotpos - atpos < 2 )) {
	  $('#invalid_email').show();
	   document.myForm.EMail.focus() ;
	   return false;
	}
	return( true );
 }
</script>

<!-- Mirrored from radixtouch.in/templates/admin/aegis/source/light/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 14 Apr 2020 09:45:18 GMT -->
</html>


