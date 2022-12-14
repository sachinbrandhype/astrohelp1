<!-- Breadcrumb -->
<?php $loginflag = 0;$wallet=0; if (isset($_SESSION['user_id'])): ?>
	<?php if ($_SESSION['user_id'] > 0): 
		$loginflag=1; 
		$get_user = $this->db->get_where("user",array("id"=>$_SESSION['user_id']))->row();
    	if ($get_user) 
    	{
    		$wallet=$get_user->wallet;
    	}
	?>
		
	<?php endif ?>
<?php endif ?>
<div class="breadcrumb-bar">
   <div class="container-fluid">
      <div class="row align-items-center">
         <div class="col-md-12 col-12">
            <nav aria-label="breadcrumb" class="page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Astrologer Profile</li>
               </ol>
            </nav>
            <h2 class="breadcrumb-title">Astrologer Profile</h2>
         </div>
      </div>
   </div>
</div>
<!-- /Breadcrumb -->
<!-- Page Content -->
<div class="content">
   <div class="container">
      <?php if ($astrologer_details): ?>
      	<!-- Astrologer Widget -->

      <?php 
      	$booking_status = '';
      	$specialty = '';
    	$astrid = $astrologer_details->id;
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
      <div class="card">
         <div class="card-body">
            <div class="doctor-widget">
               <div class="doc-info-left">
                  <div class="doctor-img">
                     <img src="<?= BASE_URL_IMAGE.'astrologers/'.$astrologer_details->image ?>" class="img-fluid" alt="User Image">
                     <div class="intro-banner-vdo-play-btn1 pinkBg1">
                        <i class="glyphicon glyphicon-play whiteText" aria-hidden="true"></i>
                        <span class="ripple pinkBg1"></span>
                        <span class="ripple pinkBg1"></span>
                        <span class="ripple pinkBg1"></span>
                     </div>
                     <p class="avi" id="booking_status"></p>
                  </div>
                  <div class="doc-info-cont">
                     <h4 class="doc-name"><?=$astrologer_details->name?></h4>
                     <p class="doc-speciality"><?=$specialty?></p>
                     <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <i class="fas fa-star filled"></i>
                        <span class="d-inline-block average-rating">(5.0)</span>
                     </div>
                     <div class="clinic-details">
                        <p class="doc-location"><i class="fas fa-graduation-cap"></i> Exp: <?=$astrologer_details->experience?> years</p>
                        <p class="doc-location"><i class="fas fa-globe"></i> <?=$astrologer_details->languages?></p>
                        <?php 
                            $avgprice = 100;
							if ($astrologer_details->price_per_mint_chat > 0) {
								$avgprice = $astrologer_details->price_per_mint_chat;
							}

							// phone
							$audio_status = '';
							$audio_price = '';
							if ($astrologer_details->audio_status == 1) 
							{
								$audio_status = 1;
								$audio_price = $astrologer_details->price_per_mint_audio;
							}

							$chat_status = '';
							$chat_price = '';
							if ($astrologer_details->chat_status == 1) 
							{
								$chat_status = 1;
								$chat_price = $astrologer_details->price_per_mint_audio;
							}

							$video_status = '';
							$video_price = '';
							if ($astrologer_details->video_status == 1) 
							{
								$video_status = 1;
								$video_price = $astrologer_details->price_per_mint_video;
							}

                        ?>
                        <p class="doc-location"><i class="far fa-money-bill-alt"></i> ₹<?=$avgprice?>/Min</p>
                     </div>
                  </div>
               </div>
               <div class="doc-info-right">
                  <div class="doctor-action">
                     <!-- <a href="javascript:void(0)" class="btn btn-white fav-btn">
                     <i class="far fa-bookmark"></i>
                     </a> -->
                     <?php if ($loginflag == 1): ?>
                     	<span id="chatbuttone"></span>
                     	
                     <?php else: ?>
                     		<button onClick='showAlertlogin(this.value)' value="You have to login!" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>
                     <?php endif ?>
                     <!-- <a href="javascript:void(0)" class="btn view-btn voi_cal" data-toggle="modal" data-target="#voice_call">
                     <i class="fas fa-phone"></i> ₹20/Min
                     </a>
                     <a href="javascript:void(0)" class="btn view-btn vid_cha" data-toggle="modal" data-target="#download-popup">
                     <i class="fas fa-video"></i> ₹80/Min
                     </a> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- /astrologer Widget -->
      <!-- astrologer Details Tab -->
      <div class="card">
         <div class="card-body pt-0">
            <!-- Tab Menu -->
            <nav class="user-tabs mb-4">
               <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                  <li class="nav-item">
                     <a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
                  </li>
                  <!-- <li class="nav-item">
                     <a class="nav-link" href="#doc_reviews" data-toggle="tab">Reviews</a>
                  </li> -->
               </ul>
            </nav>
            <!-- /Tab Menu -->
            <!-- Tab Content -->
            <div class="tab-content pt-0">
               <!-- Overview Content -->
               <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                  <div class="row">
                     <div class="col-md-12 col-lg-12">
                        <!-- About Details -->
                        <div class="widget about-widget">
                           <h4 class="widget-title">About Me</h4>
                           <p><?= $astrologer_details->bio ?></p>
                        </div>
                        <!-- /About Details -->
                        <!-- About Details -->
                        <div class="widget about-widget">
                           <h4 class="widget-title">Expertise</h4>
                           <div class="tags">
                           	  <?php if ($astrologer_details->expertise): ?>
                           	  	<?php 
                           	  		$a = explode(',', $astrologer_details->expertise);
                           	  		if (count($a) > 0) 
                           	  		{
                           	  			for ($i=0; $i < count($a); $i++) { 
                           	  				
                           	  			?>
                           	  				<a href="#"><?= ucfirst($a[$i])?></a>
                           	  			<?php
                           	  			}
                           	  		}
                           	  	?>
                           	  <?php endif ?>
                           </div>
                        </div>
                        <!-- /About Details -->
                     </div>
                  </div>
               </div>
               <!-- /Overview Content -->
               <!-- Reviews Content -->
               <div role="tabpanel" id="doc_reviews" class="tab-pane fade">
                  <!-- Review Listing -->
                  <div class="widget review-listing">
                     <ul class="comments-list">
                        <!-- Comment List -->
                        <li>
                           <div class="comment">
                              <img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?php echo base_url();?>assets/img/patients/patient.jpg">
                              <div class="comment-body">
                                 <div class="meta-data">
                                    <span class="comment-author">Richard Wilson</span>
                                    <span class="comment-date">Reviewed 2 Days ago</span>
                                    <div class="review-count rating">
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star"></i>
                                    </div>
                                 </div>
                                 <p class="comment-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut enim ad minim veniam, quis nostrud exercitation.
                                    Curabitur non nulla sit amet nisl tempus
                                 </p>
                              </div>
                           </div>
                        </li>
                        <!-- /Comment List -->
                        <!-- Comment List -->
                        <li>
                           <div class="comment">
                              <img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?php echo base_url();?>assets/img/patients/patient2.jpg">
                              <div class="comment-body">
                                 <div class="meta-data">
                                    <span class="comment-author">Travis Trimble</span>
                                    <span class="comment-date">Reviewed 4 Days ago</span>
                                    <div class="review-count rating">
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star filled"></i>
                                       <i class="fas fa-star"></i>
                                    </div>
                                 </div>
                                 <p class="comment-content">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Ut enim ad minim veniam, quis nostrud exercitation.
                                    Curabitur non nulla sit amet nisl tempus
                                 </p>
                              </div>
                           </div>
                        </li>
                        <!-- /Comment List -->
                     </ul>
                     <!-- Show All -->
                     <div class="all-feedback text-center">
                        <a href="#" class="btn btn-primary btn-sm">
                        Show all feedback <strong>(167)</strong>
                        </a>
                     </div>
                     <!-- /Show All -->
                  </div>
                  <!-- /Review Listing -->
               </div>
               <!-- /Reviews Content -->
            </div>
         </div>
      </div>
      <!-- /astrologer Details Tab -->
      <?php else: ?>
      	No Astrologer found!;
      <?php endif ?>
   </div>
