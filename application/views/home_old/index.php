<!-- Main Wrapper -->
<!-- Header -->
<!-- /Header -->
<!-- Home Banner -->
<div class="container-fluid">
   <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
         <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
         <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
         <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
      </ol>
      <div class="banner-wrapper">
         <div class="banner-header text-center">
            <h1 style="color: #ffffff;">Search Astrologer, Make an Appointment</h1>
            <p style="color: #ffffff;">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
         </div>
         <!-- Search -->
         <div class="search-box">
            <form method="post" action="<?=base_url('sdauth/filter_astrologers')?>">
               <input type="hidden" name="sorting" value="">
               <input type="hidden" name="expertiseastro" value="">
               <input type="hidden" name="language" value="">
               <input type="hidden" name="rating" value="">
               <div class="form-group search-info">
                  <input type="text" name="search_keyword" class="form-control" placeholder="Search Astrologer, Categories Etc">
               </div>
               <button type="submit" class="btn btn-primary search-btn mt-0"><i class="fas fa-search"></i> <span>Search</span></button>
            </form>
         </div>
         <!-- /Search -->
      </div>
      <div class="carousel-inner">
         <?php
            if (!empty($slider)) 
            {  
               $i=1;
               foreach ($slider as $slider_key ) 
               {
                  ?>
         <div class="carousel-item <?php if($i == 1) { echo "active"; } ?>">
            <div class="mask flex-center">
               <div class="align-items-center">
                  <div class="order-1">
                     <img src="<?php echo BASE_URL_IMAGE."banner/website/".$slider_key->image;?>" class="" alt="slide"> 
                  </div>
               </div>
            </div>
         </div>
         <?php
            $i++;
            }
            }
            
            ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
      </a>
   </div>
</div>
<!-- /Home Banner -->
<?php if ($top_expertise): ?>
      <section class="section section-category">
      <div class="container">
         <div class="row">
            <?php foreach ($top_expertise as $texp): ?>
            <a href="<?=base_url('sdauth/filter_astrologers/'.$texp->id)?>"><div class="col-lg-2">
               <div class="speicality-item text-center">
                  <div class="speicality-img rel">
                     <img src="<?= BASE_URL_IMAGE.'specialities/'.$texp->image ?>" class="img-fluid">
                  </div>
                  <p><?=ucfirst($texp->name) ?></p>
               </div>
            </div>
            </a>
            <?php endforeach ?>
         </div>
      </div>
   </section>
   
<?php endif ?>
<!-- Kundali category -->
<section class="section section-horos">
   <div class="container">
      <!-- Section Header -->
      <div class="section-header">
         <h2 class="daily-hor">Daily Horoscopes</h2>
         <p class="sub-title horos-tit">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <!-- /Section Header -->
      <div class="row">
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-aries">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/aries1.png"></span>
               </div>
               <p class="text-sign pbold5">Aries</p>
               <p class="date-da">Mar 21 - Apr 19</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-taurus">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/taurus1.png"></span>
               </div>
               <p class="text-sign pbold5">Taurus</p>
               <p class="date-da">Apr 20 - May 20</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-gemini">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/gemini1.png"></span>
               </div>
               <p class="text-sign pbold5">Gemini</p>
               <p class="date-da">May 21 - Jun 20</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-cancer">
                  <span class="bg-aries-icon bg-horoshop-icon can"><img src="<?php echo base_url();?>assets/img/category/cancer1.png"></span>
               </div>
               <p class="text-sign pbold5">Cancer</p>
               <p class="date-da">jul 21 - Jul 22</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-leo">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/leo1.png"></span>
               </div>
               <p class="text-sign pbold5">Leo</p>
               <p class="date-da">Jul 23 - Aug 22</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-virgo">
                  <span class="bg-aries-icon bg-horoshop-icon vir"><img src="<?php echo base_url();?>assets/img/category/virgo1.png"></span>
               </div>
               <p class="text-sign pbold5">Virgo</p>
               <p class="date-da">Aug 23 - Sep 22</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-libra">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/libra1.png"></span>
               </div>
               <p class="text-sign pbold5">Libra</p>
               <p class="date-da">Sep 23 - oct 22</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-scorpio">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/scorpion1.png"></span>
               </div>
               <p class="text-sign pbold5">Scorpio</p>
               <p class="date-da">Oct 23 - nov 21</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-sagitt">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/sagittarius1.png"></span>
               </div>
               <p class="text-sign pbold5">Sagittarius</p>
               <p class="date-da">Nov 22 - Dec 21</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-capricorn">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/capricorn1.png"></span>
               </div>
               <p class="text-sign pbold5">Capricorn</p>
               <p class="date-da">dec 22 - Jan 19</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-aquarius">
                  <span class="bg-aries-icon bg-horoshop-icon aqu"><img src="<?php echo base_url();?>assets/img/category/aquarius1.png"></span>
               </div>
               <p class="text-sign pbold5">Aquarius</p>
               <p class="date-da">Jan 20 - Feb 19</p>
            </div>
         </div>
         <div class="col-md-2 col-sm-3 col-xs-6">
            <div class="sign-tile">
               <div class="icon1 bg-pisces">
                  <span class="bg-aries-icon bg-horoshop-icon"><img src="<?php echo base_url();?>assets/img/category/pisces1.png"></span>
               </div>
               <p class="text-sign pbold5">Pisces</p>
               <p class="date-da">Mar 21 - Apr 19</p>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- /Indian Section -->
