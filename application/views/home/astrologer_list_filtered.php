<div class="breadcrumb-bar">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-md-8 col-12">
            <nav aria-label="breadcrumb" class="page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Astrologer list</li>
               </ol>
            </nav>
            <h2 class="breadcrumb-title">Astrologer List</h2>
         </div>
         <div class="col-md-4 col-12 d-md-block d-none">
            <div class="sort-by">
               <form method="post" action="<?=base_url('sdauth/filter_astrologers')?>">
               <span class="sort-title">Sort by</span>
               <span class="sortby-fliter">
                  <select name="sorting" class="select">
                     <option>Select</option>
                     <option value="rating" class="sorting">Rating</option>
                     <option value="experience" class="sorting">Experience</option>
                     <option value="price" class="sorting">Price</option>
                  </select>
                  <!-- <i class="fas fa-search"></i> -->

               </span>
               
            </div>
            
         </div>
      </div>
   </div>
</div>
<!-- /Breadcrumb -->
<!-- Page Content -->
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">
            <div class="card search-filter">
               <div class="card-body">
                  <div class="filter-widget">
                     <label for="">Search</label>
                     <input type="text" name="search_keyword" value="" class="form-control" placeholder="Search Keyword" id="search_keyword">
                  </div>
               </div>
            </div>
            <!-- Search Filter -->
            <div class="card search-filter">
               <div class="card-header">
                  <h4 class="card-title mb-0">Filter</h4>
               </div>
               <?php $top_expertise = $this->db->query("SELECT * FROM `master_specialization` WHERE `status` = '1' AND `in_home` = '1' ORDER BY `position` ASC")->result(); ?>
                     
               <div class="card-body">
                  <?php if ($top_expertise): ?>
                  	<div class="filter-widget">
	                  	<h4>Select Expertise</h4>
	                    <?php foreach ($top_expertise as $keyexp): ?>
	                    <div>
	                        <label class="custom_check">
	                        <input type="checkbox" name="expertiseastro[]" value="<?=$keyexp->id?>" id="experstise_astro">
	                        <span class="checkmark"></span><?=$keyexp->name?>
	                        </label>
	                    </div>
	                    <?php endforeach ?>
	                  </div>
	                  		
                  <?php endif ?>
                  <?php $top_language = $this->db->query("SELECT * FROM `language_categories` ORDER BY `language_name` ASC")->result(); ?>
                  <?php if ($top_language): ?>
                  	<div class="filter-widget">
                     <h4>Select Languages</h4>
                     <?php foreach ($top_language as $keylang): ?>
                     <div>
                        <label class="custom_check">
                        <input type="checkbox" name="language[]" value="<?=$keylang->language_name?>" id="language_astro">
                        <span class="checkmark"></span><?=ucfirst($keylang->language_name) ?>
                        </label>
                     </div>	
                     <?php endforeach ?>
                  </div>	
                  <?php endif ?>
                  
                  <div class="filter-widget">
                     <h4>Select Rating</h4>
                     <div>
                        <label class="custom_check">
                        <input type="checkbox" name="rating[]" value="all" id="rating">
                        <span class="checkmark"></span>All Rating
                        </label>
                     </div>
                     <div>
                        <label class="custom_check">
                        <input type="checkbox" name="rating[]" value="3" id="rating3">
                        <span class="checkmark"></span>3 Star & above
                        </label>
                     </div>
                     <div>
                        <label class="custom_check">
                        <input type="checkbox" name="rating[]" value="4" id="rating4">
                        <span class="checkmark"></span>4 Star & above
                        </label>
                     </div>
                  </div>
                  <div class="btn-search">
                     <input type="submit" value="Search" class="btn btn-block">
                  </div>
                  <div class="btn-search">
                     <a href="<?=base_url('sdauth/filter_astrologers')?>"><button type="button" value="Re" class="btn btn-block">Reset Filter</button></a>
                  </div>
               </div>
            </div>
            </form>
            <!-- /Search Filter -->
         </div>
    

          <div class="col-md-12 col-lg-8 col-xl-9">
            <div class="row">


              <?php if (!empty($astro)): ?>
                 <?php foreach ($astro as $key): 
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
                    $chat_price = $key->price_per_mint_chat;
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

                ?>




                   <div class="col-md-4 astro-list">
                        <!-- start -->
                       <div class="card1">
                  <div class="card-header1">
                     <div class="media">
                  <div class="media-left">

                    <a href="<?=base_url('home/astrologer_profile/'.$key->id)?>">
                           
   <img src="<?= BASE_URL_IMAGE.'astrologers/'.$key->image ?>"  class="media-object astro-img" style="border-radius: 50%;">

                          </a>


                         </div>

                  <div class="media-body">
   <a href="<?=base_url('home/astrologer_profile/'.$key->id)?>"> <h4 class="media-heading astro-name"><?=$key->name?></h4></a>
  <p class="astro-rating">

    <?php 
  $sss = $this->db->query("select AVG(rate) as avg_rating from reviews where type_id = $key->id")->row();
  
  $r = $sss->avg_rating+ 0;
    if ($r >= 5) {
      ?>
      <div class="rating">
        <i class="fas fa-star filled"></i>
        <i class="fas fa-star filled"></i>
        <i class="fas fa-star filled"></i>
        <i class="fas fa-star filled"></i>
        <i class="fas fa-star filled"></i>
        <span class="d-inline-block average-rating">(<?php echo $r; ?>)</span>
      </div>
      <?php
    }
  
    elseif ($r >= 4) 
    {
    ?>
    <div class="rating">
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star "></i>
      <span class="d-inline-block average-rating">(<?php echo $r; ?>)</span>
    </div>
    <?php
    }
    elseif ($r >= 3) 
    {
    ?>
    <div class="rating">
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <span class="d-inline-block average-rating">(<?php echo $r; ?>)</span>
    </div>
    <?php
    }
    elseif ($r >= 2) 
    {
    ?>
    <div class="rating">
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <span class="d-inline-block average-rating">(<?php echo $r; ?>)</span>
    </div>
    <?php
    }
    elseif ($r >= 1) 
    {
    ?>
    <div class="rating">
      <i class="fas fa-star filled"></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <span class="d-inline-block average-rating">(<?php echo $r; ?>)</span>
    </div>
    <?php
    }
    elseif (empty($r)) 
    {
    ?>
    <div class="rating">
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <i class="fas fa-star "></i>
      <span class="d-inline-block average-rating">(<?php echo "0"; ?>)</span>
    </div>
    <?php
    }
