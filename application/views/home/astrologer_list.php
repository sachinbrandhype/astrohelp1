
         <!-- Breadcrumb -->
         <div class="breadcrumb-bar">
            <div class="container-fluid">
               <div class="row align-items-center">
                  <div class="col-md-8 col-12">
                     <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Astrologer list</li>
                        </ol>
                     </nav>
                     <h2 class="breadcrumb-title">Astrologer List</h2>
                  </div>
                  <div class="col-md-4 col-12 d-md-block d-none">
                     <div class="sort-by">
                        <span class="sort-title">Sort by</span>
                        <span class="sortby-fliter">
                           <select class="select">
                              <option>Select</option>
                              <option class="sorting">Rating</option>
                              <option class="sorting">Experience</option>
                              <option class="sorting">Price</option>
                           </select>
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
                       <?php $top_expertise = $this->db->query("SELECT * FROM `master_specialization` WHERE `status` = '1' AND `in_home` = '1' ORDER BY `position` ASC")->result(); ?>
                       <div class="card search-filter">
               <div class="card-header">
                  <h4 class="card-title mb-0">Filter</h4>
               </div>
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
                     <a href="<?=base_url('home/astrologer_list')?>"><button type="button" value="Re" class="btn btn-block">Reset Filter</button></a>
                  </div>
               </div>
            </div>
                     <!-- /Search Filter -->
                  </div>
                  <div class="col-md-12 col-lg-8 col-xl-9">
                  	

 <div class="row row-grid" id="list-astrologer">
               
            </div>
                    
                    
                     
                    
                    
                  
                  </div>
               </div>
            </div>
         </div>
         <!-- /Page Content -->
        <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>

<script>


$(document).ready(function(){
	var apiurl = "<?=base_url('sdauth/GetAstrologer')?>";
  	$.ajax({
          url: apiurl,
          type: "POST",
          data: '',
          success: function (data) {
          	// console.log(data);
            if(data.length != ''){
              var json = JSON.parse(data);
              var lengthofObject = json.length;
              var i;
              var showData = [];
              if (json['status'] == true) 
              {
				var lengthofObject_ = json['list'].length;
				for (i = 0; i < lengthofObject_; ++i) {
					var specialty = specialty_list(json['list'][i]['id']);
					var avgprice = 100;
					if (json['list'][i]['price_per_mint_chat'] > 0) {
						avgprice = json['list'][i]['price_per_mint_chat'];
					}
					var astrologers_details_url = "<?=base_url('home/astrologer_profile')?>/"+json['list'][i]['id'];

					// phone
					var audio_status = '';
					if (json['list'][i]['audio_status'] == 1) 
					{
						//audio_status = '<a href="'+astrologers_details_url+'" class="fav-btn"><i class="fas fa-phone-alt"></i></a>';
					}

					var chat_status = '';
					if (json['list'][i]['chat_status'] == 1) 
					{
						chat_status = '<a href="'+astrologers_details_url+'" class="fav-btn1"><i class="fas fa-comment-dots"></i></a>';
					}

					var video_status = '';
					if (json['list'][i]['video_status'] == 1) 
					{
						//video_status = '<a href="'+astrologers_details_url+'" class="fav-btn2" data-toggle="modal" data-target="#download-popup"><i class="fas fa-video"></i></a>';
					}

				if (audio_status != '' || chat_status != '' || video_status != '') {
					
            	showData[i] = '<div class="col-md-6 col-lg-4 col-xl-4">'+
                  '<div class="profile-widget">'+
                     '<div class="doc-img">'+
                        '<a href="'+astrologers_details_url+'">'+
                        '<img class="img-fluid" alt="User Image" src="<?php echo BASE_URL_IMAGE.'astrologers';?>/'+json['list'][i]['image']+'"></a>'+audio_status+
                        chat_status+video_status+
                        '<a href="'+astrologers_details_url+'" class="fav-btn3">'+
                           "<p class='pri'>Start's ₹ "+avgprice+"/min</p>"+
                        '</a>'+
                     '</div>'+
                     '<div class="pro-content">'+
                        '<h3 class="title">'+
                           '<a href="'+astrologers_details_url+'">'+json['list'][i]['name']+'</a>'+ 
                        '</h3>'+
                        '<p class="speciality" id="astro_speci'+json['list'][i]['id']+'">'+specialty+'</p>'+
                        '<ul class="available-info">'+
                           '<li><i class="fas fa-graduation-cap"></i> Exp: '+json['list'][i]['experience']+' years</li>'+
                           '<li><i class="fas fa-globe"></i> '+json['list'][i]['languages']+'</li>'+
                        '</ul>'+
                     '</div>'+
                  '</div>'+
               '</div>';
                  }
                }
              }
              else
              {
                showData[0] = '<div class="col-md-6 col-lg-4 col-xl-4">No Astrologer Online!</div>';
              }
              var final_v = showData;
              // console.log(final_v);
              $("#list-astrologer").html(final_v);
            }
          },
        });
 });

