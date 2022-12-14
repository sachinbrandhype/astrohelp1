<?php
if (isset($_SESSION['user_id'])) {
   $current_url = current_url();
   $get_booking_ = $this->db->query("SELECT * FROM `bookings` WHERE `user_id` = '" . $_SESSION['user_id'] . "' AND `type` IN ('1','2','3') AND `booking_type`='2' AND `status` = 0 AND (`is_chat_or_video_start` = '1' or `is_chat_or_video_start` = '2') LIMIT 1");
   if ($get_booking_->num_rows() > 0) {
      if (strpos($_SERVER['REQUEST_URI'], 'sdauth/chatwindow') !== false) {
      } else {
         redirect(base_url('sdauth/chatwindow'));
      }
   }
}

?>

<?php $CI = &get_instance();


?>
<?php $session_data = ($CI->applib->get_user_session());

// print_r($session_data); die;

?>



<header class="header">
   <nav class="navbar navbar-expand-lg header-nav">
      <div class="navbar-header">
         <a id="mobile_btn" href="javascript:void(0);">
            <span class="bar-icon">
               <span></span>
               <span></span>
               <span></span>
            </span>
         </a>
         <a href="<?php echo base_url(); ?>" class="navbar-brand logo">
            <img src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid" alt="Logo">
         </a>
      </div>
      <div class="main-menu-wrapper">
         <div class="menu-header">
            <a href="<?php echo base_url(); ?>" class="menu-logo">
               <img src="<?php echo base_url(); ?>assets/img/logo.png" class="img-fluid" alt="Logo">
            </a>
            <a id="menu_close" class="menu-close" href="javascript:void(0);">
               <i class="fas fa-times"></i>
            </a>
         </div>
         <ul class="main-nav">
            <li class="">
               <a href="<?php echo base_url(); ?>">Home</a>
            </li>
            <li class="">
               <a href="<?php echo base_url(); ?>home/about_us">About Us</a>
            </li>
            <!-- <li class="has-submenu">
               <a href="">Services <i class="fas fa-chevron-down"></i></a>
               <ul class="submenu">
                  <li class="has-submenu">
                     <a href="#">Report</a>
                     <ul class="submenu">
                        <li><a href="<?php echo base_url(); ?>home/career_report">Career Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/education_report">Education Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/marriage_report">Marriage Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/love_report">Love Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/child_report">Child Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/business_report">Business Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/foreign_report">Foreign Report</a></li>
                        <li><a href="<?php echo base_url(); ?>home/property_report">Property Report</a></li>
                     </ul>
                  </li>
                  <li class="has-submenu">
                     <a href="#">Courses</a>
                     <ul class="submenu">
                        <li><a href="<?php echo base_url(); ?>home/astrology_course">Astrology Courses</a></li>
                        <li><a href="<?php echo base_url(); ?>home/tarot_course">Tarot Course</a></li>
                        <li><a href="<?php echo base_url(); ?>home/vastu_course">Vastu Course</a></li>
                        <li><a href="<?php echo base_url(); ?>home/palmistry_course">Palmistry Course</a></li>
                     </ul>
                  </li>
                  <li class="has-submenu">
                     <a href="#">Vastu Consultant</a>
                     <ul class="submenu">
                        <li><a href="<?php echo base_url(); ?>home/office_vastu">Home /office Vastu</a></li>
                        <li><a href="<?php echo base_url(); ?>home/industrial_vastu">Industrial Vastu</a></li>
                     </ul>
                  </li>
                  <li><a href="<?php echo base_url(); ?>home/horoscopes">Free Horoscope</a></li>
                  <li><a href="<?php echo base_url(); ?>kundali/match-making.php">Marriage Matching</a></li>
                  <li><a href="<?php echo base_url(); ?>kundali/numerology-details.php">Numerology</a></li>
               </ul>
            </li> -->
            <li class="">
               <a href="<?php echo base_url(); ?>sdauth/filter_astrologers" class="">Consult Astrologers</a>
            </li>
            <li class="">
               <a href="<?php echo base_url(); ?>home/blog" class="">Blog</a>
            </li>

            <!-- <li class="">
               <a class="" href="<?php echo base_url(); ?>kundali?id">Kundli</a>
            </li> -->


            <!--  <li class="">
                        <a href="#">Horoscopes</a>
                          </li> -->
            <!--  <li class="">
                        <a href="#">My Account</a>
                     </li> -->
            <!--  <li class="">
                        <a href="blog.html">Blogs</a>
                          </li> -->
            <li class="">
               <a href="<?php echo base_url(); ?>home/contact">Contact Us</a>
            </li>
            <li class="login-link">
               <a href="#">Login / Signup</a>
            </li>
         </ul>
      </div>
      <ul class="nav header-navbar-rht">
         <li class="nav-item contact-item">


            <?php
            if (!empty($_SESSION['user_id'])) {

               $u_ide = $_SESSION['user_id'];
               $web_wallet = $this->db->query("select wallet from user where id = $u_ide")->row();
               // $wallet = $_SESSION['user_data']->wallet;
            ?>
               <div class="header-contact-detail">
                  <a class="nav-link header-wallet" href="<?php echo base_url(); ?>home/wallet"> Wallet : ₹ <?php echo $web_wallet->wallet; ?>/-</a>
               </div>
            <?php
            }

            ?>


            <!--    <div class="header-contact-img">
                        <i class="far fa-hospital"></i>                    
                     </div>
                     <div class="header-contact-detail">
                        <p class="contact-header">Contact</p>
                          <?php
                           $web_data = $this->db->query("select helpline_number from settings where id = 1")->row();

                           ?>
                        <p class="contact-info-header"><?php echo $web_data->helpline_number; ?></p>
                     </div> -->
         </li>
         <li class="nav-item">

            <?php
            if (!empty($_SESSION['user_id'])) {
            ?>
               <a class="nav-link header-login" href="<?php echo base_url(); ?>home/logout">Logout </a>
            <?php
            } else {
            ?>
               <a class="nav-link header-login" href="<?php echo base_url(); ?>home/login">login / Signup </a>
            <?php
            }

            ?>

         </li>
      </ul>
   </nav>
</header>