<?php
$CI =& get_instance();
?>

<style type="text/css">
   .fill_bookmark{
      background-color: green !important;
   }
</style>

         <!-- Header -->
    
         <!-- Home Banner -->
  <div class="">
   <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
         <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
         <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
         <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
      </ol>
    
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


         <!-- Daily Horoscope -->
         <section class="section section-specialities">
            <div class="container">
               <div class="row">


                <div class="col-md-8 d-flex">
                           <div class="card flex-fill">
                              <div class="card-header">
                                 <h4 class="card-title">Kundli Matching</h4>
                              </div>
                              <div class="card-body">
                                <form  method="post" action="<?php echo base_url('kundali/match-making-details.php')?>"  enctype="multipart/form-data" >

<div class="row">


                                 <div class="col-md-6">
                                 
                                       
                                       <div class="row">
                                            <div class="col-lg-12"><div class="exist-customer mb-1">Enter Boy's Details</div></div>
                                          <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Name</label>
                                             <input class="form-control" required name="fullname" id="card_name" type="text">
                                             <input class="form-control" name="web" id="card_name" type="hidden" value="1">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_month">Day</label>
                                             <input class="form-control" required name="m-date" id="expiry_month" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_year">Month</label>
                                             <input class="form-control" name="m-month" id="expiry_year" placeholder="" type="number" required>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Year</label>
                                             <input class="form-control" name="m-year" id="cvv" type="number" required>
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Hours</label>
                                             <input class="form-control" name="m-hour" id="cvv" type="number" required>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Minute</label>
                                             <input class="form-control" name="m-minute" id="cvv" type="number" required>
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Second</label>
                                             <input class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>

                                           <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_number">Birth Place</label>
                                    <div id="locationField">
                                        <input id="rz_location-pac-input"  type="text" placeholder="Enter a location" class="form-control" name="location" required>
                                    </div>
                        <div id="rz_location-map" style="position: relative; overflow: hidden;">
                            <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                               <div style="overflow: hidden;"></div>

                               <div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                                  <div tabindex="0" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: pan-x pan-y;">
                                     <div style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                              <div style="position: absolute; z-index: 987; transform: matrix(1, 0, 0, 1, -21, -245);">
                                                 <div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;">
                                                    <div style="width: 256px; height: 256px;"></div>

                                                 </div>
                                              </div>
                                           </div>
                                        </div>

                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div>
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div>
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"></div>
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 0;"></div>

                                     </div>

                                     <div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;">

                                        <p class="gm-style-pbt"></p>
                                     </div>

                                     <div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                        <div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">

                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"></div>
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div>

                                        </div>
                                     </div>
                                  </div>

                                  <iframe aria-hidden="true" frameborder="0" tabindex="-1" style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;"></iframe>

                               </div>
                            </div>
                         </div>
                    </div>
                    </div>

                
                        <input type="hidden" name="m-latitude"  class="form-control drop_lat" id="input_lat"  placeholder="Latitude" readonly required>
                    

                        <input type="hidden" name="m-longitude" class="form-control drop_lng"  placeholder="Longitude" readonly required>
                   

                                    </div>

                                       
                                     
                                    </div>

  <div class="col-md-6">
                                 
                                       
                                       <div class="row">
                                            <div class="col-lg-12"><div class="exist-customer mb-1">Enter Girl's Details</div></div>
                                          <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Name</label>
                                             <input class="form-control" required name="f_fullname" id="card_name" type="text">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_month">Day</label>
                                             <input class="form-control" required  name="f-date" id="expiry_month" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_year">Month</label>
                                             <input class="form-control" required name="f-month" id="expiry_year" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Year</label>
                                             <input class="form-control" required name="f-year" id="cvv" type="number">
                                          </div>
                                       </div>

                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Hours</label>
                                             <input class="form-control" required name="f-hours" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Minute</label>
                                             <input class="form-control" required name="f-minute" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Second</label>
                                             <input class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>

                                      <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_number">Birth Place</label>
                                    <div id="locationField">
                                        <input id="rz_location-pac-input2"  type="text" placeholder="Enter a location" class="form-control" name="location" required>
                                    </div>
                        <div id="rz_location-map2" style="position: relative; overflow: hidden;">
                            <div style="height: 100%; width: 100%; position: absolute; top: 0px; left: 0px; background-color: rgb(229, 227, 223);">
                               <div style="overflow: hidden;"></div>

                               <div class="gm-style" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px;">
                                  <div tabindex="0" style="position: absolute; z-index: 0; left: 0px; top: 0px; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; cursor: url(&quot;https://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;), default; touch-action: pan-x pan-y;">
                                     <div style="z-index: 1; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                              <div style="position: absolute; z-index: 987; transform: matrix(1, 0, 0, 1, -21, -245);">
                                                 <div style="position: absolute; left: 0px; top: 0px; width: 256px; height: 256px;">
                                                    <div style="width: 256px; height: 256px;"></div>

                                                 </div>
                                              </div>
                                           </div>
                                        </div>

                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div>
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div>
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;"></div>
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 0;"></div>

                                     </div>

                                     <div class="gm-style-pbc" style="z-index: 2; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; opacity: 0;">

                                        <p class="gm-style-pbt"></p>
                                     </div>

                                     <div style="z-index: 3; position: absolute; height: 100%; width: 100%; padding: 0px; border-width: 0px; margin: 0px; left: 0px; top: 0px; touch-action: pan-x pan-y;">
                                        <div style="z-index: 4; position: absolute; left: 50%; top: 50%; width: 100%; transform: translate(0px, 0px);">

                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"></div>
                                           <div style="position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;"></div>

                                        </div>
                                     </div>
                                  </div>

                                  <iframe aria-hidden="true" frameborder="0" tabindex="-1" style="z-index: -1; position: absolute; width: 100%; height: 100%; top: 0px; left: 0px; border: none;"></iframe>

                               </div>
                            </div>
                         </div>
                    </div>
                    </div>

                
                        <input type="hidden" name="f-latitude"  class="form-control drop_lat2" id="input_lat2"  placeholder="Latitude" readonly required>
                    

                        <input type="hidden" name="f-longitude" class="form-control drop_lng2"  placeholder="Longitude" readonly required>
                   

                                    </div>

                                        <div class="submit-section mt-4 col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-md">Continue</button>
                                 </div>
                                     
                                    </div>

