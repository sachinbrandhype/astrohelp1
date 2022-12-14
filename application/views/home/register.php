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
                  <div class="col-md-12 col-lg-6 login-right" id="register-row">
                     <div class="login-header">
                        <h3>Create <span>your account</span></h3>
                     </div>
                     <h6 id="error_message_shown" style="color: red;"></h6>
                     <h6 id="error_message" style="color: red;"></h6>
                     <!-- <form id="signupForm"  class="form-border" method="post"> -->
                     <div class="form-group">
                        <input type="text" class="form-control border-2" id="newName" required placeholder="Name">
                     </div>
                     <div class="form-group">
                        <input type="email" class="form-control border-2" id="newEmail" required placeholder="Email">
                        
                     </div>
                     <div class="form-group">
                        <input type="input" class="form-control border-2" id="newMobile" required placeholder="Mobile number">
                     </div>
                     <div class="form-group">
                        <input type="password" class="form-control border-2" id="newPassword" required placeholder="Password">
                     </div>
                     <div class="form-group">
                        <select id="newGender" name="gender" required class="form-control">
                           <option value="">Gender</option>
                           <option value="male">Male</option>
                           <option value="female">Female</option>
                        </select>
                     </div>
                     <div class="form-group my-4">
                        <div class="form-check text-2 custom-control custom-checkbox">
                           <input id="tc" name="agree" class="custom-control-input" type="checkbox" checked>
                           <label class="custom-control-label" for="agree">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.</label>
                        </div>
                     </div>
                     <button id="content4" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Create Account</button>
                     <!-- <div class="text-right">
                        <a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>
                        </div> -->
                     <div class="text-center dont-have">Already have an have an account? <a href="<?php echo base_url();?>home/login">Login</a></div>
                     
                  </div>


                  <div id="otpscreen" class="col-md-12 col-lg-6 login-right">
                        <div class="col-11 col-lg-10 mx-auto">
                           <h3 class="text-center text-4 mb-4">Verify OTP</h3>
                           <h6 id="error_message_shown_two" style="color: red;"></h6>
                           <!-- <form id="signupForm"  class="form-border" method="post"> -->
                              <div class="form-group">
                                 <input type="number" class="form-control border-2" id="ipotp" required placeholder="OTP">
                              </div>
                              <span id="token"></span>
                              <!-- <span id="viewotp"></span> -->
                              <img id="loadingotp" src="<?=base_url()?>assets/loader/713.gif">
                              <button id="content5" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Verify</button>
                              <button id="content6" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Resend</button>
                           <!-- </form> -->
                           <p class="text-2 text-center mb-0 dont">Already have an account? <a class="btn-link" href="<?php echo base_url();?>home/login" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In Now</a></p>
                        </div>
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