
         <!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
			<div class="container-fluid">
		<div class="row align-items-center">
		   <div class="col-md-12 col-12">
<nav aria-label="breadcrumb" class="page-breadcrumb">
				<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Blog</li>
						</ol>
						</nav>
		<h2 class="breadcrumb-title">Blog Details</h2>
						</div>
					    </div>
				       </div>
			          </div>
			<!-- /Breadcrumb -->
			
			<!-- Page Content -->
			<div class="content">
			<div class="container">
				
			 <div class="row">
	<div class="col-lg-12 col-md-12">
		 <div class="blog-view">
	<div class="blog blog-single-post">
			<div class="blog-image">
<a href="javascript:void(0);"><img alt="" src="<?php echo BASE_URL_IMAGE."blog/".$blog->image;?>" class="img-fluid"></a>
				  </div>

<h3 class="blog-title"><?php echo $blog->title; ?></h3>
		<div class="blog-info clearfix">
			<div class="post-left">
					<ul>
					 <li>
			 <?php

                             $author_nameid =  $blog->author_name;
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

  <li><i class="far fa-calendar"></i> <?=date('d M Y', strtotime($blog->show_date))?> </li>
				</ul>
				</div>
				</div>

		<div class="blog-content">
<?php echo $blog->desc  ; ?>

<?php
      $web_data = $this->db->query("select google_play_app_link,ios_app_link,facebook_link,youtube_link,instagram_link,twitter_link,linkedin_link,address,support_email,helpline_number from settings where id = 1")->row();
      
      ?>

    <div class="social-icon social-face">
                           <ul>
                          <li>
                 
                        <a href="https://api.whatsapp.com/send?text=<?php echo base_url();?>home/blog_details/<?php echo $blog->id; ?>" data-action="share/whatsapp/share" target="_blank"><i class="fab fa-whatsapp"></i></a>

                                      
                                    </li>
                                    <!-- <li>

              <a class="btn-floating btn btn-tw" type="button" role="button" title="Share on facebook"
   href="https://www.facebook.com/sharer/sharer.php?u=<?php echo base_url();?>home/blog_details/<?php echo $blog->id; ?>" target="_blank"
   rel="noopener">
  <i class="fab fa-facebook-square"></i>
</a>



                                     
                                    </li> -->
                                    <li>

                                    	<a href = "https://telegram.me/share/url?url=<?php echo base_url();?>home/blog_details/<?php echo $blog->id; ?>&text=Astrohelp24" target="_blank"><i class="fab fa-telegram"></i></a>


                                       
                                    </li>
                                    <li>
                                    	<a class="btn-floating btn btn-tw" type="button" role="button" title="Share on twitter"
   href="https://twitter.com/intent/tweet?url=<?php echo base_url();?>home/blog_details/<?php echo $blog->id; ?>"
   rel="noopener" target="_blank">
  <i class="fab fa-twitter"></i>
</a>

                                    </li>
                                    
                           </ul>
                          </div>

					  </div>



					  </div>		



					     <section class="section section-doctor">
                  <div class="container">
            <div class="section-header text-center">
                  <h2>Related Blogs</h2>
               
                        </div>
                    <div class="row">
                 <div class="col-lg-12">
             <div class="doctor-slider slider">

                 <?php
            if (!empty($blog_data)) 
            {
              
               foreach ($blog_data as $blog_key) {
                  ?>

                   <div class="profile-widget blog-pro">
                     <div class="doc-img">
                         <a href="<?php echo base_url();?>home/blog_details/<?php echo $blog_key->id; ?>">
   <img class="img-fluid" alt="User Image" src="<?php echo BASE_URL_IMAGE."blog/".$blog_key->image;?>">
                           </a>
                           </div>
            <div class="pro-content blog-cont">
                    
      <h3 class="blog-title"><a href="<?php echo base_url();?>home/blog_details/<?php echo $blog_key->id; ?>"><?php echo $blog_key->title; ?></a></h3>           
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
								
					   </div>
					   </div>		
                   </div>
				   </div>

			       </div>		
			<!-- /Page Content -->
   
		 