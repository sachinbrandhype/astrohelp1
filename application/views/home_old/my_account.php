
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
                     <h2 class="breadcrumb-title">My Account</h2>
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
                        <?php $this->load->view('Templates/sidebarwidget'); ?>
                     </div>
                  </div>
                  <!-- /Profile Sidebar -->
                  <div class="col-md-7 col-lg-8 col-xl-9">
                     <div class="card">
                        <div class="card-body">
                           <!-- Profile Settings Form -->
                           <form enctype="multipart/form-data"  method="post">
                              <div class="row form-row">
                                 <div class="col-12 col-md-12">
                                    <div class="form-group">
                                       <div class="change-avatar">
                                          <div class="profile-img">
                                             <?php
                                             // print_r($user_data->image); die;
                                             if ($user_data->image) {
                                            ?>
                                              <img src="<?php echo BASE_URL_IMAGE."user/".$user_data->image;?>" class="" alt="User Image"> 
                                           
                                            <?php
                                             }
                                             else{
                                                ?>
                                                 <img src="<?php echo base_url();?>assets/img/patients/patient.jpg" alt="User Image">
                                                <?php
                                             }
                                             ?>
                                         
                                          </div>
                                          <div class="upload-img">
                                             <div class="change-photo-btn">
                                                <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                   <input type="file" id="files" name="image" class="form-control upload" >
                                                <input type="hidden" name="old_image" value="<?=$user_data->image?>">

                                             </div>
                                             <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                       <label>First Name</label>
                                       <input type="text" class="form-control" name="name" value="<?php echo $user_data->name;?>">
                                    </div>
                                 </div>
                               
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                       <label>Date of Birth</label>
                                       <div class="cal-icon">
                                          <input type="date" class="form-control datetimepicker"  name="dob" value="<?php echo $user_data->dob;?>">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                       <label>Gender</label>
                                       <select class="form-control select" name="gender">
                                          <option value="male"  <?=$user_data->gender == "male" ? 'selected' : ''?>>Male</option>
                                          <option value="female"   <?=$user_data->gender == "female" ? 'selected' : ''?>>Female</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                       <label>Email ID</label>
                                       <input type="email" class="form-control"  name="email" value="<?php echo $user_data->email;?>">
                                    </div>
                                 </div>
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                       <label>Mobile</label>
                                       <input type="text"  name="phone" value="<?php echo $user_data->phone;?>" class="form-control">
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-group">
                                       <label>Place of birth</label>
                                       <input type="text" class="form-control" name="place_of_birth" value="<?php echo $user_data->place_of_birth;?>" >
                                    </div>
                                 </div>
                                 <div class="col-12 col-md-6">
                                    <div class="form-group">
                                       <label>Time of birth</label>
                                       <input type="time" class="form-control" name="birth_time" value="<?php echo $user_data->birth_time;?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="submit-section">
                                 <button type="submit" class="btn btn-primary submit-btn">Save Changes</button>
                              </div>
                           </form>
                           <!-- /Profile Settings Form -->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /Page Content -->
         <!-- Footer -->
        