</div>
</form>


                              </div>
                           </div>
                        </div>

<!-- 
                        <div class="col-md-4 d-flex">
                           <div class="card flex-fill">
                              <div class="card-header">
                                 <h4 class="card-title">Kundli / Birth Chart</h4>
                              </div>
                              <div class="card-body">
                                   <form  method="post" action="<?php echo base_url('home/action_basic_detail')?>"  enctype="multipart/form-data" >
                                 <div class="row">
                                    
                                    <div class="col-lg-12"><div class="exist-customer mb-1">
                                    Enter Birth Details</div></div>
                                       <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Name</label>
                                             <input type="text" class="form-control" name="name" id="card_name">
                                          </div>
                                       </div>
                                       
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_month">Day</label>
                                             <input type="number" name="day" class="form-control" id="expiry_month" placeholder="" >
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_year">Month</label>
                                             <input  name="month" class="form-control" id="expiry_year" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Year</label>
                                             <input name="year" class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Hours</label>
                                             <input name="hour" class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Minute</label>
                                             <input name="minute" class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                               

                                  


                                       <div class="submit-section mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md">Get Kundli</button>
                                 </div>
                              
                                    </div>
                                    </form>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4 d-flex">
                           <div class="card flex-fill">
                              <div class="card-header">
                                 <h4 class="card-title">Kundli Matching</h4>
                              </div>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12"><div class="exist-customer mb-1">Enter Boy's Details</div></div>
                                       <div class="col-md-12">
                                          <div class="form-group card-label">
                                             <label for="card_name">Name</label>
                                             <input class="form-control" id="card_name" type="text">
                                          </div>
                                       </div>
                                       
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_month">Day</label>
                                             <input class="form-control" id="expiry_month" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="expiry_year">Month</label>
                                             <input class="form-control" id="expiry_year" placeholder="" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Year</label>
                                             <input class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Hours</label>
                                             <input class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Minute</label>
                                             <input class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                                       <div class="col-md-4">
                                          <div class="form-group card-label">
                                             <label for="cvv">Second</label>
                                             <input class="form-control" id="cvv" type="number">
                                          </div>
                                       </div>
                                         
                             
                                       <div class="col-lg-12"><div class="exist-customer mb-3">Enter Girl's Details on next page</div></div>
                                       <div class="submit-section mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md">Continue</button>
                                 </div>
                                    </div>
                              </div>
                           </div>
                        </div> -->
                        <div class="col-md-4 d-flex">
                           <div class="card flex-fill">
                              <div class="card-header">
                                 <h4 class="card-title">Panchang</h4>
                              </div>
                              <div class="card-body">
                                 <div class=" text-center">
                                    <?php 
                                     $datass = json_decode($panchang_data);                                   
                                    ?>
                                 <p><strong>New Delhi, India ( <?php echo date("l jS \of F Y") ?>)</strong></p>
                                 <hr>
                                 <p><strong>Tithi:</strong> <?php echo $datass->tithi;?> </p>
                                
                                 <p><strong>Sunrise:</strong> <?php echo date("h:i:s A",  strtotime($datass->sunrise));?></p>
                                 <p><strong>Sunset:</strong> <?php echo date("h:i:s A",  strtotime($datass->sunset));?></p>
                                 <p><strong>Vedic Sunrise:</strong> <?php echo date("h:i:s A",  strtotime($datass->vedic_sunrise));?></p>
                                 <p><strong>Vedic Sunset:</strong> <?php echo date("h:i:s A",  strtotime($datass->vedic_sunset));?></p>
                                 
                                
                                
                                 <hr>