?>
    
 </p>
  <!--  <p class="online-a">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Online</p> -->
                           </div>
                           </div>
                           </div>
                   <div class="card-body1">
                      <div class="row">
                   <div class="col-md-7">
                   <ul class="astro-info">
      <li><i class="fa fa-graduation-cap" aria-hidden="true"></i>&nbsp;&nbsp;<?=$key->experience?> Years</li>
      <li><i class="fa fa-language" aria-hidden="true"></i>&nbsp;&nbsp;<?=$key->languages?></li>
      <li><i class="fas fa-shield-alt"></i>&nbsp;&nbsp;<?=$specialty?></li>
      <li><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?=$avgprice?>/Min</li>
                         </ul>
                         </div>
               <div class="col-md-5 text-right">

              

   <a href="<?=base_url('home/astrologer_profile/'.$key->id)?>"><img src="<?=base_url("assets/img/chat-icon.png")?>" class="img-width"></a>
   <a href="#" data-toggle="modal" data-target="#download-popup"><img src="<?=base_url("assets/img/call-icon.png")?>" class="img-width"></a>  
                         </div>
                          </div>
                          </div>
         <!--  <div class="card-footer">
   <button class="btn btn-md btn-primary-1">Chat</button>
   <button class="btn btn-md btn-primary-1">Call</button>
                        </div> -->
                        </div>
                     <!--end-->
                      </div>


  <?php endforeach ?>
                <?php else: ?>
                  No astrologer found!
               <?php endif ?>




                    </div>
                  </div>



      </div>
   </div>
</div>
