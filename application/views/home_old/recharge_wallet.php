<!-- Breadcrumb -->
<div class="breadcrumb-bar">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-md-8 col-12">
            <nav aria-label="breadcrumb" class="page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Wallet</li>
               </ol>
            </nav>
            <h2 class="breadcrumb-title">Recharge your wallet</h2>
         </div>
      </div>
   </div>
</div>
<!-- /Breadcrumb -->
<!-- Page Content -->
<div class="content">
   <div class="container">
      <div class="row">
         <div class="col-md-7 col-lg-8">
            <div class="card">
               <div class="card-body">
                  <!-- Checkout Form -->
                  <form action="<?=base_url('sdauth/add_wallet')?>" method="post" >
                     <!-- Personal Information -->
                     <div class="info-widget">
                        <h4 class="card-title">Enter Recharge Amount</h4>
                        <div class="row">
                           <div class="col-md-12 col-sm-12">
                              <div class="form-group card-label">
                                 <label>Amount</label>
                                 <input name="AmounT" required min="100" class="form-control" id="total"  type="number">
                              </div>
                           </div>
                           <div class="col-lg-12">
                              <div class="exist-customer mb-3">Choose from the list of recharge pack</div>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="200" id="isPaymentButtonEnablecancel" type="button" class="btn btn-block btn-outline-warning">₹ 200</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="400" type="button" class="btn btn-block btn-outline-warning">₹ 400</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="600" type="button" class="btn btn-block btn-outline-warning">₹ 600</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="800" type="button" class="btn btn-block btn-outline-warning">₹ 800</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="1000" type="button" class="btn btn-block btn-outline-warning">₹ 1000</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="1200" type="button" class="btn btn-block btn-outline-warning">₹ 1200</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="1400" type="button" class="btn btn-block btn-outline-warning">₹ 1400</button>
                           </div>
                           <div class="col-lg-3 mb-3">
                              <button onClick='showAlert(this.value)' value="1600" type="button" class="btn btn-block btn-outline-warning">₹ 1600</button>
                           </div>
                        </div>
                     </div>
                     <!-- /Personal Information -->
                     <!-- Submit Section -->
                     <div class="submit-section mt-4">
                        <button class="btn btn-primary submit-btn">Confirm and Pay</button>
                     </div>
                     <!-- /Submit Section -->
                  </form>
                  <!-- /Checkout Form -->
               </div>
            </div>
         </div>
         <div class="col-md-5 col-lg-4 theiaStickySidebar">
            <!-- Booking Summary -->
            <div class="card booking-card">
               <div class="card-body">
                  <!-- Booking Doctor Info -->
                  <div class="booking-doc-info">
                     <a href="#" class="booking-doc-img">
                     <img src="<?php echo base_url();?>assets/img/wallet.png" alt="User Image">
                     </a>
                     <div class="booking-info">
                        <h4><a href="#" class="wallet-font-1">Available Wallet Balance</a></h4>
                        <div class="clinic-details">
                           <p class="doc-location wallet-font"></i> ₹ <?=$user_details->wallet?></p>
                        </div>
                     </div>
                  </div>
                  <!-- Booking Doctor Info -->
               </div>
            </div>
            <!-- /Booking Summary -->
            <!-- Booking Summary <li>GST <span>₹ 10</span></li> -->
            <div class="card booking-card">
               <div class="card-header">
                  <h4 class="card-title">Recharge Summary</h4>
               </div>
               <div class="card-body">
                  <div class="booking-summary">
                     <div class="booking-item-wrap">
                        <ul class="booking-fee">
                           <li>Amount <span>₹ <span id="subtotal"></span></span></li>
                           
                        </ul>
                        <div class="booking-total">
                           <ul class="booking-total-list">
                              <li>
                                 <span>Total  Payable</span>
                                 <span class="total-cost">₹ <span id="final"></span></span>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Booking Summary -->
         </div>
      </div>
   </div>
</div>
<script>
  function showAlert(val) {
      $('#total').val(val);
      $('#subtotal').html(val);
      $('#final').html(val);
    } 
  
</script>
<!-- /Page Content -->