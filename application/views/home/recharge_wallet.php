
         <!-- /Header -->
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Wallet</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Recharge your wallet
</h2>
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
                           <form action="<?=base_url('sdauth/add_wallet')?>" id="checkout-form" method="post" >
                           
                              <!-- Personal Information -->
                              <div class="info-widget">
                                 <h4 class="card-title">Enter Recharge Amount</h4>
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                       <div class="form-group card-label">
                                          <label>Amount</label>
                                          <input name="AmounT" value="<?=isset($_GET['remaining_recharge']) ? $_GET['remaining_recharge'] : 0?>" required min="100" class="form-control" id="total"  type="number">

                                            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" />
                                             <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $merchant_order_id; ?>" />
                                             <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>" />
                                             <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                                             <input type="hidden" name="transaction_data" id="transaction_data">

                                              <input name="name" id="name" type="hidden" class="required name" placeholder="Name" value="<?=$user_details->name ?>">
                                               <input name="email" id="email" type="hidden" class="required email" placeholder="Email" value="<?=$user_details->email ?>">
                                                <input name="mobile" id="mobile" type="hidden" class="required mobile" placeholder="Mobile No." value="<?=$user_details->phone ?>">


                                       </div>
                                    </div>
                                   <div class="col-lg-12"><div class="exist-customer mb-3">Choose from the list of recharge pack</div></div>

                                    
                                   
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
                              <a href="doctor-profile.html" class="booking-doc-img">
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
                  
                     <!-- Booking Summary -->
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
         <!-- /Page Content -->
        <script>
  function showAlert(val) {
      $('#total').val(val);
      $('#subtotal').html(val);
      $('#final').html(val);
    } 
  
</script>




<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<!-- razorpay_instance.open(); -->
<script>
  name = '';
  email = '';
  mobile = '';
  donation_amount = 0;
  $('#checkout-form').submit((e) => {

    e.preventDefault();
    name = $('#name').val();
    email = $('#email').val();
    mobile = $('#mobile').val();
    donation_amount = $('#total').val();
    var razorpay_options = {
      key: "<?php echo $key_id; ?>",
      amount: donation_amount*100,
      name: name,

      description: "Order # <?php echo $merchant_order_id; ?>",
      netbanking: true,
      currency: "<?php echo $currency_code; ?>",
      prefill: {
        name: name,
        email: email,
        contact: mobile
      },
      notes: {
        soolegal_order_id: "<?php echo $merchant_order_id; ?>",
      },
      handler: function(transaction) {
        document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
        document.getElementById('razorpay_signature').value = transaction.razorpay_signature;
        document.getElementById('transaction_data').value = transaction;
        // console.log(transaction);

        // alert(transaction);

        document.getElementById('checkout-form').submit();
      },
      "modal": {
        "ondismiss": function() {
          location.reload()
        }
      }
    };
    var razorpay_submit_btn, razorpay_instance;
    razorpay_instance = new Razorpay(razorpay_options);
    razorpay_instance.open();
  })
  // var razorpay_options = {
  //   key: "<?php echo $key_id; ?>",
  //   amount: 100,
  //   name: name,

  //   description: "Order # <?php echo $merchant_order_id; ?>",
  //   netbanking: true,
  //   currency: "<?php echo $currency_code; ?>",
  //   prefill: {
  //     name: name,
  //     email: email,
  //     contact: mobile
  //   },
  //   notes: {
  //     soolegal_order_id: "<?php echo $merchant_order_id; ?>",
  //   },
  //   handler: function(transaction) {
  //     document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
  //     document.getElementById('razorpay_signature').value = transaction.razorpay_signature;
  //     document.getElementById('transaction_data').value = transaction;
  //     // console.log(transaction);

  //     // alert(transaction);

  //     document.getElementById('checkout-form').submit();
  //   },
  //   "modal": {
  //     "ondismiss": function() {
  //       location.reload()
  //     }
  //   }
  // };
  // var razorpay_submit_btn, razorpay_instance;

  // function razorpaySubmit() {



  //   if($('#name').val() == '') 
  //   {
  //   $('#invalid_name').show();
  //   } 
  //   else if($('#email').val() == '') 
  //   {
  //     $('#invalid_email').show();
  //   } 
  //   else if($('#mobile').val() == '') 
  //   {
  //     $('#invalid_number').show();

  //     }
  //   else if($('#donation_amount').val() == '') {
  //         $('#invalid_donation').show();

  //   }
  //   else {

  //   if (typeof Razorpay == 'undefined') {
  //     setTimeout(razorpaySubmit, 200);
  //     if (!razorpay_submit_btn && el) {
  //       razorpay_submit_btn = el;
  //       el.disabled = true;
  //       el.value = 'Please wait...';
  //     }
  //   } else {
  //     if (!razorpay_instance) {
  //       formdataset();
  //       razorpay_instance = new Razorpay(razorpay_options);
  //       if (razorpay_submit_btn) {
  //         razorpay_submit_btn.disabled = false;
  //         razorpay_submit_btn.value = "Pay Now";
  //       }

  //     }
  //     razorpay_instance.open();
  //   }
  // }



  // }
</script>

