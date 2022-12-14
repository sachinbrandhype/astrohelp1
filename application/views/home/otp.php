
         <!-- /Header -->
			
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
							
							<!-- Login Tab Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="<?php echo base_url();?>assets/img/loginbg.png" class="img-fluid" alt="Doccure Login">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<form  method="post">
										<div class="login-header">
											<h3>Verify OTP <span>for your account</span></h3>
                                            <p>Please enter otp sends on <?=$phone?></p>
										</div>
										
										  <?php $this->load->view('Templates/flash'); ?>
									<!-- 	<form action="index.html"> -->



											<div class="form-group form-focus">
                                            <input id="partitioned" name="otp" type="text" maxlength="4" required />

											</div>
										
											  <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Verify</button>
											  <!-- <div id="timer_ast" ></div> -->
											  <div class="text-center dont-have resend_otp_ast" >Don’t recieve otp? <a href="<?php echo base_url();?>home/resend_otp">Resend</a></div>
									
									</form>
									</div>
								</div>
							</div>
							<!-- /Login Tab Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   <br><br>
			<style>
                #partitioned {
  padding-left: 15px;
  letter-spacing: 42px;
  border: 0;
  background-image: linear-gradient(to left, black 70%, rgba(255, 255, 255, 0) 0%);
  background-position: bottom;
  background-size: 50px 1px;
  background-repeat: repeat-x;
  background-position-x: 35px;
  width: 220px;
}
            </style>


<script>
	var timeLeft = 30;
    var elem = document.getElementById('timer_ast');
	// document.getElementsByClassName('resend_otp_ast').display = "none"
    
    var timerId = setInterval(countdown, 1000);
    
    function countdown() {
      if (timeLeft == -1) {
        clearTimeout(timerId);
        // doSomething();
	document.getElementsByClassName('resend_otp_ast').display = "block"

      } else {
        elem.innerHTML = timeLeft + ' seconds remaining';
        timeLeft--;
      }
    }
</script>