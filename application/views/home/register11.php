
			
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
										<div class="login-header">
											<h3>Create <span>your account</span></h3>
											<?php $this->load->view('Templates/flash'); ?>
										</div>
										<form action="" method="post">
											<div class="form-group form-focus">
												<input type="text" name="name" required="" class="form-control floating">
												<label class="focus-label">Name</label>
											</div>
											 <div id="msg_email"></div>
											<div class="form-group form-focus">
												<input type="text" name="email" id="check_email"  class="form-control floating check_email" onkeyup="myFunction_email()" >
												<label class="focus-label">Email</label>
											</div>
											 <div id="msg"></div>
											<div class="form-group form-focus">
												<input type="phone" name="number"  id="mobile"   class="form-control floating mobile_number"   placeholder="Mobile No."  onkeyup="myFunction_mobile()"  required>
												<label class="focus-label">Mobile</label>
											</div>

											<div class="form-group form-focus">
												<input type="password" name="password" class="form-control floating" required>
												<label class="focus-label">Password</label>
											</div>
											<!-- <div class="text-right">
												<a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>
											</div> -->
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Submit</button>
											
											
											<div class="text-center dont-have">Already have an have an account? <a href="<?php echo base_url();?>home/login">Login</a></div>
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
			



<script> 
  
       
    function myFunction_mobile() {

     
    var mobile_number = $('.mobile_number').val();    
   // alert(mobile_number);
 $.ajax({ 
          url: "<?=base_url('/')?>home/check_phone_user", 
         
          data: {mobile_number:mobile_number},

          method: "post",
          success: function(data){
          console.log(data);
          var service = JSON.parse(data);
          if(service['status'])
            {  
              $('#msg').html('<span style="color: red;">Mobile Number already exist</span>');
              $('.mobile_number').val("");

            } 

             else {
               // alert("Value not already exist")
                 $('#msg').html('<span style="color:red;"></span>');
            }
          }
    });

  
}
    </script> 

<script> 
      
    function myFunction_email() {
    var check_email = $('.check_email').val();    
   // alert(check_email); 
 $.ajax({ 
          url: "<?=base_url('/')?>home/check_email_user", 
         
          data: {check_email:check_email},

          method: "post",
          success: function(data){
          console.log(data);
          var service = JSON.parse(data);
          if(service['status'])
            {  
              $('#msg_email').html('<span style="color: red;">Email id already exist</span>');
              $('.check_email').val("");

            } 

             else {
               // alert("Value not already exist")
                 $('#msg_email').html('<span style="color:red;"></span>');
            }
          }
    });

  
}
    </script> 
