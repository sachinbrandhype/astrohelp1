
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
                     <h2 class="breadcrumb-title">Office Vastu</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
         <!-- Page Content -->
         
            <section class="section section-about">
              
               <div class="container">
                 
                  <div class="row">
                     <div class="col-md-12 mb-5">
                        <div class="about-img">
                           <img src="<?= BASE_URL_IMAGE.'common/'.$page_data->image ?>" width="100%" class="img-responsive" alt="">
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="section-header">
                           <h2 class="dtr-mb-4"><?php echo $page_data->heading ;  ?></h2>
                           <p><?php echo $page_data->desc ;  ?>
                           </p>
                        </div>
                     </div>
                     
                  </div>
               </div>
            </section>
           
         
         <!-- /Page Content -->
       