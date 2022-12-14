
			
			<!-- Breadcrumb -->
		 <div class="breadcrumb-bar">
		<div class="container-fluid">
	 <div class="row align-items-center">
		<div class="col-md-12 col-12">
<nav aria-label="breadcrumb" class="page-breadcrumb">
			<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="index.html">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Astrologer Registration</li>
					</ol>
					</nav>
	<h2 class="breadcrumb-title">Astrologer Registration</h2>
					</div>
					</div>
				    </div>
			       </div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
	<div class="content" style="min-height: 31px;">
		   <div class="container-fluid">
		    
		             <form method="post" enctype="multipart/form-data">
               <div class="row form-row">

                <div class="col-12 col-md-4">
                  <div class="form-group">
       <label class="upload">Name</label>
<input type="text" class="form-control" name="name" placeholder="Name" required="required">
                          </div>
                          </div>

                 <div class="col-12 col-md-4">
                    <div class="form-group">
        <label class="upload">Email</label>
    <input type="email" class="form-control" name="email" placeholder="Email" required="required">
                            </div> 
                            </div>

                <div class="col-12 col-md-4">
                   <div class="form-group">
         <label class="upload">Mobile No.</label>
    <input type="number" class="form-control" name="mobile" placeholder="Mobile No." required="required">
                            </div>
                            </div>

                <div class="col-12 col-md-4">
                   <div class="form-group">
             <label class="upload">Gender</label>
                 <select class="form-control" name="gender">
                <option>Select Gender</option>
                     <option value="Male">Male</option>
                   <option value="Female" >Female</option>
                            
                         </select>
                           </div>
                           </div>

                <div class="col-12 col-md-4">
                  <div class="form-group">
        <label class="upload">D.O.B</label>
    <input type="date" class="form-control" name="dob" placeholder="Date of Birth" required="">
                           </div>
                           </div>

                <div class="col-12 col-md-4">
                   <div class="form-group">
          <label class="upload">Consultant</label>
               <select class="dtr-form select2 select2-hidden-accessible"  name="service_offered[]"  multiple="" data-placeholder="Select Skill" style="width: 100%;" tabindex="-1" aria-hidden="true">
             <?php foreach ($service_offered as $key1): ?>
              <option value="<?=$key1->id?>"><?=$key1->name?></option>
              <?php endforeach ?>
                            
                        </select>
                         </div>
                         </div>

                  <div class="col-12 col-md-4">
                    <div class="form-group">
        <label class="upload">Skill</label>
        <select class="dtr-form select2 select2-hidden-accessible"  name="specialization[]" multiple="" data-placeholder="Select Skill" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <?php foreach ($specialization as $key3): ?>
                    <option value="<?=$key3->id?>"><?=$key3->name?></option>
                    <?php endforeach ?>
                       </select>
                         </div>
                         </div>

                   <div class="col-12 col-md-4">
                     <div class="form-group">
        <label class="upload">Language</label>
        <select class="dtr-form select2 select2-hidden-accessible" name="languages[]" multiple="" data-placeholder="Select Language" style="width: 100%;" tabindex="-1" aria-hidden="true">
           <?php foreach ($language as $key): ?>
            <option value="<?=$key->language_name?>"><?=$key->language_name?></option>
            <?php endforeach ?>
                       </select>
                        </div>
                        </div> 

                <div class="col-12 col-md-4">
                  <div class="form-group">
         <label class="upload">Experience</label>
    <input type="number" class="form-control" step="0.1" min="0" name="experience" placeholder="Experience" required="required">
                           </div>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Address</label>
    <input type="text" class="form-control" name="location" placeholder="Address" required="required">
                           </div>
                           </div> 

              

               <div class="col-12 col-md-4">
                 <div class="form-group">
            <label class="upload">State</label>
               <select class="form-control" name="state">
                 <?php foreach ($state as $key): ?>
            <option value="<?=$key->state_name?>"><?=$key->state_name?></option>
            <?php endforeach ?>    
                       </select>
                         </div>
                         </div> 

               <div class="col-12 col-md-4">
                 <div class="form-group">
           <label class="upload">City</label>
             <select class="form-control" name="city">
                 <?php foreach ($city as $key): ?>
            <option value="<?=$key->city_name?>"><?=$key->city_name?></option>
            <?php endforeach ?>  
                            
                       </select>
                        </div>
                        </div>  

               <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Pincode</label>
    <input type="text" class="form-control"  name="pincode" placeholder="Pincode" required="required">
                           </div>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Bank Account No.</label>
            <input class="form-control   regcom sample" placeholder="Bank Account Number" id="bank_account" name="bank_account_no"  type="text"   >

                           </div>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Confirm Account No.</label>
 <input class="form-control   regcom sample" placeholder="Bank Account Number" id="confirm_bank_account"  type="text" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off/  >
                           </div>
                             <span id='message'></span>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Account Type</label>
                <select class="form-control" name="account_type">
              <option value="Saving Account">Saving Account</option>
              <option value="Current Account">Current Account</option>
                            
                        </select>
                          </div>
                          </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">IFSC Code</label>
    <input type="text" class="form-control" name="ifsc_code" placeholder="IFSC Code" required="required">
                          </div>
                          </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Account Holder Name</label>
    <input type="text" class="form-control" name="bank_account_holder_name" placeholder="Holder Name" required="required">
                          </div>
                           </div>

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">PAN Card No.</label>
    <input type="text" class="form-control" name="pan_number" placeholder="PAN Card" required="required">
                          </div>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="form-group">
         <label class="upload">Aadhar Card No.</label>
    <input  data-type="adhaar-number" maxLength="19" class="form-control" name="aadhar_number" placeholder="Aadhar Card" required="required">
                          </div>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="card-label">
      <label class="upload">Upload Aadhar Card</label>
<input name="aadhar_card_front_image" class="required rc" type="file" placeholder="Aadhar Card">
                           </div>
                           </div> 

                <div class="col-12 col-md-4">
                 <div class="card-label">
      <label class="upload">Upload PAN Card</label>
<input name="pan_card_image" class="required rc" type="file" placeholder="PAN Card">
                           </div>
                           </div> 

                <div class="row">
        <div class="col-sm-12 col-xs-12">
        <label class="checkbox-inline">
    <input type="checkbox" value="" checked="" required="">By Clicking SignUp, you agree to Our
     <a href="#" class="ter">Terms &amp; Conditions</a> and <a href="#" class="ter">Privacy Policy</a>
                       </label>
                       </div>
                        </div>      
                        </div>

                         <br>

                   <div class="submit-section">
   <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            </div>
                             <br>
                           </form>
		
				</div>
			    </div>		
		<!-- /Page Content -->
   
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
  $('#confirm_bank_account').keyup(function(){
     var confirm_bank_account = $('#confirm_bank_account').val();   
   if (confirm_bank_account) 
   { 
  $('#bank_account, #confirm_bank_account').on('keyup', function () {
  if ($('#bank_account').val() == $('#confirm_bank_account').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});
  }

  })
  

</script>