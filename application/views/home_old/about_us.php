
        
         <!-- /Header -->
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">About us</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
         <!-- Page Content -->
         <div class="content">
            <div class="container">
               <div class="row">
                  <div class="col-md-6">
                     <div class="section-header">
                        <h2 class="dtr-mb-4">About Us</h2>
                       <?php echo $data->about_us ?>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="about-img">
                        <img src="<?php echo base_url();?>assets/img/about.png" class="img-responsive" alt="">
                     </div>
                  </div>
               </div>
               <div class="row vis">
                  <div class="col-md-6">
                     <div class="about-img">
                        <img src="<?php echo base_url();?>assets/img/vision.png" class="img-responsive" alt="">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="section-header">
                        <h2>Our Vision</h2>
                       <?php echo $data->our_vision ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Page Content -->
         <!-- Footer -->
         
      <!-- /Main Wrapper -->
      <!-- login form modal -->