<!--how it work  -->
<div class="sign-det">
   <div class="container">
      <!-- Section Header -->
      <div class="col-md-8" style="margin: 0 auto;">
         <div class="section-header" style="margin-bottom: 0px;">
            <h2>How it works</h2>
            <p class="sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
         </div>
      </div>
      <!-- /Section Header -->
      <div class="col-md-8" style="margin: 0 auto;">
         <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
               <div class="stepwizard-step">
                  <a href="#step-1" type="button" class="btn btn-default btn-circle"><i class="fas fa-user"></i></a>
                  <p class="sig">Signup <br><span class="ast">with Astrokul</span></p>
                  <div class="cir">
                     <img src="<?php echo base_url();?>assets/img/cir.png">
                  </div>
               </div>
               <div class="stepwizard-step">
                  <a href="#step-2" type="button" class="btn btn-default btn-circle"><i class="fas fa-wallet"></i></a>
                  <p class="ast">Put money in your <br><span class="sig">Astrokul Wallet</span></p>
                  <div class="cir1">
                     <img src="<?php echo base_url();?>assets/img/cir.png">
                  </div>
               </div>
               <div class="stepwizard-step">
                  <a href="#step-3" type="button" class="btn btn-default btn-circle"><i class="fas fa-comment-dots"></i></a>
                  <p class="sig">Connect with <br><span class="ast">astrologer</span></p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- end how it work -->
<!-- Popular Section -->
<?php if (count($top_astrologers) > 0): ?>
<section class="section section-doctor">
   <div class="container">
   <!-- Section Header -->
   <div class="row">
      <div class="col-md-6">
         <div class="section-header">
            <h2 class="top-ast">India top astrologer's</h2>
            <p class="sub-title ast-lis">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
         </div>
      </div>
      <div class="col-md-6">
         <div class="search">
            <input type="text" class="form-control input-sm" maxlength="64" placeholder="Search" />
            <a href="<?=base_url('home/astrologer_list')?>"><button type="submit" class="btn1 btn-primary btn-sm sear">Search</button></a>
         </div>
      </div>
   </div>
   <!-- /Section Header -->
   <div class="row">
      <!-- astrologer Widget -->
      <?php foreach ($top_astrologers as $key): 

         $avgprice = 100;
         if ($key->price_per_mint_chat > 0) {
            $avgprice = $key->price_per_mint_chat;
         }

         // phone
         $audio_status = '';
         $audio_price = '';
         if ($key->audio_status == 1) 
         {
            $audio_status = 1;
            $audio_price = $key->price_per_mint_audio;
         }

         $chat_status = '';
         $chat_price = '';
         if ($key->chat_status == 1) 
         {
            $chat_status = 1;
            $chat_price = $key->price_per_mint_audio;
         }

         $video_status = '';
         $video_price = '';
         if ($key->video_status == 1) 
         {
            $video_status = 1;
            $video_price = $key->price_per_mint_video;
         }

         $specialty = '';
         $astrid = $key->id;
         $get_specialty = $this->db->get_where("skills",array("user_id"=>$astrid,"type"=>1))->result();
         if (count($get_specialty)) 
         {
            $a = array();
            foreach ($get_specialty as $keys) 
            {
               $get_name = $this->db->get_where("master_specialization",array("id"=>$keys->speciality_id))->row();
               if ($get_name) 
               {
                  array_push($a, ucfirst($get_name->name));
                  // $skills[] = array("skill_id"=>$keys->speciality_id,
                             // "skill_name"=>$get_name->name);
               }
            }

            if (!empty($a)) 
            {
               $specialty = implode(', ', $a);
            }
         }

         $deturl = base_url('home/astrologer_profile').'/'.$key->id;

      ?>
         <div class="col-md-3">
            <div class="profile-widget">
               <div class="doc-img">
                  <a href="<?=$deturl?>">
                  <img class="img-fluid" alt="User Image" src="<?= BASE_URL_IMAGE.'astrologers/'.$key->image ?>">
                  </a>
                  <a href="<?=$deturl?>" class="fav-btn">
                  <i class="fas fa-phone-alt"></i>
                  </a>
                  <a href="<?=$deturl?>" class="fav-btn1">
                  <i class="fas fa-comment-dots"></i>
                  </a>
                  <a href="<?=$deturl?>" class="fav-btn2" data-toggle="modal" data-target="#download-popup">
                  <i class="fas fa-video"></i>
                  </a>
                  <a href="<?=$deturl?>" class="fav-btn3">
                     <p class="pri">Start's ₹<?=$avgprice?>/min</p>
                  </a>
               </div>
               <div class="pro-content">
                  <h3 class="title">
                     <a href="<?=$deturl?>"><?=$key->name?></a> 
                  </h3>
                  <p class="speciality"><?= $specialty?></p>
                  <ul class="available-info">
                     <li>
                        <i class="fas fa-graduation-cap"></i> Exp: <?=$key->experience?> years
                     </li>
                     <li>
                        <i class="fas fa-globe"></i> <?=$key->languages?>
                     </li>
                  </ul>
               </div>
            </div>
         </div>      
      <?php endforeach ?>
   </div>
