			<!-- /Header -->
			
			<!-- Breadcrumb -->
			<div class="breadcrumb-bar">
			<div class="container-fluid">
		<div class="row align-items-center">
		   <div class="col-md-12 col-12">
<nav aria-label="breadcrumb" class="page-breadcrumb">
				<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="<?php echo base_url();?>home/index">Home</a></li>
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
		<div class="post-author">
<a href="#"><img src="<?php echo base_url();?>assets/img/doctors/author.jpg" alt="Post Author"> <span><?php echo $blog->author_name ; ?></span></a>
				</div>
				</li>

  <li><i class="far fa-calendar"></i><?php echo $blog->show_date  ; ?></li>
				</ul>
				</div>
				</div>

		<div class="blog-content">
<?php echo $blog->desc  ; ?>
					  </div>
					  </div>		
								
					   </div>
					   </div>		
                   </div>
				   </div>

			       </div>		
			<!-- /Page Content -->
   
		