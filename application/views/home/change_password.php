
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">My Account</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Change Password</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->

         <div class="col-md-12">
   <?php
   if ($this->session->flashdata('message')) {
      $message = $this->session->flashdata('message');

   ?>
      <div class="alert alert-<?php echo $message['class']; ?>">
         <button class="close" data-dismiss="alert" type="button">×</button>
         <?php echo $message['message']; ?>
      </div>
   <?php
   }
   ?>
</div>

         <!-- Page Content -->
         <div class="content">
            <div class="container-fluid">
               <div class="row">
               
                    <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                     <div class="profile-sidebar">                       
                      <?php $this->load->view('Templates/sidebarwidget'); ?>

                     </div>
                  </div>
                  <!-- /Profile Sidebar -->
                  
                  <div class="col-md-7 col-lg-8 col-xl-9">
                    <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-12 col-lg-12">
                              
                                 <!-- Change Password Form -->
                          <form role="form" action="<?php echo base_url(); ?>home/change_password" method="post" data-parsley-validate="" id="change_password_form" class="validate" enctype="multipart/form-data">
                           <div class="form-group">
                              <label>Old Password</label>
                              <input type="password" name="password" class="form-control input_size required" data-parsley-trigger="change" data-parsley-minlength="2" data-parsley-maxlength="15" data-parsley-pattern="^[a-zA-Z0-9\  \/]+$" required="" placeholder="Enter Old Password">
                           </div>
                           <div class="form-group">
                              <label>New Password</label>
                              <input type="password" name="n_password" id="n_password" class="form-control input_size required" data-parsley-trigger="change" data-parsley-minlength="6" data-parsley-maxlength="15" data-parsley-pattern="^[a-zA-Z0-9\  \/]+$" required="" placeholder="Enter New Password">
                           </div>
                           <div class="form-group">
                              <label>Confirm Password</label>
                              <input type="password" name="c_password" class="form-control input_size required" data-parsley-trigger="change" data-parsley-minlength="6" data-parsley-maxlength="15" data-parsley-pattern="^[a-zA-Z0-9\  \/]+$" required="" placeholder="Enter Password Again">
                           </div>
                           <div class="submit-section">
                              <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                           </div>
                        </form>
                                 <!-- /Change Password Form -->
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>      
         <!-- /Page Content -->

        