<p><strong>Nakshatra:</strong> <?php echo $datass->nakshatra;?></p>
<p><strong>Yoga:</strong> <?php echo $datass->yog;?></p>
<p><strong>Karan:</strong><?php echo $datass->karan;?></p>
<hr></div>
<!--  <div class="submit-section mt-4 col-md-12">
                                    <button type="submit" class="btn btn-primary btn-md">Detailed Panchang</button>
                                 </div> -->
 
                              </div>

                           </div>
                        </div>
                     </div>
            </div>
         </section>
         <!-- Daily Horoscope -->
         <?php if (count($top_astrologers) > 0): ?>


         <section class="section section-doctor">
            <div class="container">
               <div class="section-header text-center">
                  <h2>Online Astrologers</h2>
                 <!--  <p class="sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="doctor-slider slider">
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



                              <!-- <a href="javascript:void(0)" class="fav-btn">
                              <i class="far fa-bookmark"></i>
                              </a> -->
                           </div>
                           <div class="pro-content">
                              <h3 class="title">
                                 <a href="#"><?=$key->name?></a> 
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

                          <?php endforeach ?>

                        
                        <!-- /astrologer Widget -->
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <?php endif ?>
         <section class="download-section " style="background-color: #FFD00D;">
            <div class="container">
               <div class="row">
                  <div class="col-md-5 hidden-sm hidden-xs">
                     <div class="download-app-img">
                        <img src="<?php echo base_url();?>assets/img/download-app.png" alt="app download" class="img-responsive">
                     </div>
                  </div>
                  <div class="col-md-7 col-sm-12">
                     <div class="download-app-text">
                        <h3>Get The App Now !</h3>
                        <p>You can download our Astrohelp app from the google play store and App Store.</p>
                        <div class="download-app-button">
                           <div class="play">
                             <a href=""><img src="<?php echo base_url();?>assets/img/android.png" style="width: 30%; padding-right: 10px;"></a>
      <a href=""><img src="<?php echo base_url();?>assets/img/ios.png" style="width: 30%; float: left; padding-right: 10px;"></a>
                             
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- Blog Section -->



             <section class="section section-doctor">
                  <div class="container">
            <div class="section-header text-center">
                  <h2>Latest Blogs</h2>
               
                        </div>
                    <div class="row">
                 <div class="col-lg-12">
             <div class="doctor-slider slider">

                 <?php
            if (!empty($blog)) 
            {
              
               foreach ($blog as $blog_key) {
                  ?>
                  
                  <!-- astrologer Widget -->
                 <div class="profile-widget">
                     <div class="doc-img">
                            <a href="<?php echo base_url();?>home/blog_details/<?php echo $blog_key->id; ?>"><img class="img-fluid" src="<?php echo BASE_URL_IMAGE."blog/".$blog_key->image;?>" alt="Post Image"></a>
                           </div>
                  <div class="pro-content">
                    
            <ul class="entry-meta meta-item auth">
                            <li>
               <?php

                             $author_nameid =  $blog_key->author_name;
                             $ss = $this->db->query("select * from astrologers where id =$author_nameid ")->row();
                             if ($ss) 
                             {

                               $deturl = base_url('home/astrologer_profile').'/'.$ss->id;

                              ?>
                                 <div class="post-author">

                                 


                                           <a href="<?=$deturl?>"><img src="<?= BASE_URL_IMAGE.'astrologers/'.$ss->image ?>" alt="Post Author"> <span><?php echo $ss->name ; ?></span></a>
                                 </div>
                              <?php
                              // echo $ss->name;
                             }
                             ?>
                           </li>
         <li><i class="far fa-clock"></i> <?=date('d M Y', strtotime($blog_key->show_date))?></li>
                           </ul>  
     <h3 class="blog-title"><a href="<?php echo base_url();?>home/blog_details/<?php echo $blog_key->id; ?>">

                            <?php echo $blog_key->title; ?>
                         

                           </a></h3>
     <p class="mb-0"><?php echo preg_replace('/\s+?(\S+)?$/', '', substr($blog_key->desc, 0, 200)).".."; ?></p>       
                           </div>
                           </div>
                  <!-- /astrologer Widget -->

               <?php
            
            }
            }
            ?>

                  <!-- astrologer Widget -->
               
                  <!-- /astrologer Widget -->
                     </div>
                    </div>
                    </div>
                    </div>
                  </section>
 <!--  <a href="<?php echo base_url();?>home/blog"class="btn btn-primary"><span>View more Blogs</span></a> -->

      
         <!-- /Blog Section -->        