</div>

<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>

<script>
function showAlertlogin(val) {
              $('#myModalcancel').modal('show');
              var msg = 'You have to login first!';
              $("#ermsgcancel").html(val);
              var c_id = '<input type="hidden" name="mixid" value="'+val+'">';
              $("#cancelbookingid").html(c_id);
          }

$(document).ready(function(){
	var apiurl = "<?=base_url('sdauth/GetAstrologeravail')?>";
	var astroid = "<?=$astrologer_details->id ?>";
  	$.ajax({
          url: apiurl,
          type: "POST",
          data: 'id='+astroid,
          success: function (data) {
          	var final_v = '';
          	var chat_button = '';
          	var wallet = parseInt('<?=$wallet?>');
          	var chatprice_astro = parseInt('<?=$chat_price?>');
          	if (data == 1) 
          	{
          		chat_button = '<button onClick="showAlertlogin(this.value)" value="Astrologer is busy kindly check after some time!" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>';
          		final_v = '<span style="color:orange;">Busy</span>';
          	}
          	else if (data == 2) 
          	{
          		chat_button = '<button onClick="showAlertlogin(this.value)" value="Wallet amount is not sufficient to make this consultation kindly add amount into wallet!" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>';
          		if (wallet > chatprice_astro) 
          		{
          			chat_button = '<a href="<?php echo base_url();?>sdauth/sendrequest/<?=$astrologer_details->id?>/'+chatprice_astro+'/3" class="btn view-btn cha_cha">'+'<i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</a>';
          		}
          		final_v = '<span style="color:green;">Available</span>';
          	}
          	else
          	{
          		chat_button = '<button onClick="showAlertlogin(this.value)" value="Astrologer not available kindly check after some time" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>';
          		final_v = '<span style="color:red;">Not Available</span>';
          	}
          	$("#booking_status").html(final_v);
          	$("#chatbuttone").html(chat_button);
          },
        });
 });	 