function get_astrologer_list()
{
	var apiurl = "<?=base_url('sdauth/GetAstrologer')?>";
  	$.ajax({
          url: apiurl,
          type: "POST",
          data: '',
          success: function (data) {
          	// console.log(data);
            if(data.length != ''){
              var json = JSON.parse(data);
              var lengthofObject = json.length;
              var i;
              var showData = [];
              if (json['status'] == true) 
              {
				var lengthofObject_ = json['list'].length;
				for (i = 0; i < lengthofObject_; ++i) {
					var specialty = specialty_list(json['list'][i]['id']);
					var avgprice = 100;
					if (json['list'][i]['price_per_mint_chat'] > 0) {
						avgprice = json['list'][i]['price_per_mint_chat'];
					}
					var astrologers_details_url = "<?=base_url('home/astrologer_profile')?>/"+json['list'][i]['id'];
					// phone
					var audio_status = '';
					if (json['list'][i]['audio_status'] == 1) 
					{
						//audio_status = '<a href="'+astrologers_details_url+'" class="fav-btn"><i class="fas fa-phone-alt"></i></a>';
					}

					var chat_status = '';
					if (json['list'][i]['chat_status'] == 1) 
					{
						chat_status = '<a href="'+astrologers_details_url+'" class="fav-btn1"><i class="fas fa-comment-dots"></i></a>';
					}

					var video_status = '';
					if (json['list'][i]['video_status'] == 1) 
					{
						//video_status = '<a href="'+astrologers_details_url+'" class="fav-btn2" data-toggle="modal" data-target="#download-popup"><i class="fas fa-video"></i></a>';
					}

				if (audio_status != '' || chat_status != '' || video_status != '') {
            	showData[i] = '<div class="col-md-6 col-lg-4 col-xl-4">'+
                  '<div class="profile-widget">'+
                     '<div class="doc-img">'+
                        '<a href="'+astrologers_details_url+'">'+
                        '<img class="img-fluid" alt="User Image" src="<?php echo BASE_URL_IMAGE.'astrologers';?>/'+json['list'][i]['image']+'"></a>'+audio_status+
                        chat_status+video_status+
                        '<a href="'+astrologers_details_url+'" class="fav-btn3">'+
                           "<p class='pri'>Start's ₹ "+avgprice+"/min</p>"+
                        '</a>'+
                     '</div>'+
                     '<div class="pro-content">'+
                        '<h3 class="title">'+
                           '<a href="'+astrologers_details_url+'">'+json['list'][i]['name']+'</a>'+ 
                        '</h3>'+
                        '<p class="speciality" id="astro_speci'+json['list'][i]['id']+'">'+specialty+'</p>'+
                        '<ul class="available-info">'+
                           '<li><i class="fas fa-graduation-cap"></i> Exp: '+json['list'][i]['experience']+' years</li>'+
                           '<li><i class="fas fa-globe"></i> '+json['list'][i]['languages']+'</li>'+
                        '</ul>'+
                     '</div>'+
                  '</div>'+
               '</div>';
                  }
                }
              }
              else
              {
                showData[0] = '<div class="col-md-6 col-lg-4 col-xl-4">No Astrologer Online!</div>';
              }
              var final_v = showData;
              // console.log(final_v);
              $("#list-astrologer").html(final_v);
            }
          },
        });
}
setInterval('get_astrologer_list()', 300000);

function specialty_list(id) 
{
	var specialty = '';
	var apiurl = "<?=base_url('sdauth/GetAstrologer_specialty')?>";
	 $.ajax({
          url: apiurl,
          type: "POST",
          data: '&id='+id,
          success: function (data) {
              specialty = data;
              var uid = '#astro_speci'+id;
              $(uid).html(specialty);
          },
        });
	// console.log(specialty);
	// return specialty;
}

</script>
<!-- /Page Content -->