</section>   
<?php endif ?>
<!-- /Popular Section -->
<!-- three box offer -->
<section class="section home-tile-section">
   <div class="container-fluid offf">
      <div class="row">
         <div class="col-md-12 m-auto">
            <div class="row">
               <?php
                  if (!empty($advertisment)) 
                  {
                     foreach ($advertisment as $advertisment_key ) {
                        ?>
               <div class="col-lg-4 mb-3">
                  <div class="square-flip">
                     <div class="square" data-image="" style="background-image: url(<?php echo BASE_URL_IMAGE."advertisment/".$advertisment_key->image;?>);">
                        <div class="square-container">
                           <div class="align-center"><img src="<?php echo base_url();?>" class="boxshadow" alt=""></div>
                           <h2 class="textshadow"><?php echo $advertisment_key->title;  ?></h2>
                           <h3 class="textshadow"><?php echo $advertisment_key->sub_title;  ?></h3>
                        </div>
                        <div class="flip-overlay"></div>
                     </div>
                     <div class="square2" data-image="" style="background-image: url(<?php echo BASE_URL_IMAGE."advertisment/".$advertisment_key->image;?>);">
                        <div class="square-container2">
                           <div class="align-center"></div>
                           <p class="offer-para"><?php echo $advertisment_key->desc;  ?></p>
                        </div>
                        <div class="flip-overlay"></div>
                     </div>
                  </div>
               </div>
               <?php
                  }
                  }
                  ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end three box offer -->
<!-- download section -->
<section class="download-section">
   <div class="container">
      <div class="row">
         <div class="col-md-5 hidden-sm">
            <div class="download-app-img">
               <img src="<?php echo base_url();?>assets/img/hand.png" alt="app download" class="img-responsive">
            </div>
         </div>
         <div class="col-md-6 col-sm-12">
            <div class="download-app-text">
               <h3 class="get-ap">Get The App Now !</h3>
               <style type="text/css">.app-now {
                  padding-left: 20px;
                  }
                  .app-ast {
                  font-size: 18px;
                  font-weight: 200;
                  color: #fff;
                  }
               </style>
               <ul class="app-now">
               <br>
               <li class="app-ast">1000+ Astrologers</li>
               <li class="app-ast">100m+ transactions</li>
               <li class="app-ast">Consult for better future</li>
               <!--                        </ul>
                  <p>AstroKul is one of the best astrology website for online Astrology consultation, which aims to provide genuine solution to its customers.</p> -->
               <br> 
               <div class="wemr1o-0 y6yjzl-5 cBhRmx">
                  <div data-test="text-me-app-title" class="sc-1lnfyly-0 jQalim">Send me a link to the app</div>
                  <div class="sc-1lnfyly-5 bxBWsr">
                     <div class="sc-1lnfyly-6 ewpuuk">
                        <span class="">
                           <div data-test="textbox-wrapper" class="f9jwpk-0 jkeClL">
                              <input type="text" class="f9jwpk-1 gRjNsF sc-1lnfyly-1 srttX exclude-from-playback" data-test="phone-number-textbox" placeholder="(+91) 9898989898" value="">
                           </div>
                        </span>
                     </div>
                     <button tabindex="0" class="yglqz4-2 fNAZIY">Send link</button>
                  </div>
               </div>
               <div class="download-app-button">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="play">
                           <a href=""><img src="<?php echo base_url();?>assets/img/ios.png"></a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="play">
                           <a href=""><img src="<?php echo base_url();?>assets/img/android.png"></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- end download section -->