function astrologer_avail()
{
	var apiurl = "<?=base_url('sdauth/GetAstrologeravail')?>";
	var astroid = "<?=$astrologer_details->id ?>";
  	$.ajax({
          url: apiurl,
          type: "POST",
          data: 'id='+astroid,
          success: function (data) {
          	var chat_button = '';
          	var final_v = '';
          	var wallet = parseInt('<?=$wallet?>');
          	var chatprice_astro = parseInt('<?=$chat_price?>');
          	if (data == 1) 
          	{
          		chat_button = '<button onClick="showAlertlogin(this.value)" value="Astrologer is busy kindly check after some time!" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>';
          		final_v = '<span style="color:orange;">Busy</span>';
          	}
          	else if (data == 2) 
          	{
          		chat_button = '<button onClick="showAlertlogin(this.value)" value="Wallet amount is not sufficient to make this consultation kindly add amount into wallet!" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>';
          		if (wallet > chatprice_astro) 
          		{
          			chat_button = '<a href="<?php echo base_url();?>home/chat" class="btn view-btn cha_cha">'+'<i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</a>';
          		}
          		final_v = '<span style="color:green;">Available</span>';
          	}
          	else
          	{
          		chat_button = '<button onClick="showAlertlogin(this.value)" value="Astrologer not available kindly check after some time" class="btn view-btn cha_cha"><i class="far fa-comment-alt"></i> ₹<?=$chat_price?>/Min</button>';
          		final_v = '<span style="color:red;">Not Available</span>';
          	}
          	$("#booking_status").html(final_v);
          	$("#chatbuttone").html(chat_button);
          },
        });
}
setInterval('astrologer_avail()', 10000);
</script>
<!-- /Page Content -->