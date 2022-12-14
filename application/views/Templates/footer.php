   <footer class="footer">
            <!-- Footer Top -->
               <?php
      $web_data = $this->db->query("select google_play_app_link,ios_app_link,facebook_link,youtube_link,instagram_link,twitter_link,linkedin_link,address,support_email,helpline_number from settings where id = 1")->row();
      
      ?>
            <div class="footer-top">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-about">
                           <div class="footer-logo">
                              <img src="<?php echo base_url();?>assets/img/footer-logo.png" alt="logo">
                           </div>
                           <div class="footer-about-content">
                              <p><?php // echo $web_data->facebook_link;?> </p>
                              <div class="social-icon">
                                 <ul>
                                    <li>
                                       <a href="<?php echo $web_data->facebook_link;?>"><i class="fab fa-facebook-f"></i> </a>
                                    </li>
                                    <li>
                                       <a href="<?php echo $web_data->twitter_link;?>"><i class="fab fa-twitter"></i> </a>
                                    </li>
                                    <li>
                                       <a href="<?php echo $web_data->linkedin_link;?>"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li>
                                       <a href="<?php echo $web_data->instagram_link;?>"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                       <a href="<?php echo $web_data->youtube_link;?>"><i class="fab fa-youtube"></i></a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                           <h2 class="footer-title">Online Advice</h2>
                             <ul>
                       <!--   <?php
                        $top_expertise = $this->db->query("SELECT * FROM `master_specialization` WHERE `status` = '1' AND `in_home` = '1' ORDER BY `position` ASC")->result();
                          if ($top_expertise): ?>
                         
                              <?php foreach ($top_expertise as $texp): ?>
                              <li><a href="<?=base_url('sdauth/filter_astrologers/'.$texp->id)?>"><?=ucfirst($texp->name) ?></a></li>
                              <?php endforeach ?>

                           <?php endif ?> -->

                       <li><a href="<?php echo base_url();?>home/career_report">Career Report</a></li>
                       <li><a href="<?php echo base_url();?>home/business_report">Business Report</a></li>
                        <li><a href="<?php echo base_url();?>home/marriage_report">Marriage Report</a></li>
                         <li><a href="<?php echo base_url();?>home/child_report">Child Report</a></li>

                           </ul>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-menu">
                           <h2 class="footer-title">Useful Links</h2>
                           <ul>
                              <li><a href="<?php echo base_url();?>home/about_us">About Us</a></li>
                              <li><a href="<?php echo base_url();?>home/astrologer_registration">Astrologer Registration</a></li>
                           <!--    <li><a href="#">Partner Us</a></li>
                              <li><a href="#">Career</a></li> -->
                              <li><a href="<?php echo base_url();?>home/my_account">My Account</a></li>
                              <li><a href="<?php echo base_url();?>home/money_back">Money Back</a></li>
                           </ul>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                     <div class="col-lg-3 col-md-6">
                        <!-- Footer Widget -->
                        <div class="footer-widget footer-contact">
                           <h2 class="footer-title">Contact Us</h2>
                           <div class="footer-contact-info">
                              <div class="footer-address">
                                 <span><i class="fas fa-map-marker-alt"></i></span>
                                 <p><?php echo $web_data->address; ?></p>
                              </div>
                              <p>
                                 <i class="fas fa-phone-alt"></i>
                                 <?php echo $web_data->helpline_number; ?>
                              </p>
                              <p class="mb-0">
                                 <i class="fas fa-envelope"></i>
                                  <?php echo $web_data->support_email; ?>
                              </p>
                           </div>
                        </div>
                        <!-- /Footer Widget -->
                     </div>
                  </div>
               </div>
            </div>
            <!-- /Footer Top -->
            <!-- Footer Bottom -->
            <div class="footer-bottom">
               <div class="container">
                  <!-- Copyright -->
                  <div class="copyright">
                     <div class="row">
                        <div class="col-md-6 col-lg-6">
                           <div class="copyright-text">
                              <p class="mb-0">&copy; 2021 Astrohelp243. All rights reserved.</p>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                           <!-- Copyright Menu -->
                           <div class="copyright-menu">
                              <ul class="policy-menu">
                                <li><a href="<?php echo base_url();?>home/terms">Terms and Conditions</a></li>
                                 <li><a href="<?php echo base_url();?>home/privacy">Policy</a></li>
                              </ul>
                           </div>
                           <!-- /Copyright Menu -->
                        </div>
                     </div>
                  </div>
                  <!-- /Copyright -->
               </div>
            </div>
            <!-- /Footer Bottom -->
         </footer>