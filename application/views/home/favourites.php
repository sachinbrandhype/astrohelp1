<style type="text/css">
   .fill_bookmark{
      background-color: green !important;
   }
</style>
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
                     <h2 class="breadcrumb-title">Favourites</h2>
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
                    
                           
                        <div class="row row-grid">
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


           @$user_id = $_SESSION['user_id'];
           if(!empty($user_id)){

            $q = $this->db->get_where('user_bookmark', ['user_id' => $user_id, 'astrologer_id' => $key->id]);
            $is_bookmarked = $q->row();

            
           }else{
              $is_bookmarked=0;
           }



      ?>                  
<div class="col-md-6 col-lg-4 col-xl-3"> 

             <div class="profile-widget">
                <div class="doc-img">
                     <a href="<?=$deturl?>">
                               <img class="img-fluid" style=" height: 250px; " alt="User Image" src="<?= BASE_URL_IMAGE.'astrologers/'.$key->image ?>">
                              </a>
                          <?php

                           if ($is_bookmarked) {
                              ?>
                              <a data-toggle="tooltip" data-placement="top" title="Remove from favourites" href="<?php echo base_url(); ?>home/remove_bookmark/<?=$is_bookmarked->id?>" class="fav-btn fill_bookmark">
                              <i class="far fa-bookmark"></i>
                              </a>

                              <?php
                           }else{
                              ?>
                              <a data-toggle="tooltip" data-placement="top" title="Add to favourites" href="<?php echo base_url(); ?>home/bookmark/<?php echo $key->id; ?>" class="fav-btn">
                              <i class="far fa-bookmark"></i>
                              </a>

                              <?php
                           }

                           ?>
                      </div>

               <div class="pro-content">
                  <h3 class="title">
                 <a href="<?=$deturl?>"><?=$key->name?></a> 
       <i class="fas fa-check-circle verified"></i>
                     </h3>

   <p class="speciality"><?= $specialty?></p>
                 

               <ul class="available-info">
                     <li>
      <i class="fas fa-graduation-cap"></i> Exp: <?=$key->experience?> years
                     </li>

                     <li>
      <i class="fas fa-globe"></i> <?=$key->languages?>
                     </li>

                     <li>
      <i class="far fa-money-bill-alt"></i> ₹<?=$avgprice?>/Min
                     </li>

                     </ul>
            <div class="row row-sm">
               <div class="col-4">
    <a href="<?=$deturl?>" class="btn view-btn"><i class="far fa-comment-alt"></i> ₹<?=$key->price_per_mint_chat?>/Min</a>
                    </div>

                <div class="col-4">
    <a href="<?=$deturl?>" class="btn view-btn-busy"><i class="fas fa-phone"></i> ₹<?=$key->price_per_mint_audio?>/Min</a>
                    </div>

                    <div class="col-4">
    <a href="<?=$deturl?>" class="btn view-btn" data-toggle="modal" data-target="#download-popup"><i class="fas fa-video"></i> ₹<?=$key->price_per_mint_video?>/Min</a>
                    </div>
                    </div>
                    </div>
                    </div>
            
            </div>
               <?php endforeach ?>
 <!-- /astrologer Widget -->
 
 <!-- /astrologer Widget -->

 <!-- /astrologer Widget -->
                          </div>
                           
                       
                  </div>
               </div>
            </div>

         </div>      
         <!-- /Page Content -->

         