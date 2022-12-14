
         <!-- /Header -->
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-12 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">My Account</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Change Password</h2>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Breadcrumb -->
         <!-- Page Content -->
         <div class="content">
            <div class="container-fluid">
               <div class="row">
                  <!-- Profile Sidebar -->
                  <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                     <div class="profile-sidebar">
                        <div class="widget-profile pro-widget-content">
                           <div class="profile-info-widget">
                              <a href="#" class="booking-doc-img">
                              <img src="<?php echo base_url();?>assets/img/patients/patient.jpg" alt="User Image">
                              </a>
                              <div class="profile-det-info">
                                 <h3>Richard Wilson</h3>
                                 <div class="patient-details">
                                    <h5><i class="fas fa-birthday-cake"></i> 24 Jul 1983, 38 years</h5>
                                    <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> New Delhi, India</h5>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="dashboard-widget">
                           <nav class="dashboard-menu">
                              <ul>
                                 <li class="active">
                                    <a href="<?php echo base_url();?>home/my_account">
                                    <i class="fas fa-columns"></i>
                                    <span>Dashboard</span>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="<?php echo base_url();?>home/favourites">
                                    <i class="fas fa-bookmark"></i>
                                    <span>Favourites</span>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="<?php echo base_url();?>home/booking_history">
                                       <i class="fas fa-comments"></i>
                                       <span>Booking History</span>
                                       <!--  <small class="unread-msg">23</small> -->
                                    </a>
                                 </li>
                                 <li>
                                    <a href="<?php echo base_url();?>home/change_password">
                                    <i class="fas fa-lock"></i>
                                    <span>Change Password</span>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="<?php echo base_url();?>home/logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                    </a>
                                 </li>
                              </ul>
                           </nav>
                        </div>
                     </div>
                  </div>
                  <!-- /Profile Sidebar -->
                  <div class="col-md-7 col-lg-8 col-xl-9">
                     <div class="card">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-12 col-lg-12">
                                 <!-- Change Password Form -->
                                 <form method="post">
                                   <!--  <div class="form-group">
                                       <label>Old Password</label>
                                    <input type="password" name="password" class="form-control input_size required" data-parsley-trigger="change"  
                      data-parsley-minlength="2" data-parsley-maxlength="15" data-parsley-pattern="^[a-zA-Z0-9\  \/]+$" required="" placeholder="Enter Old Password">
                                    </div> -->
                                    <div class="form-group">
                                       <label>New Password</label>
                                      <input type="password" name="password" class="form-control input_size required" data-parsley-trigger="change" 
                   data-parsley-minlength="6" data-parsley-maxlength="15" data-parsley-pattern="^[a-zA-Z0-9\  \/]+$" required=""placeholder="Enter New Password">
                   <input type="hidden" name="user_id" value="<?php echo $user_id;?>" >
                                    </div>
                                    <div class="form-group">
                                       <label>Confirm Password</label>
                                       <input type="password" name="confirm_password" class="form-control input_size required" data-parsley-trigger="change"   
                   data-parsley-minlength="6" data-parsley-maxlength="15" data-parsley-pattern="^[a-zA-Z0-9\  \/]+$" required="" placeholder="Enter Password Again">
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
         <!-- Footer -->
       