<!-- Blog Section -->
<section class="section section-blogs">
   <div class="container">
      <!-- Section Header -->
      <div class="section-header">
         <h2>Latest Blogs</h2>
         <p class="sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
      </div>
      <!-- /Section Header -->
      <div class="row blog-grid-row">
         <?php
            if (!empty($blog)) 
            {
               $ss = 1;
               foreach ($blog as $blog_key) {
                  ?>
         <div class="col-md-6 col-lg-3 col-sm-12">
            <div class="blog grid-blog <?php 
               if($ss == 1) { echo 'sd_one'; } 
               elseif($ss == 2) { echo 'sd_two'; }
               elseif($ss == 3) { echo 'sd_three'; }
               elseif($ss == 4) { echo 'sd_four'; }
               ?>">
               <div class="blog-image">
                  <a href="<?php echo base_url();?>home/blog_details/<?php echo $blog_key->id; ?>"><img class="img-fluid" src="<?php echo BASE_URL_IMAGE."blog/".$blog_key->image;?>" alt="Post Image"></a>
               </div>
               <div class="blog-content">
                  <h3 class="blog-title 
                     <?php 
                        if($ss == 1) { echo 'blog_tt_one'; } 
                        elseif($ss == 2) { echo 'blog_tt_two'; }
                        elseif($ss == 3) { echo 'blog_tt_three'; }
                        elseif($ss == 4) { echo 'blog_tt_four'; }
                        ?>">   
                     <?php echo $blog_key->title; ?>
                  </h3>
                  <p class="mb-0 
                     <?php 
                        if($ss == 1) { echo "blog_cc_one"; } 
                        elseif($ss == 2) { echo "blog_cc_two"; }
                        elseif($ss == 3) { echo "blog_cc_three"; }
                        elseif($ss == 4) { echo "blog_cc_four"; }
                        ?>
                     "><?php echo preg_replace('/\s+?(\S+)?$/', '', substr($blog_key->desc, 0, 263)).".."; ?></p>
               </div>
            </div>
         </div>
         <?php
            $ss++;
            }
            }
            ?>
         <!--     <div class="col-md-6 col-lg-3 col-sm-12">
            <div class="blog grid-blog sd_two">
            <div class="blog-image">
            <a href="<?php echo base_url();?>home/blog_details"><img class="img-fluid" src="<?php echo base_url();?>assets/img/blog/blog2.jpg" alt="Post Image"></a>
            </div>
            <div class="blog-content">
            <h3 class="blog-title blog_tt_two">How much does an Astrologer earn online?</h3>
            <p class="mb-0 blog_cc_two">This is the story of a fellow Mridul, who is working with us at Astrokul and is the Best Astrologer in Lucknow & the most followed Astrologer Online.</p>
            </div>
            </div>
            
            </div>
            <div class="col-md-6 col-lg-3 col-sm-12">
            
            <div class="blog grid-blog sd_three">
            <div class="blog-image">
            <a href="<?php echo base_url();?>home/blog_details"><img class="img-fluid" src="<?php echo base_url();?>assets/img/blog/blog3.jpg" alt="Post Image"></a>
            </div>
            <div class="blog-content">
            <h3 class="blog-title blog_tt_three">How much does an Astrologer earn online?</h3>
            <p class="mb-0 blog_cc_three">This is the story of a fellow Mridul, who is working with us at Astrokul and is the Best Astrologer in Lucknow & the most followed Astrologer Online.</p>
            </div>
            </div>
            
            </div>
            <div class="col-md-6 col-lg-3 col-sm-12">
            
            <div class="blog grid-blog sd_four">
            <div class="blog-image">
            <a href="<?php echo base_url();?>home/blog_details"><img class="img-fluid" src="<?php echo base_url();?>assets/img/blog/blog4.jpg" alt="Post Image"></a>
            </div>
            <div class="blog-content">
            <h3 class="blog-title blog_tt_four">How much does an Astrologer earn online?</h3>
            <p class="mb-0 blog_cc_four">This is the story of a fellow Mridul, who is working with us at Astrokul and is the Best Astrologer in Lucknow & the most followed Astrologer Online.</p>
            </div>
            </div>
            
            </div>
            
            -->
      </div>
   </div>
</section>
<!-- /Blog Section -->  
<!-- Footer -->
<!-- /Footer -->
<!-- /Main Wrapper -->
<!-- download app Modal -->