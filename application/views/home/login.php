
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
											<h3>Register/Login <span>to your account</span></h3>
										</div>
										  <h6 id="err_msg" style="color: red;">* All Fields Are Mandatory</h6>
                            <h6 id="err_msg2" style="color: red;">* Credential Invalid if you forget your password then click on forget password! Thanks</h6>
										  <?php $this->load->view('Templates/flash'); ?>
									<!-- 	<form action="index.html"> -->



											<div class="form-group form-focus">
												  <input id="email_phone" type="text" name="phone" class="form-control floating" id="emailAddress" required data-kwimpalastatus="alive" data-kwimpalaid="1628758822138-1">
												<label class="focus-label">Mobile</label>
											</div>
											<!-- <div class="form-group form-focus">
												  <input  type="password" name="password" class="form-control floating" id="loginPassword" required placeholder=""  data-kwimpalastatus="alive" data-kwimpalaid="1628758822138-1">
												<label class="focus-label">Password</label>
											</div>
											<div class="text-right">
												<a class="forgot-link" href="<?php echo base_url();?>home/forget_password">Forgot Password ?</a>
											</div> -->
											  <!-- <img id="loading" src="<?=base_url()?>assets/loader/713.gif"> -->
											  <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</button>
										<!-- 	<a href="<?php echo base_url();?>home/my_account" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Login</a> -->
											
											
											<!-- <div class="text-center dont-have">Don’t have an account? <a href="<?php echo base_url();?>home/register">Register</a></div> -->
									<!-- 	</form> -->
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
			