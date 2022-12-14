
         <!-- /Header -->
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Service</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Career Report
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
                  <div class="col-md-6 col-lg-7">
                     <div class="card">
                       <!--  <div class="card-header">
                           <h3 class="card-title">Billing details</h3>
                        </div> -->
                        <div class="card-body">
                           <h3 class="text-center mb-4"><?php echo $page_data->heading ;  ?></h3>


                        <img src="<?= BASE_URL_IMAGE.'common/'.$page_data->image ?>" class="img-responsive mb-3" width="100%">
                        <p class="report-text">
                              <?php echo $page_data->desc ;  ?>

                        </p>
                           
                        </div>
                     </div>
                     
                  </div>
                  
                  <div class="col-md-6 col-lg-5 theiaStickySidebar">
                  
                     <!-- Booking Summary -->
                     <div class="card booking-card">
                        <div class="card-header">
                           <h4 class="card-title">View Your Career Report  : <span id='horoscope_price'></span><br/></h4>
                        </div>

                        <?php
               if($this->session->flashdata('message')) {
                        $message = $this->session->flashdata('message');
                     ?>
            <div class="alert alert-<?php echo $message['class']; ?>">
               <button class="close" data-dismiss="alert" type="button">×</button>
               <?php echo $message['message']; ?>
            </div>
            <?php
               }
               ?>

               
                        <form method="post">
                        <div class="card-body">
                            <div class="row">
                                   
                                       <!-- <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Astrologer Name</label>
                                             <select class="form-control" name="astrologer" id='sel_astrologer'>
                                               <option value="0">Select Astrologer</option>
                                                <?php
                                                $as = $this->db->query("select * from skills where speciality_id = 21 AND horoscope_price >1")->result();
                                                // print_r($as); die;
                                                foreach ($as as $as_key) {
                                                  $as_name = $this->db->query("select * from astrologers where id = $as_key->user_id ")->row();
                                                  ?>
                                                   <option value="<?php echo $as_name->id ?>"><?php echo $as_name->name  ?></option>
                                                  <?php
                                                }
                                                ?>
                                                
                                               
                                             </select>
                                          </div>
                                       </div> -->

                                       <?php 
                                          $asprice = $this->db->query("select * from skills where user_id = 383 AND speciality_id  = 21")->row();
                                          ?>
                                       <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Name</label>
                                             <input class="form-control" name="firstname" id="card_name" type="text">
                                             <input class="form-control astro_price" name="price" id="astro_price" value="<?php echo $asprice->horoscope_price ?>" type="hidden">
                                             <input class="form-control astro_price" name="astrologer" id="astrologer" value="383" type="hidden">
                                          </div>
                                       </div>

                                       
                                       <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Email</label>
                                             <input class="form-control" name="email" id="card_name" type="text">
                                          </div>
                                       </div>



                                         <div class="col-md-12">
                                            <div class="form-group card-label">
                                                 <label for="card_name">Gender</label>
                                                <select class="form-control select" name="gender">
                                                   <option value="Male">Male</option>
                                                   <option value="Female">Female</option>
                                                  
                                                  
                                                </select>
                                             </div>
                                          </div>


                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_month">Day</label>
                                             <input class="form-control" name="day"  id="expiry_month" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_year">Month</label>
                                             <input class="form-control" name="month" id="expiry_year" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Year</label>
                                             <input class="form-control" name="year" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Hours</label>
                                             <input class="form-control" name="hours" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Minute</label>
                                             <input class="form-control" name="minute" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Second</label>
                                             <input class="form-control" name="second" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_number">Birth Place</label>
                                             <input class="form-control" id="card_number" name="address" placeholder="" type="text">
                                          </div>
                                       </div>
                                       <div class="submit-section mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md">Send</button>
                                 </div>
                                    </div>
                          
                        </div>
                     </form>
                     </div>
                     <!-- /Booking Summary -->
                     
                  </div>
               </div>

            </div>

         </div>      
         <!-- /Page Content -->
         <!-- Footer -->
      <!-- Script -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type='text/javascript'>
  $(document).ready(function(){
 
   $('#sel_astrologer').change(function(){
    var username = $(this).val();
    $.ajax({
     url:'<?=base_url()?>/home/astologer_peice_details',
     method: 'post',
     data: {username: username},
     dataType: 'json',
     success: function(response){
      console.log(response.horoscope_price);
      
    
       $('#horoscope_price').text('');
      
         // Read values
         var horoscope_price = response.horoscope_price;
      
         $('#horoscope_price').text(horoscope_price);
         $('#astro_price').val(horoscope_price);
      
 
     }
   });
  });
 });
 </script>