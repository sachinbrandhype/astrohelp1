<!-- <section id="section-01" class="home-main-intro-abc">
    <div class="home-main-intro-container-abc">
        <div class="container-1">
            <div class="slick-slider arrows-inner" data-slick-options='{"slidesToShow": 1, "autoplay":true,"dots":false,"arrows":true}'>


                <div class="box">
                    <div class="banner" style="background-image: url('images/banner.png')">
                        <div class="container pl-10 pl-sm-8">
                            <div class="banner-content">
                                <div class="heading">
                                    <h2 class="lh-1 mb-5 text-white heading-width-2">
                                        Poojas on ground and online
                                    </h2>
                                    <p class="mb-5 lh-4 text-white heading-width-2">Dictum at maecenas urna curabitur pellentesque. Arcu nulla ut porttitor integer nibh posuere nunc, quis nullam. Ultrices nascetur sagittis, amet, semper...</p>

                                    <div class="d-flex flex-wrap">
                                        <div class="mb-1 mx-1">
                                            <a class="btn btn-white" title="Accent Button" href="#"> Book Now </a>
                                        </div>
                                        <div class="mb-1 mx-1">
                                            <a class="btn btn-outline-white" title="Secondary Button" href="explore.html">
                                                Explore </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="banner" style="background-image: url('images/banner.png')">
                        <div class="container pl-10 pl-sm-8">
                            <div class="banner-content">
                                <div class="heading">
                                    <h2 class="lh-1 mb-5 text-white heading-width-2">
                                        Poojas on ground and online
                                    </h2>
                                    <p class="mb-5 lh-4 text-white heading-width-2">Dictum at maecenas urna curabitur pellentesque. Arcu nulla ut porttitor integer nibh posuere nunc, quis nullam. Ultrices nascetur sagittis, amet, semper...</p>

                                    <div class="d-flex flex-wrap">
                                        <div class="mb-1 mx-1">
                                            <a class="btn btn-white" title="Accent Button" href="#"> Book Now </a>
                                        </div>
                                        <div class="mb-1 mx-1">
                                            <a class="btn btn-outline-white" title="Secondary Button" href="#">
                                                Explore </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="banner" style="background-image: url('images/banner.png')">
                        <div class="container pl-10 pl-sm-8">
                            <div class="banner-content">
                                <div class="heading">
                                    <h2 class="lh-1 mb-5 text-white heading-width-2">
                                        Poojas on ground and online
                                    </h2>
                                    <p class="mb-5 lh-4 text-white heading-width-2">Dictum at maecenas urna curabitur pellentesque. Arcu nulla ut porttitor integer nibh posuere nunc, quis nullam. Ultrices nascetur sagittis, amet, semper...</p>

                                    <div class="d-flex flex-wrap">
                                        <div class="mb-1 mx-1">
                                            <a class="btn btn-white" title="Accent Button" href="#"> Book Now </a>
                                        </div>
                                        <div class="mb-1 mx-1">
                                            <a class="btn btn-outline-white" title="Secondary Button" href="#">
                                                Explore </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
</section> -->
<section id="section-05" class="pt-11 pb-11">
    <div class="container">
        <div class="d-flex align-items-center mb-7 flex-wrap flex-sm-nowrap">

            <div class="form-search d-none d-md-flex col-md-5">
                <div class="input-group align-items-center search-border bg-white px-4 w-100 position-relative">
                    <a href="#" class="input-group-prepend text-decoration-none text-secondary">
                        <i class="fal fa-search font-weight-medium primary-text-color"></i>
                    </a>
                    <input type="text" id="key-word" name="key-word" autocomplete="off" class="form-control bg-transparent border-0 search-input" placeholder="Search">
                    <ul class="search-result list-group list-group-flush list-group-borderless">
                    </ul>
                </div>
            </div>
            <a href="#sample-popup" data-gtf-mfp="true" data-mfp-options='{"type":"inline"}' class="link-hover-dark-primary ml-0 ml-sm-auto w-100 w-sm-auto">
                <span class="font-size-md d-inline-block mr-1"><i class="fal fa-sliders-h mr-1"></i> Filters</span>

            </a>
        </div>
        <div class="row">
        <?php if(!empty($pujadata)) : ?>

            <?php foreach($pujadata as $puja) : ?>
                <div class="col-md-4 mb-4" data-animate="zoomIn">
                    <div class="card border-0">
                        <a href="<?=base_url().'pooja-details/'.$puja->id?>" target="_blank" class="hover-scale">
                            <img src="<?=!empty($puja->imageUrl) ? $puja->imageUrl : base_url().'assets/images/pooja.png' ?>" alt="product 1" class="card-img-top image">
                        </a>
                        <div class="image-content position-absolute m-2 d-flex align-items-center">
                            <div class="content-left">
                                <div class="badge badge-primary p-2 font-size-md">Available online</div>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <h5 class="lh-13 letter-spacing-25">
                                <a href="<?=base_url().'pooja-details/'.$puja->id?>" target="_blank" class="link-hover-dark-primary text-capitalize">
                                    <?=ucwords($puja->name)?></a>
                                <span class="link-hover-dark-primary float-right primary-text-color text-capitalize">
                                    ₹ <?=$puja->price?></span>
                            </h5>
                            <div class="mb-2"><?=$puja->city_name?></div>
                            <span class="card-text font-size-md">
                                <?=sh_limit_words(strip_tags($puja->description))?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
           
        </div>
        <ul class="pagination pagination-style-01 justify-content-center mt-6">
           
            <?php   for($page = 1; $page<= $number_of_pages; $page++) {    ?>  
                <li class="page-item"><a href="<?=$self_url?>?page=<?=$page?>" class="page-link bg-transparent link-hover-dark-primary px-3 <?=$page == $current_page ? 'page-active-link' : ''?>"><?=$page?></a></li>
            <?php } ?>
            <!-- <li class="page-item primary-text-color"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3"><i class="fal fa-arrow-left"></i></a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">1</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">2</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">3</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">4</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">5</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">6</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3">7</a></li>
            <li class="page-item"><a href="#" class="page-link bg-transparent link-hover-dark-primary px-3"><i class="fal fa-arrow-right"></i></a></li> -->
        </ul>
    </div>
</section>


</div>