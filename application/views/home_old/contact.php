
         <!-- /Header -->
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Contact Us</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
         <!-- Page Content -->
         <div class="content">
            <section class="contact-page-section">
               <div class="auto-container">
                  <div class="inner-container">
                     <h2>Contact our support guys</h2>
                     <div class="row clearfix">
                        <!-- Info Column -->
                        <div class="info-column col-lg-6 col-md-12 col-sm-12">
                           <div class="inner-column">
                              <div class="text"><?php echo  $contact_us->contact_us?></div>
                              <ul class="list-style-two">
                                 <li><span class="icon fa fa-building"></span> <?php echo  $contact_us->address?></li>
                                 <li><span class="icon fa fa-fax"></span> <?php echo  $contact_us->helpline_number?></li>
                                 <li><span class="icon fa fa-envelope"></span><?php echo  $contact_us->support_email?></li>
                              </ul>
                           </div>
                        </div>
                        <!-- Form Column -->
                        <div class="form-column col-lg-6 col-md-12 col-sm-12">
                           <div class="inner-column">
                              <!--Contact Form-->
                              <div class="contact-form">
                                 <form method="post">
                                    <div class="form-group">
                                       <input type="text" name="firstname"  value="" placeholder="Full name" required="">
                                    </div>
                                    <div class="form-group">
                                       <input type="text" name="email" name="" value="" placeholder="Email" required="">
                                    </div>
                                    <div class="form-group">
                                       <input type="text" name="mobile" name="" value="" placeholder="mobile no." required="">
                                    </div>
                                    <div class="form-group">
                                       <textarea name="message" name="" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group">
                                       <button type="submit" class="btn btn-primary">Send Message</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <!-- /Page Content -->
         <!-- Footer -->
       