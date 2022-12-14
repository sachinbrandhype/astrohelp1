<?php
$user_id = $this->session->userdata('user_id');
$wallet = 0;
$loginflag = 0;
$get_user = $user_data;

?>
<style>
	.view-btn {
		font-size: 14px;
		padding: 8px;
	}
</style>
<!-- Breadcrumb -->
<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-md-12 col-12">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
						<li class="breadcrumb-item"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Astrologer Lists</a></li>
						
						<li class="breadcrumb-item active" aria-current="page">Astrologer Profile</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- /Breadcrumb -->

<!-- Page Content -->
<div class="content">
	<div class="container">
		<?php if ($astrologer_details) : ?>
			<!-- Astrologer Widget -->

			<?php
			$booking_status = '';
			$specialty = '';
			$astrid = $astrologer_details->id;
			$get_specialty = $astrologer_details->expertiesData;
			if (count($get_specialty)) {
				$a = array();
				foreach ($get_specialty as $keys) {
					// $get_name = $this->db->get_where("master_specialization", array("id" => $keys->speciality_id))->row();
					// if ($get_name) {

					if ($keys->type == 1) {
						array_push($a, ucfirst($keys->name));
					}
					// $skills[] = array("skill_id"=>$keys->speciality_id,
					// "skill_name"=>$get_name->name);
					// }
				}

				if (!empty($a)) {
					$specialty = implode(', ', $a);
				}
			}


			?>
			<!-- Astrologer Widget -->
			<div class="card">
				<div class="card-body">
					<div class="doctor-widget">
						<div class="doc-info-left">
							<div class="doctor-img">
								<img src="<?= $astrologer_details->imageUrl ?>" class="img-fluid" style="border-radius: 50%;" alt="User Image">

								<?php
								if ($astrologer_details->online_status == 1) {
								?>
									<p class="avi" style="margin: 10px 0px 0px 25px; color: green;">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Online</p>
								<?php
								}
								if ($astrologer_details->online_status == 2) {
								?>
									<p class="avi" style="margin: 10px 0px 0px 25px; color: red;">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Busy <br>
										<span class="wait-time">Wait time ~ <?php echo $astrologer_details->wait_time; ?>min</span>
									</p>
								<?php
								}
								if (empty($astrologer_details->online_status)) {

								?>
									<p class="avi" style="margin: 10px 0px 0px 25px; color: red;">&nbsp;<i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Offline</p>

								<?php
								}
								?>

							</div>

							<div class="doc-info-cont">
								<h4 class="doc-name"><?= $astrologer_details->name ?></h4>
								<p class="doc-speciality"><?= $specialty ?></p>


								<?php
								$sss = $this->db->query("select AVG(rate) as avg_rating from reviews where type_id = $astrid")->row();

								$r = $sss->avg_rating + 0;
								if ($r >= 5) {
								?>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<span class="d-inline-block average-rating">(<?php echo round($r, 1); ?>)</span>
									</div>
								<?php
								} elseif ($r >= 4) {
								?>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star "></i>
										<span class="d-inline-block average-rating">(<?php echo round($r, 1); ?>)</span>
									</div>
								<?php
								} elseif ($r >= 3) {
								?>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star "></i>
										<i class="fas fa-star "></i>
										<span class="d-inline-block average-rating">(<?php echo round($r, 1); ?>)</span>
									</div>
								<?php
								} elseif ($r >= 2) {
								?>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star "></i>
										<i class="fas fa-star "></i>
										<i class="fas fa-star "></i>
										<span class="d-inline-block average-rating">(<?php echo round($r, 1); ?>)</span>
									</div>
								<?php
								} elseif ($r >= 1) {
								?>
									<div class="rating">
										<i class="fas fa-star filled"></i>
										<i class="fas fa-star "></i>
										<i class="fas fa-star "></i>
										<i class="fas fa-star "></i>
										<i class="fas fa-star "></i>
										<span class="d-inline-block average-rating">(<?php echo round($r, 1); ?>)</span>
									</div>
								<?php
								} elseif (empty($r)) {
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


								<div class="clinic-details">
									<p class="doc-location"><i class="fas fa-graduation-cap"></i> Exp: <?= $astrologer_details->experience ?> years</p>
									<p class="doc-location"><i class="fas fa-globe"></i> <?= $astrologer_details->languages ?></p>
									<?php
									$avgprice = 100;
									$audio_status = '';
									$chat_status = '';
									$video_status = '';
									$video_price = $astrologer_details->price_per_mint_chat;
									$audio_price = $astrologer_details->price_per_mint_audio;
									$chat_price = $astrologer_details->price_per_mint_chat;

									if ($astrologer_details->discount_on) {
										$timed = time();
										if ($timed >= strtotime($astrologer_details->discount_start) && $timed <= strtotime($astrologer_details->discount_end)) {
											$discount_on_arr = explode('|', $astrologer_details->discount_on);
											$discount_pct = floatval($astrologer_details->discount);
											if ($discount_pct) {
												if (in_array('audio', $discount_on_arr)) {
													$audio_price = $audio_price * ($discount_pct / 100);
												}

												if (in_array('chat', $discount_on_arr)) {
													$chat_price = $chat_price * ($discount_pct / 100);
												}

												if (in_array('video', $discount_on_arr)) {
													$video_price = $video_price * ($discount_pct / 100);
												}
											}
										}
									}

									?>
									<p class="doc-location"><i class="far fa-money-bill-alt"></i> ₹<?= $chat_price ?>/Min</p>
								</div>
							</div>
						</div>
						<?php
									$online_consult = intval($astrologer_details->online_consult);
									?>
						<div class="doc-info-right">
							<?php if($astrologer_details->online_status == 1): ?>

							<div class="doctor-action">
								<?php if ($user_id) : ?>
									<?php $walletblc = isset($user_data->wallet) ? $user_data->wallet : 0; ?>


									&nbsp; &nbsp;
								
									<?php if ($online_consult == 1 || $online_consult == 4 || $online_consult == 5 || $online_consult == 6) :  ?>
										<?php $chat_condtion = $walletblc >= $chat_price * 4;  ?>
										<?php if ($chat_condtion) : ?>
                                            
											<a style="color:red" href="#" onclick="return chat_request('<?= $astrologer_details->id ?>','<?= $this->session->userdata('user_id') ?>','<?= $chat_price ?>')" class="btn view-btn">
												<i class="fas fa-comment-alt"></i> ₹<?= $chat_price ?>/Min
											</a>
                                            
										<?php else : ?>
											<?php $remaining_recharge = ($chat_price*4) - $walletblc; ?>
											<a href="<?= base_url('home/recharge_wallet') ?>?remaining_recharge=<?=$remaining_recharge?>" class="btn view-btn">
												<i class="fas fa-comment-alt"></i> ₹<?= $chat_price ?>/Min
											</a>
										<?php endif; ?>
									<?php endif; ?>

									<?php if ($online_consult == 3 || $online_consult == 4 || $online_consult == 6 || $online_consult == 7) :  ?>
										<?php $audio_condition = $walletblc >= $chat_price * 4;  ?>
										<?php if ($audio_condition) : ?>
											<a href="#" onclick="return audio_request('<?= $astrologer_details->id ?>','<?= $this->session->userdata('user_id') ?>','<?= $audio_price ?>')" class="btn view-btn">
												<i class="fas fa-phone"></i> ₹<?= $audio_price ?>/Min
											</a>
										<?php else : ?>
											<?php $remaining_recharge = ($audio_price*4) - $walletblc; ?>

											<a href="<?= base_url('home/recharge_wallet') ?>?remaining_recharge=<?=$remaining_recharge?>" class="btn view-btn">
												<i class="fas fa-phone"></i> ₹<?= $chat_price ?>/Min
											</a>
										<?php endif; ?>

									<?php endif; ?>

									<?php if ($online_consult == 2 || $online_consult == 4 || $online_consult == 5 || $online_consult == 7) :  ?>
										<a href="#" class="btn view-btn" data-toggle="modal" data-target="#download-popup">
											<i class="fas fa-video"></i> ₹<?= $video_price ?>/Min
										</a>
									<?php endif; ?>

								<?php else : ?>
									<?php if ($online_consult == 1 || $online_consult == 4 || $online_consult == 5 || $online_consult == 6) :  ?>
										<a href="<?= base_url('home/login') ?>" class="btn view-btn">
											<i class="fas fa-comment-alt"></i> ₹<?= $chat_price ?>/Min
										</a>
									<?php endif; ?>

									<?php if ($online_consult == 3 || $online_consult == 4 || $online_consult == 6 || $online_consult == 7) :  ?>
										<a href="<?= base_url('home/login') ?>" class="btn view-btn">
											<i class="fas fa-phone"></i> ₹<?= $audio_price ?>/Min
										</a>
									<?php endif; ?>

									<?php if ($online_consult == 2 || $online_consult == 4 || $online_consult == 5 || $online_consult == 7) :  ?>
										<a href="#" class="btn view-btn" data-toggle="modal" data-target="#download-popup">
											<i class="fas fa-video"></i> ₹<?= $video_price ?>/Min
										</a>
									<?php endif; ?>
								<?php endif; ?>


							</div>
							<?php endif; ?>
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

							<li class="nav-item">
								<a class="nav-link" href="#doc_reviews" data-toggle="tab">Reviews</a>
							</li>

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



									<!-- About Details -->
									<div class="widget about-widget">
										<h4 class="widget-title">Expertise</h4>
										<div class="tags">


											<?php
											$a_id = $astrologer_details->id;
											// $qq = $this->db->query("select * from skills where user_id = $a_id AND status = 1")->result();
											// echo $this->db->last_query();
											if ($get_specialty) : ?>
												<?php
												foreach ($get_specialty as $skill_key) {


												?>
													<a href="#"><?= ucfirst($skill_key->name) ?></a>
												<?php


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

									<?php
									function star_function($integer)
									{
										$integer = intval($integer);

										$star1 = '<span class="fa fa-star">';
										$star2 = '<span class="fa fa-star">';
										$star3 = '<span class="fa fa-star">';
										$star4 = '<span class="fa fa-star">';
										$star5 = '<span class="fa fa-star">';
										if ($integer >= 1) {
											$star1 = '<span class="fa fa-star checked">';
										}
										if ($integer >= 2) {
											$star2 = '<span class="fa fa-star checked">';
										}
										if ($integer >= 3) {
											$star3 = '<span class="fa fa-star checked">';
										}
										if ($integer >= 4) {
											$star4 = '<span class="fa fa-star checked">';
										}
										if ($integer >= 5) {
											$star5 = '<span class="fa fa-star checked">';
										}


										echo $star1 . $star2 . $star3 . $star4 . $star5;
									}
									?>

									<?php
									$a_id = $astrologer_details->id;
									$reviews = $astrologer_details->reviews;
									if ($reviews) {
										foreach ($reviews as $reviews_key => $value) {

											$usr = $value->user;

									?>
											<li>
												<div class="comment">
													<img class="avatar avatar-sm rounded-circle" alt="User Image" src="<?= $usr->imageUrl ?>">
													<div class="comment-body">
														<div class="meta-data">
															<span class="comment-author"><?= $usr->name ?></span>
															<span class="comment-date"><?= date('d M Y g:ia', strtotime($value->created_at)) ?></span>




														</div>
														<?php
														if ($value->rate == 1) {
														?>
															<div class="review-count rating">
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star "></i>
																<i class="fas fa-star "></i>
																<i class="fas fa-star "></i>
																<i class="fas fa-star "></i>
															</div>
														<?php
														} elseif ($value->rate == 2) {
														?>
															<div class="review-count rating">
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star "></i>
																<i class="fas fa-star "></i>
																<i class="fas fa-star "></i>
															</div>
														<?php
														} elseif ($value->rate == 3) {
														?>
															<div class="review-count rating">
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star "></i>
																<i class="fas fa-star "></i>
															</div>
														<?php
														} elseif ($value->rate == 4) {
														?>
															<div class="review-count rating">
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star "></i>
															</div>
														<?php
														} elseif ($value->rate == 5) {
														?>
															<div class="review-count rating">
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
																<i class="fas fa-star filled"></i>
															</div>

														<?php
														}


														?>



														<p class="comment-content">
															<?= $value->message ?>
														</p>
													</div>
												</div>

											</li>
									<?php
										}
									} else {
										echo "No Review";
									}

									?>
									<!-- Comment List -->

									<!-- /Comment List -->

									<!-- Comment List -->

									<!-- /Comment List -->

								</ul>

								<!-- Show All -->

								<!-- /Show All -->

							</div>
							<!-- /Review Listing -->


						</div>
						<!-- /Reviews Content -->

					</div>
				</div>
			</div>
			<!-- /astrologer Details Tab -->
		<?php else : ?>
			No Astrologer found!;
		<?php endif ?>
	</div>
</div>
<!-- /Page Content -->

<?php //die; 
?>

<!-- /Page Content -->