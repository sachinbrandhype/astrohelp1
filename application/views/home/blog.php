
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
			<div class="container-fluid">
		<div class="row align-items-center">
		   <div class="col-md-12 col-12">
  <nav aria-label="breadcrumb" class="page-breadcrumb">
				<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
<li class="breadcrumb-item active" aria-current="page">Blogs</li>
					   </ol>
					  </nav>
			<h2 class="breadcrumb-title">Blogs</h2>
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
						
	 <div class="row blog-grid-row">


	 	    <?php
            if (!empty($blog)) 
            {
              
               foreach ($blog as $blog_key) {
                  ?>
                  
	<div class="col-md-4 col-sm-12">
								
			  <!-- Blog Post -->
		<div class="blog grid-blog">
		   <div class="blog-image">
  <a href="<?php echo base_url();?>home/blog_details/<?php echo $blog_key->id; ?>"><img class="img-fluid" src="<?php echo BASE_URL_IMAGE."blog/".$blog_key->image;?>" alt="Post Image"></a>
				  </div>

			<div class="blog-content">
		<ul class="entry-meta meta-item">
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
                           <p class="mb-0"><?php echo preg_replace('/\s+?(\S+)?$/', '', substr($blog_key->desc, 0, 263)).".."; ?></p>
					</div>
					</div>
				<!-- /Blog Post -->
									
					 </div>

	
 <?php
            
            }
            }
            ?>
               

										
					 </div>
								
					</div>
							
					</div>
				    </div>
			       </div>	
			<!-- /Page Content -->
   
		