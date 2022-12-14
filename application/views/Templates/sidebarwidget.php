<?php 
if (isset($_SESSION['user_id'])) 
{
   $get_user_details = $this->db->get_where("user",array("id"=>$_SESSION['user_id']))->row();
   if ($get_user_details) {
      $user_data = $get_user_details;
   }
   else
   {
      redirect(base_url());
   }
   
}
else
{
   redirect(base_url());
}

?>

<div class="widget-profile pro-widget-content">
   <div class="profile-info-widget">
      <a href="#" class="booking-doc-img">
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
      </a>
      <div class="profile-det-info">
         <h3><?php echo $user_data->name;?></h3>
         <div class="patient-details">
            <h5><i class="fas fa-birthday-cake"></i> <?php echo $user_data->dob;?></h5>
            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?php echo $user_data->place_of_birth;?></h5>
         </div>
      </div>
   </div>
</div>
<div class="dashboard-widget">
   <nav class="dashboard-menu">
      <ul>
         <li class="<?php echo strpos($_SERVER['REQUEST_URI'],'home/my_account') !== false ? 'active' : ''  ?>">
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
         <li class="<?php echo strpos($_SERVER['REQUEST_URI'],'home/booking_history') !== false ? 'active' : ''  ?>">
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
         <li lass="<?php echo strpos($_SERVER['REQUEST_URI'],'home/logout') !== false ? 'active' : ''  ?>">
            <a href="<?php echo base_url();?>home/logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
            </a>
         </li>
      </ul>
   </nav>
</div>