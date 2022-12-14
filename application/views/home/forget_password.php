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
                  <div class="col-md-12 col-lg-6 login-right" id="forgetpage">
                      <h3 class="text-center text-6 mb-4">Forgot your password?</h3>
                           <h6 id="error_message_shown_forget" style="color: red;"></h6>
                           <p class="text-center text-muted">Enter your Email Id or Phone and we’ll help you reset your password.</p>
                           <!-- <form id="forgotForm" class="form-border" method="post"> -->
                              <div class="form-group">
                                 <input type="text" class="form-control border-2" id="emailAddress" required placeholder="Enter Email or Mobile Number">
                              </div>
                              <button id="content2" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Continue</button>
                           <!-- </form> -->
                           <p class="text-2 text-center mb-0 dont"><a class="btn-link" href="<?php echo base_url();?>home/login">Return to Log In</a></p>    
                     
                  </div>


                  <div id="forgetotp" class="col-md-12 col-lg-6 login-right">
                        <div class="col-11 col-lg-10 mx-auto">
                           <h3 class="text-center text-4 mb-4">OTP for forget password</h3>
                           <h6 id="error_message_shown_two" style="color: red;"></h6>
                           <!-- <form id="signupForm"  class="form-border" method="post"> -->
                                <h6 id="error_message_shown_forget_two" style="color: red;"></h6>
                           <div class="form-group">
                                 <input type="number" class="form-control border-2" id="ipotpfwd" required placeholder="OTP">
                              </div>
                              <span id="tokenforgetpwd"></span>
                              <!-- <span id="viewotpforgetpwd"></span> -->
                              <img id="loadingotpforgetpwd" style="display: none;" src="<?=base_url()?>assets/loader/713.gif">
                              <button id="content23456" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Verify</button>
                              <button id="content23" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Resend</button>
                           <!-- </form> -->
                           <p class="text-2 text-center mb-0 dont">Already have an account? <a class="btn-link" href="#" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In Now</a></p>

                        </div>
                     </div>







                  <div id="changepasswordotp" class="col-md-12 col-lg-6 login-right">
                        <div class="col-11 col-lg-10 mx-auto">
                           <h3 class="text-center text-4 mb-4">Change password</h3>
                           <h6 id="error_message_shown_two" style="color: red;"></h6>
                           <h6 id="error_message_shown_forget_three" style="color: red;"></h6>
                             <div class="form-group">
                                 <input type="password" class="form-control border-2" id="newpassword" required placeholder="Password">
                              </div>
                               <div class="form-group">
                                 <input type="password" class="form-control border-2" id="newconfirmpassword" required placeholder="Confirm Password">
                              </div>
                              <span id="tokenchangepwd"></span>
                              <img id="loadingotppwd" style="display: none;" src="<?=base_url()?>assets/loader/713.gif">
                              <button id="content234" class="btn btn-primary btn-block btn-lg login-btn" type="submit">Confirm</button>
                           <!-- </form> -->
                           <p class="text-2 text-center mb-0 dont">Already have an account? <a class="btn-link" href="#" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Log In Now</a></p>

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